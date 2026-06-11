<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\PengaturanPembayaran;
use App\Models\Voucher;
use App\Models\User;
use Filament\Notifications\Notification;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;
use Midtrans\Notification as MidtransNotification;

class CheckoutController extends Controller
{
    /**
     * Inisialisasi konfigurasi Midtrans
     */
    private function setupMidtrans(): void
    {
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = config('midtrans.is_production');
        MidtransConfig::$isSanitized = config('midtrans.is_sanitized');
        MidtransConfig::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Kirim notifikasi WhatsApp via Fonnte
     */
    private function kirimNotifikasiWA(string $nomorTujuan, string $pesan): void
    {
        try {
            Http::withHeaders([
                'Authorization' => config('fonnte.token'),
            ])->post('https://api.fonnte.com/send', [
                        'target' => $nomorTujuan,
                        'message' => $pesan,
                    ]);
        } catch (\Exception $e) {
            Log::error('Fonnte WA Error: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman checkout
     */
    public function create()
    {
        $items = auth()->user()->keranjang()->with('produk')->get();
        $subtotal = $items->sum('subtotal');

        $qrisQrImage = PengaturanPembayaran::get('qris', 'qr_image', '');
        $qrisDescription = PengaturanPembayaran::get('qris', 'description', 'Scan QR Code di bawah untuk pembayaran');

        $bankAccounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $name = PengaturanPembayaran::get('transfer_bank', "bank_{$i}_name");
            $number = PengaturanPembayaran::get('transfer_bank', "bank_{$i}_number");
            $holder = PengaturanPembayaran::get('transfer_bank', "bank_{$i}_holder");
            if ($name && $number && $holder) {
                $bankAccounts[] = [
                    'bank_name' => $name,
                    'account_number' => $number,
                    'account_holder' => $holder,
                ];
            }
        }

        $danaPhone = PengaturanPembayaran::get('dana', 'phone_number', '');
        $danaName = PengaturanPembayaran::get('dana', 'account_name', '');
        $danaQrImage = PengaturanPembayaran::get('dana', 'qr_image', '');

        $midtransClientKey = config('midtrans.client_key');
        $midtransSnapUrl = config('midtrans.snap_url');

        return view('checkout.create', compact(
            'items',
            'subtotal',
            'qrisQrImage',
            'qrisDescription',
            'bankAccounts',
            'danaPhone',
            'danaName',
            'danaQrImage',
            'midtransClientKey',
            'midtransSnapUrl'
        ));
    }

    /**
     * Validasi voucher via AJAX
     */
    public function validateVoucher(Request $request)
    {
        $request->validate([
            'kode_voucher' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $voucher = Voucher::where('kode', strtoupper($request->kode_voucher))->first();
        $userId = auth()->id();

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Kode voucher tidak ditemukan.']);
        }

        if (!$voucher->isValid()) {
            $status = $voucher->getStatusBadge();
            return response()->json(['success' => false, 'message' => 'Voucher tidak berlaku. Status: ' . $status['label']]);
        }

        if (!$voucher->canApply($request->subtotal, $userId)) {
            if ($userId && $voucher->max_penggunaan_per_user > 0) {
                $userUsage = $voucher->getUserUsageCount($userId);
                if ($userUsage >= $voucher->max_penggunaan_per_user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda sudah menggunakan voucher ini sebanyak ' . $userUsage . ' kali. Maksimal: ' . $voucher->max_penggunaan_per_user . ' kali.'
                    ]);
                }
            }
            return response()->json([
                'success' => false,
                'message' => 'Minimum pembelian untuk voucher ini adalah Rp ' . number_format($voucher->min_pembelian, 0, ',', '.')
            ]);
        }

        $discount = $voucher->calculateDiscount($request->subtotal);
        $remainingUserQuota = $voucher->getRemainingUserQuota($userId);

        return response()->json([
            'success' => true,
            'voucher_id' => $voucher->id,
            'kode' => $voucher->kode,
            'nama' => $voucher->nama,
            'tipe_diskon' => $voucher->tipe_diskon,
            'nilai_diskon' => $voucher->nilai_diskon,
            'max_diskon' => $voucher->max_diskon,
            'diskon' => $discount,
            'remaining_user_quota' => $remainingUserQuota,
            'message' => 'Voucher berhasil diterapkan!'
        ]);
    }

    /**
     * Proses checkout dan simpan transaksi
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'metode_pembayaran' => 'required|in:cod,qris,dana,transfer_bank,midtrans',
            'sub_tipe_pembayaran' => 'nullable|in:nomor_hp,qr_code',
            'bukti_pembayaran' => 'nullable|image|max:2048',
            'voucher_id' => 'nullable|exists:vouchers,id',
            'destination_id' => 'nullable|string',
            'destination_name' => 'nullable|string',
            'kurir' => 'nullable|string',
            'layanan_kurir' => 'nullable|string',
            'ongkir' => 'nullable|numeric|min:0',
        ]);

        $items = auth()->user()->keranjang()->with('produk')->get();
        if ($items->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', config('filesystems.cloud', 'public'));
        }

        $transaksi = null;

        DB::transaction(function () use ($request, $items, $buktiPath, &$transaksi) {
            $subtotal = $items->sum(fn($i) => $i->produk->harga * $i->jumlah);
            $ongkir = (int) ($request->ongkir ?? 0);
            $diskonVoucher = 0;
            $voucherId = null;
            $userId = auth()->id();

            if ($request->voucher_id) {
                $voucher = Voucher::find($request->voucher_id);
                if ($voucher) {
                    if (!$voucher->isValid()) {
                        throw new \Exception('Voucher sudah tidak berlaku.');
                    }
                    if (!$voucher->canApply($subtotal, $userId)) {
                        $minPembelian = number_format($voucher->min_pembelian, 0, ',', '.');
                        throw new \Exception("Minimum pembelian: Rp {$minPembelian}.");
                    }
                    $diskonVoucher = $voucher->calculateDiscount($subtotal);
                    $voucherId = $voucher->id;
                    $voucher->increment('jumlah_dipakai');
                }
            }

            $totalBayar = max(0, $subtotal + $ongkir - $diskonVoucher);
            $subTipe = $request->metode_pembayaran === 'dana'
                ? ($request->sub_tipe_pembayaran ?? 'nomor_hp')
                : null;

            $midtransOrderId = $request->metode_pembayaran === 'midtrans'
                ? 'ORDER-' . auth()->id() . '-' . time()
                : null;

            $transaksi = Transaksi::create([
                'user_id' => auth()->id(),
                'voucher_id' => $voucherId,
                'nama_pembeli' => $request->nama_pembeli,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'destination_id' => $request->destination_id,
                'destination_name' => $request->destination_name,
                'kurir' => $request->kurir,
                'layanan_kurir' => $request->layanan_kurir,
                'ongkir' => $ongkir,
                'metode_pembayaran' => $request->metode_pembayaran,
                'sub_tipe_pembayaran' => $subTipe,
                'bukti_pembayaran' => $buktiPath,
                'total' => $subtotal,
                'diskon_voucher' => $diskonVoucher,
                'total_bayar' => $totalBayar,
                'midtrans_order_id' => $midtransOrderId,
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                if ($item->produk->stok < $item->jumlah) {
                    throw new \Exception("Stok {$item->produk->nama} tidak cukup.");
                }

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item->produk_id,
                    'nama_produk' => $item->produk->nama,
                    'harga_satuan' => $item->produk->harga,
                    'jumlah' => $item->jumlah,
                    'subtotal' => $item->produk->harga * $item->jumlah,
                ]);

                $item->produk->decrement('stok', $item->jumlah);
            }

            auth()->user()->keranjang()->delete();
        });

        if (!$transaksi) {
            return back()->with('error', 'Terjadi kesalahan saat checkout.');
        }

        // Notifikasi Filament ke admin
        $this->notifikasiAdmin($transaksi);

        // Notifikasi WA ke admin untuk semua metode kecuali Midtrans
        // (Midtrans dikirim setelah pembayaran berhasil via webhook)
        if ($transaksi->metode_pembayaran !== 'midtrans') {
            $metodeLabel = match ($transaksi->metode_pembayaran) {
                'cod' => 'COD (Bayar di Tempat)',
                'qris' => 'QRIS',
                'dana' => 'DANA',
                'transfer_bank' => 'Transfer Bank',
                default => $transaksi->metode_pembayaran,
            };

            $pesan = "🛒 *PESANAN BARU MASUK!*\n\n" .
                "Dari: *{$transaksi->nama_pembeli}*\n" .
                "No. HP: {$transaksi->no_telepon}\n" .
                "Alamat: {$transaksi->alamat}\n" .
                "Total: *Rp " . number_format($transaksi->total_bayar, 0, ',', '.') . "*\n" .
                "Metode: {$metodeLabel}\n\n" .
                "Silakan cek dashboard untuk detail pesanan.";

            $this->kirimNotifikasiWA(config('fonnte.admin_phone'), $pesan);
        }

        activity()
            ->causedBy(auth()->user())
            ->performedOn($transaksi)
            ->withProperties([
                'total' => $transaksi->total_bayar,
                'metode' => $transaksi->metode_pembayaran,
            ])
            ->log('checkout');

        if ($transaksi->metode_pembayaran === 'midtrans') {
            return $this->generateSnapToken($transaksi);
        }

        return redirect()->route('pesanan.index')->with('success', 'Checkout berhasil!');
    }

    /**
     * Generate Midtrans Snap Token dan tampilkan halaman pembayaran
     */
    private function generateSnapToken(Transaksi $transaksi)
    {
        try {
            $this->setupMidtrans();

            Log::info('Midtrans Config Check', [
                'server_key_prefix' => substr(config('midtrans.server_key'), 0, 15) . '...',
                'is_production' => config('midtrans.is_production'),
                'order_id' => $transaksi->midtrans_order_id,
                'total_bayar' => $transaksi->total_bayar,
            ]);

            if (empty(config('midtrans.server_key'))) {
                throw new \Exception('Midtrans server key belum dikonfigurasi di .env');
            }

            $itemDetails = $transaksi->detailTransaksi->map(function ($detail) {
                return [
                    'id' => (string) $detail->produk_id,
                    'price' => (int) $detail->harga_satuan,
                    'quantity' => (int) $detail->jumlah,
                    'name' => substr($detail->nama_produk, 0, 50),
                ];
            })->toArray();

            if ($transaksi->ongkir > 0) {
                $itemDetails[] = [
                    'id' => 'ONGKIR',
                    'price' => (int) $transaksi->ongkir,
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim (' . strtoupper($transaksi->kurir ?? '') . ')',
                ];
            }

            if ($transaksi->diskon_voucher > 0) {
                $itemDetails[] = [
                    'id' => 'DISKON',
                    'price' => -(int) $transaksi->diskon_voucher,
                    'quantity' => 1,
                    'name' => 'Diskon Voucher',
                ];
            }

            $itemTotal = collect($itemDetails)->sum(fn($i) => $i['price'] * $i['quantity']);
            if ($itemTotal !== (int) $transaksi->total_bayar) {
                $selisih = (int) $transaksi->total_bayar - $itemTotal;
                if ($selisih !== 0) {
                    $itemDetails[] = [
                        'id' => 'ADJUSTMENT',
                        'price' => $selisih,
                        'quantity' => 1,
                        'name' => 'Penyesuaian Harga',
                    ];
                }
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $transaksi->midtrans_order_id,
                    'gross_amount' => (int) $transaksi->total_bayar,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $transaksi->nama_pembeli,
                    'phone' => $transaksi->no_telepon,
                    'address' => $transaksi->alamat,
                    'email' => auth()->user()->email ?? 'customer@autocommerce.com',
                ],
                'callbacks' => [
                    'finish' => route('pesanan.show', $transaksi->id),
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            $transaksi->update(['snap_token' => $snapToken]);

            Log::info('Midtrans Snap Token berhasil dibuat', [
                'transaksi_id' => $transaksi->id,
                'order_id' => $transaksi->midtrans_order_id,
            ]);

            return view('checkout.midtrans', compact('transaksi', 'snapToken'));

        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error', [
                'message' => $e->getMessage(),
                'transaksi_id' => $transaksi->id,
            ]);

            return redirect()->route('pesanan.index')
                ->with('error', 'Gagal menghubungi Midtrans: ' . $e->getMessage() . '. Pesanan Anda tetap tersimpan, silakan coba bayar lagi.');
        }
    }

    /**
     * Retry pembayaran Midtrans untuk transaksi pending
     */
    public function retryMidtrans(Transaksi $transaksi)
    {
        if ($transaksi->user_id !== auth()->id()) {
            abort(403);
        }

        if ($transaksi->metode_pembayaran !== 'midtrans') {
            return redirect()->route('pesanan.show', $transaksi->id)
                ->with('error', 'Transaksi ini bukan transaksi Midtrans.');
        }

        if (!in_array($transaksi->status, ['pending'])) {
            return redirect()->route('pesanan.show', $transaksi->id)
                ->with('error', 'Transaksi ini tidak bisa dibayar ulang.');
        }

        if ($transaksi->snap_token) {
            $snapToken = $transaksi->snap_token;
            return view('checkout.midtrans', compact('transaksi', 'snapToken'));
        }

        if (!$transaksi->midtrans_order_id) {
            $transaksi->update([
                'midtrans_order_id' => 'ORDER-' . $transaksi->user_id . '-' . time(),
            ]);
        }

        return $this->generateSnapToken($transaksi);
    }

    /**
     * Endpoint webhook/callback dari Midtrans
     */
    public function midtransCallback(Request $request)
    {
        try {
            $this->setupMidtrans();

            $notif = new MidtransNotification();

            $transactionStatus = $notif->transaction_status;
            $orderId = $notif->order_id;
            $fraudStatus = $notif->fraud_status ?? null;
            $paymentType = $notif->payment_type ?? null;
            $midtransTransId = $notif->transaction_id ?? null;

            $transaksi = Transaksi::where('midtrans_order_id', $orderId)->first();

            if (!$transaksi) {
                Log::warning('Midtrans Callback: Transaksi tidak ditemukan', ['order_id' => $orderId]);
                return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
            }

            $updateData = [
                'midtrans_transaction_id' => $midtransTransId,
                'midtrans_payment_type' => $paymentType,
            ];

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $updateData['status'] = 'pending';
                } elseif ($fraudStatus == 'accept') {
                    $updateData['status'] = 'diproses';
                }
            } elseif ($transactionStatus == 'settlement') {
                $updateData['status'] = 'diproses';
            } elseif ($transactionStatus == 'pending') {
                $updateData['status'] = 'pending';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $updateData['status'] = 'dibatalkan';

                foreach ($transaksi->detailTransaksi as $detail) {
                    \App\Models\Produk::where('id', $detail->produk_id)
                        ->increment('stok', $detail->jumlah);
                }
            } elseif ($transactionStatus == 'refund') {
                $updateData['status'] = 'dibatalkan';
            }

            $transaksi->update($updateData);

            // Notifikasi jika pembayaran berhasil
            if (isset($updateData['status']) && $updateData['status'] === 'diproses') {
                // Notifikasi Filament ke admin
                $admins = User::where('role', 'admin')->get();
                foreach ($admins as $admin) {
                    Notification::make()
                        ->title('💳 Pembayaran Midtrans Diterima!')
                        ->body(
                            "Dari: {$transaksi->nama_pembeli} | " .
                            "Total: Rp " . number_format($transaksi->total_bayar, 0, ',', '.') . " | " .
                            "Via: " . strtoupper($paymentType ?? 'Midtrans')
                        )
                        ->icon('heroicon-o-credit-card')
                        ->iconColor('success')
                        ->sendToDatabase($admin);
                }

                // Notifikasi WA ke admin via Fonnte
                $pesan = "💳 *PEMBAYARAN BERHASIL!*\n\n" .
                    "Dari: *{$transaksi->nama_pembeli}*\n" .
                    "No. HP: {$transaksi->no_telepon}\n" .
                    "Total: *Rp " . number_format($transaksi->total_bayar, 0, ',', '.') . "*\n" .
                    "Metode: " . strtoupper($paymentType ?? 'Midtrans') . "\n" .
                    "Order ID: {$transaksi->midtrans_order_id}\n\n" .
                    "Silakan segera proses pesanan ini.";

                $this->kirimNotifikasiWA(config('fonnte.admin_phone'), $pesan);
            }

            // Notifikasi jika pembayaran dibatalkan/expired
            if (isset($updateData['status']) && $updateData['status'] === 'dibatalkan') {
                $pesan = "❌ *PEMBAYARAN GAGAL/EXPIRED*\n\n" .
                    "Dari: {$transaksi->nama_pembeli}\n" .
                    "Total: Rp " . number_format($transaksi->total_bayar, 0, ',', '.') . "\n" .
                    "Status Midtrans: {$transactionStatus}\n" .
                    "Order ID: {$transaksi->midtrans_order_id}";

                $this->kirimNotifikasiWA(config('fonnte.admin_phone'), $pesan);
            }

            Log::info('Midtrans Callback Sukses', [
                'order_id' => $orderId,
                'status' => $transactionStatus,
                'new_status' => $updateData['status'] ?? 'unchanged',
            ]);

            return response()->json(['message' => 'OK']);

        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error: ' . $e->getMessage(), [
                'request' => $request->all(),
            ]);
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Kirim notifikasi Filament ke semua admin
     */
    private function notifikasiAdmin(Transaksi $transaksi): void
    {
        $metodeLabel = match ($transaksi->metode_pembayaran) {
            'cod' => 'COD',
            'qris' => 'QRIS',
            'dana' => 'DANA',
            'transfer_bank' => 'Transfer Bank',
            'midtrans' => 'Midtrans (Online)',
            default => $transaksi->metode_pembayaran,
        };

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::make()
                ->title('🛒 Pesanan Baru Masuk!')
                ->body(
                    "Dari: {$transaksi->nama_pembeli} | " .
                    "Total: Rp " . number_format($transaksi->total_bayar, 0, ',', '.') . " | " .
                    "Metode: {$metodeLabel}"
                )
                ->icon('heroicon-o-shopping-cart')
                ->iconColor('success')
                ->sendToDatabase($admin);
        }
    }
}