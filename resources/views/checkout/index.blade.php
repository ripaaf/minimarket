@extends('layouts.app')

@section('content')
  <div class="container mx-auto px-4">
    @php
      $rupiah = function($v) { return is_numeric($v) ? 'Rp ' . number_format($v, 0, ',', '.') : $v; };
    @endphp
    <div class="flex items-center justify-between mb-4">
      <div>
        <p class="text-sm text-gray-500">Langkah terakhir sebelum bayar</p>
        <h1 class="text-2xl font-bold">Checkout</h1>
      </div>
      <div class="text-right text-sm text-gray-500">1) Isi data · 2) Tentukan lokasi · 3) Konfirmasi pesanan</div>
    </div>
    @if(session('error'))<div class="bg-red-100 text-red-700 p-2 mb-4">{{ session('error') }}</div>@endif
    <form action="{{ route('checkout.store') }}" method="POST" class="grid lg:grid-cols-3 gap-6">
      @csrf

      <div class="lg:col-span-2 space-y-4">
        <div class="bg-white shadow rounded p-4 space-y-4">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">1. Data Pemesan</h2>
            <span class="text-xs text-gray-500">Pastikan nomor telepon aktif</span>
          </div>
          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="block font-medium mb-1">Name</label>
              <input type="text" name="customer_name" value="{{ old('customer_name', $user->name ?? '') }}" class="w-full border p-2 rounded" placeholder="Nama lengkap" />
            </div>
            <div>
              <label class="block font-medium mb-1">Phone</label>
              <input type="tel" inputmode="numeric" pattern="[0-9]*" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', $user->phone ?? '') }}" class="w-full border p-2 rounded" placeholder="Hanya angka" />
              <p class="text-xs text-gray-500 mt-1">Contoh: 081234567890</p>
            </div>
            <div class="md:col-span-2">
              <label class="block font-medium mb-1">Address</label>
              <input type="text" id="customer_address" name="customer_address" value="{{ old('customer_address', $user->address ?? '') }}" class="w-full border p-2 rounded" maxlength="100" placeholder="Tuliskan alamat lengkap" />
              <p class="text-xs text-gray-500 mt-1">Maksimal 100 karakter.</p>
            </div>
          </div>
        </div>

        <div class="bg-white shadow rounded p-4 space-y-3">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">2. Lokasi Pengiriman (opsional)</h2>
            <span class="text-xs text-gray-500">Klik peta atau cari lokasi</span>
          </div>
          <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2">
            <input type="text" id="map_search" placeholder="Cari lokasi (misal: Monas, Jakarta)" class="border p-2 rounded w-full sm:w-2/3" />
            <button type="button" id="map_search_btn" class="mt-2 sm:mt-0 px-3 py-2 bg-gray-800 text-white rounded text-sm">Cari</button>
          </div>
          <div id="map" style="height:300px;" class="rounded border"></div>
          <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
          <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
        </div>
      </div>

      <div class="bg-white shadow rounded p-4 h-fit">
        <div class="flex items-center justify-between mb-3">
          <h2 class="text-lg font-semibold">3. Ringkasan Pesanan</h2>
          <span class="text-xs text-gray-500">Periksa sebelum kirim</span>
        </div>
        @if(empty($cart))
          <p class="text-gray-600">Your cart is empty.</p>
        @else
          <div class="space-y-2 text-sm">
            @foreach($cart as $item)
              <div class="flex justify-between">
                <span>{{ $item['nama_barang'] ?? ($item['name'] ?? 'Product') }} × {{ $item['quantity'] }}</span>
                <span>{{ $rupiah($item['subtotal'] ?? 0) }}</span>
              </div>
            @endforeach
            <hr>
            <div class="flex justify-between font-semibold">
              <span>Total</span>
              <span>{{ $rupiah($total ?? 0) }}</span>
            </div>
          </div>
        @endif
        <button type="submit" class="mt-4 w-full bg-blue-600 text-white px-4 py-2 rounded">Place Order</button>
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
    const phoneInput = document.getElementById('customer_phone');
    phoneInput?.addEventListener('input', () => {
      phoneInput.value = phoneInput.value.replace(/[^0-9]/g, '');
    });
    const setAddress = (text) => {
      const input = document.getElementById('customer_address');
      if (!input) return;
      const trimmed = (text || '').trim().slice(0, 100);
      if (trimmed) input.value = trimmed;
    };
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
            setAddress(json.display_name);
          }
        }
      } catch(err) {
        console && console.warn('Reverse geocode failed', err);
      }
    }
    async function searchLocation(){
      const qInput = document.getElementById('map_search');
      if(!qInput) return;
      const query = qInput.value.trim();
      if(!query) return;
      try {
        const resp = await fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&q=${encodeURIComponent(query)}&limit=1`);
        if(resp.ok){
          const results = await resp.json();
          if(Array.isArray(results) && results.length>0){
            const hit = results[0];
            const lat = parseFloat(hit.lat);
            const lon = parseFloat(hit.lon);
            if(!isNaN(lat) && !isNaN(lon)){
              map.setView([lat, lon], 15);
              setMarker(lat, lon);
              setAddress(hit.display_name || hit.name || query);
            }
          }
        }
      }catch(err){
        console && console.warn('Search failed', err);
      }
    }
    map.on('click', function(e){ setMarker(e.latlng.lat, e.latlng.lng); });
    document.getElementById('map_search_btn')?.addEventListener('click', searchLocation);
    document.getElementById('map_search')?.addEventListener('keydown', (e)=>{
      if(e.key === 'Enter'){
        e.preventDefault();
        searchLocation();
      }
    });
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
