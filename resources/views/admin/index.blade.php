@extends('layouts.app')

@section('content')
  <div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-4">
      <h1 class="text-2xl font-semibold">Admin Dashboard - Orders</h1>
      <div class="space-x-2">
        <a href="{{ route('admin.products.index') }}" class="px-3 py-2 bg-gray-200 text-gray-800 rounded text-sm">Kelola Produk</a>
        <a href="{{ route('admin.products.create') }}" class="px-3 py-2 bg-green-600 text-white rounded text-sm">Tambah Produk</a>
        <a href="{{ route('admin.orders.items') }}" class="px-3 py-2 bg-blue-600 text-white rounded text-sm">Pesanan & Item</a>
      </div>
    </div>
    <div class="mb-4 p-3 bg-blue-50 text-sm text-blue-900 rounded border border-blue-100">
      Pilih status pesanan dan pegawai penanggung jawab, lalu klik <span class="font-semibold">Simpan</span> pada baris yang ingin diubah.
    </div>
    <div class="bg-white rounded shadow p-4">
      <table class="w-full text-left">
        <thead class="text-sm text-gray-600">
          <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Items</th>
            <th>Status</th>
            <th>Pegawai</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $o)
            <tr class="border-t">
              <td class="py-2">{{ $o->id_penjualan }}</td>
              <td>{{ $o->tanggal }}</td>
              <td>
                @php
                  $name = $o->pelanggan->nama ?? null;
                  $display = '-';
                  if ($name) {
                      $lower = strtolower(trim($name));
                      if (!in_array($lower, ['customer','guest','placeholder','-',''])) $display = $name;
                  }
                @endphp
                {{ $display }}
              </td>
              <td>{{ $o->detailPenjualan->count() }}</td>
              <td>
                @php
                  $statusClass = [
                    'pending' => 'bg-sky-100 text-sky-800',
                    'processed' => 'bg-amber-100 text-amber-800',
                    'done' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                  ][$o->status ?? 'pending'] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusClass }}">{{ ucfirst($o->status ?? 'pending') }}</span>
              </td>
              <td>
                @if(!empty($o->pegawai))
                  <div class="text-sm font-medium">{{ $o->pegawai->nama }}</div>
                  <div class="text-xs text-gray-500">{{ $o->pegawai->jabatan }}</div>
                @else
                  <span class="text-gray-400 text-xs">Belum ditugaskan</span>
                @endif
              </td>
              <td>
                <form action="{{ route('admin.order.process', $o->id_penjualan) }}" method="POST" class="flex flex-wrap items-center gap-2">
                  @csrf
                  <select name="status" class="border p-1 rounded text-sm">
                    <option value="pending" @if($o->status=='pending') selected @endif>Pending</option>
                    <option value="processed" @if($o->status=='processed') selected @endif>Processed</option>
                    <option value="done" @if($o->status=='done') selected @endif>Done</option>
                    <option value="cancelled" @if($o->status=='cancelled') selected @endif>Cancelled</option>
                  </select>
                  <select name="id_pegawai" class="border p-1 rounded text-sm">
                    <option value="">-- Pegawai --</option>
                    @foreach($pegawais as $p)
                      <option value="{{ $p->id_pegawai }}" @if($o->id_pegawai==$p->id_pegawai) selected @endif>{{ $p->nama }} ({{ $p->jabatan }})</option>
                    @endforeach
                  </select>
                  <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Simpan</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
