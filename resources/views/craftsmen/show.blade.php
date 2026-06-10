@extends('layouts.app')
@section('title', $craftsman->user->name . ' — Harfa.ma')
@section('content')
<div class="container py-4">
  <div class="row g-4">

    {{-- ── LEFT: bio + reviews ── --}}
    <div class="col-lg-8">

      {{-- Profile header card --}}
      <div class="card-premium" style="padding:0;overflow:hidden">
        <div style="height:120px;background:linear-gradient(135deg,#064e3b 0%,#065f46 50%,#0f766e 100%)"></div>
        <div style="padding:0 28px 28px">
          <div class="d-flex align-items-end gap-4 flex-wrap" style="margin-top:-44px;margin-bottom:20px">
            <div style="width:88px;height:88px;border-radius:50%;background:linear-gradient(135deg,#047857,#10b981);border:4px solid white;display:flex;align-items:center;justify-content:center;font-size:30px;font-weight:800;color:white;flex-shrink:0;box-shadow:0 4px 16px rgba(0,0,0,.15)">
              {{ strtoupper(substr($craftsman->user->name, 0, 2)) }}
            </div>
            <div style="padding-bottom:8px">
              <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                <h3 class="mb-0" style="color:#0f172a">{{ $craftsman->user->name }}</h3>
                <span style="background:#d1fae5;color:#065f46;font-size:11px;font-weight:700;padding:3px 10px;border-radius:999px">
                  <i class="bi bi-patch-check-fill me-1"></i>Vérifié
                </span>
              </div>
              <div class="d-flex align-items-center gap-3 flex-wrap" style="font-size:13px;color:#64748b">
                <span>
                  @for($i=1;$i<=5;$i++)
                    <i class="bi bi-star{{ $i <= round($craftsman->averageRating()) ? '-fill' : '' }}" style="color:#f59e0b;font-size:12px"></i>
                  @endfor
                  <strong style="color:#0f172a">{{ $craftsman->averageRating() }}</strong>
                  ({{ $reviews->count() }} avis)
                </span>
                @if($craftsman->user->city)
                  <span><i class="bi bi-geo-alt me-1"></i>{{ $craftsman->user->city }}</span>
                @endif
                <span><i class="bi bi-briefcase me-1"></i>{{ $craftsman->experience_years }} ans exp.</span>
              </div>
              <div class="d-flex gap-2 mt-2">
                @foreach($craftsman->categories as $cat)
                  <span class="badge-cat">{{ $cat->name }}</span>
                @endforeach
              </div>
            </div>
          </div>

          {{-- Availability --}}
          <div class="mb-3">
            @if($craftsman->availability_status)
              <span class="availability-badge">Disponible pour missions</span>
            @else
              <span class="availability-badge-off">Actuellement occupé</span>
            @endif
          </div>

          {{-- About --}}
          <h5 style="font-weight:700;color:#0f172a;margin-bottom:10px">À propos</h5>
          <p style="color:#475569;line-height:1.75;white-space:pre-line">
            {{ $craftsman->description ?? 'Cet artisan n\'a pas encore rédigé sa biographie.' }}
          </p>

          {{-- Certification info --}}
          <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px;font-size:13px;color:#64748b;margin-top:16px">
            <div class="row g-2">
              <div class="col-sm-4">
                <strong style="color:#0f172a">ID Certification</strong><br>
                HRF-{{ str_pad($craftsman->id, 4, '0', STR_PAD_LEFT) }}
              </div>
              <div class="col-sm-4">
                <strong style="color:#0f172a">Zone d'intervention</strong><br>
                {{ $craftsman->user->city ?? 'Maroc' }}
              </div>
              <div class="col-sm-4">
                <strong style="color:#0f172a">Expérience</strong><br>
                {{ $craftsman->experience_years }} an(s)
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Reviews --}}
      <div class="card-premium">
        <div class="card-premium-title">
          <i class="bi bi-chat-left-text"></i> Avis clients ({{ $reviews->count() }})
        </div>

        @forelse($reviews as $r)
          <div style="background:#fafcfb;border:1px solid #e2e8f0;border-radius:12px;padding:18px;margin-bottom:12px">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span style="font-weight:700;font-size:14px;color:#059669">
                  {{ $r->booking->client->name }}
                </span>
                <div style="margin-top:4px">
                  @for($i=1;$i<=5;$i++)
                    <i class="bi bi-star{{ $i <= $r->rating ? '-fill' : '' }}" style="color:#f59e0b;font-size:14px"></i>
                  @endfor
                </div>
              </div>
              <span style="font-size:12px;color:#94a3b8">{{ $r->created_at->format('d/m/Y') }}</span>
            </div>
            @if($r->comment)
              <p style="color:#475569;font-size:14px;line-height:1.6;margin-top:10px;margin-bottom:0;font-style:italic">
                "{{ $r->comment }}"
              </p>
            @endif
          </div>
        @empty
          <div class="empty-state">
            <i class="bi bi-chat-square-text"></i>
            <h5>Pas encore d'avis</h5>
            <p>Soyez le premier à laisser un avis sur cet artisan.</p>
          </div>
        @endforelse
      </div>

    </div>

    {{-- ── RIGHT: actions ── --}}
    <div class="col-lg-4">
      <div class="card-premium" style="position:sticky;top:88px">
        <div class="card-premium-title"><i class="bi bi-calendar-check"></i> Réserver cet artisan</div>
        <p style="font-size:14px;color:#64748b;margin-bottom:20px">
          Discutez des détails ou envoyez directement une demande de réservation.
        </p>
        @auth
          @if(auth()->user()->isClient())
            <div class="d-grid gap-2">
              <a href="{{ route('client.inbox.chat', $craftsman->user->id) }}"
                 class="btn-harfa-ghost justify-content-center">
                <i class="bi bi-chat-dots"></i> Envoyer un message
              </a>
              <a href="{{ route('client.book.form', $craftsman) }}"
                 class="btn-harfa justify-content-center">
                <i class="bi bi-calendar-plus"></i> Réserver maintenant
              </a>
            </div>
          @elseif(auth()->user()->isCraftsman())
            <div class="alert alert-warning" style="font-size:13px">
              <i class="bi bi-info-circle me-2"></i>
              Seuls les comptes clients peuvent effectuer une réservation.
            </div>
          @endif
        @else
          <div class="d-grid">
            <a href="{{ route('login', ['redirect' => request()->fullUrl()]) }}" class="btn-harfa justify-content-center">
              <i class="bi bi-box-arrow-in-right"></i> Se connecter pour réserver
            </a>
          </div>
          <p style="font-size:12px;color:#94a3b8;text-align:center;margin-top:12px">
            Pas de compte ? <a href="{{ route('register') }}" style="color:#059669">S'inscrire gratuitement</a>
          </p>
        @endauth

        {{-- Phone (if logged in) --}}
        @auth
          @if($craftsman->user->phone)
            <div style="border-top:1px solid #e2e8f0;margin-top:16px;padding-top:16px;font-size:14px;color:#64748b">
              <i class="bi bi-telephone me-2 text-green"></i>{{ $craftsman->user->phone }}
            </div>
          @endif
        @endauth
      </div>
    </div>

  </div>
</div>
@endsection