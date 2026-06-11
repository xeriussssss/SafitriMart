<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('destination_id')->nullable()->after('alamat');
            $table->string('destination_name')->nullable()->after('destination_id');
            $table->string('kurir')->nullable()->after('destination_name');
            $table->string('layanan_kurir')->nullable()->after('kurir');
            $table->integer('ongkir')->default(0)->after('layanan_kurir');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['destination_id', 'destination_name', 'kurir', 'layanan_kurir', 'ongkir']);
        });
    }
};