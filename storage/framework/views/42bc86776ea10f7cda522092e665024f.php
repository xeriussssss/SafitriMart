<?php $__env->startSection('title', 'Detail Pesanan #TRX' . str_pad($pesanan->id, 6, '0', STR_PAD_LEFT)); ?>

<?php $__env->startSection('content'); ?>
    <!-- Breadcrumb -->
    <nav class="container py-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('katalog')); ?>" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('pesanan.index')); ?>" class="text-decoration-none">Pesanan Saya</a>
            </li>
            <li class="breadcrumb-item active">Detail #TRX<?php echo e(str_pad($pesanan->id, 6, '0', STR_PAD_LEFT)); ?></li>
        </ol>
    </nav>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <h1 class="text-center fw-bold mb-2" data-aos="fade-up">
                        <i class="bi bi-receipt me-2"></i>Detail Pesanan
                    </h1>
                    <p class="text-muted text-center mb-5" data-aos="fade-up" data-aos-delay="50">
                        Informasi lengkap pesanan Anda
                    </p>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-up">
                        <div class="card-body p-4">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                                <div>
                                    <h5 class="fw-bold mb-1">#TRX<?php echo e(str_pad($pesanan->id, 6, '0', STR_PAD_LEFT)); ?></h5>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-calendar me-1"></i><?php echo e($pesanan->created_at->format('d M Y, H:i')); ?>

                                    </p>
                                </div>
                                <span class="badge bg-<?php echo e(match ($pesanan->status) {
        'pending' => 'warning',
        'diproses' => 'info',
        'dikirim' => 'primary',
        'selesai' => 'success',
        'dibatalkan' => 'danger',
        default => 'secondary'
    }); ?> px-3 py-2 fs-6">
                                    <i class="bi bi-<?php echo e(match ($pesanan->status) {
        'pending' => 'clock',
        'diproses' => 'gear',
        'dikirim' => 'truck',
        'selesai' => 'check-circle',
        'dibatalkan' => 'x-circle',
        default => 'question-circle'
    }); ?> me-1"></i>
                                    <?php echo e(match ($pesanan->status) {
        'pending' => 'Menunggu Pembayaran',
        'diproses' => 'Sedang Diproses',
        'dikirim' => 'Dikirim',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
        default => $pesanan->status
    }); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row g-3 mb-4" data-aos="fade-up">
                        <div class="col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-2">
                                        <i class="bi bi-wallet2 me-1 text-primary"></i>Pembayaran
                                    </h6>
                                    <?php
                                        $paymentLabels = [
                                            'cod' => 'Bayar di Tempat (COD)',
                                            'qris' => 'QRIS',
                                            'dana' => 'DANA',
                                            'transfer_bank' => 'Transfer Bank',
                                            'midtrans' => 'Bayar Online (Midtrans)',
                                        ];
                                    ?>
                                    <p class="mb-0 small fw-bold">
                                        <?php echo e($paymentLabels[$pesanan->metode_pembayaran] ?? $pesanan->metode_pembayaran); ?>

                                    </p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pesanan->midtrans_payment_type): ?>
                                        <p class="mb-0 small text-muted">via <?php echo e(strtoupper($pesanan->midtrans_payment_type)); ?>

                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-2">
                                        <i class="bi bi-geo-alt me-1 text-primary"></i>Alamat Pengiriman
                                    </h6>
                                    <p class="mb-0 small"><?php echo e($pesanan->alamat); ?></p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pesanan->kurir): ?>
                                        <p class="mb-0 small text-muted mt-1">
                                            <i class="bi bi-truck me-1"></i><?php echo e(strtoupper($pesanan->kurir)); ?> -
                                            <?php echo e($pesanan->layanan_kurir); ?>

                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-2">
                                        <i class="bi bi-person me-1 text-primary"></i>Penerima
                                    </h6>
                                    <p class="mb-0 small fw-bold"><?php echo e($pesanan->nama_pembeli); ?></p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pesanan->no_telepon): ?>
                                        <p class="mb-0 small text-muted">
                                            <i class="bi bi-telephone me-1"></i><?php echo e($pesanan->no_telepon); ?>

                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <p class="mb-0 small text-muted"><?php echo e($pesanan->user->email); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-up">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-box-seam me-1"></i>Detail Produk
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:45%;">Produk</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pesanan->detailTransaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><strong><?php echo e($detail->nama_produk); ?></strong></td>
                                                <td class="text-center">Rp
                                                    <?php echo e(number_format($detail->harga_satuan, 0, ',', '.')); ?></td>
                                                <td class="text-center"><?php echo e($detail->jumlah); ?></td>
                                                <td class="text-end fw-bold">Rp
                                                    <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end text-muted">Subtotal:</td>
                                            <td class="text-end fw-bold">Rp
                                                <?php echo e(number_format($pesanan->total, 0, ',', '.')); ?></td>
                                        </tr>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pesanan->ongkir > 0): ?>
                                            <tr>
                                                <td colspan="3" class="text-end text-muted">Ongkos Kirim:</td>
                                                <td class="text-end fw-bold">Rp
                                                    <?php echo e(number_format($pesanan->ongkir, 0, ',', '.')); ?></td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-end text-muted">Ongkos Kirim:</td>
                                                <td class="text-end text-success fw-bold">Gratis</td>
                                            </tr>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pesanan->diskon_voucher > 0): ?>
                                            <tr>
                                                <td colspan="3" class="text-end text-success">
                                                    <i class="bi bi-ticket-perforated me-1"></i>Diskon Voucher:
                                                </td>
                                                <td class="text-end text-success fw-bold">- Rp
                                                    <?php echo e(number_format($pesanan->diskon_voucher, 0, ',', '.')); ?></td>
                                            </tr>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <tr class="border-top">
                                            <td colspan="3" class="text-end fw-bold fs-6">Total Bayar:</td>
                                            <td class="text-end fw-bold fs-5 text-primary">
                                                Rp
                                                <?php echo e(number_format($pesanan->total_bayar ?? $pesanan->total, 0, ',', '.')); ?>

                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pesanan->status === 'pending' && $pesanan->metode_pembayaran === 'midtrans'): ?>
                        <div class="card border-0 shadow-sm mb-4 border-start border-warning border-4" data-aos="fade-up">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">
                                    <i class="bi bi-credit-card me-1 text-warning"></i>Selesaikan Pembayaran
                                </h5>
                                <p class="text-muted small mb-3">
                                    Pesanan Anda belum dibayar. Klik tombol di bawah untuk melanjutkan pembayaran via Midtrans.
                                </p>
                                <a href="<?php echo e(route('pesanan.bayar-midtrans', $pesanan)); ?>" class="btn btn-warning fw-bold">
                                    <i class="bi bi-credit-card me-1"></i>Bayar Sekarang
                                </a>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pesanan->status === 'pending' && $pesanan->metode_pembayaran !== 'midtrans'): ?>
                        <div class="row g-4 mb-4" data-aos="fade-up">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body p-4">
                                        <h5 class="fw-bold mb-3">
                                            <i class="bi bi-info-circle me-1 text-primary"></i>Instruksi Pembayaran
                                        </h5>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pesanan->metode_pembayaran === 'cod'): ?>
                                            <div class="alert alert-success mb-0">
                                                <h6 class="fw-bold mb-2"><i class="bi bi-hand-thumbs-up me-1"></i>COD (Bayar di
                                                    Tempat)</h6>
                                                <ul class="mb-0 small">
                                                    <li>Pastikan Anda berada di lokasi saat kurir tiba</li>
                                                    <li>Siapkan uang pas untuk pembayaran</li>
                                                    <li>Jika tolak barang, biaya pengiriman tetap dibebankan</li>
                                                </ul>
                                            </div>
                                        <?php elseif($pesanan->metode_pembayaran === 'qris'): ?>
                                            <div class="alert alert-primary mb-0">
                                                <h6 class="fw-bold mb-2"><i class="bi bi-qr-code me-1"></i>QRIS</h6>
                                                <ul class="mb-0 small">
                                                    <li>Scan QR Code menggunakan aplikasi e-wallet atau mobile banking</li>
                                                    <li>Batas waktu pembayaran: 15 menit</li>
                                                </ul>
                                            </div>
                                        <?php elseif($pesanan->metode_pembayaran === 'dana'): ?>
                                            <div class="alert alert-info mb-0">
                                                <h6 class="fw-bold mb-2"><i class="bi bi-phone me-1"></i>DANA</h6>
                                                <ul class="mb-0 small">
                                                    <li>Transfer nominal TEPAT sesuai total pesanan</li>
                                                    <li>Setelah transfer, upload bukti pembayaran</li>
                                                    <li>Batas waktu: 24 jam</li>
                                                </ul>
                                            </div>
                                        <?php elseif($pesanan->metode_pembayaran === 'transfer_bank'): ?>
                                            <div class="alert alert-warning mb-0">
                                                <h6 class="fw-bold mb-2"><i class="bi bi-bank me-1"></i>Transfer Bank</h6>
                                                <ul class="mb-0 small">
                                                    <li>Nominal transfer harus TEPAT sama dengan tagihan</li>
                                                    <li>Setelah transfer, upload bukti pembayaran</li>
                                                    <li>Batas waktu: 24 jam</li>
                                                </ul>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body p-4">
                                        <h5 class="fw-bold mb-2 text-danger">
                                            <i class="bi bi-exclamation-triangle me-1"></i>Batalkan Pesanan
                                        </h5>
                                        <p class="text-muted small mb-3">
                                            Stok produk akan dikembalikan dan voucher (jika digunakan) akan dikembalikan ke akun
                                            Anda.
                                        </p>
                                        <form action="<?php echo e(route('pesanan.cancel', $pesanan)); ?>" method="POST"
                                            onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="bi bi-x-circle me-1"></i>Batalkan Pesanan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($pesanan->metode_pembayaran, ['transfer_bank', 'dana'])): ?>
                            <div class="card border-0 shadow-sm mb-4" data-aos="fade-up">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-3">
                                        <i class="bi bi-camera me-1 text-primary"></i>Bukti Pembayaran
                                    </h5>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pesanan->bukti_pembayaran): ?>
                                        <div class="text-center">
                                            <img src="<?php echo e(Storage::disk('public')->url($pesanan->bukti_pembayaran)); ?>"
                                                alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm" style="max-width: 400px;">
                                            <p class="text-success small mt-2">
                                                <i class="bi bi-check-circle me-1"></i>Bukti pembayaran sudah diupload. Menunggu
                                                verifikasi admin.
                                            </p>
                                        </div>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('pesanan.upload.bukti', $pesanan)); ?>" method="POST"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <p class="text-muted small mb-2">Upload screenshot bukti transfer Anda:</p>
                                            <div class="input-group mb-2">
                                                <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*"
                                                    required>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-upload me-1"></i>Upload
                                                </button>
                                            </div>
                                            <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
                                        </form>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-up">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-clock-history me-1"></i>Riwayat Status
                            </h5>
                            <div class="timeline">
                                <div class="d-flex gap-3 mb-3">
                                    <div class="text-center" style="min-width:40px;">
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto"
                                            style="width:30px;height:30px;">
                                            <i class="bi bi-check text-white small"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold small">Pesanan Dibuat</p>
                                        <p class="mb-0 text-muted small"><?php echo e($pesanan->created_at->format('d M Y, H:i')); ?>

                                        </p>
                                    </div>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($pesanan->status, ['diproses', 'dikirim', 'selesai'])): ?>
                                    <div class="d-flex gap-3 mb-3">
                                        <div class="text-center" style="min-width:40px;">
                                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center mx-auto"
                                                style="width:30px;height:30px;">
                                                <i class="bi bi-gear text-white small"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold small">Sedang Diproses</p>
                                            <p class="mb-0 text-muted small"><?php echo e($pesanan->updated_at->format('d M Y, H:i')); ?>

                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($pesanan->status, ['dikirim', 'selesai'])): ?>
                                    <div class="d-flex gap-3 mb-3">
                                        <div class="text-center" style="min-width:40px;">
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto"
                                                style="width:30px;height:30px;">
                                                <i class="bi bi-truck text-white small"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold small">Dikirim</p>
                                            <p class="mb-0 text-muted small"><?php echo e($pesanan->updated_at->format('d M Y, H:i')); ?>

                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pesanan->status === 'selesai'): ?>
                                    <div class="d-flex gap-3 mb-3">
                                        <div class="text-center" style="min-width:40px;">
                                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center mx-auto"
                                                style="width:30px;height:30px;">
                                                <i class="bi bi-check-lg text-white small"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold small">Selesai</p>
                                            <p class="mb-0 text-muted small"><?php echo e($pesanan->updated_at->format('d M Y, H:i')); ?>

                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pesanan->status === 'dibatalkan'): ?>
                                    <div class="d-flex gap-3 mb-3">
                                        <div class="text-center" style="min-width:40px;">
                                            <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center mx-auto"
                                                style="width:30px;height:30px;">
                                                <i class="bi bi-x-lg text-white small"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold small">Pesanan Dibatalkan</p>
                                            <p class="mb-0 text-muted small"><?php echo e($pesanan->updated_at->format('d M Y, H:i')); ?>

                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pesanan->status === 'selesai'): ?>
                        <div class="card border-0 shadow-sm mb-4" data-aos="fade-up">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">
                                    <i class="bi bi-star me-2 text-warning"></i>Beri Rating & Ulasan
                                </h5>
                                <p class="text-muted small mb-4">Ulasan Anda sangat membantu pelanggan lain!</p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pesanan->detailTransaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $existingReview = $pesanan->reviews->where('produk_id', $detail->produk_id)->first(); ?>
                                    <div class="border rounded-3 p-3 mb-3 <?php echo e($existingReview ? 'bg-light' : ''); ?>">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detail->produk && $detail->produk->gambar): ?>
                                                <img src="<?php echo e($detail->produk->imageUrl()); ?>" class="rounded-2"
                                                    style="width:60px;height:60px;object-fit:cover;" alt="<?php echo e($detail->nama_produk); ?>">
                                            <?php else: ?>
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded-2"
                                                    style="width:60px;height:60px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div>
                                                <h6 class="fw-bold mb-0"><?php echo e($detail->nama_produk); ?></h6>
                                                <small class="text-muted">Rp <?php echo e(number_format($detail->harga_satuan, 0, ',', '.')); ?>

                                                    x <?php echo e($detail->jumlah); ?></small>
                                            </div>
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existingReview): ?>
                                            <div class="bg-white rounded-3 p-3">
                                                <div class="d-flex align-items-center gap-1 mb-1">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                                        <i class="bi bi-star-<?php echo e($i <= $existingReview->rating ? 'fill text-warning' : 'text-muted'); ?>"
                                                            style="font-size:1rem;"></i>
                                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existingReview->komentar): ?>
                                                    <p class="text-muted small mb-0">"<?php echo e($existingReview->komentar); ?>"</p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <small class="text-muted"><?php echo e($existingReview->created_at->format('d M Y')); ?></small>
                                            </div>
                                        <?php else: ?>
                                            <form action="<?php echo e(route('pesanan.review', $pesanan)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="detail_transaksi_id" value="<?php echo e($detail->id); ?>">
                                                <div class="mb-2">
                                                    <label class="form-label fw-semibold small">Rating</label>
                                                    <div class="rating-input d-flex gap-1" data-produk="<?php echo e($detail->id); ?>">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                                            <button type="button" class="btn btn-outline-warning btn-sm rating-star p-2"
                                                                data-rating="<?php echo e($i); ?>" data-produk="<?php echo e($detail->id); ?>">
                                                                <i class="bi bi-star"></i>
                                                            </button>
                                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                    <input type="hidden" name="rating" id="rating-<?php echo e($detail->id); ?>" value="0" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label fw-semibold small">Ulasan (opsional)</label>
                                                    <textarea class="form-control form-control-sm" name="komentar" rows="2"
                                                        placeholder="Ceritakan pengalaman Anda..."></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-send me-1"></i>Kirim Rating
                                                </button>
                                            </form>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <a href="<?php echo e(route('pesanan.index')); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Pesanan
                    </a>

                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('css/pesanan.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        AOS.init({ duration: 800, once: true, offset: 100 });

        document.querySelectorAll('.rating-input').forEach(container => {
            const produkId = container.dataset.produk;
            const stars = container.querySelectorAll('.rating-star');
            const ratingInput = document.getElementById('rating-' + produkId);

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const rating = parseInt(this.dataset.rating);
                    ratingInput.value = rating;
                    stars.forEach((s, index) => {
                        s.querySelector('i').className = index < rating ? 'bi bi-star-fill' : 'bi bi-star';
                    });
                });
                star.addEventListener('mouseenter', function () {
                    const rating = parseInt(this.dataset.rating);
                    stars.forEach((s, index) => {
                        s.querySelector('i').className = index < rating ? 'bi bi-star-fill' : 'bi bi-star';
                    });
                });
            });

            container.addEventListener('mouseleave', function () {
                const currentRating = parseInt(ratingInput.value);
                stars.forEach((s, index) => {
                    s.querySelector('i').className = index < currentRating ? 'bi bi-star-fill' : 'bi bi-star';
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\AutoCommerce-LaravelCloud\AutoCommerce-main\resources\views/pesanan/show.blade.php ENDPATH**/ ?>