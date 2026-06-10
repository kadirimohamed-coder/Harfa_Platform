<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Harfa.ma — Trouvez un artisan de confiance')</title>
  <meta name="description" content="@yield('description','Harfa.ma connecte les clients avec des artisans qualifiés au Maroc.')">

  {{-- Bootstrap Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  {{-- Google Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  {{-- AOS --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

  @yield('styles')
  @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>

  @include('partials.nav')

  @if(session('status'))
    <div class="container mt-3">
      <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('status') }}
      </div>
    </div>
  @endif

  {{-- @if($errors->any())
    <div class="container my-3">
      <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <ul class="mb-0 ps-3">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif --}}

  <main >
    @yield('content')
  </main>

  @include('partials.footer')

  {{-- Scripts --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>AOS.init({ duration: 700, once: true, offset: 50 });</script>

  @stack('scripts')
</body>
</html>
