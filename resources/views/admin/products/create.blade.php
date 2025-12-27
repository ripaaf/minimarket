@extends('layouts.app')

@section('content')
  <div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
    <div class="flex items-center justify-between mb-4">
      <div class="flex items-center gap-3">
        <h1 class="text-2xl font-semibold">Tambah Produk Baru</h1>
        <a href="{{ route('admin.index') }}" class="px-3 py-1 bg-gray-200 text-gray-800 rounded text-sm">Kembali ke Dashboard</a>
      </div>
      <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-600">Kelola Produk</a>
    </div>

    @if(session('error'))
      <div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
    @endif

    @if($errors->any())
      <div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium">Nama Produk</label>
        <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" class="w-full border p-2 rounded @error('nama_barang') border-red-500 @enderror" required>
        @error('nama_barang')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium">Harga</label>
          <input type="number" step="0.01" name="harga" value="{{ old('harga') }}" class="w-full border p-2 rounded @error('harga') border-red-500 @enderror" required>
          @error('harga')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-sm font-medium">Stok</label>
          <input type="number" name="stok" value="{{ old('stok') }}" class="w-full border p-2 rounded @error('stok') border-red-500 @enderror" required>
          @error('stok')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium">Deskripsi</label>
        <textarea name="description" rows="4" class="w-full border p-2 rounded @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
        @error('description')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-sm font-medium">Gambar Produk (opsional)</label>
        <input type="file" name="image" class="mt-1 @error('image') border border-red-500 @enderror">
        @error('image')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
      </div>
      <div class="pt-2">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan Produk</button>
      </div>
    </form>
  </div>
@endsection
