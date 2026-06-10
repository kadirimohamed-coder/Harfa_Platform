<nav class="harfa-nav navbar navbar-expand-lg fixed-top">
  <div class="container">

    
    <a class="nav-brand navbar-brand" href="<?php echo e(route('home')); ?>">
      <div class="brand-icon"><i class="bi bi-tools"></i></div>
      Harfa<span class="text-green">.ma</span>
    </a>

    
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <i class="bi bi-list fs-4"></i>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">

      
      <ul class="navbar-nav mx-auto gap-1">
        <li class="nav-item">
          <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Accueil</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo e(request()->routeIs('craftsmen.*','categories.*') ? 'active' : ''); ?>"
             href="#" data-bs-toggle="dropdown">Trouver un artisan</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo e(route('craftsmen.index')); ?>">
              <i class="bi bi-search me-2 text-green"></i>Parcourir les artisans
            </a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('craftsmen.index')); ?>">
              <i class="bi bi-grid me-2 text-green"></i>Par catégorie
            </a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo e(request()->routeIs('find-work') ? 'active' : ''); ?>" href="<?php echo e(route('find-work')); ?>">Trouver du travail</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo e(request()->routeIs('about') ? 'active' : ''); ?>" href="<?php echo e(route('about')); ?>">À propos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo e(request()->routeIs('pricing') ? 'active' : ''); ?>" href="<?php echo e(route('pricing')); ?>">Tarifs</a>
        </li>
      </ul>

      
      <div class="nav-actions d-flex align-items-center gap-2">
        <?php if(auth()->guard()->check()): ?>
          
          <span class="nav-role-badge d-none d-lg-inline">
            <?php if(auth()->user()->isAdmin()): ?> Admin
            <?php elseif(auth()->user()->isCraftsman()): ?> Artisan
            <?php else: ?> Client
            <?php endif; ?>
          </span>

          
          <?php if(auth()->user()->isAdmin()): ?>
            <a class="btn-nav-outline" href="<?php echo e(route('admin.dashboard')); ?>">
              <i class="bi bi-speedometer2 me-1"></i>Admin
            </a>
          <?php elseif(auth()->user()->isCraftsman()): ?>
            <a class="btn-nav-outline" href="<?php echo e(route('craftsman.dashboard')); ?>">
              <i class="bi bi-grid me-1"></i>Dashboard
            </a>
          <?php else: ?>
            <a class="btn-nav-outline" href="<?php echo e(route('client.dashboard')); ?>">
              <i class="bi bi-grid me-1"></i>Dashboard
            </a>
          <?php endif; ?>

          
          <div class="user-menu dropdown">
            <div class="user-avatar dropdown-toggle" data-bs-toggle="dropdown" role="button">
              <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

            </div>
            <ul class="dropdown-menu dropdown-menu-end">
              <li class="px-3 py-2">
                <div class="fw-bold text-sm" style="font-size:14px"><?php echo e(auth()->user()->name); ?></div>
                <div style="font-size:12px;color:#64748b"><?php echo e(auth()->user()->email); ?></div>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">
                <i class="bi bi-person-gear me-2"></i>Mon profil
              </a></li>
              <?php if(auth()->user()->isCraftsman()): ?>
                <li><a class="dropdown-item" href="<?php echo e(route('craftsman.profile')); ?>">
                  <i class="bi bi-person-badge me-2"></i>Profil artisan
                </a></li>
                <li><a class="dropdown-item" href="<?php echo e(route('craftsman.billing')); ?>">
                  <i class="bi bi-coin me-2"></i>Points (<?php echo e(auth()->user()->points); ?>)
                </a></li>
              <?php endif; ?>
              <?php if(auth()->user()->isClient()): ?>
                <li><a class="dropdown-item" href="<?php echo e(route('client.billing')); ?>">
                  <i class="bi bi-receipt me-2"></i>Facturation
                </a></li>
              <?php endif; ?>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                  <?php echo csrf_field(); ?>
                  <button class="dropdown-item text-danger" type="submit">
                    <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                  </button>
                </form>
              </li>
            </ul>
          </div>

        <?php else: ?>
          <a class="btn-nav-outline" href="<?php echo e(route('login')); ?>">Connexion</a>
          <a class="btn-nav-primary" href="<?php echo e(route('register')); ?>">
            <i class="bi bi-person-plus me-1"></i>S'inscrire
          </a>
        <?php endif; ?>
      </div>

    </div>
  </div>
</nav>
<?php /**PATH C:\Users\USER\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/partials/nav.blade.php ENDPATH**/ ?>