<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPenjualanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('detail_penjualan')->insert([
            ['id_penjualan' => 1, 'id_barang' => 1, 'jumlah' => 1, 'subtotal' => 60000],
            ['id_penjualan' => 1, 'id_barang' => 2, 'jumlah' => 2, 'subtotal' => 70000],
            ['id_penjualan' => 2, 'id_barang' => 3, 'jumlah' => 2, 'subtotal' => 28000],
            ['id_penjualan' => 2, 'id_barang' => 4, 'jumlah' => 1, 'subtotal' => 45000],
            ['id_penjualan' => 3, 'id_barang' => 1, 'jumlah' => 1, 'subtotal' => 60000],
            ['id_penjualan' => 4, 'id_barang' => 2, 'jumlah' => 1, 'subtotal' => 35000],
            ['id_penjualan' => 4, 'id_barang' => 3, 'jumlah' => 1, 'subtotal' => 14000],
            ['id_penjualan' => 5, 'id_barang' => 5, 'jumlah' => 3, 'subtotal' => 9000],
            ['id_penjualan' => 5, 'id_barang' => 6, 'jumlah' => 4, 'subtotal' => 10000],
            ['id_penjualan' => 6, 'id_barang' => 4, 'jumlah' => 2, 'subtotal' => 90000],
            ['id_penjualan' => 6, 'id_barang' => 2, 'jumlah' => 1, 'subtotal' => 35000],
            ['id_penjualan' => 6, 'id_barang' => 3, 'jumlah' => 2, 'subtotal' => 28000],
        ]);
    }
}
