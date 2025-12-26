@extends('layouts.app')

@section('content')
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
                        <div class="text-sm text-gray-600">Rp {{ $b->harga }}</div>
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
            <div class="mt-3 space-y-3">
                @foreach($orders as $o)
                    <div class="p-3 bg-gray-50 rounded">
                        <div class="flex justify-between">
                            <div>
                                <div class="font-semibold">Order #{{ $o->id_penjualan }}</div>
                                <div class="text-sm text-gray-600">Date: {{ $o->tanggal }}</div>
                            </div>
                            <div class="text-sm">
                                <div>Status: <span class="font-medium">{{ $o->status ?? 'pending' }}</span></div>
                                @if(!empty($o->admin_note))
                                    <div class="text-xs mt-1 text-gray-700">Note: {{ $o->admin_note }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
