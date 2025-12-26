<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
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
        } else {
            $cart = $request->session()->get('cart', []);
            foreach ($cart as $item) $total += $item['subtotal'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'id_barang' => 'required|integer',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $barang = Barang::findOrFail($data['id_barang']);
        $qty = $data['quantity'] ?? 1;
        $userId = $request->session()->get('user_id');
        if ($userId) {
            $existing = DB::table('cart_items')->where('user_id', $userId)->where('id_barang', $barang->id_barang)->first();
            if ($existing) {
                DB::table('cart_items')->where('id', $existing->id)->update(['quantity' => $existing->quantity + $qty, 'updated_at' => now()]);
            } else {
                DB::table('cart_items')->insert(['user_id' => $userId, 'id_barang' => $barang->id_barang, 'quantity' => $qty, 'created_at' => now(), 'updated_at' => now()]);
            }
        } else {
            $cart = $request->session()->get('cart', []);

            if (isset($cart[$barang->id_barang])) {
                $cart[$barang->id_barang]['quantity'] += $qty;
                $cart[$barang->id_barang]['subtotal'] = $cart[$barang->id_barang]['quantity'] * $barang->harga;
            } else {
                $cart[$barang->id_barang] = [
                    'id' => $barang->id_barang,
                    'nama_barang' => $barang->nama_barang,
                    'price' => $barang->harga,
                    'quantity' => $qty,
                    'subtotal' => $qty * $barang->harga,
                ];
            }

            $request->session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Added to cart');
    }

    public function remove(Request $request)
    {
        $data = $request->validate(['id_barang' => 'required|integer']);
        $userId = $request->session()->get('user_id');
        if ($userId) {
            DB::table('cart_items')->where('user_id',$userId)->where('id_barang',$data['id_barang'])->delete();
        } else {
            $cart = $request->session()->get('cart', []);
            if (isset($cart[$data['id_barang']])) {
                unset($cart[$data['id_barang']]);
                $request->session()->put('cart', $cart);
            }
        }
        return redirect()->route('cart.index');
    }
}
