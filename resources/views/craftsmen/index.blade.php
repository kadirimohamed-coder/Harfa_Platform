@extends('layouts.app')
@section('title', 'Parcourir les artisans — Harfa.ma')
@section('content')
<div class="container py-4" style="margin-top: 40px; margin-bottom: 50px;" >

  {{-- Page header --}}
  <div class="section-header mb-4">
    <div>
      <h2 class="section-title">Artisans disponibles</h2>
      <p class="section-subtitle">{{ $craftsmen->total() }} artisan(s) trouvé(s)</p>
    </div>
  </div>

  {{-- Filters --}}
  <form action="{{ route('craftsmen.index') }}" method="GET" class="card-premium mb-4" style="padding:20px 24px">
    <div class="row g-3 align-items-end">
      <div class="col-md-4">
        <label class="form-label">Recherche</label>
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0" style="border:1.5px solid #e2e8f0">
            <i class="bi bi-search text-muted"></i>
          </span>
          <input type="text" name="search" value="{{ request('search') }}"
                 class="form-control border-start-0" placeholder="Nom, ville, service...">
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label">Catégorie</label>
        <select name="category" class="form-select">
          <option value="">Toutes les catégories</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>
              {{ $c->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Ville</label>
        <input type="text" name="city" value="{{ request('city') }}"
               class="form-control" placeholder="Casablanca, Rabat...">
      </div>
      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn-harfa flex-grow-1 justify-content-center">
          <i class="bi bi-search"></i>
        </button>
        @if(request()->hasAny(['search','city','category']))
          <a href="{{ route('craftsmen.index') }}" class="btn-harfa-outline" style="padding:9px 12px">
            <i class="bi bi-x"></i>
          </a>
        @endif
      </div>
    </div>
  </form>

  {{-- Results --}}
  <div class="row g-4">
    @forelse($craftsmen as $cm)
      <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 80 }}">
        <a href="{{ route('craftsmen.show', $cm->id) }}" class="text-decoration-none">
          <div class="artisan-card">
            <div class="artisan-cover">
              @if($cm->availability_status)
                <span class="availability-badge position-absolute" style="top:10px;right:10px;font-size:11px">Disponible</span>
              @else
                <span class="availability-badge-off position-absolute" style="top:10px;right:10px;font-size:11px">Occupé</span>
              @endif
            </div>
            <div class="artisan-body">
              <div class="artisan-avatar">
                {{ strtoupper(substr($cm->user->name, 0, 2)) }}
              </div>
              <h5 class="mb-1 fw-bold" style="font-size:15px;color:#0f172a">{{ $cm->user->name }}</h5>
              <p class="mb-2" style="font-size:12px;color:#64748b">
                @if($cm->user->city) {{ $cm->user->city }} @endif
                @if($cm->categories->count()) · {{ $cm->categories->first()->name }} @endif
              </p>

              {{-- Stars --}}
              <div class="mb-2 d-flex justify-content-center gap-1 align-items-center">
                @for($i = 1; $i <= 5; $i++)
                  <i class="bi bi-star{{ $i <= round($cm->reviews_avg_rating ?? 0) ? '-fill text-warning' : ' text-muted' }}" style="font-size:13px"></i>
                @endfor
                <span style="font-size:12px;color:#64748b;margin-left:4px">
                  {{ number_format($cm->reviews_avg_rating ?? 0, 1) }}
                </span>
              </div>

              {{-- Categories --}}
              @if($cm->categories->count())
                <div class="d-flex flex-wrap gap-1 justify-content-center mb-3">
                  @foreach($cm->categories->take(2) as $cat)
                    <span class="badge-cat">{{ $cat->name }}</span>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
        </a>

        {{-- Book button (clients only) --}}
        @auth
          @if(auth()->user()->isClient())
            <a href="{{ route('client.book.form', $cm) }}"
               class="btn-harfa w-100 justify-content-center mt-2" style="border-radius:0 0 16px 16px">
              <i class="bi bi-calendar-check"></i> Réserver
            </a>
          @endif
        @endauth
      </div>
    @empty
      <div class="col-12">
        <div class="empty-state">
          <i class="bi bi-search"></i>
          <h5>Aucun artisan trouvé</h5>
          <p>Essayez d'élargir votre recherche ou de changer de catégorie.</p>
          <a href="{{ route('craftsmen.index') }}" class="btn-harfa">Voir tous les artisans</a>
        </div>
      </div>
    @endforelse
  </div>

  {{-- Pagination --}}
  @if($craftsmen->hasPages())
    <div class="d-flex justify-content-center mt-5">
      {{ $craftsmen->withQueryString()->links() }}
    </div>
  @endif

</div>
@endsection