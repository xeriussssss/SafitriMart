<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Tampil halaman laporan (admin only)
     */
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->format('Y-m'));
        $tahun = $request->get('tahun', now()->year);

        [$year, $month] = explode('-', $bulan);

        $transaksi = Transaksi::with(['detailTransaksi', 'user', 'voucher'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->get();

        $summary = [
            'total_transaksi'   => $transaksi->count(),
            'total_pendapatan'  => $transaksi->where('status', 'selesai')->sum('total_bayar'),
            'total_diskon'      => $transaksi->sum('diskon_voucher'),
            'pending'           => $transaksi->where('status', 'pending')->count(),
            'diproses'          => $transaksi->where('status', 'diproses')->count(),
            'dikirim'           => $transaksi->where('status', 'dikirim')->count(),
            'selesai'           => $transaksi->where('status', 'selesai')->count(),
            'dibatalkan'        => $transaksi->where('status', 'dibatalkan')->count(),
        ];

        return view('laporan.index', compact('transaksi', 'summary', 'bulan', 'tahun'));
    }

    /**
     * Export laporan ke PDF
     */
    public function exportPdf(Request $request)
    {
        $bulan = $request->get('bulan', now()->format('Y-m'));
        [$year, $month] = explode('-', $bulan);

        $transaksi = Transaksi::with(['detailTransaksi', 'user', 'voucher'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->get();

        $summary = [
            'total_transaksi'  => $transaksi->count(),
            'total_pendapatan' => $transaksi->where('status', 'selesai')->sum('total_bayar'),
            'total_diskon'     => $transaksi->sum('diskon_voucher'),
            'selesai'          => $transaksi->where('status', 'selesai')->count(),
            'dibatalkan'       => $transaksi->where('status', 'dibatalkan')->count(),
            'pending'          => $transaksi->where('status', 'pending')->count(),
        ];

        $namaBulan = Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf', compact(
            'transaksi', 'summary', 'namaBulan', 'bulan'
        ))->setPaper('a4', 'landscape');

        return $pdf->download("Laporan_Safitri_Mart_{$year}_{$month}.pdf");
    }
}
