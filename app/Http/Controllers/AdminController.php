<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        // simple session-based admin check
        if (session('role') !== 'admin') {
            return redirect('/admin/login');
        }
        $orders = Penjualan::with('detailPenjualan','pelanggan','pegawai')->orderBy('id_penjualan','desc')->get();
        $pegawais = \App\Models\Pegawai::orderBy('nama')->get();
        return view('admin.index', compact('orders','pegawais'));
    }

    public function process(Request $request, $id)
    {
        if (session('role') !== 'admin') {
            return redirect('/admin/login');
        }
        $order = Penjualan::findOrFail($id);
        $data = $request->validate([
            'status' => 'nullable|string|in:pending,processed,done,cancelled',
            'id_pegawai' => 'nullable|integer|exists:pegawai,id_pegawai',
        ]);

        if (isset($data['status'])) {
            $order->status = $data['status'];
        }
        if (array_key_exists('id_pegawai', $data)) {
            $order->id_pegawai = $data['id_pegawai'];
        }

        $order->save();
        return redirect()->back()->with('success','Order updated');
    }

    public function createProduct()
    {
        if (session('role') !== 'admin') {
            return redirect('/admin/login');
        }
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        if (session('role') !== 'admin') {
            return redirect('/admin/login');
        }

        $data = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:3072',
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            if (!$path) {
                return back()->withInput()->with('error', 'Gagal mengunggah gambar produk.');
            }
            // store relative URL so it works across environments as long as storage:link exists
            $imageUrl = '/storage/'.$path;
        }

        Barang::create([
            'nama_barang' => $data['nama_barang'],
            'harga' => $data['harga'],
            'stok' => $data['stok'],
            'description' => $data['description'] ?? null,
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('admin.index')->with('success', 'Produk baru berhasil ditambahkan.');
    }

    public function listProducts()
    {
        if (session('role') !== 'admin') {
            return redirect('/admin/login');
        }

        $products = Barang::orderBy('id_barang','desc')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function editProduct($id)
    {
        if (session('role') !== 'admin') {
            return redirect('/admin/login');
        }

        $product = Barang::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        if (session('role') !== 'admin') {
            return redirect('/admin/login');
        }

        $product = Barang::findOrFail($id);

        $data = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            if (!$path) {
                return back()->withInput()->with('error', 'Gagal mengunggah gambar produk.');
            }
            // best-effort delete old file if stored on public disk
            if ($product->image_url && str_contains($product->image_url, '/storage/')) {
                $relative = str_replace('/storage/', '', $product->image_url);
                Storage::disk('public')->delete($relative);
            }
            $product->image_url = '/storage/'.$path;
        }

        $product->nama_barang = $data['nama_barang'];
        $product->harga = $data['harga'];
        $product->stok = $data['stok'];
        $product->description = $data['description'] ?? null;
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroyProduct($id)
    {
        if (session('role') !== 'admin') {
            return redirect('/admin/login');
        }

        $product = Barang::findOrFail($id);
        if ($product->image_url && str_contains($product->image_url, '/storage/')) {
            $relative = str_replace('/storage/', '', $product->image_url);
            Storage::disk('public')->delete($relative);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk dihapus.');
    }

    public function ordersWithItems()
    {
        if (session('role') !== 'admin') {
            return redirect('/admin/login');
        }

        $activeOrders = Penjualan::with(['pelanggan', 'pegawai', 'detailPenjualan.barang'])
            ->whereIn('status', ['pending','processed'])
            ->orderBy('id_penjualan', 'desc')
            ->get();

        $archivedOrders = Penjualan::with(['pelanggan', 'pegawai', 'detailPenjualan.barang'])
            ->whereIn('status', ['done','cancelled'])
            ->orderBy('id_penjualan', 'desc')
            ->get();

        return view('admin.orders.items', [
            'activeOrders' => $activeOrders,
            'archivedOrders' => $archivedOrders,
        ]);
    }
}
