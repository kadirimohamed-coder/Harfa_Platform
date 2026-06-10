@extends('layouts.app')
@section('title', 'Mon profil — Harfa.ma')

@section('content')
<div class="container py-4" style="max-width:720px">

  <div class="profile-page">
    {{-- Profile hero --}}
    <div class="profile-hero d-flex align-items-center gap-4">
      @if($user->photo)
        <img src="{{ asset('storage/'.$user->photo) }}"
            class="profile-big-avatar"
            style="object-fit:cover;padding:0;border:3px solid rgba(255,255,255,.3)"
            alt="{{ $user->name }}">
      @else
        <div class="profile-big-avatar">
          {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
      @endif
        <div>
          <h3>{{ $user->name }}</h3>
          <p style="font-size:14px;color:rgba(255,255,255,.75);margin-bottom:8px">
            {{ $user->email }}
            @if($user->city)
              &nbsp;·&nbsp;{{ $user->city }}
            @endif
          </p>
        <div class="d-flex align-items-center gap-2 flex-wrap">
          {{-- Role en français --}}
          <span style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);
                      color:white;padding:3px 12px;border-radius:999px;font-size:12px;font-weight:600">
            @switch($user->role)
              @case('craftsman') Artisan      @break
              @case('client')    Client       @break
              @case('admin')     Administrateur @break
              @default           {{ ucfirst($user->role) }}
            @endswitch
          </span>
          {{-- Status --}}
          <span class="badge-status status-{{ $user->status ?? 'active' }}">
            {{ ($user->status ?? 'active') === 'active' ? 'Actif' : 'Inactif' }}
          </span>
        </div>
      </div>
    </div>

    {{-- Form --}}
    <div class="card-premium">
      <div class="card-premium-title">
        <i class="bi bi-person-gear"></i> Modifier mes informations
      </div>

      <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
          <div class="col-12">
            <label class="form-label">Nom complet</label>
            <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Téléphone</label>
            <input class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="06 00 00 00 00">
          </div>
          <div class="col-md-6">
            <label class="form-label">Ville</label>
            <input class="form-control" name="city" value="{{ old('city', $user->city) }}" placeholder="Casablanca">
          </div>
          <div class="col-12">
            <label class="form-label">Adresse complète</label>
            <input class="form-control" name="address" value="{{ old('address', $user->address) }}" placeholder="123 Rue Mohammed V">
          </div>
          <div class="col-12">
            <label class="form-label">Photo de profil</label>
            @if($user->photo)
              <div class="mb-2">
                <img src="{{ asset('storage/'.$user->photo) }}" class="rounded-circle" width="60" height="60" style="object-fit:cover">
              </div>
            @endif
            <input type="file" class="form-control" name="photo" accept="image/*">
          </div>
        </div>

        <div class="mt-4">
          <button type="submit" class="btn-harfa">
            <i class="bi bi-check-lg"></i> Enregistrer les modifications
          </button>
        </div>
      </form>
    </div>

    {{-- Role-specific quick links --}}
    @if(auth()->user()->isCraftsman())
      <div class="card-premium">
        <div class="card-premium-title"><i class="bi bi-link-45deg"></i> Liens rapides</div>
        <div class="d-flex gap-3 flex-wrap">
          <a href="{{ route('craftsman.dashboard') }}" class="btn-harfa-ghost">
            <i class="bi bi-grid"></i> Mon tableau de bord
          </a>
          <a href="{{ route('craftsman.profile') }}" class="btn-harfa-ghost">
            <i class="bi bi-person-badge"></i> Profil artisan
          </a>
        </div>
      </div>
    @elseif(auth()->user()->isClient())
      <div class="card-premium">
        <div class="card-premium-title"><i class="bi bi-link-45deg"></i> Liens rapides</div>
        <div class="d-flex gap-3 flex-wrap">
          <a href="{{ route('client.dashboard') }}" class="btn-harfa-ghost">
            <i class="bi bi-grid"></i> Mon tableau de bord
          </a>
          <a href="{{ route('client.bookings') }}" class="btn-harfa-ghost">
            <i class="bi bi-calendar-check"></i> Mes réservations
          </a>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
