<?php $__env->startSection('title', 'Wishlist Saya'); ?>

<?php $__env->startSection('content'); ?>
<nav class="container py-3 bg-light">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="<?php echo e(route('katalog')); ?>" class="text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item active">Wishlist</li>
    </ol>
</nav>

<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-4 text-center" data-aos="fade-up">
            <i class="bi bi-heart me-2 text-danger"></i>Wishlist Saya
        </h1>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($wishlists->count() > 0): ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $wishlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 50); ?>">
                <div class="product-card rounded-3 overflow-hidden border-0 shadow-sm bg-white d-flex flex-column h-100">
                    <figure class="product-figure mb-0 position-relative overflow-hidden">
                        <a href="<?php echo e(route('produk.show', $item->produk)); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->produk->gambar): ?>
                            <img src="<?php echo e($item->produk->imageUrl()); ?>" alt="<?php echo e($item->produk->nama); ?>" class="img-fluid product-image w-100">
                            <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center product-placeholder">
                                <i class="bi bi-image display-1 text-muted"></i>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </a>
                        <form action="<?php echo e(route('wishlist.remove', $item->produk)); ?>" method="POST" class="position-absolute top-0 end-0 m-2">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Hapus dari Wishlist">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </figure>
                    <div class="product-info p-3 d-flex flex-column flex-grow-1">
                        <a href="<?php echo e(route('katalog', ['kategori' => $item->produk->kategori_id])); ?>" class="text-decoration-none mb-1">
                            <small class="text-primary text-uppercase fw-semibold" style="font-size:0.7rem;"><?php echo e($item->produk->kategori->nama ?? 'Umum'); ?></small>
                        </a>
                        <a href="<?php echo e(route('produk.show', $item->produk)); ?>" class="text-decoration-none mb-2">
                            <h6 class="fw-bold mb-0 text-dark product-title"><?php echo e($item->produk->nama); ?></h6>
                        </a>
                        <div class="mb-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->produk->harga_diskon && $item->produk->harga_diskon < $item->produk->harga): ?>
                            <span class="text-decoration-line-through text-muted small">Rp <?php echo e(number_format($item->produk->harga, 0, ',', '.')); ?></span>
                            <div class="fs-5 fw-bold text-danger">Rp <?php echo e(number_format($item->produk->harga_diskon, 0, ',', '.')); ?></div>
                            <?php else: ?>
                            <span class="fs-5 fw-bold text-primary">Rp <?php echo e(number_format($item->produk->harga, 0, ',', '.')); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="mt-auto">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->produk->stok > 0): ?>
                            <form action="<?php echo e(route('keranjang.tambah', $item->produk)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="jumlah" value="1">
                                <button type="submit" class="btn btn-cart w-100 btn-sm">
                                    <i class="bi bi-cart-plus me-1"></i>Tambah ke Keranjang
                                </button>
                            </form>
                            <?php else: ?>
                            <button class="btn btn-secondary w-100 btn-sm" disabled>Stok Habis</button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($wishlists->hasPages()): ?>
        <div class="mt-4 d-flex justify-content-center">
            <?php echo e($wishlists->links('vendor.pagination.bootstrap-5')); ?>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php else: ?>
        <div class="text-center py-5" data-aos="fade-up">
            <i class="bi bi-heart display-1 text-muted mb-3 d-block"></i>
            <h4>Wishlist Kosong</h4>
            <p class="text-muted">Anda belum menambahkan produk ke wishlist.</p>
            <a href="<?php echo e(route('katalog')); ?>" class="btn btn-primary mt-2">
                <i class="bi bi-bag me-1"></i>Mulai Belanja
            </a>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/wishlist.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\AutoCommerce-main\resources\views/katalog/wishlist.blade.php ENDPATH**/ ?>