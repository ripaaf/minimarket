@extends('layouts.app')

@section('content')
  <div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Checkout</h1>
    @if(session('error'))<div class="bg-red-100 text-red-700 p-2 mb-4">{{ session('error') }}</div>@endif
    <form action="{{ route('checkout.store') }}" method="POST">
      @csrf

      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="block font-medium">Name</label>
          <input type="text" name="customer_name" value="{{ old('customer_name', $user->name ?? '') }}" class="w-full border p-2" />
        </div>
        <div>
          <label class="block font-medium">Phone</label>
          <input type="text" name="customer_phone" value="{{ old('customer_phone', $user->phone ?? '') }}" class="w-full border p-2" />
        </div>
        <div class="md:col-span-2">
          <label class="block font-medium">Address</label>
          <input type="text" id="customer_address" name="customer_address" value="{{ old('customer_address', $user->address ?? '') }}" class="w-full border p-2" />
        </div>

        <div class="md:col-span-2">
          <label class="block font-medium mb-2">Select location on map (optional)</label>
          <div id="map" style="height:300px;" class="mb-2"></div>
          <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
          <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
        </div>
      </div>

      <div class="mt-6">
        <h2 class="text-xl font-semibold">Order Summary</h2>
        @if(empty($cart))
          <p>Your cart is empty.</p>
        @else
          <ul>
          @foreach($cart as $item)
            <li>{{ $item['nama_barang'] ?? ($item['name'] ?? 'Product') }} x {{ $item['quantity'] }} = {{ $item['subtotal'] }}</li>
          @endforeach
          </ul>
          <p class="font-bold">Total: {{ $total }}</p>
        @endif
      </div>

      <div class="mt-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2">Place Order</button>
      </div>
    </form>
  </div>

  <!-- Leaflet map -->
  @push('styles')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
  @endpush
  @push('scripts')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
  <script>
    const map = L.map('map').setView([{{ old('latitude', $user->latitude ?? 0) ?: -6.200000 }}, {{ old('longitude', $user->longitude ?? 0) ?: 106.816666 }}], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19}).addTo(map);
    let marker = null;
    async function setMarker(lat,lng){
      if(marker) map.removeLayer(marker);
      marker = L.marker([lat,lng]).addTo(map);
      document.getElementById('latitude').value = lat;
      document.getElementById('longitude').value = lng;
      // reverse geocode with Nominatim to fill address field if possible
      try {
        const resp = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
        if (resp.ok) {
          const json = await resp.json();
          if (json && json.display_name) {
            const input = document.getElementById('customer_address');
            if (input && (!input.value || input.value.trim()==='')) {
              input.value = json.display_name;
            }
          }
        }
      } catch(err) {
        console && console.warn('Reverse geocode failed', err);
      }
    }
    map.on('click', function(e){ setMarker(e.latlng.lat, e.latlng.lng); });
    // if there are initial coords, set marker
    const initLat = parseFloat(document.getElementById('latitude').value || '{{ $user->latitude ?? '' }}');
    const initLng = parseFloat(document.getElementById('longitude').value || '{{ $user->longitude ?? '' }}');
    if (!isNaN(initLat) && !isNaN(initLng) && initLat !== 0 && initLng !== 0) {
      setMarker(initLat, initLng);
      map.setView([initLat, initLng], 14);
    }
  </script>
  @endpush

  @endsection
