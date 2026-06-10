@extends('layouts.app')
@section('title', 'Offres d\'emploi — Admin')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-admin')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Offres d'emploi</h1>
        <p class="portal-subtitle">{{ $gigs->total() }} offre(s) publiée(s)</p>
      </div>
    </div>

    <div class="card-premium" style="padding:0;overflow:hidden">
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Titre</th>
            <th>Client</th>
            <th>Catégorie</th>
            <th>Candidatures</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($gigs as $gig)
            <tr>
              <td>
                <div style="font-weight:600;font-size:14px;color:#0f172a">{{ $gig->title }}</div>
                <div style="font-size:12px;color:#64748b">{{ $gig->city }}</div>
              </td>
              <td style="font-size:13px">{{ $gig->client->name }}</td>
              <td><span class="badge-cat">{{ $gig->category->name }}</span></td>
              <td style="font-size:13px;font-weight:600">{{ $gig->applications->count() }}</td>
              <td>
                <span class="badge-status status-{{ $gig->status === 'open' ? 'open' : 'closed' }}">
                  {{ $gig->status === 'open' ? 'Ouverte' : 'Fermée' }}
                </span>
              </td>
              <td>
                <div class="d-flex gap-1">
                  <form method="POST" action="{{ route('admin.gigs.toggle', $gig) }}">
                    @csrf
                    <button type="submit" class="btn-harfa-ghost" style="font-size:12px;padding:5px 10px">
                      <i class="bi {{ $gig->status === 'open' ? 'bi-lock' : 'bi-unlock' }}"></i>
                    </button>
                  </form>
                  <form method="POST" action="{{ route('admin.gigs.destroy', $gig) }}"
                        onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-harfa-ghost" style="font-size:12px;padding:5px 10px;color:#ef4444;border-color:#ef4444">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="6"><div class="empty-state"><i class="bi bi-briefcase"></i><h5>Aucune offre</h5></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($gigs->hasPages())
      <div class="d-flex justify-content-center mt-4">{{ $gigs->links() }}</div>
    @endif

  </div>
</div>
@endsection
