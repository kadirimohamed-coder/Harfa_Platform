<?php $__env->startSection('title', 'Inscription — Harfa.ma'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-container">

  
  <div class="auth-panel-left">
    <div class="auth-logo">
      <div class="logo-box"><i class="bi bi-tools"></i></div>
      Harfa.ma
    </div>

    <?php if(request('role') == 'craftsman'): ?>
      <h2>Développez votre<br>activité artisanale 🔧</h2>
      <p>Rejoignez notre réseau d'artisans et recevez des demandes directement depuis votre profil.</p>
      <ul class="auth-features">
        <li><div class="feat-icon"><i class="bi bi-person-check-fill" style="color:#34d399"></i></div> Profil visible partout au Maroc</li>
        <li><div class="feat-icon"><i class="bi bi-graph-up" style="color:#60a5fa"></i></div> Recevez plus de demandes clients</li>
        <li><div class="feat-icon"><i class="bi bi-bell-fill" style="color:#fbbf24"></i></div> Notifications de réservation en temps réel</li>
        <li><div class="feat-icon"><i class="bi bi-shield-check" style="color:#a78bfa"></i></div> Badge artisan vérifié par Harfa</li>
      </ul>
    <?php else: ?>
      <h2>Bienvenue sur<br>Harfa.ma ✨</h2>
      <p>Créez votre compte gratuit et trouvez l'artisan qu'il vous faut en quelques minutes seulement.</p>
      <ul class="auth-features">
        <li><div class="feat-icon"><i class="bi bi-star-fill" style="color:#fbbf24"></i></div> Artisans vérifiés et notés</li>
        <li><div class="feat-icon"><i class="bi bi-calendar-check-fill" style="color:#34d399"></i></div> Réservation en quelques clics</li>
        <li><div class="feat-icon"><i class="bi bi-geo-alt-fill" style="color:#60a5fa"></i></div> Disponibles près de chez vous</li>
        <li><div class="feat-icon"><i class="bi bi-chat-dots-fill" style="color:#f472b6"></i></div> Avis clients transparents</li>
      </ul>
    <?php endif; ?>
  </div>

  
  <div class="auth-panel-right">

    <h3>Créer un compte</h3>
    <p class="auth-sub">Déjà inscrit ? <a href="<?php echo e(route('login')); ?>" class="fw-semibold" style="color:#059669">Se connecter</a></p>

    
    <div class="role-selector mb-4" id="rolePicker">
      <label class="role-card <?php echo e(old('role','client') === 'client' ? 'selected' : ''); ?>" onclick="selectRole('client')">
        <input type="radio" name="role_display" value="client" <?php echo e(old('role','client') === 'client' ? 'checked' : ''); ?>>
        <i class="bi bi-person-circle"></i>
        <div class="role-text">
          <span>Client</span>
          <small>Je cherche un artisan</small>
        </div>
      </label>
      <label class="role-card <?php echo e(old('role') === 'craftsman' ? 'selected' : ''); ?>" onclick="selectRole('craftsman')">
        <input type="radio" name="role_display" value="craftsman" <?php echo e(old('role') === 'craftsman' ? 'checked' : ''); ?>>
        <i class="bi bi-tools"></i>
        <div class="role-text">
          <span>Artisan</span>
          <small>Je propose mes services</small>
        </div>
      </label>
    </div>

    <form method="POST" action="<?php echo e(route('register')); ?>" id="registerForm">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="role" id="roleInput" value="<?php echo e(old('role','client')); ?>">

      <div class="auth-field">
        <label for="name">Nom complet</label>
        <div class="field-wrap">
          <i class="bi bi-person field-icon"></i>
          <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>"
                 placeholder="Ahmed Benali" autocomplete="name" required>
        </div>
      </div>

      <div class="auth-field">
        <label for="email">Adresse email</label>
        <div class="field-wrap">
          <i class="bi bi-envelope field-icon"></i>
          <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>"
                 placeholder="vous@exemple.ma" autocomplete="email" required>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-6">
          <div class="auth-field">
            <label for="phone">Téléphone</label>
            <div class="field-wrap">
              <i class="bi bi-telephone field-icon"></i>
              <input type="tel" id="phone" name="phone" value="<?php echo e(old('phone')); ?>"
                     placeholder="06 00 00 00 00" required>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="auth-field">
            <label for="city">Ville</label>
            <div class="field-wrap">
              <i class="bi bi-geo-alt field-icon"></i>
              <input type="text" id="city" name="city" value="<?php echo e(old('city')); ?>"
                     placeholder="Casablanca">
            </div>
          </div>
        </div>
      </div>

      <div class="auth-field">
        <label for="password">Mot de passe</label>
        <div class="field-wrap">
          <i class="bi bi-lock field-icon"></i>
          <input type="password" id="password" name="password"
                 placeholder="Min. 6 caractères" autocomplete="new-password" required>
          <button type="button" class="eye-btn" id="togglePwd"><i class="bi bi-eye"></i></button>
        </div>
        <div class="pass-strength-bar mt-1">
          <div class="bar-fill" id="strengthBar"></div>
        </div>
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

<?php $__env->startPush('scripts'); ?>
<script>
function selectRole(role){
  document.getElementById('roleInput').value = role;
  document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
  event.currentTarget.classList.add('selected');
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

// Password strength
document.getElementById('password').addEventListener('input', function(){
  const val = this.value;
  const bar = document.getElementById('strengthBar');
  bar.className = 'bar-fill';
  if(val.length === 0){ bar.style.width = '0'; return; }
  if(val.length < 6)       { bar.classList.add('weak');   }
  else if(val.length < 10) { bar.classList.add('fair');   }
  else                     { bar.classList.add('strong'); }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/auth/register.blade.php ENDPATH**/ ?>