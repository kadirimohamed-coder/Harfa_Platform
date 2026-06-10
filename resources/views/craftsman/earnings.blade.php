@extends('layouts.app')
@section('title', 'Travaux terminés — Harfa.ma')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-craftsman')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Travaux terminés</h1>
        <p class="portal-subtitle">Historique de vos missions accomplies</p>
      </div>
      <div style="background:#f0fdf4;border:1.5px solid rgba(5,150,105,.2);border-radius:12px;padding:12px 20px;text-align:center">
        <div style="font-size:12px;color:#64748b">Total accompli</div>
        <div style="font-size:24px;font-weight:800;color:#059669">{{ $completedBookings->total() }} missions</div>
      </div>
    </div>

    <div class="card-premium" style="padding:0;overflow:hidden">
      <div style="padding:20px 24px;border-bottom:1px solid #e2e8f0">
        <h5 style="font-weight:700;margin:0">Historique des missions</h5>
      </div>
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Date</th>
            <th>Client</th>
            <th>Description</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          @forelse($completedBookings as $b)
            <tr>
              <td style="font-size:13px">{{ $b->booking_date->format('d/m/Y') }}</td>
              <td style="font-size:13px;font-weight:600">
                {{ $b->client->name }}
                @if($b->client->phone)
                  <div style="font-size:12px;color:#94a3b8;font-weight:400">{{ $b->client->phone }}</div>
                @endif
              </td>
              <td style="font-size:13px;color:#475569;max-width:220px">
                {{ Str::limit($b->description, 60) }}
              </td>
              <td><span class="badge-status status-done">Terminé</span></td>
            </tr>
          @empty
            <tr>
              <td colspan="4">
                <div class="empty-state">
                  <i class="bi bi-calendar-check"></i>
                  <h5>Aucune mission terminée</h5>
                  <p>Marquez vos réservations comme "done" pour les voir apparaître ici.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($completedBookings->hasPages())
      <div class="d-flex justify-content-center mt-4">{{ $completedBookings->links() }}</div>
    @endif

  </div>
</div>
@endsection
