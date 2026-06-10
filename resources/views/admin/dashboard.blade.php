@extends('layouts.app')
@section('title', 'Administration — Harfa.ma')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-admin')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Console d'administration</h1>
        <p class="portal-subtitle">Pilotez la plateforme Harfa.ma — utilisateurs, artisans et finances.</p>
      </div>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
      <div class="stat-card stat-green">
        <div class="stat-icon" style="background:#d1fae5;color:#059669"><i class="bi bi-people"></i></div>
        <div class="stat-label">Utilisateurs</div>
        <div class="stat-value" style="color:#059669">{{ $stats['users'] }}</div>
        <div class="stat-sub">Clients, Artisans, Admins</div>
      </div>
      <div class="stat-card stat-blue">
        <div class="stat-icon" style="background:#dbeafe;color:#2563eb"><i class="bi bi-person-badge"></i></div>
        <div class="stat-label">Artisans</div>
        <div class="stat-value" style="color:#2563eb">{{ $stats['craftsmen'] }}</div>
        <div class="stat-sub">Profils professionnels</div>
      </div>
      <div class="stat-card stat-amber">
        <div class="stat-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-calendar3"></i></div>
        <div class="stat-label">Réservations ce mois</div>
        <div class="stat-value" style="color:#d97706">{{ $stats['bookings_month'] }}</div>
        <div class="stat-sub">{{ now()->format('F Y') }}</div>
      </div>
      <div class="stat-card stat-purple">
        <div class="stat-icon" style="background:#ede9fe;color:#7c3aed"><i class="bi bi-star-fill"></i></div>
        <div class="stat-label">Satisfaction</div>
        <div class="stat-value" style="color:#7c3aed">{{ $stats['avg_rating'] }}</div>
        <div class="stat-sub">/ 5 — note moyenne</div>
      </div>
    </div>

    <div class="row g-4">

      {{-- Quick links --}}
      <div class="col-lg-12">
        <div class="card-premium h-100">
          <div class="card-premium-title"><i class="bi bi-lightning-charge"></i> Gestion rapide</div>
          <div class="d-flex flex-column gap-2">
            @foreach([
              ['route' => 'admin.users',     'icon' => 'bi-people',        'label' => 'Comptes utilisateurs',   'color' => 'text-green'],
              ['route' => 'admin.craftsmen', 'icon' => 'bi-person-check',  'label' => 'Validation artisans',    'color' => 'text-blue'],
              ['route' => 'admin.categories','icon' => 'bi-tags',          'label' => 'Catégories métiers',     'color' => 'text-amber'],
              ['route' => 'admin.bookings',  'icon' => 'bi-calendar3',     'label' => 'Audit réservations',     'color' => 'text-green'],
              ['route' => 'admin.reviews',   'icon' => 'bi-chat-heart',    'label' => 'Modération avis',        'color' => 'text-purple'],
              ['route' => 'admin.gigs',      'icon' => 'bi-briefcase',     'label' => 'Offres d\'emploi',      'color' => 'text-blue'],
              ['route' => 'admin.payments',  'icon' => 'bi-cash-coin',     'label' => 'Flux financiers',        'color' => 'text-amber'],
            ] as $link)
              <a href="{{ route($link['route']) }}"
                 style="display:flex;align-items:center;gap:12px;padding:12px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;transition:.2s;font-size:14px;font-weight:500"
                 onmouseover="this.style.borderColor='#059669';this.style.background='#f0fdf4'"
                 onmouseout="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
                <i class="bi {{ $link['icon'] }}" style="color:#059669;font-size:17px;width:20px;text-align:center"></i>
                {{ $link['label'] }}
                <i class="bi bi-chevron-right ms-auto" style="color:#94a3b8;font-size:13px"></i>
              </a>
            @endforeach
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
