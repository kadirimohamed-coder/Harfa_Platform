<div class="portal-sidebar">
  <div class="sidebar-section">
    <div class="sidebar-section-label">Principal</div>
    <a href="<?php echo e(route('client.dashboard')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('client.dashboard') ? 'active' : ''); ?>"
       style="justify-content:space-between">
      <span><i class="bi bi-grid-1x2"></i> Tableau de bord</span>
      <?php if(!empty($_newAppsCount) && $_newAppsCount > 0): ?>
        <span style="background:#10b981;color:#fff;border-radius:20px;padding:1px 8px;font-size:11px;font-weight:700;min-width:20px;text-align:center">
          <?php echo e($_newAppsCount); ?>

        </span>
      <?php endif; ?>
    </a>
    <a href="<?php echo e(route('craftsmen.index')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('craftsmen.*') ? 'active' : ''); ?>">
      <i class="bi bi-search"></i> Trouver un artisan
    </a>
    <a href="<?php echo e(route('client.post-job')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('client.post-job') ? 'active' : ''); ?>">
      <i class="bi bi-plus-circle"></i> Publier un job
    </a>
  </div>

  <div class="sidebar-section">
    <div class="sidebar-section-label">Mes activités</div>
    <a href="<?php echo e(route('client.bookings')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('client.bookings') ? 'active' : ''); ?>">
      <i class="bi bi-calendar-check"></i> Réservations
    </a>
    <a href="<?php echo e(route('client.inbox')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('client.inbox*') ? 'active' : ''); ?>">
      <i class="bi bi-chat-dots"></i> Messages
    </a>
    <a href="<?php echo e(route('client.reviews')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('client.reviews') ? 'active' : ''); ?>">
      <i class="bi bi-star"></i> Mes avis
    </a>
    <a href="<?php echo e(route('client.billing')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('client.billing') ? 'active' : ''); ?>">
      <i class="bi bi-receipt"></i> Facturation
    </a>
  </div>

  <div class="sidebar-user">
    <div class="sidebar-user-card">
      <div class="user-avatar-sm"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?></div>
      <div>
        <div class="user-name"><?php echo e(auth()->user()->name); ?></div>
        <div class="user-role">Client</div>
      </div>
    </div>
  </div>
</div><?php /**PATH C:\Users\Admin\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/partials/sidebar-client.blade.php ENDPATH**/ ?>