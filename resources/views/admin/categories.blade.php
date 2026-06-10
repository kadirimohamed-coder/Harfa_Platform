@extends('layouts.app')
@section('title', 'Catégories — Admin')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-admin')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Catégories</h1>
        <p class="portal-subtitle">Gérez les métiers disponibles sur la plateforme</p>
      </div>
      <button class="btn-harfa" data-bs-toggle="modal" data-bs-target="#addCatModal">
        <i class="bi bi-plus"></i> Ajouter une catégorie
      </button>
    </div>

    <div class="row g-3">
      @forelse($categories as $cat)
        <div class="col-md-4 col-sm-6">
          <div class="card-modern" style="padding:20px">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div style="width:48px;height:48px;background:#d1fae5;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;color:#059669;flex-shrink:0">
                <i class="bi {{ $cat->icon ?? 'bi-tools' }}"></i>
              </div>
              <div>
                <div style="font-weight:700;font-size:15px;color:#0f172a">{{ $cat->name }}</div>
                <div style="font-size:12px;color:#64748b">{{ $cat->craftsmen_count ?? 0 }} artisan(s)</div>
              </div>
            </div>
            <div class="d-flex gap-2">
              <button class="btn-harfa-ghost flex-grow-1 justify-content-center edit-cat-btn"
                      data-id="{{ $cat->id }}" data-name="{{ $cat->name }}" data-icon="{{ $cat->icon }}"
                      data-bs-toggle="modal" data-bs-target="#editCatModal"
                      style="font-size:13px;padding:7px 12px">
                <i class="bi bi-pencil"></i> Modifier
              </button>
              <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                    onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-harfa-ghost" style="font-size:13px;padding:7px 10px;color:#ef4444;border-color:#ef4444">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="empty-state">
            <i class="bi bi-tags"></i>
            <h5>Aucune catégorie</h5>
            <p>Commencez par en ajouter une.</p>
          </div>
        </div>
      @endforelse
    </div>

  </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addCatModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
      <div class="modal-body p-4">
        <h5 style="font-weight:800;margin-bottom:20px">Ajouter une catégorie</h5>
        <form method="POST" action="{{ route('admin.categories.store') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Nom</label>
            <input class="form-control" name="name" required placeholder="Plomberie, Électricité...">
          </div>
          <div class="mb-4">
            <label class="form-label">Icône Bootstrap (ex: bi-wrench)</label>
            <input class="form-control" name="icon" placeholder="bi-tools">
          </div>
          <div class="d-flex gap-2 justify-content-end">
            <button type="button" class="btn-harfa-outline" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn-harfa"><i class="bi bi-plus"></i> Ajouter</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editCatModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
      <div class="modal-body p-4">
        <h5 style="font-weight:800;margin-bottom:20px">Modifier la catégorie</h5>
        <form method="POST" id="editCatForm">
          @csrf @method('PUT')
          <div class="mb-3">
            <label class="form-label">Nom</label>
            <input class="form-control" name="name" id="editCatName" required>
          </div>
          <div class="mb-4">
            <label class="form-label">Icône</label>
            <input class="form-control" name="icon" id="editCatIcon">
          </div>
          <div class="d-flex gap-2 justify-content-end">
            <button type="button" class="btn-harfa-outline" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn-harfa"><i class="bi bi-check"></i> Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.edit-cat-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.getElementById('editCatName').value = btn.dataset.name;
    document.getElementById('editCatIcon').value = btn.dataset.icon;
    document.getElementById('editCatForm').action = `/admin/categories/${btn.dataset.id}`;
  });
});
</script>
@endpush
@endsection
