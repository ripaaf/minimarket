@extends('layouts.app')

@section('content')
@php
  $rupiah = function($v) { return is_numeric($v) ? 'Rp ' . number_format($v, 0, ',', '.') : $v; };
  $status = $order->status ?? 'pending';
  $statusColor = [
      'pending' => 'bg-sky-100 text-sky-800',
      'processed' => 'bg-amber-100 text-amber-800',
      'done' => 'bg-emerald-100 text-emerald-800',
      'cancelled' => 'bg-red-100 text-red-800',
  ][$status] ?? 'bg-gray-100 text-gray-800';
@endphp
<div class="max-w-3xl mx-auto bg-white shadow rounded p-6">
  <div class="flex items-start justify-between gap-4">
    <div>
      <p class="text-sm text-gray-500">Terima kasih! Pesanan Anda diterima.</p>
      <h1 class="text-2xl font-bold">Order #{{ $order->id_penjualan }}</h1>
      <div class="mt-1 text-sm text-gray-600">Tanggal: {{ $order->tanggal }}</div>
      <div class="mt-2 flex items-center gap-2 text-sm">
        <span class="px-2 py-1 rounded-full {{ $statusColor }} capitalize">{{ $status }}</span>
        @if($order->pegawai)
          <span class="text-gray-600">Diproses oleh {{ $order->pegawai->nama }}</span>
        @else
          <span class="text-gray-400">Menunggu penugasan pegawai</span>
        @endif
      </div>
    </div>
    <div class="text-right text-sm text-gray-500">
      <div>Langkah berikut:</div>
      <div>1) Admin memproses pesanan</div>
      <div>2) Anda akan dihubungi jika perlu</div>
      <div>3) Lacak status di profil</div>
    </div>
  </div>

  <div class="mt-6 border-t pt-4 space-y-2 text-sm">
    @foreach($order->detailPenjualan as $d)
      <div class="flex justify-between">
        <span>{{ $d->barang->nama_barang ?? 'Produk' }} × {{ $d->jumlah }}</span>
        <span>{{ $rupiah($d->subtotal ?? 0) }}</span>
      </div>
    @endforeach
    <hr>
    <div class="flex justify-between font-semibold text-base">
      <span>Total</span>
      <span>{{ $rupiah($total ?? 0) }}</span>
    </div>
  </div>

  <div class="mt-6 grid sm:grid-cols-3 gap-3 text-sm">
    <a href="{{ route('profile.show') }}" class="block text-center px-4 py-2 bg-blue-600 text-white rounded">Lihat riwayat di Profil</a>
    <a href="{{ route('shop') }}" class="block text-center px-4 py-2 bg-gray-100 text-gray-800 rounded">Belanja lagi</a>
    <a href="{{ route('home') }}" class="block text-center px-4 py-2 bg-white border rounded">Kembali ke beranda</a>
  </div>

  <div class="mt-4 text-xs text-gray-500">
    Jika ada koreksi alamat atau kontak, perbarui di halaman profil atau hubungi admin.
  </div>
</div>
@endsection
