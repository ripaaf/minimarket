<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // block access if customer is not authenticated
        if (!$request->session()->get('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mengakses shop.');
        }

        $query = $request->input('q');
        $barangs = Barang::query();
        if ($query) {
            $barangs->where('nama_barang', 'like', "%{$query}%");
        }
        $barangs = $barangs->paginate(12);
        return view('shop.index', compact('barangs','query'));
    }
}
