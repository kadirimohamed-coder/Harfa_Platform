<div class="portal-sidebar">
  <div class="sidebar-section">
    <div class="sidebar-section-label">Administration</div>
    <a href="<?php echo e(route('admin.dashboard')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="<?php echo e(route('admin.users')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('admin.users') ? 'active' : ''); ?>">
      <i class="bi bi-people"></i> Utilisateurs
    </a>
    <a href="<?php echo e(route('admin.craftsmen')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('admin.craftsmen') ? 'active' : ''); ?>">
      <i class="bi bi-person-check"></i> Artisans
    </a>
    <a href="<?php echo e(route('admin.categories')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('admin.categories') ? 'active' : ''); ?>">
      <i class="bi bi-tags"></i> Catégories
    </a>
  </div>
  <div class="sidebar-section">
    <div class="sidebar-section-label">Contenu</div>
    <a href="<?php echo e(route('admin.bookings')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('admin.bookings') ? 'active' : ''); ?>">
      <i class="bi bi-calendar3"></i> Réservations
    </a>
    <a href="<?php echo e(route('admin.reviews')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('admin.reviews') ? 'active' : ''); ?>">
      <i class="bi bi-chat-heart"></i> Avis
    </a>
    <a href="<?php echo e(route('admin.gigs')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('admin.gigs') ? 'active' : ''); ?>">
      <i class="bi bi-briefcase"></i> Offres d'emploi
    </a>
    <a href="<?php echo e(route('admin.payments')); ?>"
       class="sidebar-link <?php echo e(request()->routeIs('admin.payments') ? 'active' : ''); ?>">
      <i class="bi bi-coin"></i> Points plateforme
    </a>
  </div>
  <div class="sidebar-user">
    <div class="sidebar-user-card">
      <div class="user-avatar-sm"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?></div>
      <div>
        <div class="user-name"><?php echo e(auth()->user()->name); ?></div>
        <div class="user-role" style="color:#ef4444">Administrateur</div>
      </div>
    </div>
  </div>
</div>
<?php /**PATH C:\Users\USER\harfa\resources\views/partials/sidebar-admin.blade.php ENDPATH**/ ?>