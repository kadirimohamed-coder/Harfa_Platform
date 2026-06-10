@extends('layouts.app')
@section('title', 'Artisans — Admin')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-admin')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Gestion des artisans</h1>
        <p class="portal-subtitle">Validez et gérez les profils professionnels</p>
      </div>
    </div>

    <div class="card-premium" style="padding:0;overflow:hidden">
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Artisan</th>
            <th>Catégories</th>
            <th>Note</th>
            <th>Réservations</th>
            <th>Disponible</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($craftsmen as $cm)
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#047857,#10b981);color:white;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0">
                    {{ strtoupper(substr($cm->user->name,0,2)) }}
                  </div>
                  <div>
                    <div style="font-weight:600;font-size:14px;color:#0f172a">{{ $cm->user->name }}</div>
                    <div style="font-size:12px;color:#64748b">{{ $cm->user->city ?? '—' }}</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-flex flex-wrap gap-1">
                  @foreach($cm->categories->take(2) as $cat)
                    <span class="badge-cat">{{ $cat->name }}</span>
                  @endforeach
                  @if($cm->categories->count() > 2)
                    <span class="badge-cat">+{{ $cm->categories->count()-2 }}</span>
                  @endif
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center gap-1">
                  <i class="bi bi-star-fill" style="color:#f59e0b;font-size:12px"></i>
                  <span style="font-size:13px;font-weight:600">{{ number_format($cm->averageRating(),1) }}</span>
                </div>
              </td>
              <td style="font-size:13px;font-weight:600">{{ $cm->bookings->count() }}</td>
              <td>
                @if($cm->availability_status)
                  <span class="availability-badge" style="font-size:11px">Oui</span>
                @else
                  <span class="availability-badge-off" style="font-size:11px">Non</span>
                @endif
              </td>
              <td>
                <span class="badge-status status-{{ $cm->user->status === 'active' ? 'active' : 'inactive' }}">
                  {{ $cm->user->status === 'active' ? 'Actif' : 'Inactif' }}
                </span>
              </td>
              <td>
                <div class="d-flex gap-1">
                  <a href="{{ route('craftsmen.show', $cm) }}" class="btn-harfa-ghost" style="font-size:12px;padding:5px 10px" target="_blank">
                    <i class="bi bi-eye"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.craftsmen.toggle', $cm) }}">
                    @csrf
                    <button type="submit" class="btn-harfa-ghost" style="font-size:12px;padding:5px 10px">
                      <i class="bi bi-toggle-on"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="7"><div class="empty-state"><i class="bi bi-person-check"></i><h5>Aucun artisan</h5></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($craftsmen->hasPages())
      <div class="d-flex justify-content-center mt-4">{{ $craftsmen->links() }}</div>
    @endif

  </div>
</div>
@endsection
