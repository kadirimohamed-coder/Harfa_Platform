<?php $__env->startSection('title', 'Connexion — Harfa.ma'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-container">

  
  <div class="auth-panel-left">
    <div class="auth-logo">
      <div class="logo-box"><i class="bi bi-tools"></i></div>
      Harfa.ma
    </div>
    <h2>Bon retour sur<br>Harfa.ma 👋</h2>
    <p>Connectez-vous pour accéder à votre espace personnel et retrouver vos artisans de confiance.</p>
    <ul class="auth-features">
      <li>
        <div class="feat-icon"><i class="bi bi-star-fill" style="color:#fbbf24"></i></div>
        Artisans vérifiés et notés par la communauté
      </li>
      <li>
        <div class="feat-icon"><i class="bi bi-calendar-check-fill" style="color:#34d399"></i></div>
        Réservation en quelques clics seulement
      </li>
      <li>
        <div class="feat-icon"><i class="bi bi-geo-alt-fill" style="color:#60a5fa"></i></div>
        Artisans disponibles près de chez vous
      </li>
      <li>
        <div class="feat-icon"><i class="bi bi-shield-check" style="color:#a78bfa"></i></div>
        Paiements et données sécurisés
      </li>
    </ul>
  </div>

  
  <div class="auth-panel-right">

    <?php if($errors->any()): ?>
      <div class="alert alert-danger mb-4">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <?php echo e($errors->first()); ?>

      </div>
    <?php endif; ?>

    <h3>Se connecter</h3>
    <p class="auth-sub">Pas encore de compte ? <a href="<?php echo e(route('register')); ?>" class="fw-semibold" style="color:#059669">S'inscrire gratuitement</a></p>

    <form method="POST" action="<?php echo e(route('login')); ?>">
      <?php echo csrf_field(); ?>

      <div class="auth-field">
        <label for="email">Adresse email</label>
        <div class="field-wrap">
          <i class="bi bi-envelope field-icon"></i>
          <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>"
                 placeholder="vous@exemple.ma" autocomplete="email" required>
        </div>
      </div>

      <div class="auth-field">
        <label for="password">Mot de passe</label>
        <div class="field-wrap">
          <i class="bi bi-lock field-icon"></i>
          <input type="password" id="password" name="password"
                 placeholder="••••••••" autocomplete="current-password" required>
          <button type="button" class="eye-btn" id="togglePwd">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between mb-4">
        <label class="d-flex align-items-center gap-2" style="font-size:14px;cursor:pointer">
          <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
          Se souvenir de moi
        </label>
        <a href="#" style="font-size:13px;color:#059669;text-decoration:none">Mot de passe oublié ?</a>
      </div>

      <button type="submit" class="btn-auth">
        <i class="bi bi-box-arrow-in-right"></i> Se connecter
      </button>
    </form>

    <div class="mt-4 text-center" style="font-size:13px;color:#94a3b8">
      En vous connectant, vous acceptez nos
      <a href="#" style="color:#059669">Conditions d'utilisation</a> et notre
      <a href="#" style="color:#059669">Politique de confidentialité</a>.
    </div>
  </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
  document.getElementById('togglePwd').addEventListener('click', function(){
    const inp = document.getElementById('password');
    const icon = this.querySelector('i');
    if(inp.type === 'password'){
      inp.type = 'text';
      icon.className = 'bi bi-eye-slash';
    } else {
      inp.type = 'password';
      icon.className = 'bi bi-eye';
    }
  });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/auth/login.blade.php ENDPATH**/ ?>