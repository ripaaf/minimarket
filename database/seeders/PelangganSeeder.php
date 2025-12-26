<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pelanggan')->insert([
            ['nama' => 'andi', 'alamat' => 'jl. merdeka 1', 'no_telp' => '081234567890'],
            ['nama' => 'budi', 'alamat' => 'jl. sudirman 2', 'no_telp' => '081234567891'],
            ['nama' => 'cici', 'alamat' => 'jl. gatot subroto 3', 'no_telp' => '081234567892'],
            ['nama' => 'dewi', 'alamat' => 'jl. ahmad yani 4', 'no_telp' => '081234567893'],
            ['nama' => 'eka', 'alamat' => 'jl. diponegoro 5', 'no_telp' => '081234567894'],
            ['nama' => 'fajar', 'alamat' => 'jl. imam bonjol 6', 'no_telp' => '081234567895'],
        ]);
    }
}
