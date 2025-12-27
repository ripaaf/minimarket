@extends('layouts.app')

@section('content')
  <div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h1 class="text-2xl font-semibold">Daftar Pesanan & Item</h1>
        <p class="text-sm text-gray-600">Untuk pegawai: lihat detail item yang harus diproses dan siapa penanggung jawabnya.</p>
      </div>
      <a href="{{ route('admin.index') }}" class="px-3 py-2 bg-gray-200 text-gray-800 rounded text-sm">Kembali ke Dashboard</a>
    </div>

    <div class="bg-white rounded shadow p-4 space-y-4">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold">Aktif (Pending / Processed)</h2>
        <span class="px-2 py-1 rounded text-xs font-semibold bg-blue-100 text-blue-800">Aktif</span>
      </div>
      @forelse($activeOrders as $order)
        <div class="border rounded p-3">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div class="space-y-1">
              <div class="text-sm text-gray-600">Order #{{ $order->id_penjualan }} • {{ $order->tanggal }}</div>
              <div class="text-base font-semibold">{{ $order->pelanggan->nama ?? 'Customer' }}</div>
              <div class="text-sm text-gray-500">{{ $order->pelanggan->alamat ?? 'Alamat tidak tersedia' }}</div>
              <div class="text-sm font-semibold text-gray-800">Total: Rp {{ number_format($order->detailPenjualan->sum('subtotal'),0,',','.') }}</div>
            </div>
            <div class="text-right space-y-1">
              @php
                $statusClass = [
                  'pending' => 'bg-sky-100 text-sky-800',
                  'processed' => 'bg-amber-100 text-amber-800',
                  'done' => 'bg-green-100 text-green-800',
                  'cancelled' => 'bg-red-100 text-red-800',
                ][$order->status ?? 'pending'] ?? 'bg-gray-100 text-gray-800';
              @endphp
              <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusClass }}">{{ ucfirst($order->status ?? 'pending') }}</span>
              <div class="text-xs text-gray-600">
                Pegawai: {{ $order->pegawai->nama ?? 'Belum ditugaskan' }}
                @if(!empty($order->pegawai))
                  <span class="text-gray-400">•</span> {{ $order->pegawai->jabatan }}
                @endif
              </div>
            </div>
          </div>

          <div class="mt-3 flex flex-wrap items-center gap-2">
            @if(($order->status ?? 'pending') === 'pending')
              <form method="POST" action="{{ route('admin.order.process', $order->id_penjualan) }}">
                @csrf
                <input type="hidden" name="status" value="processed">
                <button class="px-3 py-1 rounded text-sm bg-amber-500 text-white">Tandai Processed</button>
              </form>
            @elseif(($order->status ?? '') === 'processed')
              <form method="POST" action="{{ route('admin.order.process', $order->id_penjualan) }}">
                @csrf
                <input type="hidden" name="status" value="done">
                <button class="px-3 py-1 rounded text-sm bg-green-600 text-white">Tandai Done</button>
              </form>
            @endif
          </div>

          <div class="mt-3 overflow-x-auto">
            <table class="w-full text-sm text-left">
              <thead class="text-gray-600 border-b">
                <tr>
                  <th class="py-2">Produk</th>
                  <th>Jumlah</th>
                  <th>Harga</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($order->detailPenjualan as $detail)
                  <tr class="border-b">
                    <td class="py-2 flex items-center gap-3">
                      @if($detail->barang && $detail->barang->image_url)
                        <img src="{{ $detail->barang->image_url }}" alt="img" class="w-12 h-12 object-cover rounded">
                      @else
                        <span class="w-12 h-12 flex items-center justify-center bg-gray-100 text-gray-400 text-xs rounded">No img</span>
                      @endif
                      <div>
                        <div class="font-medium">{{ $detail->barang->nama_barang ?? 'Produk' }}</div>
                        <div class="text-xs text-gray-500">ID: {{ $detail->id_barang }}</div>
                      </div>
                    </td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->barang->harga ?? 0,0,',','.') }}</td>
                    <td>Rp {{ number_format($detail->subtotal ?? 0,0,',','.') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @empty
        <p class="text-sm text-gray-600">Tidak ada pesanan aktif.</p>
      @endforelse

      <details class="mt-4">
        <summary class="cursor-pointer text-base font-semibold flex items-center gap-2">
          Arsip (Done / Cancelled)
          <span class="px-2 py-1 rounded text-xs font-semibold bg-gray-200 text-gray-700">Archived</span>
        </summary>
        <div class="mt-3 space-y-4">
          @forelse($archivedOrders as $order)
            <div class="border rounded p-3 bg-gray-50">
              <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <div class="space-y-1">
                  <div class="text-sm text-gray-600">Order #{{ $order->id_penjualan }} • {{ $order->tanggal }}</div>
                  <div class="text-base font-semibold">{{ $order->pelanggan->nama ?? 'Customer' }}</div>
                  <div class="text-sm text-gray-500">{{ $order->pelanggan->alamat ?? 'Alamat tidak tersedia' }}</div>
                  <div class="text-sm font-semibold text-gray-800">Total: Rp {{ number_format($order->detailPenjualan->sum('subtotal'),0,',','.') }}</div>
                </div>
                <div class="text-right space-y-1">
                  @php
                    $statusClass = [
                      'pending' => 'bg-sky-100 text-sky-800',
                      'processed' => 'bg-amber-100 text-amber-800',
                      'done' => 'bg-green-100 text-green-800',
                      'cancelled' => 'bg-red-100 text-red-800',
                    ][$order->status ?? 'pending'] ?? 'bg-gray-100 text-gray-800';
                  @endphp
                  <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusClass }}">{{ ucfirst($order->status ?? 'pending') }}</span>
                  <div class="text-xs text-gray-600">
                    Pegawai: {{ $order->pegawai->nama ?? 'Belum ditugaskan' }}
                    @if(!empty($order->pegawai))
                      <span class="text-gray-400">•</span> {{ $order->pegawai->jabatan }}
                    @endif
                  </div>
                </div>
              </div>

              <div class="mt-3 overflow-x-auto">
                <table class="w-full text-sm text-left">
                  <thead class="text-gray-600 border-b">
                    <tr>
                      <th class="py-2">Produk</th>
                      <th>Jumlah</th>
                      <th>Harga</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($order->detailPenjualan as $detail)
                      <tr class="border-b">
                        <td class="py-2 flex items-center gap-3">
                          @if($detail->barang && $detail->barang->image_url)
                            <img src="{{ $detail->barang->image_url }}" alt="img" class="w-12 h-12 object-cover rounded">
                          @else
                            <span class="w-12 h-12 flex items-center justify-center bg-gray-100 text-gray-400 text-xs rounded">No img</span>
                          @endif
                          <div>
                            <div class="font-medium">{{ $detail->barang->nama_barang ?? 'Produk' }}</div>
                            <div class="text-xs text-gray-500">ID: {{ $detail->id_barang }}</div>
                          </div>
                        </td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->barang->harga ?? 0,0,',','.') }}</td>
                        <td>Rp {{ number_format($detail->subtotal ?? 0,0,',','.') }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          @empty
            <p class="text-sm text-gray-600">Belum ada arsip pesanan.</p>
          @endforelse
        </div>
      </details>
    </div>
  </div>
@endsection
