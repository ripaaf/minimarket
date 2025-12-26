<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    public function index()
    {
        return response()->json(Pelanggan::all());
    }

    public function show($id)
    {
        return response()->json(Pelanggan::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'nullable|string|max:100',
            'no_telp' => 'nullable|string|max:15',
        ]);
        $p = Pelanggan::create($data);
        return response()->json($p, 201);
    }

    public function update(Request $request, $id)
    {
        $p = Pelanggan::findOrFail($id);
        $data = $request->validate([
            'nama' => 'sometimes|required|string|max:50',
            'alamat' => 'nullable|string|max:100',
            'no_telp' => 'nullable|string|max:15',
        ]);
        $p->update($data);
        return response()->json($p);
    }

    public function destroy($id)
    {
        Pelanggan::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
