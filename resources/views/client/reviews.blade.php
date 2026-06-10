@extends('layouts.app')
@section('title', 'Mes avis — Harfa.ma')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-client')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Mes évaluations</h1>
        <p class="portal-subtitle">Les avis que vous avez laissés aux artisans</p>
      </div>
    </div>

    <div class="row g-4">
      @forelse($reviews as $r)
        <div class="col-md-6">
          <div style="background:white;border:1.5px solid #e2e8f0;border-radius:16px;padding:24px">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#047857,#10b981);color:white;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:800;flex-shrink:0">
                {{ strtoupper(substr($r->booking->craftsman->user->name,0,2)) }}
              </div>
              <div>
                <a href="{{ route('craftsmen.show', $r->booking->craftsman) }}"
                   style="font-weight:700;font-size:15px;color:#0f172a;text-decoration:none">
                  {{ $r->booking->craftsman->user->name }}
                </a>
                <div class="d-flex gap-1 mt-1">
                  @for($i=1;$i<=5;$i++)
                    <i class="bi bi-star{{ $i<=$r->rating?'-fill':'' }}" style="color:#f59e0b;font-size:14px"></i>
                  @endfor
                </div>
              </div>
              <span class="ms-auto" style="font-size:12px;color:#94a3b8">{{ $r->created_at->format('d/m/Y') }}</span>
            </div>
            @if($r->comment)
              <p style="color:#475569;font-size:14px;font-style:italic;line-height:1.6;margin:0">
                "{{ $r->comment }}"
              </p>
            @else
              <p style="color:#94a3b8;font-size:13px;margin:0">Aucun commentaire laissé</p>
            @endif
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="empty-state">
            <i class="bi bi-star"></i>
            <h5>Aucun avis pour l'instant</h5>
            <p>Après la fin d'une réservation, vous pouvez évaluer l'artisan.</p>
            <a href="{{ route('client.bookings') }}" class="btn-harfa">Voir mes réservations</a>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</div>
@endsection
