<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('barang')->insert([
            ['nama_barang' => 'beras 5kg', 'harga' => 60000, 'stok' => 20, 'description' => 'Beras kualitas bagus 5kg', 'image_url' => 'https://image.astronauts.cloud/product-images/2024/12/HokairiBerasJepang5kg_a783b5d9-542e-429c-8ed4-ea861e64936e_900x900.jpg'],
            ['nama_barang' => 'minyak goreng 2l', 'harga' => 35000, 'stok' => 8, 'description' => 'Minyak goreng kemasan 2 liter', 'image_url' => 'https://solvent-production.s3.amazonaws.com/media/images/products/2021/06/5444a.jpg'],
            ['nama_barang' => 'gula pasir 1kg', 'harga' => 14000, 'stok' => 5, 'description' => 'Gula pasir kemasan 1kg', 'image_url' => 'https://image.astronauts.cloud/product-images/2025/6/SusGulaPasirPutih1kg_e1fbec40-d0ae-4d71-8488-008597a6eaf7_900x900.jpg'],
            ['nama_barang' => 'susu bubuk 400gr', 'harga' => 45000, 'stok' => 15, 'description' => 'Susu bubuk 400 gram', 'image_url' => 'https://citranatapramana.com/wp-content/uploads/2020/07/Borngrain-Polska-Bilact-26_10-Poland_01.jpg'],
            ['nama_barang' => 'kopi sachet', 'harga' => 3000, 'stok' => 12, 'description' => 'Kopi sachet praktis untuk 1 cangkir', 'image_url' => 'https://solvent-production.s3.amazonaws.com/media/images/products/2021/10/DSC_0855.JPG'],
            ['nama_barang' => 'mie instan', 'harga' => 2500, 'stok' => 6, 'description' => 'Mie instan rasanya enak dan praktis', 'image_url' => 'https://pasarsegar.co.id/wp-content/uploads/2022/07/3bf90ea6-651c-4bb1-b0eb-97c1df7a11aa_Indomie-Rasa-Mie-Goreng-1-Pcs-10-1.jpg'],
        ]);
    }
}
