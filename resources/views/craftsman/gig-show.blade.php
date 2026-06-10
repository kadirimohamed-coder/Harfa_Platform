@extends('layouts.app')
@section('title', $gig->title . ' — Harfa.ma')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-craftsman')
  <div class="portal-content">

    {{-- Header --}}
    <div class="portal-header">
      <div>
        <a href="{{ url()->previous() }}" class="btn-harfa-ghost" style="margin-bottom:10px;display:inline-flex">
          <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
        <h1 class="portal-title">{{ $gig->title }}</h1>
        <p class="portal-subtitle">Détails de l'offre · Postuler coûte <strong>5 points</strong></p>
      </div>
      <div class="page-actions">
        <span class="badge-status status-{{ $gig->status }}">
          {{ ucfirst($gig->status) }}
        </span>
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

    <div class="row g-4">

      {{-- Main gig card --}}
      <div class="col-lg-8">
        <div class="card-premium">
          <div class="card-premium-title">
            <i class="bi bi-briefcase"></i> Description du job
          </div>

          <p style="color:#374151;line-height:1.75;font-size:15px;white-space:pre-line">{{ $gig->description }}</p>

          <hr style="border-color:#e2e8f0;margin:20px 0">

          {{-- Meta grid --}}
          <div class="row g-3">
            <div class="col-sm-6">
              <div style="background:#f8fafc;border-radius:10px;padding:14px 16px">
                <div style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:#94a3b8;font-weight:600;margin-bottom:4px">Catégorie</div>
                <div style="font-size:1rem;font-weight:600;color:#0f172a">
                  <span class="badge-cat">{{ $gig->category->name }}</span>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div style="background:#f8fafc;border-radius:10px;padding:14px 16px">
                <div style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:#94a3b8;font-weight:600;margin-bottom:4px">Ville</div>
                <div style="font-size:1rem;font-weight:600;color:#0f172a">
                  <i class="bi bi-geo-alt me-1 text-muted"></i>{{ $gig->city }}
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div style="background:#f8fafc;border-radius:10px;padding:14px 16px">
                <div style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:#94a3b8;font-weight:600;margin-bottom:4px">Date limite</div>
                <div style="font-size:1rem;font-weight:600;color:#0f172a">
                  @if($gig->deadline)
                    <i class="bi bi-calendar me-1 text-muted"></i>{{ $gig->deadline->format('d/m/Y') }}
                  @else
                    <span class="text-muted">Non précisée</span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Client info --}}
        <div class="card-premium mt-4">
          <div class="card-premium-title">
            <i class="bi bi-person-circle"></i> Publié par
          </div>
          <div class="booking-row" style="padding:0">
            <div class="booking-avatar" style="background:#ede9fe;color:#7c3aed;font-size:20px">
              <i class="bi bi-person"></i>
            </div>
            <div class="booking-info">
              <div class="booking-name">{{ $gig->client->name }}</div>
              <div class="booking-meta">
                <i class="bi bi-clock me-1"></i>Publié {{ $gig->created_at->diffForHumans() }}
                @if($gig->client->city)
                  <span class="ms-2"><i class="bi bi-geo-alt me-1"></i>{{ $gig->client->city }}</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Sidebar: apply + contact --}}
      <div class="col-lg-4">

        {{-- Points balance --}}
        <div class="card-premium mb-4">
          <div class="card-premium-title">
            <i class="bi bi-coin"></i> Votre solde
          </div>
          <div style="text-align:center;padding:10px 0 6px">
            <div style="font-size:2rem;font-weight:700;color:#2563eb">{{ auth()->user()->points }}</div>
            <div style="font-size:13px;color:#64748b">points disponibles</div>
          </div>
          @if(auth()->user()->points < 5)
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:10px 14px;font-size:13px;color:#dc2626;margin-top:10px">
              <i class="bi bi-exclamation-triangle me-1"></i>
              Solde insuffisant. Il vous faut au moins <strong>5 points</strong>.
            </div>
            <a href="{{ route('craftsman.billing') }}" class="btn-harfa-ghost w-100 justify-content-center mt-3">
              <i class="bi bi-plus-circle me-1"></i> Recharger des points
            </a>
          @endif
        </div>

        {{-- Apply / already applied card --}}
        @php
          $craftsman      = auth()->user()->craftsman;
          $alreadyApplied = $gig->applications->where('craftsman_id', $craftsman->id)->count() > 0;
        @endphp

        <div class="card-premium">
          <div class="card-premium-title">
            <i class="bi bi-send"></i> Candidature
          </div>

          @if($gig->status !== 'open')
            <div style="background:#f1f5f9;border-radius:8px;padding:14px;font-size:14px;color:#64748b;text-align:center">
              <i class="bi bi-lock me-1"></i> Cette offre n'accepte plus de candidatures.
            </div>

          @elseif($alreadyApplied)
            {{-- ✅ Candidature confirmed --}}
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:14px;font-size:14px;color:#15803d;text-align:center;font-weight:600">
              <i class="bi bi-check-circle-fill me-1"></i> Candidature envoyée avec succès !
            </div>

            {{-- 📞 Client contact info revealed --}}
            <div style="margin-top:16px">
              <div style="font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:700;margin-bottom:10px">
                <i class="bi bi-unlock-fill me-1" style="color:#059669"></i> Contact du client
              </div>

              @if($gig->client->phone)
                <a href="tel:{{ $gig->client->phone }}"
                   style="display:flex;align-items:center;gap:10px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px 16px;text-decoration:none;margin-bottom:10px">
                  <div style="width:36px;height:36px;background:#dcfce7;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="bi bi-telephone-fill" style="color:#059669;font-size:16px"></i>
                  </div>
                  <div>
                    <div style="font-size:11px;color:#64748b;margin-bottom:2px">Téléphone</div>
                    <div style="font-size:1rem;font-weight:700;color:#0f172a">{{ $gig->client->phone }}</div>
                  </div>
                </a>
              @else
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 14px;font-size:13px;color:#64748b;margin-bottom:10px">
                  <i class="bi bi-info-circle me-1"></i> Le client n'a pas renseigné de numéro. Utilisez la messagerie pour le contacter.
                </div>
              @endif

              {{-- Chat button --}}
              <a href="{{ route('craftsman.inbox.chat', $gig->client->id) }}"
                 class="btn-harfa w-100 justify-content-center"
                 style="font-size:14px;padding:11px">
                <i class="bi bi-chat-dots me-2"></i> Envoyer un message
              </a>
            </div>

          @else
            <p style="font-size:13px;color:#64748b;margin-bottom:16px">
              En postulant, <strong>5 points</strong> seront déduits de votre solde.
              Le numéro du client vous sera révélé immédiatement après.
            </p>
            <form method="POST" action="{{ route('craftsman.gigs.apply', $gig) }}">
              @csrf
              <button
                type="submit"
                class="btn-harfa w-100 justify-content-center"
                {{ auth()->user()->points < 5 ? 'disabled' : '' }}
                style="font-size:15px;padding:12px"
              >
                <i class="bi bi-send me-2"></i> Postuler (−5 pts)
              </button>
            </form>
          @endif

          {{-- Applications count --}}
          <div style="text-align:center;margin-top:14px;font-size:12px;color:#94a3b8">
            <i class="bi bi-people me-1"></i>
            {{ $gig->applications->count() }} candidature{{ $gig->applications->count() !== 1 ? 's' : '' }} reçue{{ $gig->applications->count() !== 1 ? 's' : '' }}
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
@endsection