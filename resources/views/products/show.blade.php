@extends('layouts.app')

@section('content')
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white p-6 rounded shadow">
      <div class="relative mb-6">
        <div class="absolute inset-0 rounded-xl overflow-hidden">
          @if($barang->image_url)
            <div class="w-full h-full bg-center bg-cover filter blur-lg scale-110" style="background-image: url('{{ $barang->image_url }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-white/60 via-white/40 to-white"></div>
          @else
            <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-100">No image</div>
          @endif
        </div>
        <div class="relative flex justify-end mb-2">
          @if(session('user_id'))
            <form action="{{ url('/product/'.$barang->id_barang.'/like') }}" method="POST" class="inline">
              @csrf
              <button type="submit" title="Like" aria-label="Like" class="p-2 rounded-full bg-white shadow focus:outline-none">
                @if(!empty($liked))
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657 3.172 10.828a4 4 0 010-5.656z" clip-rule="evenodd" />
                  </svg>
                @else
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                  </svg>
                @endif
              </button>
            </form>
          @else
            <a href="{{ route('login') }}" class="p-2 rounded-full bg-white shadow" title="Login untuk like" aria-label="Login">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
              </svg>
            </a>
          @endif
        </div>
        <div class="relative mx-auto w-64 h-64 rounded-xl overflow-hidden shadow-lg bg-white flex items-center justify-center">
          @if($barang->image_url)
            <img src="{{ $barang->image_url }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover">
          @else
            <div class="text-gray-400">No image</div>
          @endif
        </div>
      </div>
      <h2 class="text-2xl font-semibold mb-2">{{ $barang->nama_barang }}</h2>
      <p class="text-gray-700 mb-4">Price: Rp {{ number_format($barang->harga,0,',','.') }}</p>
      <p class="text-gray-600">Stock: {{ $barang->stok }}</p>
      <div class="mt-4">
        <div class="flex items-center space-x-2">
          @if(session('user_id'))
            <form action="{{ route('cart.add') }}" method="POST">
              @csrf
              <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
              <label class="block mb-2">Quantity</label>
              <input type="number" name="quantity" value="1" min="1" class="border p-2 rounded w-24">
              <button class="ml-2 px-4 py-2 bg-green-600 text-white rounded">Add to cart</button>
            </form>

          @else
            <div class="text-gray-600">
              Silakan <a href="{{ route('login') }}" class="text-blue-600 underline">login</a> untuk menambahkan ke keranjang atau menyukai produk ini.
            </div>
          @endif
        </div>
      </div>
    </div>
    <div class="bg-white p-6 rounded shadow">
      <h3 class="font-semibold">Details</h3>
      <p class="text-sm text-gray-600 mt-2">{{ $barang->description ?? 'No description available.' }}</p>
    </div>
  </div>
@endsection
