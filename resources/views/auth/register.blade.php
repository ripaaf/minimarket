@extends('layouts.app')

@section('content')
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Register</h2>
    @if($errors->any())
      <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
        {{ $errors->first() }}
      </div>
    @endif
    <form method="POST" action="{{ url('/register') }}">
      @csrf
      <div class="mb-3">
        <label class="block mb-1">Name</label>
        <input name="name" type="text" value="{{ old('name') }}" class="w-full border p-2 rounded @error('name') border-red-500 @enderror" required>
        @error('name')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-3">
        <label class="block mb-1">Email (optional)</label>
        <input name="email" type="email" value="{{ old('email') }}" class="w-full border p-2 rounded @error('email') border-red-500 @enderror">
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
      <div class="mb-3">
        <label class="block mb-1">Confirm Password</label>
        <input name="password_confirmation" type="password" class="w-full border p-2 rounded @error('password_confirmation') border-red-500 @enderror" required>
        @error('password_confirmation')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div>
        <button class="px-4 py-2 bg-green-600 text-white rounded">Register</button>
      </div>
    </form>
  </div>
@endsection
