<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('barang')->insert([
            ['nama_barang' => 'beras 5kg', 'harga' => 60000, 'stok' => 20, 'description' => 'Beras kualitas bagus 5kg', 'image_url' => 'https://via.placeholder.com/400x300?text=Beras+5kg'],
            ['nama_barang' => 'minyak goreng 2l', 'harga' => 35000, 'stok' => 8, 'description' => 'Minyak goreng kemasan 2 liter', 'image_url' => 'https://via.placeholder.com/400x300?text=Minyak+2L'],
            ['nama_barang' => 'gula pasir 1kg', 'harga' => 14000, 'stok' => 5, 'description' => 'Gula pasir kemasan 1kg', 'image_url' => 'https://via.placeholder.com/400x300?text=Gula+1kg'],
            ['nama_barang' => 'susu bubuk 400gr', 'harga' => 45000, 'stok' => 15, 'description' => 'Susu bubuk 400 gram', 'image_url' => 'https://via.placeholder.com/400x300?text=Susu+400gr'],
            ['nama_barang' => 'kopi sachet', 'harga' => 3000, 'stok' => 12, 'description' => 'Kopi sachet praktis untuk 1 cangkir', 'image_url' => 'https://via.placeholder.com/400x300?text=Kopi+Sachet'],
            ['nama_barang' => 'mie instan', 'harga' => 2500, 'stok' => 6, 'description' => 'Mie instan rasanya enak dan praktis', 'image_url' => 'https://via.placeholder.com/400x300?text=Mie+Instan'],
        ]);
    }
}
