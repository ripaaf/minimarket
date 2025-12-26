<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pegawai')->insert([
            ['nama' => 'rina', 'jabatan' => 'kasir', 'no_telp' => '081223344556'],
            ['nama' => 'tono', 'jabatan' => 'gudang', 'no_telp' => '081234566778'],
            ['nama' => 'sari', 'jabatan' => 'kasir', 'no_telp' => '081298765432'],
            ['nama' => 'joko', 'jabatan' => 'manager', 'no_telp' => '081212345678'],
            ['nama' => 'udin', 'jabatan' => 'kasir', 'no_telp' => '081211112222'],
            ['nama' => 'lina', 'jabatan' => 'gudang', 'no_telp' => '081299988877'],
        ]);
    }
}
