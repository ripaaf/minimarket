@extends('layouts.app')

@section('content')
  <div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-semibold">Shop</h1>
    <form method="GET" action="{{ route('shop') }}" class="flex items-center">
      <input name="q" value="{{ $query ?? '' }}" placeholder="Search products..." class="border p-2 rounded mr-2">
      <button class="px-3 py-2 bg-blue-600 text-white rounded">Search</button>
    </form>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($barangs as $b)
      <div class="bg-white rounded shadow p-4 flex flex-col">
        <div class="h-48 bg-gray-100 rounded overflow-hidden mb-4">
          @if($b->image_url)
            <img src="{{ $b->image_url }}" alt="{{ $b->nama_barang }}" class="w-full h-full object-cover">
          @else
            <div class="w-full h-full flex items-center justify-center text-gray-400">No image</div>
          @endif
        </div>
        <h3 class="font-semibold text-lg">{{ $b->nama_barang }}</h3>
        <p class="text-gray-600">Rp {{ number_format($b->harga,0,',','.') }}</p>
        <p class="text-sm text-gray-500">Stock: {{ $b->stok }}</p>
        <div class="mt-auto pt-4 flex items-center justify-between">
          <a href="{{ route('product.show', $b->id_barang) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded">View</a>
          <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="id_barang" value="{{ $b->id_barang }}">
            <button class="px-3 py-2 bg-green-600 text-white rounded">Add</button>
          </form>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-6">{{ $barangs->withQueryString()->links() }}</div>
@endsection
