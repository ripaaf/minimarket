<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->increments('id_penjualan');
            $table->date('tanggal')->nullable();
            $table->unsignedInteger('id_pelanggan')->nullable();
            $table->unsignedInteger('id_pegawai')->nullable();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('set null');
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawai')->onDelete('set null');
        });

        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedInteger('id_penjualan')->nullable();
            $table->unsignedInteger('id_barang')->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('subtotal')->nullable();

            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->onDelete('cascade');
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
        Schema::dropIfExists('penjualan');
    }
};
