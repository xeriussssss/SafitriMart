<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Breadcrumb -->
    <nav class="container py-3 bg-light">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('katalog')); ?>" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('keranjang.index')); ?>" class="text-decoration-none">Keranjang</a>
            </li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
    </nav>

    <section class="py-5">
        <div class="container">
            <h1 class="text-center mb-2" data-aos="fade-up">
                <i class="bi bi-credit-card me-2"></i>Checkout
            </h1>
            <p class="text-muted text-center mb-5" data-aos="fade-up" data-aos-delay="50">
                Lengkapi data pengiriman untuk memproses pesanan
            </p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form action="<?php echo e(route('checkout.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <!-- Informasi Pengiriman -->
                    <div class="col-lg-7 mb-4" data-aos="fade-right">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-4 fw-bold">
                                    <i class="bi bi-person-vcard me-2 text-primary"></i>Informasi Pengiriman
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['nama_pembeli'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="nama_pembeli" value="<?php echo e(old('nama_pembeli', auth()->user()->nama)); ?>"
                                        required>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nama_pembeli'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nomor Telepon <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control <?php $__errorArgs = ['no_telepon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="no_telepon" value="<?php echo e(old('no_telepon', auth()->user()->no_telepon)); ?>"
                                        placeholder="08xxxxxxxxxx" required>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['no_telepon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Alamat Lengkap <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="alamat"
                                        rows="3" required
                                        placeholder="Jl. Nama Jalan No. XX, RT/RW, Kelurahan, Kecamatan"><?php echo e(old('alamat')); ?></textarea>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Pilih Kota & Ongkir -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-4 fw-bold">
                                    <i class="bi bi-truck me-2 text-primary"></i>Pilih Pengiriman
                                </h5>

                                <!-- Cari Kota Tujuan -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Kota Tujuan <span
                                            class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" id="kota-search"
                                            placeholder="Ketik nama kota/kecamatan..." autocomplete="off">
                                        <div id="kota-dropdown"
                                            class="position-absolute w-100 bg-white border rounded-3 shadow-sm mt-1"
                                            style="display:none; z-index:1000; max-height:220px; overflow-y:auto;">
                                        </div>
                                    </div>
                                    <input type="hidden" name="destination_id" id="destination-id">
                                    <input type="hidden" name="destination_name" id="destination-name">
                                    <small class="text-muted">Ketik minimal 3 huruf untuk mencari kota</small>
                                </div>

                                <!-- Pilih Kurir -->
                                <div class="mb-3" id="kurir-section" style="display:none;">
                                    <label class="form-label fw-semibold">Kurir <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-2 flex-wrap" id="kurir-list">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['jne' => 'JNE', 'pos' => 'POS Indonesia', 'tiki' => 'TIKI', 'sicepat' => 'SiCepat']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <button type="button" class="btn btn-outline-secondary btn-sm kurir-btn"
                                                data-kurir="<?php echo e($kode); ?>">
                                                <?php echo e($nama); ?>

                                            </button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <input type="hidden" name="kurir" id="kurir-input">
                                </div>

                                <!-- Loading -->
                                <div id="ongkir-loading" style="display:none;" class="text-center py-3">
                                    <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                                    <span class="text-muted small">Menghitung ongkir...</span>
                                </div>

                                <!-- Hasil Ongkir -->
                                <div id="ongkir-result" style="display:none;">
                                    <label class="form-label fw-semibold">Pilih Layanan</label>
                                    <div id="ongkir-services" class="d-grid gap-2"></div>
                                    <input type="hidden" name="ongkir" id="ongkir-input" value="0">
                                    <input type="hidden" name="layanan_kurir" id="layanan-kurir-input">
                                </div>

                                <!-- Info asal -->
                                <div class="alert alert-info small mt-3 mb-0">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    Pengiriman dari: <strong>Jalan Pasar Sumani, Kec. X Koto Singkarak, Kabupaten Solok,
                                        Sumatera Barat </strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Metode Pembayaran & Ringkasan -->
                    <div class="col-lg-5" data-aos="fade-left">
                        <!-- Metode Pembayaran -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-4 fw-bold">
                                    <i class="bi bi-wallet2 me-2 text-primary"></i>Metode Pembayaran
                                </h5>
                                <div class="d-grid gap-2">
                                    <div class="form-check payment-option p-3 border rounded-3">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran"
                                            id="payment_cod" value="cod" required>
                                        <label class="form-check-label w-100" for="payment_cod">
                                            <i class="bi bi-hand-thumbs-up me-2 text-success"></i><strong>COD (Bayar di
                                                Tempat)</strong>
                                            <small class="d-block text-muted">Bayar saat paket tiba</small>
                                        </label>
                                    </div>
                                    <div class="form-check payment-option p-3 border rounded-3">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran"
                                            id="payment_qris" value="qris">
                                        <label class="form-check-label w-100" for="payment_qris">
                                            <i class="bi bi-qr-code me-2 text-primary"></i><strong>QRIS</strong>
                                            <small class="d-block text-muted">Scan QR untuk pembayaran instan</small>
                                        </label>
                                    </div>
                                    <div class="form-check payment-option p-3 border rounded-3">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran"
                                            id="payment_dana" value="dana">
                                        <label class="form-check-label w-100" for="payment_dana">
                                            <i class="bi bi-phone me-2 text-info"></i><strong>DANA</strong>
                                            <small class="d-block text-muted">Bayar melalui e-wallet DANA</small>
                                        </label>
                                    </div>
                                    <div class="form-check payment-option p-3 border rounded-3">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran"
                                            id="payment_transfer" value="transfer_bank">
                                        <label class="form-check-label w-100" for="payment_transfer">
                                            <i class="bi bi-bank me-2 text-warning"></i><strong>Transfer Bank</strong>
                                            <small class="d-block text-muted">Transfer ke rekening bank kami</small>
                                        </label>
                                    </div>
                                    
                                    <div class="form-check payment-option p-3 border rounded-3">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran"
                                            id="payment_midtrans" value="midtrans">
                                        <label class="form-check-label w-100" for="payment_midtrans">
                                            <i class="bi bi-credit-card-2-front me-2 text-danger"></i>
                                            <strong>Bayar Online (Midtrans)</strong>
                                            <small class="d-block text-muted">Kartu Kredit, GoPay, OVO, ShopeePay, VA Bank
                                                &amp; lainnya</small>
                                            <div class="mt-2 d-flex flex-wrap gap-1">
                                                <span class="badge bg-light text-dark border" style="font-size:10px;">💳
                                                    Kartu Kredit</span>
                                                <span class="badge bg-light text-dark border"
                                                    style="font-size:10px;">GoPay</span>
                                                <span class="badge bg-light text-dark border"
                                                    style="font-size:10px;">OVO</span>
                                                <span class="badge bg-light text-dark border"
                                                    style="font-size:10px;">ShopeePay</span>
                                                <span class="badge bg-light text-dark border" style="font-size:10px;">VA
                                                    BCA/BNI/BRI</span>
                                                <span class="badge bg-light text-dark border"
                                                    style="font-size:10px;">QRIS</span>
                                            </div>
                                        </label>
                                    </div>
                                    
                                </div>

                                <!-- DANA Sub-type -->
                                <div id="dana-subtype-section" class="mt-3" style="display:none;">
                                    <h6 class="fw-bold mb-2"><i class="bi bi-phone me-1 text-info"></i>Cara Pembayaran DANA
                                    </h6>
                                    <div class="d-grid gap-2">
                                        <div class="form-check payment-subtype-option p-3 border rounded-3">
                                            <input class="form-check-input" type="radio" name="sub_tipe_pembayaran"
                                                id="dana_nomor_hp" value="nomor_hp">
                                            <label class="form-check-label w-100" for="dana_nomor_hp">
                                                <i class="bi bi-person me-2 text-info"></i><strong>Via Nomor HP</strong>
                                            </label>
                                        </div>
                                        <div class="form-check payment-subtype-option p-3 border rounded-3">
                                            <input class="form-check-input" type="radio" name="sub_tipe_pembayaran"
                                                id="dana_qr_code" value="qr_code">
                                            <label class="form-check-label w-100" for="dana_qr_code">
                                                <i class="bi bi-qr-code me-2 text-info"></i><strong>Via QR Code</strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail QRIS -->
                                <div id="payment-detail-qris" class="mt-3" style="display:none;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($qrisQrImage)): ?>
                                        <div class="text-center bg-white p-3 rounded-3 border">
                                            <img src="<?php echo e(Storage::disk('public')->url($qrisQrImage)); ?>" alt="QR QRIS"
                                                class="img-fluid rounded" style="max-width:200px;">
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- Detail Transfer Bank -->
                                <div id="payment-detail-transfer_bank" class="mt-3" style="display:none;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card border-0 bg-light mb-2">
                                            <div class="card-body p-3">
                                                <h6 class="fw-bold mb-1"><?php echo e($bank['bank_name']); ?></h6>
                                                <p class="mb-0 fw-bold font-monospace"><?php echo e($bank['account_number']); ?></p>
                                                <p class="mb-0 text-muted small">a.n. <?php echo e($bank['account_holder']); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- Detail DANA HP -->
                                <div id="dana-nomor-hp-section" class="mt-3" style="display:none;">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body p-3 text-center">
                                            <p class="fw-bold fs-5 font-monospace mb-1"><?php echo e($danaPhone); ?></p>
                                            <p class="text-muted small mb-0">a.n. <?php echo e($danaName); ?></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail DANA QR -->
                                <div id="dana-qr-code-section" class="mt-3" style="display:none;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($danaQrImage)): ?>
                                        <div class="text-center">
                                            <img src="<?php echo e(Storage::disk('public')->url($danaQrImage)); ?>" alt="QR DANA"
                                                class="img-fluid rounded" style="max-width:200px;">
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- Bukti Pembayaran -->
                                <div id="payment-proof-section" class="mt-3" style="display:none;">
                                    <label class="form-label fw-semibold"><i class="bi bi-camera me-1"></i>Upload Bukti
                                        Pembayaran</label>
                                    <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, max 2MB</small>
                                </div>

                                
                                <div id="payment-detail-midtrans" class="mt-3" style="display:none;">
                                    <div class="alert alert-info mb-0">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-info-circle-fill me-2 mt-1 flex-shrink-0"></i>
                                            <div>
                                                <strong>Pembayaran Online via Midtrans</strong>
                                                <p class="mb-0 small mt-1">
                                                    Setelah klik <strong>"Buat Pesanan"</strong>, Anda akan diarahkan ke
                                                    halaman pembayaran Midtrans yang aman. Pilih metode bayar yang Anda
                                                    inginkan (kartu kredit, e-wallet, virtual account, dll).
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <!-- Ringkasan Pesanan -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-4 fw-bold">
                                    <i class="bi bi-receipt me-2 text-primary"></i>Ringkasan Pesanan
                                </h5>

                                <div class="table-responsive mb-3">
                                    <table class="table table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Produk</th>
                                                <th class="text-center">Jml</th>
                                                <th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <small class="d-block fw-bold"><?php echo e($item->produk->nama); ?></small>
                                                        <small class="text-muted">Rp
                                                            <?php echo e(number_format($item->produk->harga, 0, ',', '.')); ?></small>
                                                    </td>
                                                    <td class="text-center"><?php echo e($item->jumlah); ?></td>
                                                    <td class="text-end">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Voucher -->
                                <div class="mb-3">
                                    <h6 class="fw-bold mb-2"><i class="bi bi-ticket-perforated me-1 text-warning"></i>Kode
                                        Voucher</h6>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="voucher-input"
                                            placeholder="Kode voucher" style="text-transform:uppercase;">
                                        <button type="button" class="btn btn-outline-primary"
                                            id="voucher-apply-btn">Terapkan</button>
                                    </div>
                                    <div id="voucher-message" class="mt-2 small" style="display:none;"></div>
                                    <div id="voucher-applied" class="mt-2" style="display:none;">
                                        <div
                                            class="d-flex justify-content-between align-items-center bg-success bg-opacity-10 rounded-3 p-2 px-3">
                                            <div>
                                                <i class="bi bi-check-circle text-success me-1"></i>
                                                <strong id="voucher-applied-code"></strong>
                                            </div>
                                            <button type="button" class="btn btn-sm text-danger" id="voucher-remove-btn"><i
                                                    class="bi bi-x-lg"></i></button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="voucher_id" id="voucher-id-input">
                                </div>

                                <!-- Total -->
                                <table class="table table-sm mb-3">
                                    <tbody>
                                        <tr>
                                            <td class="text-end text-muted">Subtotal:</td>
                                            <td class="text-end fw-bold" id="summary-subtotal">Rp
                                                <?php echo e(number_format($subtotal, 0, ',', '.')); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-end text-muted">Ongkir:</td>
                                            <td class="text-end fw-bold text-primary" id="summary-ongkir">Pilih kurir</td>
                                        </tr>
                                        <tr id="voucher-discount-row" style="display:none;">
                                            <td class="text-end text-success"><i
                                                    class="bi bi-ticket-perforated me-1"></i>Diskon:</td>
                                            <td class="text-end text-success fw-bold" id="voucher-discount-amount">- Rp 0
                                            </td>
                                        </tr>
                                        <tr class="border-top">
                                            <td class="text-end fw-bold fs-6">Total:</td>
                                            <td class="text-end fw-bold fs-5 text-primary" id="summary-total">Rp
                                                <?php echo e(number_format($subtotal, 0, ',', '.')); ?>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                    <i class="bi bi-check-circle me-2"></i>Buat Pesanan
                                </button>
                                <a href="<?php echo e(route('keranjang.index')); ?>" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('css/checkout.css')); ?>" rel="stylesheet">
    <style>
        .kurir-btn.active {
            background: var(--primary-gradient);
            color: #fff;
            border-color: transparent;
        }

        .ongkir-service-btn {
            background: var(--bg-card);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 16px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: left;
            width: 100%;
        }

        .ongkir-service-btn:hover,
        .ongkir-service-btn.active {
            border-color: #ea580c;
            background: rgba(234, 88, 12, 0.06);
        }

        #kota-dropdown div {
            padding: 10px 14px;
            cursor: pointer;
            font-size: 0.875rem;
            border-bottom: 1px solid #f0f0f0;
        }

        #kota-dropdown div:hover {
            background: #fff8f5;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        AOS.init({ duration: 800, once: true, offset: 100 });

        const subtotal = <?php echo e($subtotal); ?>;
        let appliedDiscount = 0;
        let appliedOngkir = 0;
        let searchTimeout = null;

        // =============================================
        // PENCARIAN KOTA
        // =============================================
        const kotaSearch = document.getElementById('kota-search');
        const kotaDropdown = document.getElementById('kota-dropdown');
        const destinationId = document.getElementById('destination-id');
        const destinationName = document.getElementById('destination-name');

        kotaSearch.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const keyword = this.value.trim();
            if (keyword.length < 3) {
                kotaDropdown.style.display = 'none';
                return;
            }
            searchTimeout = setTimeout(() => searchKota(keyword), 400);
        });

        function searchKota(keyword) {
            fetch(`/ongkir/search?name=${encodeURIComponent(keyword)}`)
                .then(r => r.json())
                .then(data => {
                    kotaDropdown.innerHTML = '';
                    const results = data.data || [];
                    if (results.length === 0) {
                        kotaDropdown.innerHTML = '<div class="text-muted px-3 py-2">Kota tidak ditemukan</div>';
                        kotaDropdown.style.display = 'block';
                        return;
                    }
                    results.forEach(item => {
                        const div = document.createElement('div');
                        div.textContent = item.label;
                        div.addEventListener('click', () => {
                            kotaSearch.value = item.label;
                            destinationId.value = item.id;
                            destinationName.value = item.label;
                            kotaDropdown.style.display = 'none';
                            document.getElementById('kurir-section').style.display = 'block';
                            resetOngkir();
                        });
                        kotaDropdown.appendChild(div);
                    });
                    kotaDropdown.style.display = 'block';
                })
                .catch(() => kotaDropdown.style.display = 'none');
        }

        document.addEventListener('click', function (e) {
            if (!kotaSearch.contains(e.target) && !kotaDropdown.contains(e.target)) {
                kotaDropdown.style.display = 'none';
            }
        });

        // =============================================
        // PILIH KURIR & HITUNG ONGKIR
        // =============================================
        let selectedKurir = null;

        document.querySelectorAll('.kurir-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.kurir-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                selectedKurir = this.dataset.kurir;
                document.getElementById('kurir-input').value = selectedKurir;
                hitungOngkir();
            });
        });

        function hitungOngkir() {
            const destId = destinationId.value;
            if (!destId || !selectedKurir) return;

            document.getElementById('ongkir-loading').style.display = 'block';
            document.getElementById('ongkir-result').style.display = 'none';

            const totalBerat = <?php echo e($items->sum('jumlah')); ?> * 500;

            fetch('/ongkir/calculate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    destination_id: destId,
                    weight: totalBerat,
                    courier: selectedKurir
                })
            })
                .then(r => r.json())
                .then(data => {
                    document.getElementById('ongkir-loading').style.display = 'none';
                    const services = data.data || [];
                    if (services.length === 0) {
                        document.getElementById('ongkir-services').innerHTML =
                            '<div class="alert alert-warning small">Tidak ada layanan tersedia untuk kurir ini.</div>';
                        document.getElementById('ongkir-result').style.display = 'block';
                        return;
                    }
                    renderOngkirServices(services);
                })
                .catch(() => {
                    document.getElementById('ongkir-loading').style.display = 'none';
                    document.getElementById('ongkir-services').innerHTML =
                        '<div class="alert alert-danger small">Gagal menghitung ongkir. Coba lagi.</div>';
                    document.getElementById('ongkir-result').style.display = 'block';
                });
        }

        function renderOngkirServices(services) {
            const container = document.getElementById('ongkir-services');
            container.innerHTML = '';

            services.forEach(service => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'ongkir-service-btn';
                btn.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold">${service.service_name}</span>
                            <small class="d-block text-muted">${service.etd ? 'Estimasi: ' + service.etd + ' hari' : ''}</small>
                        </div>
                        <span class="fw-bold text-primary">Rp ${formatNumber(service.price)}</span>
                    </div>`;
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.ongkir-service-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    appliedOngkir = service.price;
                    document.getElementById('ongkir-input').value = appliedOngkir;
                    document.getElementById('layanan-kurir-input').value = service.service_name;
                    document.getElementById('summary-ongkir').textContent = 'Rp ' + formatNumber(appliedOngkir);
                    updateTotal();
                });
                container.appendChild(btn);
            });

            document.getElementById('ongkir-result').style.display = 'block';
        }

        function resetOngkir() {
            appliedOngkir = 0;
            document.getElementById('ongkir-input').value = 0;
            document.getElementById('ongkir-result').style.display = 'none';
            document.getElementById('summary-ongkir').textContent = 'Pilih kurir';
            updateTotal();
        }

        // =============================================
        // VOUCHER
        // =============================================
        document.getElementById('voucher-apply-btn').addEventListener('click', applyVoucher);
        document.getElementById('voucher-remove-btn').addEventListener('click', function () {
            appliedDiscount = 0;
            document.getElementById('voucher-id-input').value = '';
            document.getElementById('voucher-input').value = '';
            document.getElementById('voucher-input').disabled = false;
            document.getElementById('voucher-apply-btn').disabled = false;
            document.getElementById('voucher-applied').style.display = 'none';
            document.getElementById('voucher-message').style.display = 'none';
            document.getElementById('voucher-discount-row').style.display = 'none';
            updateTotal();
        });

        function applyVoucher() {
            const kode = document.getElementById('voucher-input').value.trim().toUpperCase();
            if (!kode) return;

            document.getElementById('voucher-apply-btn').disabled = true;
            document.getElementById('voucher-apply-btn').innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Memeriksa...';

            fetch('<?php echo e(route('checkout.validate-voucher')); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                body: JSON.stringify({ kode_voucher: kode, subtotal })
            })
                .then(r => r.json())
                .then(data => {
                    document.getElementById('voucher-apply-btn').disabled = false;
                    document.getElementById('voucher-apply-btn').innerHTML = 'Terapkan';
                    if (data.success) {
                        appliedDiscount = data.diskon;
                        document.getElementById('voucher-id-input').value = data.voucher_id;
                        document.getElementById('voucher-applied-code').textContent = data.kode;
                        document.getElementById('voucher-input').disabled = true;
                        document.getElementById('voucher-apply-btn').disabled = true;
                        document.getElementById('voucher-applied').style.display = 'block';
                        document.getElementById('voucher-message').style.display = 'none';
                        document.getElementById('voucher-discount-row').style.display = '';
                        document.getElementById('voucher-discount-amount').textContent = '- Rp ' + formatNumber(data.diskon);
                        updateTotal();
                    } else {
                        const msg = document.getElementById('voucher-message');
                        msg.textContent = data.message;
                        msg.className = 'mt-2 small text-danger';
                        msg.style.display = 'block';
                    }
                });
        }

        // =============================================
        // UPDATE TOTAL
        // =============================================
        function updateTotal() {
            const total = Math.max(0, subtotal + appliedOngkir - appliedDiscount);
            document.getElementById('summary-total').textContent = 'Rp ' + formatNumber(total);
        }

        function formatNumber(num) {
            return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // =============================================
        // METODE PEMBAYARAN
        // =============================================
        document.querySelectorAll('.payment-option').forEach(option => {
            const radio = option.querySelector('input[type="radio"]');
            option.addEventListener('click', function () {
                document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('border-primary', 'bg-light'));
                option.classList.add('border-primary', 'bg-light');
                radio.checked = true;
                showPaymentDetail(radio.value);
            });
        });

        document.querySelectorAll('.payment-subtype-option').forEach(option => {
            option.addEventListener('click', function () {
                document.querySelectorAll('.payment-subtype-option').forEach(o => o.classList.remove('border-primary', 'bg-light'));
                option.classList.add('border-primary', 'bg-light');
                const radio = option.querySelector('input[type="radio"]');
                radio.checked = true;
                showDanaSubtype(radio.value);
            });
        });

        function showPaymentDetail(method) {
            // Sembunyikan semua detail termasuk midtrans
            ['qris', 'transfer_bank', 'dana', 'midtrans'].forEach(m => {
                const el = document.getElementById('payment-detail-' + m);
                if (el) el.style.display = 'none';
            });
            document.getElementById('dana-subtype-section').style.display = 'none';
            document.getElementById('payment-proof-section').style.display = 'none';

            // Tampilkan detail sesuai metode yang dipilih
            const detail = document.getElementById('payment-detail-' + method);
            if (detail) detail.style.display = 'block';

            if (method === 'dana') {
                document.getElementById('dana-subtype-section').style.display = 'block';
                showDanaSubtype('nomor_hp');
                document.getElementById('dana_nomor_hp').checked = true;
            }
            if (method === 'transfer_bank') {
                document.getElementById('payment-proof-section').style.display = 'block';
            }
        }

        function showDanaSubtype(subtype) {
            document.getElementById('dana-nomor-hp-section').style.display = subtype === 'nomor_hp' ? 'block' : 'none';
            document.getElementById('dana-qr-code-section').style.display = subtype === 'qr_code' ? 'block' : 'none';
            document.getElementById('payment-proof-section').style.display = subtype === 'nomor_hp' ? 'block' : 'none';
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\AutoCommerce-LaravelCloud\AutoCommerce-main\resources\views/checkout/create.blade.php ENDPATH**/ ?>