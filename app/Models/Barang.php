<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $timestamps = false;
    protected $fillable = ['nama_barang', 'harga', 'stok', 'description', 'image_url'];

    public function stokBarang()
    {
        return $this->hasMany(StokBarang::class, 'id_barang', 'id_barang');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_barang', 'id_barang');
    }
}
