@extends('layouts.app')

@section('title', 'Pembayaran Midtrans')

@section('content')
    <!-- Breadcrumb -->
    <nav class="container py-3 bg-light">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('katalog') }}" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pesanan.index') }}" class="text-decoration-none">Pesanan Saya</a></li>
            <li class="breadcrumb-item active">Pembayaran</li>
        </ol>
    </nav>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">

                    <!-- Loading State (ditampilkan sebelum popup muncul) -->
                    <div id="loading-payment" class="text-center">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-5">
                                <div class="mb-4">
                                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                <h4 class="fw-bold mb-2">Memuat Halaman Pembayaran</h4>
                                <p class="text-muted mb-0">Mohon tunggu, jangan tutup halaman ini...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Info Pesanan -->
                    <div id="order-info" class="card border-0 shadow-sm mt-4" style="display:none;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-receipt me-2 text-primary"></i>Ringkasan Pesanan
                            </h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">No. Order</span>
                                <span class="fw-semibold font-monospace">{{ $transaksi->midtrans_order_id }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Nama</span>
                                <span class="fw-semibold">{{ $transaksi->nama_pembeli }}</span>
                            </div>
                            @if($transaksi->kurir)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Pengiriman</span>
                                    <span class="fw-semibold">{{ strtoupper($transaksi->kurir) }} - {{ strtoupper($transaksi->layanan_kurir ?? '') }}</span>
                                </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold fs-6">Total Pembayaran</span>
                                <span class="fw-bold fs-5 text-primary">
                                    Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Bayar (muncul jika popup ditutup tanpa bayar) -->
                    <div id="pay-button-container" class="mt-3" style="display:none;">
                        <button id="pay-button" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="bi bi-credit-card me-2"></i>Bayar Sekarang
                        </button>
                        <a href="{{ route('pesanan.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Pesanan
                        </a>
                        <p class="text-muted text-center small mt-2">
                            <i class="bi bi-shield-check me-1 text-success"></i>
                            Pembayaran aman & terenkripsi oleh Midtrans
                        </p>
                    </div>

                    <!-- Pesan jika popup diblokir browser -->
                    <div class="alert alert-warning mt-3" id="popup-blocked-alert" style="display:none;">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Popup diblokir!</strong> Silakan izinkan popup di browser Anda, lalu klik tombol "Bayar Sekarang".
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- Load Midtrans Snap JS --}}
    <script src="{{ config('midtrans.snap_url') }}"
            data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        const snapToken = @json($snapToken);
        const finishUrl = @json(route('pesanan.show', $transaksi->id));
        const pesananUrl = @json(route('pesanan.index'));

        // Tampilkan info pesanan
        document.getElementById('order-info').style.display = 'block';

        // Fungsi buka popup Midtrans
        function openSnapPopup() {
            if (typeof snap === 'undefined') {
                document.getElementById('popup-blocked-alert').style.display = 'block';
                document.getElementById('loading-payment').style.display = 'none';
                document.getElementById('pay-button-container').style.display = 'block';
                return;
            }

            snap.pay(snapToken, {
                onSuccess: function (result) {
                    // Pembayaran berhasil
                    window.location.href = finishUrl + '?payment=success';
                },
                onPending: function (result) {
                    // Menunggu pembayaran (misal: transfer bank virtual account)
                    window.location.href = finishUrl + '?payment=pending';
                },
                onError: function (result) {
                    // Pembayaran gagal
                    document.getElementById('loading-payment').style.display = 'none';
                    document.getElementById('pay-button-container').style.display = 'block';
                    alert('Pembayaran gagal. Silakan coba lagi.');
                },
                onClose: function () {
                    // User menutup popup tanpa bayar
                    document.getElementById('loading-payment').style.display = 'none';
                    document.getElementById('pay-button-container').style.display = 'block';
                }
            });
        }

        // Otomatis buka popup saat halaman loaded
        window.addEventListener('load', function () {
            // Delay sedikit untuk pastikan snap.js sudah terload
            setTimeout(function () {
                document.getElementById('loading-payment').style.display = 'none';
                openSnapPopup();
            }, 1000);
        });

        // Tombol bayar (jika popup ditutup)
        document.getElementById('pay-button').addEventListener('click', function () {
            document.getElementById('pay-button-container').style.display = 'none';
            document.getElementById('loading-payment').style.display = 'block';
            document.getElementById('popup-blocked-alert').style.display = 'none';
            openSnapPopup();
        });
    </script>
@endpush
