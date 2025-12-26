@extends('layouts.app')

@section('content')
  <div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Admin Dashboard - Orders</h1>
    <div class="bg-white rounded shadow p-4">
      <table class="w-full text-left">
        <thead class="text-sm text-gray-600">
          <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Items</th>
            <th>Status</th>
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
              <td>{{ $o->status }}</td>
              <td>
                <form action="{{ route('admin.order.process', $o->id_penjualan) }}" method="POST">
                  @csrf
                  <select name="status" class="border p-1 rounded">
                    <option value="pending" @if($o->status=='pending') selected @endif>Pending</option>
                    <option value="processed" @if($o->status=='processed') selected @endif>Processed</option>
                    <option value="cancelled" @if($o->status=='cancelled') selected @endif>Cancelled</option>
                  </select>
                  <button class="ml-2 px-2 py-1 bg-blue-600 text-white rounded">Update</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
