<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StokBarang;

class StokBarangController extends Controller
{
    public function index()
    {
        return response()->json(StokBarang::with('barang','pegawai')->get());
    }

    public function show($id)
    {
        return response()->json(StokBarang::with('barang','pegawai')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_barang' => 'required|integer',
            'tanggal' => 'required|date',
            'tipe' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer',
            'keterangan' => 'nullable|string|max:100',
            'id_pegawai' => 'nullable|integer',
        ]);
        $s = StokBarang::create($data);
        return response()->json($s, 201);
    }

    public function update(Request $request, $id)
    {
        $s = StokBarang::findOrFail($id);
        $data = $request->validate([
            'id_barang' => 'nullable|integer',
            'tanggal' => 'nullable|date',
            'tipe' => 'nullable|in:masuk,keluar',
            'jumlah' => 'nullable|integer',
            'keterangan' => 'nullable|string|max:100',
            'id_pegawai' => 'nullable|integer',
        ]);
        $s->update($data);
        return response()->json($s);
    }

    public function destroy($id)
    {
        StokBarang::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
