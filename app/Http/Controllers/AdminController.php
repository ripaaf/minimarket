<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;

class AdminController extends Controller
{
    public function index()
    {
        // simple session-based admin check
        if (session('role') !== 'admin') {
            return redirect('/admin/login');
        }
        $orders = Penjualan::with('detailPenjualan','pelanggan','pegawai')->orderBy('id_penjualan','desc')->get();
        return view('admin.index', compact('orders'));
    }

    public function process(Request $request, $id)
    {
        if (session('role') !== 'admin') {
            return redirect('/admin/login');
        }
        $order = Penjualan::findOrFail($id);
        $order->status = $request->input('status','processed');
        $order->save();
        return redirect()->back()->with('success','Order updated');
    }
}
