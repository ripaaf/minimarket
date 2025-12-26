<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;

class PenjualanController extends Controller
{
    public function index()
    {
        return response()->json(Penjualan::with('detailPenjualan')->get());
    }

    public function show($id)
    {
        return response()->json(Penjualan::with('detailPenjualan')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'id_pelanggan' => 'nullable|integer',
            'id_pegawai' => 'nullable|integer',
        ]);
        $p = Penjualan::create($data);
        return response()->json($p, 201);
    }

    public function update(Request $request, $id)
    {
        $p = Penjualan::findOrFail($id);
        $data = $request->validate([
            'tanggal' => 'sometimes|required|date',
            'id_pelanggan' => 'nullable|integer',
            'id_pegawai' => 'nullable|integer',
        ]);
        $p->update($data);
        return response()->json($p);
    }

    public function destroy($id)
    {
        Penjualan::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
