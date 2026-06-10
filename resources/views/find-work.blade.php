@extends('layouts.app')
@section('title', 'Trouver du travail — Harfa.ma')
@section('content')
<div class="container py-4">

  {{-- Hero --}}
  <div style="background:linear-gradient(135deg,#1e3a5f 0%,#1d4ed8 100%);border-radius:20px;padding:56px 40px;color:white;margin-bottom:40px;position:relative;overflow:hidden">
    <div style="position:absolute;top:-60px;right:-60px;width:280px;height:280px;background:radial-gradient(circle,rgba(255,255,255,.07) 0%,transparent 70%)"></div>
    <div class="row align-items-center">
      <div class="col-lg-7">
        <span style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);border-radius:999px;padding:5px 16px;font-size:13px;font-weight:600;display:inline-block;margin-bottom:20px">
          <i class="bi bi-briefcase me-2"></i>Espace artisans
        </span>
        <h1 style="font-size:clamp(28px,4vw,44px);font-weight:800;line-height:1.15;margin-bottom:16px;color:white">
          Trouvez des chantiers<br>qui vous correspondent
        </h1>
        <p style="font-size:16px;color:rgba(255,255,255,.8);line-height:1.6;margin-bottom:32px">
          Des clients postent leurs besoins chaque jour. Postulez avec vos points et développez votre clientèle.
        </p>
        @guest
          <div class="d-flex gap-3">
            <a href="{{ route('register', ['role'=>'craftsman']) }}" class="btn-harfa">
              <i class="bi bi-person-plus"></i> Créer mon profil artisan
            </a>
            <a href="{{ route('login') }}" style="color:rgba(255,255,255,.85);font-size:14px;font-weight:600;text-decoration:none;padding:10px 0;display:inline-flex;align-items:center;gap:6px">
              Déjà inscrit ? <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        @endguest
      </div>
      <div class="col-lg-5 d-none d-lg-flex justify-content-center">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;max-width:280px">
          @foreach(['Plomberie','Électricité','Peinture','Menuiserie'] as $s)
            <div style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:16px;text-align:center;backdrop-filter:blur(8px)">
              <i class="bi bi-tools" style="font-size:24px;color:rgba(255,255,255,.8);display:block;margin-bottom:8px"></i>
              <div style="font-size:13px;color:rgba(255,255,255,.8);font-weight:600">{{ $s }}</div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  {{-- Filters --}}
  <form action="{{ route('find-work') }}" method="GET" class="card-premium mb-5" style="padding:20px 24px">
    <div class="row g-3 align-items-end">
      <div class="col-md-4">
        <label class="form-label">Mot-clé</label>
        <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Plombier, peinture...">
      </div>
      <div class="col-md-3">
        <label class="form-label">Catégorie</label>
        <select class="form-select" name="category">
          <option value="">Toutes</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Ville</label>
        <input class="form-control" name="city" value="{{ request('city') }}" placeholder="Casablanca">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn-harfa w-100 justify-content-center">
          <i class="bi bi-search"></i> Filtrer
        </button>
      </div>
    </div>
  </form>

  {{-- Gigs grid --}}
  <div class="section-header mb-4">
    <div>
      <h2 class="section-title">Offres disponibles</h2>
      <p class="section-subtitle">{{ $gigs->total() }} offre(s) publiée(s)</p>
    </div>
  </div>

  <div class="row g-4">
    @forelse($gigs as $gig)
      <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 2) * 60 }}">
        <div class="card-modern" style="padding:24px">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="d-flex align-items-center gap-3">
              <div style="width:48px;height:48px;background:linear-gradient(135deg,#1e3a5f,#1d4ed8);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <i class="bi {{ $gig->category->icon ?? 'bi-briefcase' }}" style="color:white;font-size:20px"></i>
              </div>
              <div>
                <h5 style="font-size:15px;font-weight:700;color:#0f172a;margin-bottom:2px">{{ $gig->title }}</h5>
                <span class="badge-cat">{{ $gig->category->name }}</span>
              </div>
            </div>
            <span class="badge-status status-open" style="white-space:nowrap">Ouverte</span>
          </div>

          <p style="font-size:14px;color:#475569;line-height:1.6;margin-bottom:16px">
            {{ Str::limit($gig->description, 120) }}
          </p>

          <div class="d-flex flex-wrap gap-3 mb-4" style="font-size:13px;color:#64748b">
            <span><i class="bi bi-geo-alt me-1" style="color:#059669"></i>{{ $gig->city }}</span>
            @if($gig->deadline)
              <span><i class="bi bi-calendar me-1" style="color:#059669"></i>{{ \Carbon\Carbon::parse($gig->deadline)->format('d/m/Y') }}</span>
            @endif
            <span><i class="bi bi-people me-1" style="color:#059669"></i>{{ $gig->applications->count() }} candidature(s)</span>
            <span><i class="bi bi-clock me-1" style="color:#94a3b8"></i>{{ $gig->created_at->diffForHumans() }}</span>
          </div>

          <div class="d-flex gap-2">
            @auth
              @if(auth()->user()->isCraftsman())
                @if($gig->applications->where('craftsman_id', auth()->user()->craftsman->id)->count())
                  <span class="btn-harfa-ghost" style="pointer-events:none;opacity:.7">
                    <i class="bi bi-check"></i> Déjà postulé
                  </span>
                @else
                  <form method="POST" action="{{ route('craftsman.gigs.apply', $gig) }}">
                    @csrf
                    <button type="submit" class="btn-harfa" style="font-size:13px;padding:9px 18px">
                      <i class="bi bi-send"></i> Postuler (5 pts)
                    </button>
                  </form>
                @endif
              @endif
            @else
              <a href="{{ route('login') }}" class="btn-harfa">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter pour postuler
              </a>
            @endauth
            <a href="{{ route('craftsmen.show', $gig->client_user_id ?? 1) }}"
               class="btn-harfa-ghost" style="font-size:13px;padding:9px 14px">
              <i class="bi bi-info-circle"></i>
            </a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="empty-state">
          <i class="bi bi-briefcase"></i>
          <h5>Aucune offre disponible</h5>
          <p>De nouvelles offres sont publiées quotidiennement. Revenez bientôt ou élargissez vos critères.</p>
        </div>
      </div>
    @endforelse
  </div>

  @if($gigs->hasPages())
    <div class="d-flex justify-content-center mt-5">{{ $gigs->withQueryString()->links() }}</div>
  @endif

</div>
@endsection
