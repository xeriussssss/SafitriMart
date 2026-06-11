<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tambahkan kolom untuk integrasi Midtrans ke tabel transaksi
     */
    public function up(): void
    {
        // 1. Ubah enum metode_pembayaran untuk menambahkan 'midtrans'
        Schema::table('transaksi', function (Blueprint $table) {
            // Hapus kolom lama dulu (karena MySQL tidak bisa langsung modify ENUM)
            $table->string('metode_pembayaran', 50)->nullable()->change();
        });

        // 2. Tambah kolom midtrans
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('snap_token')->nullable()->after('metode_pembayaran');
            $table->string('midtrans_order_id')->nullable()->after('snap_token');
            $table->string('midtrans_transaction_id')->nullable()->after('midtrans_order_id');
            $table->string('midtrans_payment_type')->nullable()->after('midtrans_transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn([
                'snap_token',
                'midtrans_order_id',
                'midtrans_transaction_id',
                'midtrans_payment_type',
            ]);
        });
    }
};
