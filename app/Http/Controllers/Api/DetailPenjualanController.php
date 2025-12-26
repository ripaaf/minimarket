<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;

class DetailPenjualanController extends Controller
{
    public function index()
    {
        return response()->json(DetailPenjualan::with('barang','penjualan')->get());
    }

    public function show($id)
    {
        return response()->json(DetailPenjualan::with('barang','penjualan')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_penjualan' => 'required|integer',
            'id_barang' => 'required|integer',
            'jumlah' => 'required|integer',
            'subtotal' => 'required|integer',
        ]);
        $d = DetailPenjualan::create($data);
        return response()->json($d, 201);
    }

    public function update(Request $request, $id)
    {
        $d = DetailPenjualan::findOrFail($id);
        $data = $request->validate([
            'id_penjualan' => 'nullable|integer',
            'id_barang' => 'nullable|integer',
            'jumlah' => 'nullable|integer',
            'subtotal' => 'nullable|integer',
        ]);
        $d->update($data);
        return response()->json($d);
    }

    public function destroy($id)
    {
        DetailPenjualan::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
