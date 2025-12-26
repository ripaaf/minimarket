<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stok_barang', function (Blueprint $table) {
            $table->increments('id_stok');
            $table->unsignedInteger('id_barang')->nullable();
            $table->date('tanggal')->nullable();
            $table->enum('tipe', ['masuk','keluar'])->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('keterangan', 100)->nullable();
            $table->unsignedInteger('id_pegawai')->nullable();

            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('set null');
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawai')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_barang');
    }
};
