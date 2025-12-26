<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    public $timestamps = false;
    protected $fillable = ['nama', 'jabatan', 'no_telp'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_pegawai', 'id_pegawai');
    }

    public function stokBarang()
    {
        return $this->hasMany(StokBarang::class, 'id_pegawai', 'id_pegawai');
    }
}
