@extends('layouts.app')
@section('title', 'Points plateforme — Admin')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-admin')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Points plateforme</h1>
        <p class="portal-subtitle">Transactions de points des artisans</p>
      </div>
    </div>

    {{-- Summary cards --}}
    <div class="stats-grid mb-5" style="grid-template-columns:repeat(2,1fr);max-width:600px">
      <div class="stat-card stat-blue">
        <div class="stat-icon" style="background:#dbeafe;color:#2563eb"><i class="bi bi-coin"></i></div>
        <div class="stat-label">Points vendus (total)</div>
        <div class="stat-value" style="color:#2563eb">{{ number_format($totalPoints, 0) }}</div>
        <div class="stat-sub">Via packs artisans</div>
      </div>
      <div class="stat-card stat-green">
        <div class="stat-icon" style="background:#d1fae5;color:#059669"><i class="bi bi-cart-check"></i></div>
        <div class="stat-label">Achats de packs</div>
        <div class="stat-value" style="color:#059669">{{ number_format($totalPurchases, 0) }}</div>
        <div class="stat-sub">Transactions totales</div>
      </div>
    </div>

    {{-- Point transactions --}}
    <div class="card-premium" style="padding:0;overflow:hidden">
      <div style="padding:20px 24px;border-bottom:1px solid #e2e8f0">
        <h5 style="font-weight:700;margin:0">Historique des transactions de points</h5>
      </div>
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Date</th>
            <th>Artisan</th>
            <th>Description</th>
            <th>Points</th>
            <th>Type</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transactions as $t)
            <tr>
              <td style="font-size:12px;color:#94a3b8">{{ $t->created_at->format('d/m/Y H:i') }}</td>
              <td style="font-size:13px;font-weight:600">{{ $t->user->name }}</td>
              <td style="font-size:13px;color:#475569">{{ $t->description }}</td>
              <td style="font-weight:700;color:{{ $t->amount > 0 ? '#059669' : '#ef4444' }}">
                {{ $t->amount > 0 ? '+' : '' }}{{ $t->amount }}
              </td>
              <td>
                <span class="badge-status {{ $t->amount > 0 ? 'status-done' : 'status-cancelled' }}" style="font-size:11px">
                  {{ ucfirst($t->type) }}
                </span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5">
                <div class="empty-state" style="padding:40px">
                  <i class="bi bi-coin"></i>
                  <h5>Aucune transaction</h5>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($transactions->hasPages())
      <div class="d-flex justify-content-center mt-4">{{ $transactions->links() }}</div>
    @endif

  </div>
</div>
@endsection
