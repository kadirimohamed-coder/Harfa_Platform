<div class="portal-sidebar">
  <div class="sidebar-section">
    <div class="sidebar-section-label">Principal</div>
    <a href="<?php echo e(route('craftsman.dashboard')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('craftsman.dashboard') ? 'active' : ''); ?>">
      <i class="bi bi-grid-1x2"></i> Tableau de bord
    </a>
    <a href="<?php echo e(route('craftsman.profile')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('craftsman.profile') ? 'active' : ''); ?>">
      <i class="bi bi-person-badge"></i> Mon profil
    </a>
    <a href="<?php echo e(route('craftsman.categories')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('craftsman.categories') ? 'active' : ''); ?>">
      <i class="bi bi-tags"></i> Mes catégories
    </a>
  </div>

  <div class="sidebar-section">
    <div class="sidebar-section-label">Activité</div>
    <a href="<?php echo e(route('craftsman.bookings')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('craftsman.bookings') ? 'active' : ''); ?>">
      <i class="bi bi-calendar-check"></i> Réservations
    </a>
    <a href="<?php echo e(route('craftsman.earnings')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('craftsman.earnings') ? 'active' : ''); ?>">
      <i class="bi bi-check-circle"></i> Travaux terminés
    </a>
    <a href="<?php echo e(route('craftsman.inbox')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('craftsman.inbox*') ? 'active' : ''); ?>">
      <i class="bi bi-chat-dots"></i> Messages
    </a>
    <a href="<?php echo e(route('craftsman.reviews')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('craftsman.reviews') ? 'active' : ''); ?>">
      <i class="bi bi-star"></i> Avis reçus
    </a>
  </div>

  <div class="sidebar-section">
    <div class="sidebar-section-label">Plateforme</div>
    <a href="<?php echo e(route('craftsman.billing')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('craftsman.billing') ? 'active' : ''); ?>">
      <i class="bi bi-coin"></i> Mes points
      <span class="ms-auto" style="font-size:11px;font-weight:700;color:#34d399;background:rgba(52,211,153,.15);padding:2px 8px;border-radius:20px">
        <?php echo e(auth()->user()->points); ?> pts
      </span>
    </a>
  </div>

  <div class="sidebar-user">
    <div class="sidebar-user-card">
      <div class="user-avatar-sm"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?></div>
      <div>
        <div class="user-name"><?php echo e(auth()->user()->name); ?></div>
        <div class="user-role">Artisan</div>
      </div>
    </div>
  </div>
</div><?php /**PATH C:\Users\USER\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/partials/sidebar-craftsman.blade.php ENDPATH**/ ?>