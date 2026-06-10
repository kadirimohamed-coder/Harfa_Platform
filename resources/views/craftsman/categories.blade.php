@extends('layouts.app')
@section('title', 'Mes catégories — Harfa.ma')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-craftsman')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Mes catégories de service</h1>
        <p class="portal-subtitle">Sélectionnez vos spécialités pour apparaître dans les bonnes recherches</p>
      </div>
    </div>

    <form method="POST" action="{{ route('craftsman.categories.update') }}">
      @csrf

      <div class="card-premium">
        <div class="card-premium-title">
          <i class="bi bi-tags"></i> Catégories disponibles
          <span class="ms-auto badge-cat" style="font-size:12px">
            {{ $craftsman->categories->count() }} sélectionnée(s)
          </span>
        </div>
        <p style="font-size:14px;color:#64748b;margin-bottom:24px">
          Cochez toutes les catégories correspondant à vos compétences professionnelles.
          Vous apparaîtrez dans les résultats de recherche pour chaque catégorie sélectionnée.
        </p>

        <div class="row g-3">
          @foreach($categories as $cat)
            @php $selected = $craftsman->categories->contains($cat->id); @endphp
            <div class="col-md-4 col-sm-6">
              <label style="display:flex;align-items:center;gap:14px;padding:16px;border:2px solid {{ $selected ? '#059669' : '#e2e8f0' }};border-radius:14px;cursor:pointer;background:{{ $selected ? '#f0fdf4' : 'white' }};transition:.2s;user-select:none"
                     class="cat-toggle-card">
                <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                       {{ $selected ? 'checked' : '' }} style="display:none">
                <div style="width:48px;height:48px;background:{{ $selected ? '#d1fae5' : '#f8fafc' }};border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;color:{{ $selected ? '#059669' : '#94a3b8' }};flex-shrink:0;transition:.2s">
                  <i class="bi {{ $cat->icon ?? 'bi-tools' }}"></i>
                </div>
                <div>
                  <div style="font-weight:700;font-size:14px;color:{{ $selected ? '#065f46' : '#0f172a' }}">{{ $cat->name }}</div>
                  @if($cat->craftsmen_count)
                    <div style="font-size:12px;color:#94a3b8">{{ $cat->craftsmen_count }} artisan(s)</div>
                  @endif
                </div>
                @if($selected)
                  <i class="bi bi-check-circle-fill ms-auto" style="color:#059669;font-size:18px"></i>
                @endif
              </label>
            </div>
          @endforeach
        </div>
      </div>

      <div class="d-flex justify-content-end gap-3 mt-2">
        <button type="submit" class="btn-harfa">
          <i class="bi bi-check-lg"></i> Enregistrer mes catégories
        </button>
      </div>
    </form>

  </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.cat-toggle-card').forEach(label => {
  label.addEventListener('click', function() {
    const cb = this.querySelector('input[type="checkbox"]');
    setTimeout(() => {
      const checked = cb.checked;
      this.style.borderColor = checked ? '#059669' : '#e2e8f0';
      this.style.background  = checked ? '#f0fdf4' : 'white';
      const icon = this.querySelector('.bi-tools, [class*="bi-"]');
      if(icon) {
        icon.style.color = checked ? '#059669' : '#94a3b8';
      }
    }, 0);
  });
});
</script>
@endpush
@endsection
