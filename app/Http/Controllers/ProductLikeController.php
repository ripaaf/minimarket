<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductLikeController extends Controller
{
    public function toggle(Request $request, $id)
    {
        $userId = $request->session()->get('user_id');
        if (!$userId) {
            return redirect('/login');
        }

        $existing = DB::table('product_likes')->where('user_id', $userId)->where('id_barang', $id)->first();
        if ($existing) {
            DB::table('product_likes')->where('id', $existing->id)->delete();
        } else {
            DB::table('product_likes')->insert([ 'user_id' => $userId, 'id_barang' => $id, 'created_at' => now(), 'updated_at' => now() ]);
        }
        return redirect()->back();
    }
}
