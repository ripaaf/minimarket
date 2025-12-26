@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-2xl font-bold mb-4">Edit Profile</h2>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full border p-2">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Address</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="w-full border p-2">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Profile Photo</label>
                <input type="file" name="image" class="mt-2">
                @if($user->image_url)
                    <div class="mt-3">
                        <img src="{{ $user->image_url }}" class="w-24 h-24 object-cover rounded" alt="photo">
                    </div>
                @endif
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            <a href="{{ route('profile.show') }}" class="ml-2 text-sm text-gray-600">Cancel</a>
        </div>
    </form>
</div>

@endsection
