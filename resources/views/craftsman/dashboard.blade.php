@extends('layouts.app')
@section('title', 'Dashboard Artisan — Harfa.ma')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-craftsman')
  
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Espace artisan 🔧</h1>
        <p class="portal-subtitle">Bienvenue, {{ auth()->user()->name }} — gérez vos chantiers et votre activité.</p>
      </div>
      <div class="page-actions">
        <form method="POST" action="{{ route('craftsman.availability.toggle') }}">
          @csrf
          <button type="submit" class="btn-harfa-ghost">
            @if($craftsman->availability_status)
              <span style="width:8px;height:8px;background:#059669;border-radius:50%;display:inline-block;animation:pulse-dot 1.5s infinite"></span>
              Disponible
            @else
              <span style="width:8px;height:8px;background:#94a3b8;border-radius:50%;display:inline-block"></span>
              Occupé
            @endif
          </button>
        </form>
        <a href="{{ route('craftsman.profile') }}" class="btn-harfa">
          <i class="bi bi-person-gear"></i> Mon profil
        </a>
      </div>
    </div>

    {{-- Alerts --}}
    @if(session('status'))
      <div class="alert-harfa alert-success mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
      </div>
    @endif
    @if(session('error'))
      <div class="alert-harfa alert-danger mb-4">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
      </div>
    @endif

    {{-- Stats --}}
    <div class="stats-grid">
      <div class="stat-card stat-green">
        <div class="stat-icon" style="background:#d1fae5;color:#059669"><i class="bi bi-check-circle"></i></div>
        <div class="stat-label">Travaux terminés</div>
        <div class="stat-value" style="color:#059669">{{ $completedBookings }}</div>
        <div class="stat-sub">Missions accomplies</div>
      </div>
      <div class="stat-card stat-blue">
        <div class="stat-icon" style="background:#dbeafe;color:#2563eb"><i class="bi bi-coin"></i></div>
        <div class="stat-label">Points</div>
        <div class="stat-value" style="color:#2563eb">{{ auth()->user()->points }}</div>
        <div class="stat-sub">5 pts par candidature</div>
      </div>
      <div class="stat-card stat-amber">
        <div class="stat-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-star-fill"></i></div>
        <div class="stat-label">Note moyenne</div>
        <div class="stat-value" style="color:#d97706">{{ number_format($avgRating, 1) }}</div>
        <div class="stat-sub">/ 5 étoiles</div>
      </div>
      <div class="stat-card stat-purple">
        <div class="stat-icon" style="background:#ede9fe;color:#7c3aed"><i class="bi bi-calendar-check"></i></div>
        <div class="stat-label">Chantiers actifs</div>
        <div class="stat-value" style="color:#7c3aed">{{ $activeBookings }}</div>
        <div class="stat-sub">En cours ou confirmés</div>
      </div>
    </div>

    <div class="row g-4">

      {{-- Available gigs --}}
      <div class="col-lg-7">
        <div class="card-premium">
          <div class="card-premium-title">
            <i class="bi bi-briefcase"></i> Jobs disponibles à proximité
            <span class="badge-cat ms-auto" style="font-size:11px">5 pts par candidature</span>
          </div>
          <p style="font-size:13px;color:#64748b;margin-top:-8px;margin-bottom:16px">
            Jobs correspondant à vos catégories
          </p>

          @forelse($matchingGigs as $gig)
            @php $alreadyApplied = $gig->applications->where('craftsman_id', $craftsman->id)->count() > 0; @endphp
            <div class="booking-row" style="{{ $alreadyApplied ? 'opacity:.85' : '' }}">
              <div class="booking-avatar" style="background:{{ $alreadyApplied ? '#f0fdf4' : '#f0fdf4' }};color:#059669">
                <i class="bi bi-briefcase" style="font-size:18px"></i>
              </div>
              <div class="booking-info">
                <div class="booking-name">{{ $gig->title }}</div>
                <div class="booking-meta">
                  <span class="badge-cat">{{ $gig->category->name }}</span>
                  <span class="ms-2"><i class="bi bi-geo-alt me-1"></i>{{ $gig->city }}</span>
                  <span class="ms-2 text-muted">· {{ $gig->created_at->diffForHumans() }}</span>
                </div>
              </div>

              @if($alreadyApplied)
                {{-- Already applied: show success badge + phone reveal button --}}
                <a href="{{ route('craftsman.gigs.show', $gig) }}"
                   style="display:inline-flex;align-items:center;gap:6px;font-size:13px;padding:7px 14px;white-space:nowrap;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;color:#15803d;font-weight:600;text-decoration:none">
                  <i class="bi bi-check-circle-fill"></i> Postulé
                </a>
              @else
                <a href="{{ route('craftsman.gigs.show', $gig) }}"
                   class="btn-harfa"
                   style="font-size:13px;padding:7px 14px;white-space:nowrap">
                  Postuler
                </a>
              @endif
            </div>
          @empty
            <div class="empty-state">
              <i class="bi bi-briefcase"></i>
              <h5>Aucun job disponible</h5>
              <p>Ajoutez plus de catégories à votre profil pour voir plus d'offres.</p>
              <a href="{{ route('craftsman.categories') }}" class="btn-harfa-ghost">
                Gérer mes catégories
              </a>
            </div>
          @endforelse
        </div>
      </div>

      {{-- Recent bookings --}}
      <div class="col-lg-5">
        <div class="card-premium">
          <div class="card-premium-title">
            <i class="bi bi-calendar-check"></i> Demandes de réservation
          </div>

          @forelse($bookings as $booking)
            <div class="booking-row">
              <div class="booking-avatar" style="background:#ede9fe;color:#7c3aed;font-size:16px">
                <i class="bi bi-person"></i>
              </div>
              <div class="booking-info">
                <div class="booking-name">{{ $booking->client->name }}</div>
                <div class="booking-meta">
                  <i class="bi bi-calendar me-1"></i>{{ $booking->booking_date->format('d/m/Y') }}
                </div>
                <span class="badge-status status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
              </div>
              <a href="{{ route('craftsman.bookings') }}" style="color:#94a3b8;font-size:18px">
                <i class="bi bi-chevron-right"></i>
              </a>
            </div>
          @empty
            <div class="empty-state">
              <i class="bi bi-calendar-x"></i>
              <h5>Aucune réservation</h5>
              <p>Complétez votre profil pour recevoir des demandes.</p>
            </div>
          @endforelse

          <div class="mt-2">
            <a href="{{ route('craftsman.bookings') }}" class="btn-harfa-ghost w-100 justify-content-center">
              Voir toutes les réservations
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
