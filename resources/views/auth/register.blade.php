@extends('layouts.app')
@section('title', 'Inscription — Harfa.ma')

@section('content')
<div class="auth-container">

  {{-- ── Left panel ── --}}
  <div class="auth-panel-left">
    <div class="auth-logo">
      <div class="logo-box"><i class="bi bi-tools"></i></div>
      Harfa.ma
    </div>

    @if(request('role') == 'craftsman')
      <h2>Développez votre<br>activité artisanale 🔧</h2>
      <p>Rejoignez notre réseau d'artisans et recevez des demandes directement depuis votre profil.</p>
      <ul class="auth-features">
        <li><div class="feat-icon"><i class="bi bi-person-check-fill" style="color:#34d399"></i></div> Profil visible partout au Maroc</li>
        <li><div class="feat-icon"><i class="bi bi-graph-up" style="color:#60a5fa"></i></div> Recevez plus de demandes clients</li>
        <li><div class="feat-icon"><i class="bi bi-bell-fill" style="color:#fbbf24"></i></div> Notifications de réservation en temps réel</li>
        <li><div class="feat-icon"><i class="bi bi-shield-check" style="color:#a78bfa"></i></div> Badge artisan vérifié par Harfa</li>
      </ul>
    @else
      <h2>Bienvenue sur<br>Harfa.ma ✨</h2>
      <p>Créez votre compte gratuit et trouvez l'artisan qu'il vous faut en quelques minutes seulement.</p>
      <ul class="auth-features">
        <li><div class="feat-icon"><i class="bi bi-star-fill" style="color:#fbbf24"></i></div> Artisans vérifiés et notés</li>
        <li><div class="feat-icon"><i class="bi bi-calendar-check-fill" style="color:#34d399"></i></div> Réservation en quelques clics</li>
        <li><div class="feat-icon"><i class="bi bi-geo-alt-fill" style="color:#60a5fa"></i></div> Disponibles près de chez vous</li>
        <li><div class="feat-icon"><i class="bi bi-chat-dots-fill" style="color:#f472b6"></i></div> Avis clients transparents</li>
      </ul>
    @endif
  </div>

  {{-- ── Right panel ── --}}
  <div class="auth-panel-right">

    <h3>Créer un compte</h3>
    <p class="auth-sub">Déjà inscrit ? <a href="{{ route('login') }}" class="fw-semibold" style="color:#059669">Se connecter</a></p>

    @if($errors->any())
      <div class="alert alert-danger py-2 px-3 mb-3" style="font-size: 14px; border-radius: 8px;">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <ul class="mb-0 ps-3" style="padding-left: 15px !important;">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="registerForm">
      @csrf

      <input type="hidden" name="role" id="roleInput" value="{{ old('role', request('role', 'client')) }}">

      {{-- Role picker --}}
      <div class="role-selector mb-4">
        <label class="role-card {{ old('role', request('role', 'client')) === 'client' ? 'selected' : '' }}"
               onclick="selectRole('client', this)">
          <input type="radio" name="role_display" value="client" {{ old('role', request('role', 'client')) === 'client' ? 'checked' : '' }}>
          <i class="bi bi-person-circle"></i>
          <div class="role-text">
            <span>Client</span>
            <small>Je cherche un artisan</small>
          </div>
        </label>
        <label class="role-card {{ old('role', request('role')) === 'craftsman' ? 'selected' : '' }}"
               onclick="selectRole('craftsman', this)">
          <input type="radio" name="role_display" value="craftsman" {{ old('role', request('role')) === 'craftsman' ? 'checked' : '' }}>
          <i class="bi bi-tools"></i>
          <div class="role-text">
            <span>Artisan</span>
            <small>Je propose mes services</small>
          </div>
        </label>
      </div>

      <div class="auth-field">
        <label for="name">Nom complet</label>
        <div class="field-wrap">
          <i class="bi bi-person field-icon"></i>
          <input type="text" id="name" name="name" value="{{ old('name') }}"
                 placeholder="Ahmed Benali" autocomplete="name" required>
        </div>
      </div>

      <div class="auth-field">
        <label for="email">Adresse email</label>
        <div class="field-wrap">
          <i class="bi bi-envelope field-icon"></i>
          <input type="email" id="email" name="email" value="{{ old('email') }}"
                 placeholder="vous@exemple.ma" autocomplete="email" required>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-6">
          <div class="auth-field">
            <label for="phone">Téléphone</label>
            <div class="field-wrap">
              <i class="bi bi-telephone field-icon"></i>
              <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                     placeholder="06 00 00 00 00" required>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="auth-field">
            <label for="city">Ville</label>
            <div class="field-wrap">
              <i class="bi bi-geo-alt field-icon"></i>
              <input type="text" id="city" name="city" value="{{ old('city') }}"
                     placeholder="Casablanca">
            </div>
          </div>
        </div>
      </div>

      {{-- Mot de passe (معدل باش يدعم الـ 4 طبقات والـ Label) --}}
      <div class="auth-field">
        <label for="password">Mot de passe</label>
        <div class="field-wrap">
          <i class="bi bi-lock field-icon"></i>
          <input type="password" id="password" name="password"
                 placeholder="Min. 6 caractères" autocomplete="new-password" required>
          <button type="button" class="eye-btn" id="togglePwd"><i class="bi bi-eye"></i></button>
        </div>
        
        {{-- هنا قاديت حاوية الـ Bar باش تحكم فـ العرض والنعومة ديال الإنميشن لداخل --}}
        <div class="pass-strength-bar mt-2" style="height: 6px; background-color: #e2e8f0; border-radius: 4px; overflow: hidden;">
          <div class="bar-fill" id="strengthBar" style="width: 0%; height: 100%; background-color: #e2e8f0; transition: all 0.3s ease;"></div>
        </div>
        {{-- هاد الـ Label هو اللي غايطبع الكلمات (Faible, Moyen...) --}}
        <div id="strengthLabel" class="small mt-1 fw-semibold text-end" style="min-height: 18px; font-size: 12px;"></div>
      </div>

      <div class="auth-field">
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <div class="field-wrap">
          <i class="bi bi-lock-fill field-icon"></i>
          <input type="password" id="password_confirmation" name="password_confirmation"
                 placeholder="••••••••" autocomplete="new-password" required>
          <button type="button" class="eye-btn" id="togglePwd2"><i class="bi bi-eye"></i></button>
        </div>
      </div>

      <button type="submit" class="btn-auth">
        <i class="bi bi-person-plus"></i> Créer mon compte
      </button>
    </form>
  </div>
</div>

@push('scripts')
<script>
function selectRole(role, el) {
    document.getElementById('roleInput').value = role;
    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
}

// Toggle password visibility
['togglePwd','togglePwd2'].forEach(id => {
  const btn = document.getElementById(id);
  if(!btn) return;
  const inp = btn.closest('.field-wrap').querySelector('input');
  btn.addEventListener('click', () => {
    inp.type = inp.type === 'password' ? 'text' : 'password';
    btn.querySelector('i').className = inp.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
  });
});

// ── Password strength meter (الـ 4 طبقات ديالك المظبوطة) ──────────────────────
const passInput = document.getElementById('password');
const bar       = document.getElementById('strengthBar');
const label     = document.getElementById('strengthLabel');

if (passInput && bar && label) {
  passInput.addEventListener('input', () => {
    const val   = passInput.value;
    const score = getStrength(val);

    const levels = [
      { width: '0%',   color: '#e2e8f0', text: '' },
      { width: '25%',  color: '#fc8181', text: 'Faible' },
      { width: '50%',  color: '#f6ad55', text: 'Moyen' },
      { width: '75%',  color: '#68d391', text: 'Bon' },
      { width: '100%', color: '#1D9E75', text: 'Excellent' },
    ];

    bar.style.width      = levels[score].width;
    bar.style.backgroundColor = levels[score].color;
    label.textContent    = levels[score].text;
    label.style.color    = levels[score].color; // باش حتى الكلمة تاخد نفس لون الـ Bar
  });
}

function getStrength(password) {
  if (!password) return 0;
  let score = 0;
  if (password.length >= 6)           score++;
  if (/[A-Z]/.test(password))         score++;
  if (/[0-9]/.test(password))         score++;
  if (/[^A-Za-z0-9]/.test(password))  score++;
  return score;
}
</script>
@endpush
@endsection