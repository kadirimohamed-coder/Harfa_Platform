@extends('layouts.app')
@section('title', 'Réservations — Admin')
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
  @include('partials.sidebar-admin')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Toutes les réservations</h1>
        <p class="portal-subtitle">{{ $bookings->total() }} réservation(s) enregistrée(s)</p>
      </div>
    </div>

    {{-- Status filter tabs --}}
    <div class="d-flex gap-2 mb-4 flex-wrap">
      @foreach($tabs as $val => $label)
        @php $active = request('status', '') === $val; @endphp
        <a href="{{ route('admin.bookings', $val ? ['status' => $val] : []) }}"
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
            <th>#</th>
            <th>Client</th>
            <th>Artisan</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Changer statut</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bookings as $b)
            <tr>
              <td style="color:#94a3b8;font-size:13px">{{ $b->id }}</td>
              <td>
                <div style="font-weight:600;font-size:13px;color:#0f172a">{{ $b->client->name }}</div>
                <div style="font-size:12px;color:#64748b">{{ $b->client->phone }}</div>
              </td>
              <td>
                <div style="font-weight:600;font-size:13px;color:#0f172a">{{ $b->craftsman->user->name }}</div>
                <div style="font-size:12px;color:#64748b">{{ $b->craftsman->user->city }}</div>
              </td>
              <td style="font-size:13px;color:#475569">{{ $b->booking_date->format('d/m/Y H:i') }}</td>
              <td>
                <span class="badge-status status-{{ $b->status }}">
                  {{ $statusLabels[$b->status] ?? ucfirst($b->status) }}
                </span>
              </td>
              <td>
                <form method="POST" action="{{ route('admin.bookings.update', $b) }}" class="d-flex gap-2">
                  @csrf
                  <select name="status" class="form-select form-select-sm" style="width:auto">
                    @foreach($statusLabels as $val => $label)
                      <option value="{{ $val }}" {{ $b->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn-harfa" style="padding:5px 10px;font-size:12px">
                    <i class="bi bi-check"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6">
                <div class="empty-state">
                  <i class="bi bi-calendar-x"></i>
                  <h5>Aucune réservation{{ request('status') ? ' pour ce statut' : '' }}</h5>
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