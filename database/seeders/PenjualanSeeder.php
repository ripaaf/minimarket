<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penjualan')->insert([
            ['tanggal' => '2025-05-01', 'id_pelanggan' => 1, 'id_pegawai' => 1],
            ['tanggal' => '2025-05-12', 'id_pelanggan' => 2, 'id_pegawai' => 3],
            ['tanggal' => '2025-04-20', 'id_pelanggan' => 3, 'id_pegawai' => 1],
            ['tanggal' => '2025-05-22', 'id_pelanggan' => 1, 'id_pegawai' => 3],
            ['tanggal' => '2025-05-23', 'id_pelanggan' => 4, 'id_pegawai' => 5],
            ['tanggal' => '2025-06-01', 'id_pelanggan' => 5, 'id_pegawai' => 1],
        ]);
    }
}
