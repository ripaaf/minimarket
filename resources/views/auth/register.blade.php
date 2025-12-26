@extends('layouts.app')

@section('content')
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Register</h2>
    <form method="POST" action="{{ url('/register') }}">
      @csrf
      <div class="mb-3">
        <label class="block mb-1">Name</label>
        <input name="name" type="text" class="w-full border p-2 rounded" required>
      </div>
      <div class="mb-3">
        <label class="block mb-1">Email (optional)</label>
        <input name="email" type="email" class="w-full border p-2 rounded">
      </div>
      <div class="mb-3">
        <label class="block mb-1">Password</label>
        <input name="password" type="password" class="w-full border p-2 rounded" required>
      </div>
      <div class="mb-3">
        <label class="block mb-1">Confirm Password</label>
        <input name="password_confirmation" type="password" class="w-full border p-2 rounded" required>
      </div>
      <div>
        <button class="px-4 py-2 bg-green-600 text-white rounded">Register</button>
      </div>
    </form>
  </div>
@endsection
