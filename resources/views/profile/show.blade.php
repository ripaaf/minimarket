@extends('layouts.app')

@section('content')
@php
    $rupiah = function($v) { return is_numeric($v) ? 'Rp ' . number_format($v, 0, ',', '.') : $v; };
@endphp
<div class="max-w-4xl mx-auto bg-white shadow p-6 rounded">
    <div class="flex items-center space-x-6">
        <div class="w-24 h-24 bg-gray-100 rounded-full overflow-hidden">
            @if($user->image_url)
                <img src="{{ $user->image_url }}" alt="avatar" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">No Photo</div>
            @endif
        </div>
        <div>
            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
            <p class="text-sm text-gray-600">{{ $user->email }}</p>
            <p class="text-sm mt-1">{{ $user->phone ?? '-' }}</p>
            <p class="text-sm text-gray-700 mt-2">{{ $user->address ?? 'No address set' }}</p>
            <div class="mt-3">
                <a href="{{ route('profile.edit') }}" class="inline-block bg-blue-600 text-white px-3 py-1 rounded">Edit Profile</a>
                @if(session('role') === 'admin')
                    <a href="{{ route('admin.index') }}" class="inline-block bg-gray-200 text-gray-800 px-3 py-1 rounded ml-2">Admin Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline-block ml-2">
                    @csrf
                    <button class="bg-red-600 text-white px-3 py-1 rounded text-sm">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <h3 class="font-semibold text-lg">Liked Products</h3>
        @if($likes->isEmpty())
            <p class="text-sm text-gray-600">You have no liked products yet.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3">
                @foreach($likes as $b)
                    <div class="bg-gray-50 p-3 rounded">
                        <img src="{{ $b->image_url ?? '' }}" class="w-full h-28 object-cover mb-2" alt="{{ $b->nama_barang }}">
                        <div class="text-sm font-medium">{{ $b->nama_barang }}</div>
                        <div class="text-sm text-gray-600">{{ $rupiah($b->harga ?? 0) }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-6">
        <h3 class="font-semibold text-lg">Order History</h3>
        @if(empty($orders) || count($orders)===0)
            <p class="text-sm text-gray-600">No orders yet.</p>
        @else
            <div class="mt-3 space-y-4">
                @foreach($orders as $o)
                    @php
                        $status = $o->status ?? 'pending';
                        $statusColor = [
                            'pending' => 'bg-sky-100 text-sky-800',
                            'processed' => 'bg-amber-100 text-amber-800',
                            'done' => 'bg-emerald-100 text-emerald-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ][$status] ?? 'bg-gray-100 text-gray-800';
                        $total = $o->detailPenjualan->sum('subtotal');
                        $itemCount = $o->detailPenjualan->sum('jumlah');
                    @endphp
                    <div class="p-4 bg-gray-50 rounded border border-gray-100">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                            <div>
                                <div class="font-semibold">Order #{{ $o->id_penjualan }}</div>
                                <div class="text-sm text-gray-600">Tanggal: {{ $o->tanggal }}</div>
                                <div class="text-xs text-gray-500">Items: {{ $itemCount }} · Total: {{ $rupiah($total) }}</div>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <span class="px-2 py-1 rounded-full {{ $statusColor }} capitalize">{{ $status }}</span>
                                @if($o->pegawai)
                                    <span class="text-gray-600">Diproses oleh {{ $o->pegawai->nama }}</span>
                                @else
                                    <span class="text-gray-400">Belum ditugaskan</span>
                                @endif
                            </div>
                        </div>
                        <div class="mt-3 space-y-2">
                            @foreach($o->detailPenjualan as $d)
                                <div class="flex justify-between text-sm">
                                    <div class="text-gray-800">{{ $d->barang->nama_barang ?? 'Produk' }} × {{ $d->jumlah }}</div>
                                    <div class="text-gray-700">{{ $rupiah($d->subtotal ?? 0) }}</div>
                                </div>
                            @endforeach
                        </div>
                        @if(!empty($o->admin_note))
                            <div class="mt-2 text-xs text-gray-600">Catatan admin: {{ $o->admin_note }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
