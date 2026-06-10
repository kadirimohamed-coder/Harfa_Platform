@extends('layouts.app')
@section('title', 'Dashboard Client — Harfa.ma')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-client')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Bonjour, {{ auth()->user()->name }} 👋</h1>
        <p class="portal-subtitle">Gérez vos réservations, offres d'emploi et messages depuis ici.</p>
      </div>
      <div class="page-actions">
        <a href="{{ route('craftsmen.index') }}" class="btn-harfa-ghost">
          <i class="bi bi-search"></i> Trouver un artisan
        </a>
        <a href="{{ route('client.post-job') }}" class="btn-harfa">
          <i class="bi bi-plus"></i> Publier un job
        </a>
      </div>
    </div>

    {{-- Alerts --}}
    @if(session('status'))
      <div class="alert-harfa alert-success mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
      </div>
    @endif

    {{-- 🔔 New applications notification banner --}}
    @if($newApplications->count() > 0)
      <div style="background:linear-gradient(135deg,#f0fdf4 0%,#dcfce7 100%);border:1px solid #86efac;border-radius:14px;padding:18px 22px;margin-bottom:24px;display:flex;align-items:flex-start;gap:16px">
        <div style="width:44px;height:44px;background:#059669;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <i class="bi bi-bell-fill" style="color:#fff;font-size:20px"></i>
        </div>
        <div style="flex:1">
          <div style="font-size:15px;font-weight:700;color:#14532d;margin-bottom:4px">
            {{ $newApplications->count() }} nouvelle{{ $newApplications->count() > 1 ? 's' : '' }} candidature{{ $newApplications->count() > 1 ? 's' : '' }} reçue{{ $newApplications->count() > 1 ? 's' : '' }} (dernières 48h)
          </div>
          <div style="font-size:13px;color:#166534">
            @foreach($newApplications->groupBy('gig_id') as $gigId => $apps)
              @php $gigTitle = $apps->first()->gig->title; @endphp
              <span style="display:inline-block;margin-right:12px">
                <i class="bi bi-briefcase me-1"></i>
                <strong>{{ $apps->count() }}</strong> sur « {{ Str::limit($gigTitle, 40) }} »
              </span>
            @endforeach
          </div>
        </div>
        <a href="{{ route('client.dashboard') }}#mes-offres"
           style="flex-shrink:0;background:#059669;color:#fff;border-radius:8px;padding:8px 16px;font-size:13px;font-weight:600;text-decoration:none;white-space:nowrap">
          Voir les offres
        </a>
      </div>
    @endif

    {{-- Stats --}}
    <div class="stats-grid">
      <div class="stat-card stat-green">
        <div class="stat-icon" style="background:#d1fae5;color:#059669">
          <i class="bi bi-calendar-check"></i>
        </div>
        <div class="stat-label">Total réservations</div>
        <div class="stat-value" style="color:#059669">{{ $totalBookings }}</div>
        <div class="stat-sub">Toutes périodes confondues</div>
      </div>
      <div class="stat-card stat-blue">
        <div class="stat-icon" style="background:#dbeafe;color:#2563eb">
          <i class="bi bi-clock"></i>
        </div>
        <div class="stat-label">Actives</div>
        <div class="stat-value" style="color:#2563eb">{{ $activeBookings }}</div>
        <div class="stat-sub">En attente ou confirmées</div>
      </div>
      <div class="stat-card stat-amber">
        <div class="stat-icon" style="background:#fef3c7;color:#d97706">
          <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-label">Clôturées</div>
        <div class="stat-value" style="color:#d97706">{{ $completedBookings }}</div>
        <div class="stat-sub">Contrats terminés</div>
      </div>
      <div class="stat-card" style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px">
        <div class="stat-icon" style="background:#fef9c3;color:#ca8a04">
          <i class="bi bi-briefcase"></i>
        </div>
        <div class="stat-label">Candidatures reçues</div>
        <div class="stat-value" style="color:#ca8a04">{{ $newApplications->count() }}</div>
        <div class="stat-sub">Dernières 48 heures</div>
      </div>
    </div>

    <div class="row g-4" id="mes-offres">

      {{-- Active gigs --}}
      <div class="col-lg-7">
        <div class="card-premium">
          <div class="card-premium-title">
            <i class="bi bi-briefcase"></i> Mes offres d'emploi actives
          </div>

          @forelse($gigs as $gig)
            @php $recentAppCount = $gig->applications->where('created_at', '>=', now()->subHours(48))->count(); @endphp
            <div class="booking-row" style="{{ $recentAppCount > 0 ? 'background:#f0fdf4;border-radius:10px;border:1px solid #bbf7d0;margin-bottom:6px' : '' }}">
              <div class="booking-avatar"
                   style="background:{{ $recentAppCount > 0 ? '#dcfce7' : '#f1f5f9' }};color:{{ $recentAppCount > 0 ? '#059669' : '#64748b' }}">
                {{ strtoupper(substr($gig->title, 0, 1)) }}
              </div>
              <div class="booking-info">
                <div class="booking-name" style="display:flex;align-items:center;gap:8px">
                  {{ $gig->title }}
                  @if($recentAppCount > 0)
                    <span style="display:inline-flex;align-items:center;gap:4px;background:#059669;color:#fff;border-radius:20px;padding:2px 9px;font-size:11px;font-weight:700">
                      <i class="bi bi-bell-fill" style="font-size:9px"></i> {{ $recentAppCount }} nouveau{{ $recentAppCount > 1 ? 'x' : '' }}
                    </span>
                  @endif
                </div>
                <div class="booking-meta">
                  <span class="badge-cat">{{ $gig->category->name }}</span>
                  <span class="ms-2"><i class="bi bi-geo-alt me-1"></i>{{ $gig->city }}</span>
                  <span class="ms-2">
                    <i class="bi bi-people me-1"></i>{{ $gig->applications->count() }} postulant(s)
                  </span>
                </div>
              </div>
              <a href="{{ route('client.gigs.show', $gig) }}"
                 class="{{ $recentAppCount > 0 ? 'btn-harfa' : 'btn-harfa-ghost' }}"
                 style="white-space:nowrap;font-size:13px;padding:7px 14px">
                Voir candidatures
              </a>
            </div>
          @empty
            <div class="empty-state">
              <i class="bi bi-briefcase"></i>
              <h5>Aucune offre publiée</h5>
              <p>Publiez une offre pour recevoir des candidatures d'artisans.</p>
              <a href="{{ route('client.post-job') }}" class="btn-harfa">
                <i class="bi bi-plus"></i> Publier un job
              </a>
            </div>
          @endforelse
        </div>

        {{-- Recent new applicants panel --}}
        @if($newApplications->count() > 0)
          <div class="card-premium mt-4">
            <div class="card-premium-title" style="color:#059669">
              <i class="bi bi-person-check"></i> Nouveaux postulants (48h)
            </div>
            @foreach($newApplications as $app)
              <div class="booking-row">
                <div class="booking-avatar" style="background:#dbeafe;color:#2563eb;font-size:18px">
                  <i class="bi bi-person-gear"></i>
                </div>
                <div class="booking-info">
                  <div class="booking-name">{{ $app->craftsman->user->name }}</div>
                  <div class="booking-meta">
                    <span class="badge-cat" style="font-size:11px">{{ $app->gig->title }}</span>
                    @if($app->craftsman->user->city)
                      <span class="ms-2"><i class="bi bi-geo-alt me-1"></i>{{ $app->craftsman->user->city }}</span>
                    @endif
                    <span class="ms-2 text-muted">· {{ $app->created_at->diffForHumans() }}</span>
                  </div>
                </div>
                <div class="d-flex gap-2">
                  <a href="{{ route('craftsmen.show', $app->craftsman) }}"
                     class="btn-harfa-ghost"
                     style="font-size:12px;padding:6px 10px"
                     title="Voir profil">
                    <i class="bi bi-person"></i>
                  </a>
                  <a href="{{ route('client.inbox.chat', $app->craftsman->user_id) }}"
                     class="btn-harfa"
                     style="font-size:12px;padding:6px 12px"
                     title="Contacter">
                    <i class="bi bi-chat me-1"></i> Contacter
                  </a>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      {{-- Recent bookings --}}
      <div class="col-lg-5">
        <div class="card-premium">
          <div class="card-premium-title">
            <i class="bi bi-calendar-check"></i> Réservations récentes
          </div>

          @forelse($bookings as $booking)
            <div class="booking-row">
              <div class="booking-avatar" style="background:#e0f2fe;color:#0369a1;font-size:16px">
                <i class="bi bi-person"></i>
              </div>
              <div class="booking-info">
                <div class="booking-name">{{ $booking->craftsman->user->name }}</div>
                <div class="booking-meta">
                  <i class="bi bi-calendar me-1"></i>{{ $booking->booking_date->format('d/m/Y') }}
                </div>
                <span class="badge-status status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
              </div>
              <a href="{{ route('client.bookings') }}" style="color:#94a3b8;font-size:18px">
                <i class="bi bi-chevron-right"></i>
              </a>
            </div>
          @empty
            <div class="empty-state">
              <i class="bi bi-calendar-x"></i>
              <h5>Aucune réservation</h5>
              <p>Réservez un artisan pour démarrer.</p>
            </div>
          @endforelse

          <div class="mt-2">
            <a href="{{ route('client.bookings') }}" class="btn-harfa-ghost w-100 justify-content-center">
              Voir toutes les réservations
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection