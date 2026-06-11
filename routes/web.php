<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    KatalogController,
    KeranjangController,
    CheckoutController,
    PesananController,
    WishlistController,
    DashboardController,
    LaporanController,
    OngkirController,
};

/*
|--------------------------------------------------------------------------
| 1. ROUTE PUBLIK (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('katalog');
});

Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
Route::get('/produk/{produk}', [KatalogController::class, 'show'])->name('produk.show');

// Serve uploaded files via /uploads/ route
Route::get('/uploads/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);

    if (!file_exists($fullPath)) {
        $dir = dirname($fullPath);
        $debug = [
            'requested_path' => $fullPath,
            'dir_exists' => is_dir($dir),
            'dir_contents' => is_dir($dir) ? array_values(scandir($dir)) : [],
        ];
        return response()->json(['error' => 'File not found', 'debug' => $debug], 404);
    }

    return response()->file($fullPath, [
        'Content-Type' => mime_content_type($fullPath),
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*');

// Fallback: redirect old /storage/ URLs to /uploads/
Route::get('/storage/{path}', function ($path) {
    return redirect('/uploads/' . $path, 302);
})->where('path', '.*');

// --- Ongkir ---
Route::get('/ongkir/search', [OngkirController::class, 'searchDestination'])->name('ongkir.search');
Route::post('/ongkir/calculate', [OngkirController::class, 'calculate'])->name('ongkir.calculate');
Route::get('/ongkir/provinces', [OngkirController::class, 'getProvinces'])->name('ongkir.provinces');
Route::get('/ongkir/cities', [OngkirController::class, 'getCities'])->name('ongkir.cities');

/*
|--------------------------------------------------------------------------
| MIDTRANS WEBHOOK (Tidak perlu login & tidak perlu CSRF)
| URL ini didaftarkan di dashboard Midtrans sebagai Payment Notification URL
| Contoh: https://domainmu.com/midtrans/callback
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/callback', [CheckoutController::class, 'midtransCallback'])
    ->name('midtrans.callback');

/*
|--------------------------------------------------------------------------
| 2. ROUTE USER (Membutuhkan Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // --- Dashboard ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Keranjang Belanja ---
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/{produk}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::delete('/keranjang/{keranjang}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::patch('/keranjang/{keranjang}', [KeranjangController::class, 'update'])->name('keranjang.update');

    // --- Checkout ---
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/checkout/validate-voucher', [CheckoutController::class, 'validateVoucher'])->name('checkout.validate-voucher');

    // --- Retry Pembayaran Midtrans ---
    Route::get('/pesanan/{transaksi}/bayar-midtrans', [CheckoutController::class, 'retryMidtrans'])
    ->name('pesanan.bayar-midtrans')
    ->middleware('auth');

    // --- Pesanan Saya ---
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/{pesanan}/cancel', [PesananController::class, 'cancel'])->name('pesanan.cancel');
    Route::post('/pesanan/{pesanan}/review', [PesananController::class, 'submitReview'])->name('pesanan.review');
    Route::post('/pesanan/{pesanan}/upload-bukti', [PesananController::class, 'uploadBukti'])->name('pesanan.upload.bukti');

    // --- Profil User ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Wishlist ---
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{produk}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{produk}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');

    // --- Laporan & Export PDF (Admin) ---
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])
            ->name('laporan.export-pdf');
    });
});

require __DIR__ . '/auth.php';
