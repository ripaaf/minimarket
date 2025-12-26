@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-semibold mb-4">Your Cart</h1>

  @if(empty($cart))
    <p>Your cart is empty. <a href="{{ route('home') }}" class="text-blue-600">Continue shopping</a></p>
  @else
    <div class="bg-white p-4 rounded shadow">
      <table class="w-full">
        <thead class="text-left text-sm text-gray-600">
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($cart as $item)
            <tr class="border-t">
              <td class="py-2">{{ $item['nama_barang'] }}</td>
              <td>Rp {{ number_format($item['price'],0,',','.') }}</td>
              <td>{{ $item['quantity'] }}</td>
              <td>Rp {{ number_format($item['subtotal'],0,',','.') }}</td>
              <td>
                <form action="{{ route('cart.remove') }}" method="POST">
                  @csrf
                  <input type="hidden" name="id_barang" value="{{ $item['id'] }}">
                  <button class="px-3 py-1 bg-red-600 text-white rounded">Remove</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="mt-4 flex justify-between items-center">
        <div class="text-lg font-semibold">Total: Rp {{ number_format($total,0,',','.') }}</div>
        <a href="{{ route('checkout.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Proceed to Checkout</a>
      </div>
    </div>
  @endif
@endsection
