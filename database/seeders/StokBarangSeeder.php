<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokBarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stok_barang')->insert([
            ['id_barang' => 1, 'tanggal' => '2025-05-01', 'tipe' => 'masuk', 'jumlah' => 30, 'keterangan' => 'restok supplier', 'id_pegawai' => 2],
            ['id_barang' => 2, 'tanggal' => '2025-05-02', 'tipe' => 'masuk', 'jumlah' => 20, 'keterangan' => 'restok minyak', 'id_pegawai' => 2],
            ['id_barang' => 3, 'tanggal' => '2025-05-03', 'tipe' => 'keluar', 'jumlah' => 5, 'keterangan' => 'barang rusak', 'id_pegawai' => 2],
            ['id_barang' => 4, 'tanggal' => '2025-05-04', 'tipe' => 'masuk', 'jumlah' => 15, 'keterangan' => 'stok susu baru', 'id_pegawai' => 2],
            ['id_barang' => 5, 'tanggal' => '2025-05-05', 'tipe' => 'masuk', 'jumlah' => 25, 'keterangan' => 'restok kopi', 'id_pegawai' => 6],
            ['id_barang' => 6, 'tanggal' => '2025-05-06', 'tipe' => 'keluar', 'jumlah' => 10, 'keterangan' => 'barang kadaluarsa', 'id_pegawai' => 6],
        ]);
    }
}
