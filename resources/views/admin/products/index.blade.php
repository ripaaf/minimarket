@extends('layouts.app')

@section('content')
  <div class="max-w-6xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
      <div class="flex items-center gap-3">
        <h1 class="text-2xl font-semibold">Kelola Produk</h1>
        <a href="{{ route('admin.index') }}" class="px-3 py-2 bg-gray-200 text-gray-800 rounded text-sm">Kembali ke Dashboard</a>
      </div>
      <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-green-600 text-white rounded text-sm">Tambah Produk</a>
    </div>

    @if(session('success'))
      <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded shadow p-4 overflow-x-auto">
      <table class="w-full text-left text-sm align-middle">
        <thead class="text-gray-700 border-b bg-gray-50">
          <tr>
            <th class="py-2 px-2">ID</th>
            <th class="px-2">Nama</th>
            <th class="px-2 text-right">Harga</th>
            <th class="px-2 text-center">Stok</th>
            <th class="px-2 text-center">Gambar</th>
            <th class="px-2 text-center w-44">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $p)
            <tr class="border-b last:border-0 hover:bg-gray-50">
              <td class="py-2 px-2 font-mono text-xs text-gray-600">#{{ $p->id_barang }}</td>
              <td class="px-2">
                <div class="font-semibold text-gray-900">{{ $p->nama_barang }}</div>
                @if(!empty($p->description))
                  <div class="text-xs text-gray-500 line-clamp-1">{{ $p->description }}</div>
                @endif
              </td>
              <td class="px-2 text-right font-semibold">Rp {{ number_format($p->harga,0,',','.') }}</td>
              <td class="px-2 text-center">
                @php $stok = (int) ($p->stok ?? 0); @endphp
                @if($stok <= 0)
                  <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">Habis</span>
                @elseif($stok < 5)
                  <span class="px-2 py-1 rounded text-xs bg-amber-100 text-amber-700">Low ({{ $stok }})</span>
                @else
                  <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">{{ $stok }}</span>
                @endif
              </td>
              <td class="px-2 text-center">
                @if($p->image_url)
                  <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded overflow-hidden">
                    <img src="{{ $p->image_url }}" alt="img" class="w-full h-full object-cover">
                  </div>
                @else
                  <span class="text-gray-400 text-xs">No image</span>
                @endif
              </td>
              <td class="px-2">
                <div class="flex flex-wrap gap-2 justify-center">
                  <a href="{{ route('admin.products.edit', $p->id_barang) }}" class="px-3 py-1 bg-blue-600 text-white rounded text-xs">Edit</a>
                  <form action="{{ route('admin.products.destroy', $p->id_barang) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Hapus produk ini?')" class="px-3 py-1 bg-red-600 text-white rounded text-xs">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="py-4 text-center text-gray-600">Belum ada produk.</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="mt-4">{{ $products->links() }}</div>
    </div>
  </div>
@endsection
