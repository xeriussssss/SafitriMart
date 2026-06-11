@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
    <!-- Breadcrumb -->
    <nav class="container py-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('katalog') }}" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item active">Pesanan Saya</li>
        </ol>
    </nav>

    <!-- Orders Section -->
    <section class="py-5">
        <div class="container">

            <!-- Page Header -->
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="page-icon-wrap mx-auto mb-3">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
                <h1 class="page-title">Riwayat Pesanan</h1>
                <p class="text-muted mb-0">Pantau status pesanan Anda di sini</p>
            </div>

            <!-- Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert"
                    data-aos="fade-up">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($pesanan->isEmpty())
                <!-- Empty State -->
                <div class="empty-state text-center py-5" data-aos="fade-up">
                    <div class="empty-icon mb-4">
                        <i class="bi bi-bag-x"></i>
                    </div>
                    <h3 class="fw-bold mb-2">Belum Ada Pesanan</h3>
                    <p class="text-muted mb-4">Anda belum memiliki pesanan. Yuk, mulai belanja!</p>
                    <a href="{{ route('katalog') }}" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-grid me-2"></i>Mulai Belanja
                    </a>
                </div>
            @else

                <!-- Orders List -->
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="accordion order-accordion" id="ordersAccordion">
                            @foreach($pesanan as $order)
                                <div class="order-card mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}">

                                    <!-- Order Header -->
                                    <div class="order-header d-flex align-items-center gap-2 flex-wrap" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $order->id }}"
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}" role="button">

                                        <div class="order-id">
                                            <i class="bi bi-hash"></i>TRX{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                        </div>

                                        <div class="order-date text-muted small">
                                            <i class="bi bi-calendar3 me-1"></i>{{ $order->created_at->format('d M Y') }}
                                        </div>

                                        <div class="ms-auto d-flex align-items-center gap-2 flex-wrap">
                                            <!-- Status Badge -->
                                            <span class="status-badge status-{{ $order->status }}">
                                                <i class="bi bi-{{ match ($order->status) {
                                                    'pending' => 'clock',
                                                    'diproses' => 'gear',
                                                    'dikirim' => 'truck',
                                                    'selesai' => 'check-circle-fill',
                                                    'dibatalkan' => 'x-circle-fill',
                                                    default => 'question-circle'
                                                } }}"></i>
                                                {{ match ($order->status) {
                                                    'pending' => 'Menunggu Pembayaran',
                                                    'diproses' => 'Sedang Diproses',
                                                    'dikirim' => 'Dikirim',
                                                    'selesai' => 'Selesai',
                                                    'dibatalkan' => 'Dibatalkan',
                                                    default => $order->status
                                                } }}
                                            </span>

                                            <!-- Total -->
                                            <span class="order-total">
                                                Rp {{ number_format($order->total_bayar ?? $order->total, 0, ',', '.') }}
                                            </span>

                                            <!-- Chevron -->
                                            <span class="chevron-icon">
                                                <i class="bi bi-chevron-down"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="order-actions">
                                        <a href="{{ route('pesanan.show', $order) }}" class="btn-action btn-action-view"
                                            title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($order->status === 'pending')
                                            <form action="{{ route('pesanan.cancel', $order) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                @csrf
                                                <button type="submit" class="btn-action btn-action-cancel" title="Batalkan Pesanan">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <!-- Collapsible Body -->
                                    <div id="collapse{{ $order->id }}" class="collapse {{ $loop->first ? 'show' : '' }}">
                                        <div class="order-body">

                                            <!-- Info Cards Row -->
                                            <div class="row g-3 mb-4">
                                                <!-- Pembayaran -->
                                                <div class="col-sm-6 col-md-4">
                                                    <div class="info-card">
                                                        <div class="info-card-icon info-icon-payment">
                                                            <i class="bi bi-wallet2"></i>
                                                        </div>
                                                        <div>
                                                            <div class="info-card-label">Pembayaran</div>
                                                            <div class="info-card-value">
                                                                @php
                                                                    $paymentLabels = [
                                                                        'cod' => 'COD',
                                                                        'qris' => 'QRIS',
                                                                        'dana' => 'DANA',
                                                                        'transfer_bank' => 'Transfer Bank',
                                                                        'midtrans' => 'Midtrans (Online)',
                                                                    ];
                                                                @endphp
                                                                {{ $paymentLabels[$order->metode_pembayaran] ?? ($order->metode_pembayaran ?? '-') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Alamat -->
                                                <div class="col-sm-6 col-md-4">
                                                    <div class="info-card">
                                                        <div class="info-card-icon info-icon-address">
                                                            <i class="bi bi-geo-alt"></i>
                                                        </div>
                                                        <div>
                                                            <div class="info-card-label">Alamat Pengiriman</div>
                                                            <div class="info-card-value">{{ $order->alamat }}</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Penerima -->
                                                <div class="col-sm-12 col-md-4">
                                                    <div class="info-card">
                                                        <div class="info-card-icon info-icon-person">
                                                            <i class="bi bi-person"></i>
                                                        </div>
                                                        <div>
                                                            <div class="info-card-label">Penerima</div>
                                                            <div class="info-card-value">{{ $order->nama_pembeli }}</div>
                                                            @if($order->no_telepon)
                                                                <div class="info-card-sub">
                                                                    <i class="bi bi-telephone me-1"></i>{{ $order->no_telepon }}
                                                                </div>
                                                            @endif
                                                            <div class="info-card-sub">{{ $order->user->email }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Products Table -->
                                            <div class="products-section">
                                                <div class="products-section-title">
                                                    <i class="bi bi-box-seam me-2"></i>Detail Produk
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table order-table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Produk</th>
                                                                <th class="text-center">Harga</th>
                                                                <th class="text-center">Jumlah</th>
                                                                <th class="text-end">Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($order->detailTransaksi as $detail)
                                                                <tr>
                                                                    <td>
                                                                        <span class="fw-semibold">{{ $detail->nama_produk }}</span>
                                                                    </td>
                                                                    <td class="text-center text-muted">
                                                                        Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="qty-badge">{{ $detail->jumlah }}</span>
                                                                    </td>
                                                                    <td class="text-end fw-semibold">
                                                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr class="summary-row">
                                                                <td colspan="3" class="text-end text-muted">Subtotal</td>
                                                                <td class="text-end fw-semibold">
                                                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                                                </td>
                                                            </tr>
                                                            @if($order->diskon_voucher > 0)
                                                                <tr class="summary-row">
                                                                    <td colspan="3" class="text-end text-success">
                                                                        <i class="bi bi-ticket-perforated me-1"></i>Diskon Voucher
                                                                    </td>
                                                                    <td class="text-end text-success fw-semibold">
                                                                        - Rp {{ number_format($order->diskon_voucher, 0, ',', '.') }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            <tr class="total-row">
                                                                <td colspan="3" class="text-end fw-bold">Total Dibayar</td>
                                                                <td class="text-end total-amount">
                                                                    Rp {{ number_format($order->total_bayar ?? $order->total, 0, ',', '.') }}
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection

@push('styles')
    <link href="{{ asset('css/pesanan.css') }}" rel="stylesheet">
    <style>
        /* Page Header */
        .page-icon-wrap {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, #9a3412 0%, #c2410c 50%, #ea580c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: #fff;
            box-shadow: 0 8px 24px rgba(194, 65, 12, 0.25);
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .empty-icon {
            font-size: 5rem;
            color: var(--bs-secondary, #adb5bd);
            opacity: 0.5;
        }

        /* Order Card */
        .order-card {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-color, rgba(0, 0, 0, 0.08));
            background: var(--bg-card, #fff);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.25s ease, transform 0.25s ease;
            position: relative;
        }

        .order-card:hover {
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.10);
            transform: translateY(-1px);
        }

        .order-header {
            padding: 1.1rem 1.4rem;
            cursor: pointer;
            user-select: none;
            border-bottom: 1px solid transparent;
            transition: background 0.2s ease;
            padding-right: 110px;
        }

        .order-header:hover {
            background: rgba(234, 88, 12, 0.04);
        }

        .order-id {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-heading, #1a1a1a);
            letter-spacing: 0.3px;
        }

        .order-total {
            font-weight: 700;
            font-size: 1rem;
            color: #ea580c;
        }

        .chevron-icon {
            color: var(--text-muted, #6c757d);
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 100px;
            font-size: 0.78rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-pending   { background: #FEF3C7; color: #92400E; }
        .status-diproses  { background: #DBEAFE; color: #1E40AF; }
        .status-dikirim   { background: #EDE9FE; color: #5B21B6; }
        .status-selesai   { background: #D1FAE5; color: #065F46; }
        .status-dibatalkan{ background: #FEE2E2; color: #991B1B; }

        /* Action Buttons */
        .order-actions {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: flex;
            gap: 6px;
            z-index: 2;
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-action-view {
            background: rgba(234, 88, 12, 0.1);
            color: #ea580c;
        }

        .btn-action-view:hover {
            background: linear-gradient(135deg, #c2410c, #ea580c);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(194, 65, 12, 0.3);
        }

        .btn-action-cancel {
            background: rgba(220, 38, 38, 0.1);
            color: #dc2626;
        }

        .btn-action-cancel:hover {
            background: #dc2626;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        /* Order Body */
        .order-body {
            padding: 1.25rem 1.4rem 1.4rem;
            border-top: 1px solid var(--border-color, rgba(0, 0, 0, 0.07));
        }

        /* Info Cards */
        .info-card {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 12px;
            background: var(--bg-light, #f8f9fa);
            border: 1px solid var(--border-color, rgba(0, 0, 0, 0.06));
            height: 100%;
        }

        .info-card-icon {
            width: 36px;
            height: 36px;
            min-width: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .info-icon-payment { background: rgba(59, 130, 246, 0.12); color: #2563EB; }
        .info-icon-address  { background: rgba(239, 68, 68, 0.12);  color: #DC2626; }

        .info-icon-person {
            background: rgba(234, 88, 12, 0.12);
            color: #ea580c;
        }

        .info-card-label {
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted, #6c757d);
            margin-bottom: 3px;
        }

        .info-card-value {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-heading, #1a1a1a);
            line-height: 1.4;
        }

        .info-card-sub {
            font-size: 0.78rem;
            color: var(--text-muted, #6c757d);
            margin-top: 2px;
        }

        /* Products Section */
        .products-section {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border-color, rgba(0, 0, 0, 0.07));
        }

        .products-section-title {
            padding: 10px 16px;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: var(--bg-light, #f8f9fa);
            border-bottom: 1px solid var(--border-color, rgba(0, 0, 0, 0.07));
            color: var(--text-muted, #6c757d);
        }

        .order-table thead th {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: var(--text-muted, #6c757d);
            padding: 10px 16px;
            background: var(--bg-card, #fff);
            border-bottom: 1px solid var(--border-color, rgba(0, 0, 0, 0.07));
        }

        .order-table tbody td {
            padding: 12px 16px;
            font-size: 0.88rem;
            border-bottom: 1px solid var(--border-color, rgba(0, 0, 0, 0.04));
            vertical-align: middle;
        }

        .order-table tbody tr:last-child td { border-bottom: none; }

        .qty-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--bg-light, #f1f5f9);
            font-weight: 700;
            font-size: 0.82rem;
        }

        .summary-row td {
            padding: 8px 16px !important;
            font-size: 0.85rem;
            border-bottom: 1px solid var(--border-color, rgba(0, 0, 0, 0.04)) !important;
            background: var(--bg-light, #f8f9fa);
        }

        .total-row td {
            padding: 12px 16px !important;
            background: rgba(234, 88, 12, 0.06);
            border-top: 2px solid rgba(234, 88, 12, 0.15) !important;
        }

        .total-amount {
            font-size: 1.05rem;
            font-weight: 800;
            color: #ea580c;
        }

        /* =============================================
           DARK MODE
        ============================================= */
        [data-theme="dark"] .order-card {
            background: var(--bg-card, #1e293b);
            border-color: var(--border-color, #334155);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
        }

        [data-theme="dark"] .order-header:hover {
            background: rgba(234, 88, 12, 0.06);
        }

        [data-theme="dark"] .order-id    { color: var(--text-heading, #F1F5F9); }
        [data-theme="dark"] .order-total { color: #fb923c; }

        [data-theme="dark"] .info-card {
            background: rgba(255, 255, 255, 0.04);
            border-color: var(--border-color, #334155);
        }

        [data-theme="dark"] .info-card-value  { color: var(--text-heading, #F1F5F9); }
        [data-theme="dark"] .products-section { border-color: var(--border-color, #334155); }

        [data-theme="dark"] .products-section-title {
            background: rgba(255, 255, 255, 0.04);
            border-color: var(--border-color, #334155);
        }

        [data-theme="dark"] .order-body { border-color: var(--border-color, #334155); }

        [data-theme="dark"] .order-table thead th {
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--border-color, #334155);
        }

        [data-theme="dark"] .order-table tbody td {
            border-color: rgba(255, 255, 255, 0.05);
            color: var(--text-main, #E2E8F0);
        }

        [data-theme="dark"] .order-table tbody tr:last-child td { border-bottom: none; }

        [data-theme="dark"] .summary-row td {
            background: rgba(255, 255, 255, 0.03) !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
            color: var(--text-muted, #94A3B8) !important;
        }

        [data-theme="dark"] .total-row td {
            background: rgba(234, 88, 12, 0.08) !important;
            border-color: rgba(234, 88, 12, 0.2) !important;
        }

        [data-theme="dark"] .total-amount { color: #fb923c; }

        [data-theme="dark"] .qty-badge {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-main, #E2E8F0);
        }

        [data-theme="dark"] .status-pending    { background: rgba(251, 191, 36, 0.15);  color: #FCD34D; }
        [data-theme="dark"] .status-diproses   { background: rgba(59, 130, 246, 0.15);  color: #93C5FD; }
        [data-theme="dark"] .status-dikirim    { background: rgba(139, 92, 246, 0.15);  color: #C4B5FD; }
        [data-theme="dark"] .status-selesai    { background: rgba(34, 197, 94, 0.15);   color: #6EE7B7; }
        [data-theme="dark"] .status-dibatalkan { background: rgba(248, 113, 113, 0.15); color: #FCA5A5; }

        [data-theme="dark"] .btn-action-view {
            background: rgba(234, 88, 12, 0.12);
            color: #fb923c;
        }

        [data-theme="dark"] .btn-action-view:hover {
            background: linear-gradient(135deg, #c2410c, #ea580c);
            color: #fff;
        }

        [data-theme="dark"] .info-icon-person {
            background: rgba(234, 88, 12, 0.15);
            color: #fb923c;
        }
    </style>
@endpush

@push('scripts')
    <script>
        AOS.init({ duration: 700, once: true, offset: 80 });

        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function (el) {
            var target = document.querySelector(el.getAttribute('data-bs-target'));
            if (!target) return;

            target.addEventListener('show.bs.collapse', function () {
                el.querySelector('.chevron-icon').style.transform = 'rotate(180deg)';
            });
            target.addEventListener('hide.bs.collapse', function () {
                el.querySelector('.chevron-icon').style.transform = 'rotate(0deg)';
            });

            if (target.classList.contains('show')) {
                el.querySelector('.chevron-icon').style.transform = 'rotate(180deg)';
            }
        });
    </script>
@endpush