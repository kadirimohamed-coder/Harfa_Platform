@extends('layouts.app')
@section('title', 'Avis — Admin')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-admin')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Modération des avis</h1>
        <p class="portal-subtitle">{{ $reviews->total() }} avis publiés</p>
      </div>
    </div>

    <div class="card-premium" style="padding:0;overflow:hidden">
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Client</th>
            <th>Artisan</th>
            <th>Note</th>
            <th>Commentaire</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reviews as $r)
            <tr>
              <td style="font-size:13px;font-weight:600">{{ $r->booking->client->name }}</td>
              <td style="font-size:13px;font-weight:600">{{ $r->booking->craftsman->user->name }}</td>
              <td>
                <div class="d-flex align-items-center gap-1">
                  @for($i=1;$i<=5;$i++)
                    <i class="bi bi-star{{ $i<=$r->rating?'-fill':'' }}" style="color:#f59e0b;font-size:12px"></i>
                  @endfor
                  <strong style="font-size:13px;margin-left:3px">{{ $r->rating }}</strong>
                </div>
              </td>
              <td style="max-width:240px;font-size:13px;color:#475569;font-style:italic">
                "{{ Str::limit($r->comment, 80) }}"
              </td>
              <td style="font-size:12px;color:#94a3b8">{{ $r->created_at->format('d/m/Y') }}</td>
              <td>
                <form method="POST" action="{{ route('admin.reviews.destroy', $r) }}"
                      onsubmit="return confirm('Supprimer cet avis ?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-harfa-ghost" style="font-size:12px;padding:5px 10px;color:#ef4444;border-color:#ef4444">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="6"><div class="empty-state"><i class="bi bi-chat-heart"></i><h5>Aucun avis</h5></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($reviews->hasPages())
      <div class="d-flex justify-content-center mt-4">{{ $reviews->links() }}</div>
    @endif
  </div>
</div>
@endsection
