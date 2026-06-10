@extends('layouts.app')
@section('title', 'Évaluer un artisan — Harfa.ma')
@section('content')
<div class="container py-4" style="max-width:600px">

  <div class="mb-4">
    <a href="{{ route('client.bookings') }}" style="font-size:14px;color:#64748b;text-decoration:none">
      <i class="bi bi-arrow-left me-2"></i>Retour aux réservations
    </a>
  </div>

  <div class="card-premium">
    <div class="text-center mb-4">
      <div style="width:72px;height:72px;background:linear-gradient(135deg,#047857,#10b981);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:800;margin:0 auto 16px">
        {{ strtoupper(substr($booking->craftsman->user->name,0,2)) }}
      </div>
      <h4 style="font-weight:800;color:#0f172a;margin-bottom:4px">Évaluer {{ $booking->craftsman->user->name }}</h4>
      <p style="font-size:14px;color:#64748b">Réservation du {{ $booking->booking_date->format('d/m/Y') }}</p>
    </div>

    <form method="POST" action="{{ route('client.review.store', $booking) }}">
      @csrf

      {{-- Star rating --}}
      <div class="mb-4">
        <label class="form-label text-center w-100" style="font-size:15px;font-weight:700">Note globale</label>
        <div class="d-flex justify-content-center gap-2" id="starRating">
          @for($i = 5; $i >= 1; $i--)
            <label style="cursor:pointer;font-size:42px;color:#e2e8f0;transition:.15s" class="star-label" data-val="{{ $i }}">
              <input type="radio" name="rating" value="{{ $i }}" required style="display:none">
              <i class="bi bi-star-fill"></i>
            </label>
          @endfor
        </div>
        <div id="ratingText" class="text-center" style="font-size:13px;color:#94a3b8;margin-top:8px">
          Cliquez pour noter
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label">Commentaire (optionnel)</label>
        <textarea class="form-control" name="comment" rows="4"
                  placeholder="Partagez votre expérience avec cet artisan : ponctualité, qualité du travail, rapport qualité-prix...">{{ old('comment') }}</textarea>
      </div>

      {{-- Quick tags --}}
      <div class="mb-4">
        <label class="form-label">Points forts (optionnel)</label>
        <div class="d-flex flex-wrap gap-2" id="quickTags">
          @foreach(['Ponctuel','Soigné','Professionnel','Bon rapport qualité/prix','À l\'écoute','Rapide','Honnête'] as $tag)
            <label style="cursor:pointer">
              <input type="checkbox" name="tags[]" value="{{ $tag }}" style="display:none">
              <span class="badge-cat" style="cursor:pointer;transition:.2s;padding:7px 14px;font-size:13px">{{ $tag }}</span>
            </label>
          @endforeach
        </div>
      </div>

      <button type="submit" class="btn-harfa w-100 justify-content-center" style="font-size:15px;padding:13px">
        <i class="bi bi-send"></i> Publier mon évaluation
      </button>
    </form>
  </div>
</div>

@push('scripts')
<script>
const labels = document.querySelectorAll('.star-label');
const ratingText = document.getElementById('ratingText');
const texts = ['','Mauvais','Passable','Bien','Très bien','Excellent !'];

// Display stars left-to-right by reversing the flex-direction
document.getElementById('starRating').style.flexDirection = 'row';

// Re-order the star labels so 1 is leftmost
const starsContainer = document.getElementById('starRating');
const starArray = Array.from(starsContainer.querySelectorAll('.star-label'));
starArray.reverse().forEach(s => starsContainer.appendChild(s));

// Now they go 1-2-3-4-5 left to right
document.querySelectorAll('.star-label').forEach(label => {
  const val = parseInt(label.dataset.val);
  const input = label.querySelector('input');

  label.addEventListener('click', () => {
    input.checked = true;
    document.querySelectorAll('.star-label').forEach((l, idx) => {
      const lval = parseInt(l.dataset.val);
      l.style.color = lval <= val ? '#f59e0b' : '#e2e8f0';
    });
    ratingText.textContent = texts[val];
    ratingText.style.color = '#f59e0b';
    ratingText.style.fontWeight = '700';
  });

  label.addEventListener('mouseenter', () => {
    document.querySelectorAll('.star-label').forEach(l => {
      l.style.color = parseInt(l.dataset.val) <= val ? '#f59e0b' : '#e2e8f0';
    });
  });
});

starsContainer.addEventListener('mouseleave', () => {
  const checked = document.querySelector('input[name="rating"]:checked');
  const checkedVal = checked ? parseInt(checked.value) : 0;
  document.querySelectorAll('.star-label').forEach(l => {
    l.style.color = parseInt(l.dataset.val) <= checkedVal ? '#f59e0b' : '#e2e8f0';
  });
});

// Quick tags toggle
document.querySelectorAll('#quickTags label').forEach(label => {
  label.addEventListener('click', () => {
    const span = label.querySelector('span');
    const cb   = label.querySelector('input');
    setTimeout(() => {
      if(cb.checked) {
        span.style.background = '#d1fae5';
        span.style.color = '#065f46';
        span.style.borderColor = '#059669';
      } else {
        span.style.background = '';
        span.style.color = '';
        span.style.borderColor = '';
      }
    }, 0);
  });
});
</script>
@endpush
@endsection
