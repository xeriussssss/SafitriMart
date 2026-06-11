<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'voucher_id',
        'nama_pembeli',
        'no_telepon',
        'alamat',
        'destination_id',
        'destination_name',
        'kurir',
        'layanan_kurir',
        'ongkir',
        'metode_pembayaran',
        'sub_tipe_pembayaran',
        'bukti_pembayaran',
        'total',
        'diskon_voucher',
        'total_bayar',
        'status',
        // === Kolom Midtrans ===
        'snap_token',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'midtrans_payment_type',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'diskon_voucher' => 'decimal:2',
        'total_bayar' => 'decimal:2',
        'ongkir' => 'integer',
    ];

    // =====================
    // Relationships
    // =====================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProdukReview::class);
    }

    // =====================
    // Helper Methods
    // =====================

    /**
     * Cek apakah transaksi ini menggunakan Midtrans
     */
    public function isMidtrans(): bool
    {
        return $this->metode_pembayaran === 'midtrans';
    }

    /**
     * Cek apakah pembayaran Midtrans sudah selesai
     */
    public function isMidtransPaid(): bool
    {
        return $this->isMidtrans() && in_array($this->status, ['diproses', 'dikirim', 'selesai']);
    }

    /**
     * Cek apakah snap token masih bisa dipakai
     * (belum dibayar dan statusnya masih pending)
     */
    public function hasActiveSnapToken(): bool
    {
        return $this->isMidtrans()
            && !empty($this->snap_token)
            && $this->status === 'pending';
    }
}
