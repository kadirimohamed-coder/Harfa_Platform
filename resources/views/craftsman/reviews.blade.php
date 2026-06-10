@extends('layouts.app')
@section('title', 'Mes avis — Harfa.ma')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-craftsman')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Avis reçus</h1>
        <p class="portal-subtitle">Ce que disent vos clients</p>
      </div>
      <div style="background:#f0fdf4;border:1.5px solid rgba(5,150,105,.2);border-radius:12px;padding:14px 20px;text-align:center">
        <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:.05em;font-weight:700">Note moyenne</div>
        <div style="font-size:28px;font-weight:800;color:#059669;line-height:1">{{ number_format($avgRating, 1) }}</div>
        <div class="d-flex justify-content-center gap-1 mt-1">
          @for($i=1;$i<=5;$i++)
            <i class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }}" style="color:#f59e0b;font-size:14px"></i>
          @endfor
        </div>
      </div>
    </div>

    {{-- Rating distribution --}}
    <div class="card-premium mb-4">
      <div class="card-premium-title"><i class="bi bi-bar-chart"></i> Répartition des notes</div>
      <div class="row g-3">
        @for($star = 5; $star >= 1; $star--)
          @php $count = $reviews->where('rating', $star)->count(); @endphp
          @php $pct = $reviews->count() > 0 ? round($count / $reviews->count() * 100) : 0; @endphp
          <div class="col-12">
            <div class="d-flex align-items-center gap-3">
              <span style="font-size:13px;font-weight:600;color:#64748b;width:20px">{{ $star }}</span>
              <i class="bi bi-star-fill" style="color:#f59e0b;font-size:13px"></i>
              <div style="flex:1;background:#f1f5f9;border-radius:999px;height:8px;overflow:hidden">
                <div style="width:{{ $pct }}%;height:100%;background:linear-gradient(90deg,#f59e0b,#fbbf24);border-radius:999px;transition:width .6s ease"></div>
              </div>
              <span style="font-size:13px;color:#64748b;width:30px;text-align:right">{{ $count }}</span>
            </div>
          </div>
        @endfor
      </div>
    </div>

    {{-- Reviews list --}}
    <div class="card-premium">
      <div class="card-premium-title"><i class="bi bi-chat-left-text"></i> Tous les avis ({{ $reviews->count() }})</div>

      @forelse($reviews as $r)
        <div style="border:1px solid #e2e8f0;border-radius:14px;padding:20px;margin-bottom:14px;background:#fafcfb">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div class="d-flex align-items-center gap-3">
              <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#059669,#10b981);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0">
                {{ strtoupper(substr($r->booking->client->name,0,2)) }}
              </div>
              <div>
                <div style="font-weight:700;font-size:14px;color:#0f172a">{{ $r->booking->client->name }}</div>
                <div class="d-flex gap-1 mt-1">
                  @for($i=1;$i<=5;$i++)
                    <i class="bi bi-star{{ $i <= $r->rating ? '-fill' : '' }}" style="color:#f59e0b;font-size:13px"></i>
                  @endfor
                  <span style="font-size:12px;color:#64748b;margin-left:4px">{{ $r->rating }}/5</span>
                </div>
              </div>
            </div>
            <span style="font-size:12px;color:#94a3b8;white-space:nowrap">{{ $r->created_at->format('d/m/Y') }}</span>
          </div>
          @if($r->comment)
            <p style="color:#475569;font-size:14px;line-height:1.7;margin:14px 0 0;font-style:italic;padding-left:56px">
              "{{ $r->comment }}"
            </p>
          @endif
        </div>
      @empty
        <div class="empty-state">
          <i class="bi bi-chat-square-text"></i>
          <h5>Aucun avis pour l'instant</h5>
          <p>Complétez vos premières réservations pour recevoir des évaluations de clients.</p>
        </div>
      @endforelse
    </div>

  </div>
</div>
@endsection
