<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class HomeController extends Controller
{
    public function index()
    {
        // if user is logged in, redirect to /shop
        if (session('user_id') && session('role') === 'customer') {
            return redirect()->route('shop');
        }

        $barangs = Barang::all();
        return view('home.index', compact('barangs'));
    }
}
