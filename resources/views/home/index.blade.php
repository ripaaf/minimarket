@extends('layouts.app')

@section('content')
  <div class="prose max-w-3xl mx-auto mb-8 text-center">
    <h1 class="text-4xl font-bold">Minimarket Makmur Jaya</h1>
    <p class="text-lg text-gray-700">Toko online kebutuhan harian. Kami menjual beras, minyak, gula, susu, kopi, mie instan dan kebutuhan sehari-hari lainnya dengan harga bersaing dan kualitas terjaga.</p>
    <p class="text-gray-600">Scroll ke bawah untuk melihat beberapa produk. Silakan login untuk melanjutkan pembelian.</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
    @foreach($barangs->take(8) as $b)
      <div class="bg-white rounded shadow p-4 flex flex-col">
        <div class="h-40 bg-gray-100 rounded overflow-hidden mb-4">
          @if($b->image_url)
            <img src="{{ $b->image_url }}" alt="{{ $b->nama_barang }}" class="w-full h-full object-cover">
          @else
            <div class="w-full h-full flex items-center justify-center text-gray-400">No image</div>
          @endif
        </div>
        <h3 class="font-semibold text-lg">{{ $b->nama_barang }}</h3>
        <p class="text-gray-600">Rp {{ number_format($b->harga,0,',','.') }}</p>
        <p class="text-sm text-gray-500">Stock: {{ $b->stok }}</p>
        <div class="mt-auto pt-4">
          <a href="{{ route('product.show', $b->id_barang) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded">View</a>
        </div>
      </div>
    @endforeach
  </div>

  <div id="scroll-prompt" class="text-center text-gray-600 mb-8">
    <p>Untuk melanjutkan pembelian silakan <a href="{{ route('login') }}" class="text-blue-600">login</a> terlebih dahulu.</p>
  </div>

  <script>
    // if user scrolls more than 600px show a floating prompt to login
    window.addEventListener('scroll', function(){
      var el = document.getElementById('scroll-prompt');
      if (window.scrollY > 600) {
        el.classList.add('fixed','bottom-6','left-1/2','-translate-x-1/2','bg-white','p-4','rounded','shadow');
      } else {
        el.classList.remove('fixed','bottom-6','left-1/2','-translate-x-1/2','bg-white','p-4','rounded','shadow');
      }
    });
  </script>
@endsection
