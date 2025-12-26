<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $timestamps = false;
    protected $fillable = ['nama', 'alamat', 'no_telp', 'user_id', 'latitude', 'longitude'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_pelanggan', 'id_pelanggan');
    }
}
