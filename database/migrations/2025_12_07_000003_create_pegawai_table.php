<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->increments('id_pegawai');
            $table->string('nama', 50)->nullable();
            $table->string('jabatan', 30)->nullable();
            $table->string('no_telp', 15)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
