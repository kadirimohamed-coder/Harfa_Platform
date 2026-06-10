@extends('layouts.app')
@section('title', $category->name . ' — Harfa.ma')
@section('content')
<div class="container py-4">

  <div class="mb-4">
    <a href="{{ route('craftsmen.index') }}" style="font-size:14px;color:#64748b;text-decoration:none">
      <i class="bi bi-arrow-left me-2"></i>Retour aux artisans
    </a>
  </div>

  <div class="section-header mb-4">
    <div class="d-flex align-items-center gap-3">
      <div style="width:56px;height:56px;background:#d1fae5;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:26px;color:#059669">
        <i class="bi {{ $category->icon ?? 'bi-tools' }}"></i>
      </div>
      <div>
        <h2 class="section-title mb-1">{{ $category->name }}</h2>
        <p class="section-subtitle mb-0">{{ $craftsmen->total() }} artisan(s) disponible(s)</p>
      </div>
    </div>
  </div>

  <div class="row g-4">
    @forelse($craftsmen as $cm)
      <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3)*60 }}">
        <a href="{{ route('craftsmen.show', $cm->id) }}" class="text-decoration-none">
          <div class="artisan-card">
            <div class="artisan-cover">
              @if($cm->availability_status)
                <span class="availability-badge position-absolute" style="top:10px;right:10px;font-size:11px">Disponible</span>
              @else
                <span class="availability-badge-off position-absolute" style="top:10px;right:10px;font-size:11px">Occupé</span>
              @endif
            </div>
            <div class="artisan-body">
              <div class="artisan-avatar">{{ strtoupper(substr($cm->user->name,0,2)) }}</div>
              <h5 class="mb-1 fw-bold" style="font-size:15px;color:#0f172a">{{ $cm->user->name }}</h5>
              <p class="mb-2" style="font-size:12px;color:#64748b">{{ $cm->user->city }}</p>
              <div class="mb-2 d-flex justify-content-center gap-1 align-items-center">
                @for($i=1;$i<=5;$i++)
                  <i class="bi bi-star{{ $i<=round($cm->reviews_avg_rating??0)?'-fill':'' }} {{ $i<=round($cm->reviews_avg_rating??0)?'text-warning':'text-muted' }}" style="font-size:13px"></i>
                @endfor
              </div>
              @if($cm->price)
                <div style="font-size:14px;font-weight:700;color:#059669">{{ number_format($cm->price,0) }} DH</div>
              @endif
            </div>
          </div>
        </a>
      </div>
    @empty
      <div class="col-12">
        <div class="empty-state">
          <i class="bi bi-search"></i>
          <h5>Aucun artisan pour cette catégorie</h5>
          <p>Revenez bientôt — de nouveaux artisans rejoignent chaque jour.</p>
          <a href="{{ route('craftsmen.index') }}" class="btn-harfa">Voir tous les artisans</a>
        </div>
      </div>
    @endforelse
  </div>

  @if($craftsmen->hasPages())
    <div class="d-flex justify-content-center mt-5">{{ $craftsmen->links() }}</div>
  @endif
</div>
@endsection
