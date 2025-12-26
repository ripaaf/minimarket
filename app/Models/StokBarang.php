<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    protected $table = 'stok_barang';
    protected $primaryKey = 'id_stok';
    public $timestamps = false;
    protected $fillable = ['id_barang', 'tanggal', 'tipe', 'jumlah', 'keterangan', 'id_pegawai'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
}
