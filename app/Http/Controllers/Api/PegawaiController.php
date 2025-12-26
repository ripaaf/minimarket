<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function index()
    {
        return response()->json(Pegawai::all());
    }

    public function show($id)
    {
        return response()->json(Pegawai::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:50',
            'jabatan' => 'nullable|string|max:30',
            'no_telp' => 'nullable|string|max:15',
        ]);
        $p = Pegawai::create($data);
        return response()->json($p, 201);
    }

    public function update(Request $request, $id)
    {
        $p = Pegawai::findOrFail($id);
        $data = $request->validate([
            'nama' => 'sometimes|required|string|max:50',
            'jabatan' => 'nullable|string|max:30',
            'no_telp' => 'nullable|string|max:15',
        ]);
        $p->update($data);
        return response()->json($p);
    }

    public function destroy($id)
    {
        Pegawai::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
