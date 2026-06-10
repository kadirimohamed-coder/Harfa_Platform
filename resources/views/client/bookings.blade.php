@extends('layouts.app')
@section('title', 'Mes réservations — Harfa.ma')
@section('content')

@php
$statusLabels = [
    'pending'   => 'En attente',
    'confirmed' => 'Acceptée',
    'done'      => 'Terminée',
    'cancelled' => 'Refusée',
];
$tabs = ['' => 'Toutes'] + $statusLabels;
@endphp

<div class="portal-layout">
  @include('partials.sidebar-client')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Mes réservations</h1>
        <p class="portal-subtitle">Suivez l'avancement de toutes vos réservations</p>
      </div>
      <a href="{{ route('craftsmen.index') }}" class="btn-harfa">
        <i class="bi bi-plus"></i> Nouvelle réservation
      </a>
    </div>

    {{-- Filter tabs --}}
    <div class="d-flex gap-2 mb-4 flex-wrap">
      @foreach($tabs as $val => $label)
        @php $active = ($currentStatus ?? '') === $val; @endphp
        <a href="{{ route('client.bookings', $val ? ['status' => $val] : []) }}"
           style="padding:7px 16px;border-radius:999px;font-size:13px;font-weight:600;text-decoration:none;
                  border:1.5px solid {{ $active ? '#059669' : '#e2e8f0' }};
                  background:{{ $active ? '#d1fae5' : 'white' }};
                  color:{{ $active ? '#059669' : '#64748b' }};
                  transition:.2s">
          {{ $label }}
        </a>
      @endforeach
    </div>

    <div class="card-premium" style="padding:0;overflow:hidden">
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Artisan</th>
            <th>Date</th>
            <th>Description</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bookings as $b)
            <tr>
              <td>
                <div style="font-weight:600;color:#0f172a">{{ $b->craftsman->user->name }}</div>
                <div style="font-size:12px;color:#64748b">{{ $b->craftsman->user->city }}</div>
              </td>
              <td style="font-size:13px">
                {{ $b->booking_date->format('d/m/Y') }}<br>
                <span style="color:#94a3b8">{{ $b->booking_date->format('H:i') }}</span>
              </td>
              <td style="max-width:200px;font-size:13px;color:#475569">
                {{ Str::limit($b->description, 60) }}
              </td>
              <td>
                <span class="badge-status status-{{ $b->status }}">
                  {{ $statusLabels[$b->status] ?? ucfirst($b->status) }}
                </span>
              </td>
              <td>
                @if($b->status === 'done' && !$b->review)
                  <a href="{{ route('client.review.form', $b) }}" class="btn-harfa" style="font-size:12px;padding:6px 12px">
                    <i class="bi bi-star"></i> Évaluer
                  </a>
                @elseif($b->review)
                  <span style="font-size:12px;color:#059669;font-weight:600">
                    <i class="bi bi-check-circle me-1"></i>Évalué
                  </span>
                @elseif($b->status === 'pending')
                  <span style="font-size:12px;color:#d97706;font-weight:600">
                    <i class="bi bi-hourglass-split me-1"></i>En cours…
                  </span>
                @elseif($b->status === 'cancelled')
                  <span style="font-size:12px;color:#dc2626;font-weight:600">
                    <i class="bi bi-x-circle me-1"></i>Refusée
                  </span>
                @endif
                <a href="{{ route('client.inbox.chat', $b->craftsman->user_id) }}" class="btn-harfa-ghost ms-1" style="font-size:12px;padding:6px 10px">
                  <i class="bi bi-chat"></i>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5">
                <div class="empty-state">
                  <i class="bi bi-calendar-x"></i>
                  <h5>Aucune réservation{{ $currentStatus ? ' pour ce statut' : '' }}</h5>
                  <p>Trouvez un artisan et faites votre première réservation.</p>
                  <a href="{{ route('craftsmen.index') }}" class="btn-harfa">Trouver un artisan</a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($bookings->hasPages())
      <div class="d-flex justify-content-center mt-4">{{ $bookings->withQueryString()->links() }}</div>
    @endif

  </div>
</div>
@endsection