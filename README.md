# 🛒 Safitri Mart — AutoCommerce

Aplikasi e-commerce berbasis web untuk toko kebutuhan sehari-hari, dibangun menggunakan **Laravel 11** dengan panel admin **Filament v3**.

---

## 🚀 Fitur Utama

- 🛍️ **Katalog Produk** — tampilan grid multi-kolom dengan filter kategori
- 🛒 **Keranjang & Checkout** — alur belanja lengkap dari pilih produk hingga pembayaran
- 💳 **Payment Gateway Midtrans** — integrasi Snap untuk pembayaran online (sandbox & production)
- 📦 **Manajemen Stok** — pencatatan stok masuk/keluar (StokMasuk / StokKeluar)
- 🎟️ **Voucher Diskon** — sistem kode voucher dengan batas pemakaian per user
- 🚚 **Ongkir Otomatis** — kalkulasi ongkir via Binderbyte API
- 📱 **Notifikasi WhatsApp** — pengiriman notifikasi order via Fonnte API
- 🔔 **Notifikasi Database Filament** — notifikasi real-time di panel admin saat ada order baru
- 📊 **Laporan Bulanan** — export laporan transaksi ke PDF via DomPDF
- 📝 **Activity Log** — pencatatan aktivitas admin menggunakan `spatie/laravel-activitylog`
- ⭐ **Wishlist & Review Produk** — fitur simpan produk favorit dan ulasan pembeli
- 👤 **Role-Based Access** — hak akses Admin dan Staff Gudang

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 11 |
| Admin Panel | Filament v3 |
| Frontend | Blade + Tailwind CSS |
| Database | MySQL |
| Payment | Midtrans Snap |
| Notifikasi WA | Fonnte API |
| Ongkir | Binderbyte API |
| PDF | barryvdh/laravel-dompdf |
| Activity Log | spatie/laravel-activitylog |

---

## 📁 Struktur Project

```
AutoCommerce/
├── app/
│   ├── Filament/
│   │   ├── Pages/
│   │   │   └── Dashboard.php
│   │   ├── Resources/
│   │   │   ├── ActivityLogResource.php
│   │   │   ├── KategoriResource.php
│   │   │   ├── PengaturanPembayaranResource.php
│   │   │   ├── ProdukResource.php
│   │   │   ├── TransaksiResource.php
│   │   │   ├── UserResource.php
│   │   │   └── VoucherResource.php
│   │   └── Widgets/
│   │       ├── StatsOverviewWidget.php
│   │       ├── PendapatanChartWidget.php
│   │       ├── ProdukChartWidget.php
│   │       ├── TransaksiChartWidget.php
│   │       ├── TransaksiTerbaruWidget.php
│   │       ├── StokMenipisWidget.php
│   │       └── ExportLaporanWidget.php
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/
│   │       ├── CheckoutController.php
│   │       ├── DashboardController.php
│   │       ├── KatalogController.php
│   │       ├── KeranjangController.php
│   │       ├── LaporanController.php
│   │       ├── OngkirController.php
│   │       ├── PesananController.php
│   │       ├── ProfileController.php
│   │       └── WishlistController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Produk.php
│   │   ├── Kategori.php
│   │   ├── Transaksi.php
│   │   ├── DetailTransaksi.php
│   │   ├── Keranjang.php
│   │   ├── Voucher.php
│   │   ├── Wishlist.php
│   │   ├── ProdukReview.php
│   │   └── PengaturanPembayaran.php
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   └── Filament/
│   │       └── AdminPanelProvider.php
│   └── Services/
│       └── ActivityLogger.php
├── config/
│   ├── midtrans.php
│   ├── fonnte.php
│   └── pembayaran.php
├── database/
│   ├── migrations/
│   └── factories/
├── resources/
│   └── views/
├── routes/
│   ├── web.php
│   └── api.php
└── public/
```

---

## ⚙️ Cara Instalasi (Lokal)

```bash
# 1. Clone repository
git clone https://github.com/xeriussssss/AutoCommerce.git
cd AutoCommerce

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
DB_DATABASE=safitri_mart
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrasi database
php artisan migrate

# 6. Storage link
php artisan storage:link

# 7. Jalankan server
php artisan serve
```

---

## 🔑 Konfigurasi .env Penting

```env
# Midtrans
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false

# Fonnte WhatsApp
FONNTE_TOKEN=your_fonnte_token

# Binderbyte Ongkir
BINDERBYTE_API_KEY=your_api_key
```

---

## 👥 Role Pengguna

| Role | Akses |
|------|-------|
| Admin | Full akses ke semua fitur panel admin |
| Staff Gudang | Akses manajemen stok masuk/keluar |

---

## 📄 Lisensi

Project ini dibuat untuk keperluan akademis — Kelompok 6.
