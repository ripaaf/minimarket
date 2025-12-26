<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class WebProductController extends Controller
{
    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        $userId = session('user_id');
        $liked = false;
        if ($userId) {
            $liked = \Illuminate\Support\Facades\DB::table('product_likes')->where('user_id', $userId)->where('id_barang', $id)->exists();
        }
        return view('products.show', compact('barang','liked'));
    }
}
