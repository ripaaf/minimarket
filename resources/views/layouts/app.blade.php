<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minimarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
  @stack('styles')
  </head>
  <body class="bg-gray-100 font-sans leading-normal tracking-normal">
    @include('layouts.nav')

    <main class="container mx-auto px-4 py-6">
      @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
      @endif
      @yield('content')
    </main>
  @stack('scripts')
  <script>
    // prevent double form submit across the app
    document.addEventListener('submit', function(e){
      try{
        var form = e.target;
        if (!form || form.nodeName !== 'FORM') return;
        if (form.dataset._submitted === '1') { e.preventDefault(); return false; }
        form.dataset._submitted = '1';
        var btn = form.querySelector('button[type=submit]');
        if (btn) btn.disabled = true;
      }catch(err){console && console.error(err)}
    }, true);
  </script>
  </body>
</html>
