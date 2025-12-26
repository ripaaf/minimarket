<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        return response()->json(Barang::all());
    }

    public function show($id)
    {
        $b = Barang::findOrFail($id);
        return response()->json($b);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_barang' => 'required|string|max:50',
            'harga' => 'required|integer',
            'stok' => 'nullable|integer',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $b = Barang::create($data);
        return response()->json($b, 201);
    }

    public function update(Request $request, $id)
    {
        $b = Barang::findOrFail($id);
        $data = $request->validate([
            'nama_barang' => 'sometimes|required|string|max:50',
            'harga' => 'sometimes|required|integer',
            'stok' => 'nullable|integer',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);
        $b->update($data);
        return response()->json($b);
    }

    public function destroy($id)
    {
        $b = Barang::findOrFail($id);
        $b->delete();
        return response()->json(null, 204);
    }
}
