<nav class="bg-white shadow">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-between h-16">
      <div class="flex items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">Minimarket</a>
      </div>
      <div class="flex items-center space-x-4">
        <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900">Home</a>
        @if(session('user_id'))
          <a href="{{ route('shop') }}" class="text-gray-700 hover:text-gray-900">Shop</a>
          <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-gray-900">Cart</a>
          <a href="{{ route('profile.show') }}" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
            @if(session('user_image'))
              <img src="{{ session('user_image') }}" alt="avatar" class="w-6 h-6 rounded-full object-cover">
            @endif
            <span>{{ session('user_name') }}</span>
          </a>
        @else
          <span class="text-gray-400">Shop</span>
          <span class="text-gray-400">Cart</span>
          <a href="/login" class="text-gray-700 hover:text-gray-900">Login</a>
          <a href="/register" class="text-gray-700 hover:text-gray-900">Register</a>
        @endif
      </div>
    </div>
  </div>
</nav>
