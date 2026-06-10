@extends('layouts.app')
@section('title', 'Mes réservations — Harfa.ma')
@section('content')

<div class="portal-layout">
  @include('partials.sidebar-craftsman')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Mes réservations</h1>
        <p class="portal-subtitle">Gérez les demandes de vos clients</p>
      </div>
    </div>

    {{-- STATS CARDS --}}
    @php
      $pending   = $bookings->where('status','pending')->count();
      $confirmed = $bookings->where('status','confirmed')->count();
      $done      = $bookings->where('status','done')->count();
      $cancelled = $bookings->where('status','cancelled')->count();
    @endphp

    <div class="row g-3 mb-4">
      <div class="col-6 col-md-3">
        <div class="booking-stat-card">
          <p class="stat-number">{{ $pending }}</p>
          <span class="stat-label badge-pending">⏳ En attente</span>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="booking-stat-card">
          <p class="stat-number">{{ $confirmed }}</p>
          <span class="stat-label badge-confirmed">✓ Confirmées</span>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="booking-stat-card">
          <p class="stat-number">{{ $done }}</p>
          <span class="stat-label badge-done">● Terminées</span>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="booking-stat-card">
          <p class="stat-number">{{ $cancelled }}</p>
          <span class="stat-label badge-cancelled">✗ Annulées</span>
        </div>
      </div>
    </div>

    {{-- FILTER PILLS --}}
    <div class="booking-filters mb-3">
      <button class="filter-pill active" data-filter="all">
        Toutes ({{ $bookings->count() }})
      </button>
      <button class="filter-pill" data-filter="pending">
        ⏳ En attente ({{ $pending }})
      </button>
      <button class="filter-pill" data-filter="confirmed">
        ✓ Confirmées ({{ $confirmed }})
      </button>
      <button class="filter-pill" data-filter="done">
        ● Terminées ({{ $done }})
      </button>
      <button class="filter-pill" data-filter="cancelled">
        ✗ Annulées ({{ $cancelled }})
      </button>
    </div>

    {{-- TABLE --}}
    <div class="card-premium" style="padding:0;overflow:hidden">
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Client</th>
            <th>Date prévue</th>
            <th>Description</th>
            <th>Statut</th>
            <th>Contact</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bookings as $b)
            <tr data-status="{{ $b->status }}">

              {{-- Client + city ila kina --}}
              <td>
                <div style="font-weight:600;color:#0f172a">{{ $b->client->name }}</div>
                <div style="font-size:12px;color:#94a3b8">{{ $b->client->city ?? '' }}</div>
              </td>

              {{-- Date --}}
              <td style="font-size:13px;white-space:nowrap">
                {{ $b->booking_date->format('d/m/Y') }}<br>
                <span style="color:#94a3b8;font-size:12px">{{ $b->booking_date->format('H:i') }}</span>
              </td>

              {{-- Description --}}
              <td style="max-width:180px;font-size:13px;color:#475569">
                {{ Str::limit($b->description, 55) }}
              </td>

              {{-- Badge statut --}}
              <td>
                <span class="badge-status status-{{ $b->status }}">
                  @switch($b->status)
                    @case('pending')   ⏳ En attente  @break
                    @case('confirmed') ✓ Confirmée   @break
                    @case('done')      ● Terminée    @break
                    @case('cancelled') ✗ Annulée     @break
                  @endswitch
                </span>
              </td>

              {{-- Contact column jdida --}}
              <td>
                @if($b->status === 'confirmed')
                  <div style="font-size:13px;color:#059669;font-weight:600">
                    <i class="bi bi-telephone-fill me-1"></i>{{ $b->client->phone }}
                  </div>
                  @php
                    $wp = preg_replace('/\D/', '', $b->client->phone ?? '');
                    if(strlen($wp) === 10 && str_starts_with($wp, '0')) $wp = '212'.substr($wp,1);
                  @endphp
                  @if($wp)
                    <a href="https://wa.me/{{ $wp }}" target="_blank"
                      style="margin-top:4px;display:inline-flex;align-items:center;gap:4px;
                              background:#25D366;color:#fff;text-decoration:none;
                              padding:3px 10px;border-radius:999px;font-size:11px;font-weight:600">
                      <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                  @endif
                @else
                  <span style="font-size:12px;color:#94a3b8">
                    <i class="bi bi-lock me-1"></i>Après confirmation
                  </span>
                @endif
              </td>

              {{-- ACTIONS --}}
              <td>
                @if($b->status === 'pending')
                  <div class="d-flex gap-2 flex-wrap">
                    <form method="POST" action="{{ route('craftsman.bookings.update', $b) }}">
                      @csrf
                      <input type="hidden" name="status" value="confirmed">
                      <button type="submit" class="btn-confirm">
                        <i class="bi bi-check-lg me-1"></i>Confirmer
                      </button>
                    </form>
                    <form method="POST" action="{{ route('craftsman.bookings.update', $b) }}">
                      @csrf
                      <input type="hidden" name="status" value="cancelled">
                      <button type="submit" class="btn-refuse">
                        <i class="bi bi-x-lg me-1"></i>Refuser
                      </button>
                    </form>
                  </div>

                @elseif($b->status === 'confirmed')
                  <div class="d-flex gap-2 flex-wrap align-items-center">
                    <form method="POST" action="{{ route('craftsman.bookings.update', $b) }}">
                      @csrf
                      <input type="hidden" name="status" value="done">
                      <button type="submit" class="btn-done"
                        onclick="return confirm('Marquer comme terminée ?')">
                        <i class="bi bi-flag-fill me-1"></i>Terminer
                      </button>
                    </form>
                    {{-- Chat icon --}}
                    @if(Route::has('craftsman.inbox.chat'))
                      <a href="{{ route('craftsman.inbox.chat', $b->client_id) }}"
                         title="Chat avec {{ $b->client->name }}"
                         style="width:34px;height:34px;border-radius:50%;background:#dbeafe;color:#2563eb;
                                display:flex;align-items:center;justify-content:center;font-size:16px;
                                text-decoration:none;transition:.2s;border:1.5px solid #93c5fd"
                         onmouseover="this.style.background='#2563eb';this.style.color='white'"
                         onmouseout="this.style.background='#dbeafe';this.style.color='#2563eb'">
                        <i class="bi bi-chat-dots-fill"></i>
                      </a>
                    @endif
                  </div>

                @elseif($b->status === 'done')
                  <span style="font-size:12px;color:#7c3aed;font-weight:600">
                    <i class="bi bi-check2-all me-1"></i>Terminée
                  </span>

                @elseif($b->status === 'cancelled')
                  <span style="font-size:12px;color:#dc2626;font-weight:600">
                    <i class="bi bi-x-circle me-1"></i>Refusée
                  </span>
                @endif
              </td>

            </tr>
          @empty
            <tr>
              <td colspan="5">
                <div class="empty-state">
                  <i class="bi bi-calendar-x"></i>
                  <h5>Aucune réservation</h5>
                  <p>Complétez votre profil pour recevoir des demandes de clients.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($bookings->hasPages())
      <div class="d-flex justify-content-center mt-4">
        {{ $bookings->withQueryString()->links() }}
      </div>
    @endif

  </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.filter-pill').forEach(pill => {
  pill.addEventListener('click', function () {
    document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
    this.classList.add('active');
    const filter = this.dataset.filter;
    document.querySelectorAll('tbody tr[data-status]').forEach(row => {
      row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
    });
  });
});
</script>
@endpush

@endsection
