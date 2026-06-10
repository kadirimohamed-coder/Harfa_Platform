@extends('layouts.app')
@section('title', 'Publier une offre — Harfa.ma')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-client')
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Publier une offre d'emploi</h1>
        <p class="portal-subtitle">Les artisans correspondant à votre besoin pourront postuler directement</p>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-8">
        <form method="POST" action="{{ route('client.gigs.store') }}">
          @csrf

          <div class="card-premium">
            <div class="card-premium-title"><i class="bi bi-file-text"></i> Détails de l'offre</div>

            <div class="mb-3">
              <label class="form-label">Titre de la mission <span class="text-danger">*</span></label>
              <input class="form-control" name="title" value="{{ old('title') }}"
                     placeholder="Ex: Réparation fuite plomberie cuisine" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Description détaillée <span class="text-danger">*</span></label>
              <textarea class="form-control" name="description" rows="5"
                        placeholder="Décrivez précisément le travail à effectuer, les matériaux disponibles, l'urgence..." required>{{ old('description') }}</textarea>
              <div style="font-size:12px;color:#94a3b8;margin-top:6px">
                Plus la description est précise, plus les candidatures seront pertinentes.
              </div>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Catégorie <span class="text-danger">*</span></label>
                <select class="form-select" name="category_id" required>
                  <option value="">Choisir une catégorie</option>
                  @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                      {{ $c->name }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Ville <span class="text-danger">*</span></label>
                <input class="form-control" name="city" value="{{ old('city', auth()->user()->city) }}"
                       placeholder="Casablanca" required>
              </div>
            </div>

            <div class="row g-3 mt-1">
              <div class="col-md-6">
                <label class="form-label">Date souhaitée</label>
                <input class="form-control" type="date" name="deadline"
                       value="{{ old('deadline') }}" min="{{ now()->format('Y-m-d') }}">
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('client.dashboard') }}" class="btn-harfa-outline">Annuler</a>
            <button type="submit" class="btn-harfa">
              <i class="bi bi-send"></i> Publier l'offre
            </button>
          </div>
        </form>
      </div>

      {{-- Tips sidebar --}}
      <div class="col-lg-4">
        <div class="card-premium" style="position:sticky;top:88px">
          <div class="card-premium-title"><i class="bi bi-lightbulb"></i> Conseils</div>
          @foreach([
            ['icon'=>'bi-check-circle','title'=>'Soyez précis','text'=>'Une description détaillée attire des artisans qualifiés et évite les malentendus.'],
            ['icon'=>'bi-geo-alt','title'=>'Ville exacte','text'=>'Les artisans cherchent par zone géographique pour optimiser leurs déplacements.'],
            ['icon'=>'bi-handshake','title'=>'Tarif en direct','text'=>'Le prix se négocie directement avec l\'artisan lors de votre rencontre.'],
            ['icon'=>'bi-clock','title'=>'Délai raisonnable','text'=>'Laissez suffisamment de temps pour que les artisans s\'organisent.'],
          ] as $tip)
            <div class="d-flex gap-3 mb-3">
              <div style="width:36px;height:36px;background:#f0fdf4;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <i class="bi {{ $tip['icon'] }}" style="color:#059669;font-size:16px"></i>
              </div>
              <div>
                <div style="font-size:13px;font-weight:700;color:#0f172a">{{ $tip['title'] }}</div>
                <div style="font-size:12px;color:#64748b;line-height:1.5">{{ $tip['text'] }}</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
