@extends('layouts.app')
@section('title', 'Réserver — Harfa.ma')
@section('content')
<div class="container py-4" style="max-width:900px">

  <div class="mb-4">
    <a href="{{ route('craftsmen.show', $craftsman) }}" style="font-size:14px;color:#64748b;text-decoration:none">
      <i class="bi bi-arrow-left me-2"></i>Retour au profil
    </a>
  </div>

  <div class="row g-4">
    <div class="col-lg-7">
      <div class="card-premium">
        <div class="card-premium-title"><i class="bi bi-calendar-plus"></i> Demande de réservation</div>

        <form method="POST" action="{{ route('client.book.store', $craftsman) }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Date et heure souhaitées <span class="text-danger">*</span></label>
            <input class="form-control" type="datetime-local" name="booking_date"
                   value="{{ old('booking_date') }}" min="{{ now()->format('Y-m-d\TH:i') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Adresse d'intervention <span class="text-danger">*</span></label>
            <input class="form-control" name="address" value="{{ old('address', auth()->user()->address) }}"
                   placeholder="Ex: 12 Rue Hassan II, Casablanca" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Description du problème / besoin <span class="text-danger">*</span></label>
            <textarea class="form-control" name="description" rows="4"
                      placeholder="Décrivez précisément ce qui doit être fait..." required>{{ old('description') }}</textarea>
          </div>

          <div class="mb-4">
            <label class="form-label">Urgence</label>
            <div class="d-flex gap-2 flex-wrap">
              @foreach(['normal'=>['Normal','bg:#f1f5f9;color:#64748b'], 'urgent'=>['Urgent','bg:#fef3c7;color:#d97706'], 'très urgent'=>['Très urgent','bg:#fee2e2;color:#dc2626']] as $val => $info)
                <label style="cursor:pointer">
                  <input type="radio" name="urgency" value="{{ $val }}" style="display:none"
                         {{ old('urgency','normal') === $val ? 'checked' : '' }}>
                  <span style="{{ $info[1] }};padding:8px 18px;border-radius:999px;font-size:13px;font-weight:600;border:2px solid transparent;display:block;transition:.2s"
                        class="urgency-opt">{{ $info[0] }}</span>
                </label>
              @endforeach
            </div>
          </div>

          <button type="submit" class="btn-harfa">
            <i class="bi bi-calendar-check"></i> Envoyer la demande
          </button>
        </form>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card-premium" style="position:sticky;top:88px">
        <div class="card-premium-title"><i class="bi bi-person-badge"></i> Artisan sélectionné</div>

        <div class="d-flex align-items-center gap-3 mb-4">
          <div style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#047857,#10b981);color:white;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:800;flex-shrink:0">
            {{ strtoupper(substr($craftsman->user->name,0,2)) }}
          </div>
          <div>
            <div style="font-weight:700;font-size:15px;color:#0f172a">{{ $craftsman->user->name }}</div>
            <div style="font-size:13px;color:#64748b">
              @if($craftsman->user->city) {{ $craftsman->user->city }} · @endif
              {{ $craftsman->experience_years }} ans d'expérience
            </div>
            <div class="d-flex gap-1 mt-1">
              @for($i=1;$i<=5;$i++)
                <i class="bi bi-star{{ $i <= round($craftsman->averageRating()) ? '-fill' : '' }}" style="color:#f59e0b;font-size:12px"></i>
              @endfor
              <span style="font-size:12px;color:#64748b;margin-left:3px">{{ number_format($craftsman->averageRating(),1) }}</span>
            </div>
          </div>
        </div>

        <div style="background:#fef3c7;border:1px solid #fde68a;border-radius:12px;padding:14px;font-size:13px;color:#92400e">
          <i class="bi bi-info-circle-fill me-2"></i>
          Votre demande sera transmise à l'artisan. Il confirmera ou proposera une autre date.
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('input[name="urgency"]').forEach(radio => {
  radio.addEventListener('change', () => {
    document.querySelectorAll('.urgency-opt').forEach(el => {
      el.style.borderColor = 'transparent';
    });
    radio.nextElementSibling.style.borderColor = '#059669';
  });
});
// Highlight default
const def = document.querySelector('input[name="urgency"]:checked');
if(def) def.nextElementSibling.style.borderColor = '#059669';
</script>
@endpush
@endsection