<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $userId = $request->session()->get('user_id');
        if (!$userId) return redirect()->route('login')->with('error', 'Please login first');
        $user = User::find($userId);
        $likes = DB::table('product_likes')
            ->where('user_id', $userId)
            ->join('barang', 'product_likes.id_barang', '=', 'barang.id_barang')
            ->select('barang.*')
            ->get();

        // try to find pelanggan linked to user; if none, attempt to find by name as fallback
        $pelanggan = Pelanggan::where('user_id', $userId)->first();
        if (!$pelanggan) {
            $pelanggan = Pelanggan::where('nama', $user->name)->first();
        }
        $orders = [];
        if ($pelanggan) {
            $orders = Penjualan::with(['detailPenjualan.barang', 'pegawai'])
                ->where('id_pelanggan', $pelanggan->id_pelanggan)
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        return view('profile.show', compact('user','likes','orders'));
    }

    public function edit(Request $request)
    {
        $userId = $request->session()->get('user_id');
        if (!$userId) return redirect()->route('login')->with('error', 'Please login first');
        $user = User::find($userId);
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $userId = $request->session()->get('user_id');
        if (!$userId) return redirect()->route('login')->with('error', 'Please login first');
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:1024',
            'image' => 'nullable|image|max:2048',
        ]);
        $user = User::find($userId);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profiles', 'public');
            if (!$path) {
                return back()->with('error', 'Upload foto gagal, coba lagi.');
            }
            $user->image_url = Storage::url($path);
        }
        $user->name = $data['name'];
        $user->phone = $data['phone'] ?? $user->phone;
        $user->address = $data['address'] ?? $user->address;
        $user->save();

        // also update or create pelanggan mapping
        $pelanggan = Pelanggan::where('user_id', $userId)->first();
        if (!$pelanggan) {
            Pelanggan::create([
                'nama' => $user->name,
                'alamat' => $user->address,
                'no_telp' => $user->phone,
                'user_id' => $userId,
            ]);
        } else {
            $pelanggan->nama = $user->name;
            $pelanggan->alamat = $user->address;
            $pelanggan->no_telp = $user->phone;
            $pelanggan->save();
        }

        // refresh session name/image
        session(['user_name' => $user->name, 'user_image' => $user->image_url ?? null]);

        return redirect()->route('profile.show')->with('success','Profile updated');
    }
}
