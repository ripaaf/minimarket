@extends('layouts.app')

@section('content')
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Customer Login</h2>
    @if($errors->any())
      <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
        {{ $errors->first() }}
      </div>
    @endif
    <form method="POST" action="{{ url('/login') }}">
      @csrf
      <div class="mb-3">
        <label class="block mb-1">Email</label>
        <input name="email" type="email" value="{{ old('email') }}" class="w-full border p-2 rounded @error('email') border-red-500 @enderror" required>
        @error('email')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-3">
        <label class="block mb-1">Password</label>
        <input name="password" type="password" class="w-full border p-2 rounded @error('password') border-red-500 @enderror" required>
        @error('password')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div class="flex items-center justify-between">
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Login</button>
        <a href="{{ route('register') }}" class="text-sm text-gray-600">Register</a>
      </div>
    </form>
  </div>
@endsection
