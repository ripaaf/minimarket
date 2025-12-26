<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Pegawai;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $cart = [];
        $total = 0;
        if ($userId) {
            $items = DB::table('cart_items')->where('user_id', $userId)->get();
            foreach ($items as $row) {
                $barang = Barang::find($row->id_barang);
                if (!$barang) continue;
                $subtotal = ($barang->harga ?? 0) * $row->quantity;
                $cart[$row->id_barang] = ['id' => $row->id_barang,'nama_barang'=>$barang->nama_barang,'price'=>$barang->harga,'quantity'=>$row->quantity,'subtotal'=>$subtotal];
                $total += $subtotal;
            }
            $user = DB::table('users')->where('id', $userId)->first();
        } else {
            $cart = $request->session()->get('cart', []);
            foreach ($cart as $item) $total += $item['subtotal'];
            $user = null;
        }

        return view('checkout.index', compact('cart','total','user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_address' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $userId = $request->session()->get('user_id');
        $cart = [];
        if ($userId) {
            $items = DB::table('cart_items')->where('user_id', $userId)->get();
            foreach ($items as $row) {
                $barang = Barang::find($row->id_barang);
                if (!$barang) continue;
                $cart[] = ['id' => $row->id_barang, 'quantity' => $row->quantity, 'subtotal' => ($barang->harga ?? 0) * $row->quantity];
            }
        } else {
            $cart = $request->session()->get('cart', []);
        }
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cart empty');
        }

        DB::beginTransaction();
        try {
            // determine pelanggan: if user logged in, use/create pelanggan linked to user
            $pelanggan_id = null;
            if ($userId) {
                $pelanggan = Pelanggan::where('user_id', $userId)->first();
                if (!$pelanggan) {
                    // get user profile
                    $user = DB::table('users')->where('id', $userId)->first();
                    $pelanggan = Pelanggan::create([
                        'nama' => $user->name,
                        'alamat' => $user->address ?? null,
                        'no_telp' => $user->phone ?? null,
                        'user_id' => $userId,
                        'latitude' => $data['latitude'] ?? null,
                        'longitude' => $data['longitude'] ?? null,
                    ]);
                } else {
                    // update pelanggan contact info from form if provided
                    $pelanggan->alamat = $data['customer_address'] ?? $pelanggan->alamat;
                    $pelanggan->no_telp = $data['customer_phone'] ?? $pelanggan->no_telp;
                    if (!empty($data['latitude']) && !empty($data['longitude'])) {
                        $pelanggan->latitude = $data['latitude'];
                        $pelanggan->longitude = $data['longitude'];
                    }
                    $pelanggan->save();
                }
                $pelanggan_id = $pelanggan->id_pelanggan;
            } else {
                // guest checkout: create pelanggan from provided fields
                $p = Pelanggan::create([
                    'nama' => $data['customer_name'] ?? 'Guest',
                    'alamat' => $data['customer_address'] ?? null,
                    'no_telp' => $data['customer_phone'] ?? null,
                    'latitude' => $data['latitude'] ?? null,
                    'longitude' => $data['longitude'] ?? null,
                ]);
                $pelanggan_id = $p->id_pelanggan;
            }

            $penjualan = Penjualan::create([
                'tanggal' => now()->toDateString(),
                'id_pelanggan' => $pelanggan_id,
                'id_pegawai' => null,
            ]);

            foreach ($cart as $item) {
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_barang' => $item['id'],
                    'jumlah' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                // reduce stock
                $barang = Barang::find($item['id']);
                if ($barang) {
                    $barang->stok = max(0, ($barang->stok ?? 0) - $item['quantity']);
                    $barang->save();
                }
            }

            DB::commit();
            // clear cart: if user logged in clear cart_items, else session
            if ($userId) {
                DB::table('cart_items')->where('user_id', $userId)->delete();
            } else {
                $request->session()->forget('cart');
            }
            return redirect()->route('home')->with('success', 'Checkout successful');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }
}
