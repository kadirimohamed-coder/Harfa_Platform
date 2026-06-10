<?php $__env->startSection('title', 'Dashboard Client — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Bonjour, <?php echo e(auth()->user()->name); ?> 👋</h1>
        <p class="portal-subtitle">Gérez vos réservations, offres d'emploi et messages depuis ici.</p>
      </div>
      <div class="page-actions">
        <a href="<?php echo e(route('craftsmen.index')); ?>" class="btn-harfa-ghost">
          <i class="bi bi-search"></i> Trouver un artisan
        </a>
        <a href="<?php echo e(route('client.post-job')); ?>" class="btn-harfa">
          <i class="bi bi-plus"></i> Publier un job
        </a>
      </div>
    </div>

    
    <?php if(session('status')): ?>
      <div class="alert-harfa alert-success mb-4">
        <i class="bi bi-check-circle me-2"></i><?php echo e(session('status')); ?>

      </div>
    <?php endif; ?>

    
    <?php if($newApplications->count() > 0): ?>
      <div style="background:linear-gradient(135deg,#f0fdf4 0%,#dcfce7 100%);border:1px solid #86efac;border-radius:14px;padding:18px 22px;margin-bottom:24px;display:flex;align-items:flex-start;gap:16px">
        <div style="width:44px;height:44px;background:#059669;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <i class="bi bi-bell-fill" style="color:#fff;font-size:20px"></i>
        </div>
        <div style="flex:1">
          <div style="font-size:15px;font-weight:700;color:#14532d;margin-bottom:4px">
            <?php echo e($newApplications->count()); ?> nouvelle<?php echo e($newApplications->count() > 1 ? 's' : ''); ?> candidature<?php echo e($newApplications->count() > 1 ? 's' : ''); ?> reçue<?php echo e($newApplications->count() > 1 ? 's' : ''); ?> (dernières 48h)
          </div>
          <div style="font-size:13px;color:#166534">
            <?php $__currentLoopData = $newApplications->groupBy('gig_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gigId => $apps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php $gigTitle = $apps->first()->gig->title; ?>
              <span style="display:inline-block;margin-right:12px">
                <i class="bi bi-briefcase me-1"></i>
                <strong><?php echo e($apps->count()); ?></strong> sur « <?php echo e(Str::limit($gigTitle, 40)); ?> »
              </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
        <a href="<?php echo e(route('client.dashboard')); ?>#mes-offres"
           style="flex-shrink:0;background:#059669;color:#fff;border-radius:8px;padding:8px 16px;font-size:13px;font-weight:600;text-decoration:none;white-space:nowrap">
          Voir les offres
        </a>
      </div>
    <?php endif; ?>

    
    <div class="stats-grid">
      <div class="stat-card stat-green">
        <div class="stat-icon" style="background:#d1fae5;color:#059669">
          <i class="bi bi-calendar-check"></i>
        </div>
        <div class="stat-label">Total réservations</div>
        <div class="stat-value" style="color:#059669"><?php echo e($totalBookings); ?></div>
        <div class="stat-sub">Toutes périodes confondues</div>
      </div>
      <div class="stat-card stat-blue">
        <div class="stat-icon" style="background:#dbeafe;color:#2563eb">
          <i class="bi bi-clock"></i>
        </div>
        <div class="stat-label">Actives</div>
        <div class="stat-value" style="color:#2563eb"><?php echo e($activeBookings); ?></div>
        <div class="stat-sub">En attente ou confirmées</div>
      </div>
      <div class="stat-card stat-amber">
        <div class="stat-icon" style="background:#fef3c7;color:#d97706">
          <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-label">Clôturées</div>
        <div class="stat-value" style="color:#d97706"><?php echo e($completedBookings); ?></div>
        <div class="stat-sub">Contrats terminés</div>
      </div>
      <div class="stat-card" style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px">
        <div class="stat-icon" style="background:#fef9c3;color:#ca8a04">
          <i class="bi bi-briefcase"></i>
        </div>
        <div class="stat-label">Candidatures reçues</div>
        <div class="stat-value" style="color:#ca8a04"><?php echo e($newApplications->count()); ?></div>
        <div class="stat-sub">Dernières 48 heures</div>
      </div>
    </div>

    <div class="row g-4" id="mes-offres">

      
      <div class="col-lg-7">
        <div class="card-premium">
          <div class="card-premium-title">
            <i class="bi bi-briefcase"></i> Mes offres d'emploi actives
          </div>

          <?php $__empty_1 = true; $__currentLoopData = $gigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $recentAppCount = $gig->applications->where('created_at', '>=', now()->subHours(48))->count(); ?>
            <div class="booking-row" style="<?php echo e($recentAppCount > 0 ? 'background:#f0fdf4;border-radius:10px;border:1px solid #bbf7d0;margin-bottom:6px' : ''); ?>">
              <div class="booking-avatar"
                   style="background:<?php echo e($recentAppCount > 0 ? '#dcfce7' : '#f1f5f9'); ?>;color:<?php echo e($recentAppCount > 0 ? '#059669' : '#64748b'); ?>">
                <?php echo e(strtoupper(substr($gig->title, 0, 1))); ?>

              </div>
              <div class="booking-info">
                <div class="booking-name" style="display:flex;align-items:center;gap:8px">
                  <?php echo e($gig->title); ?>

                  <?php if($recentAppCount > 0): ?>
                    <span style="display:inline-flex;align-items:center;gap:4px;background:#059669;color:#fff;border-radius:20px;padding:2px 9px;font-size:11px;font-weight:700">
                      <i class="bi bi-bell-fill" style="font-size:9px"></i> <?php echo e($recentAppCount); ?> nouveau<?php echo e($recentAppCount > 1 ? 'x' : ''); ?>

                    </span>
                  <?php endif; ?>
                </div>
                <div class="booking-meta">
                  <span class="badge-cat"><?php echo e($gig->category->name); ?></span>
                  <span class="ms-2"><i class="bi bi-geo-alt me-1"></i><?php echo e($gig->city); ?></span>
                  <span class="ms-2">
                    <i class="bi bi-people me-1"></i><?php echo e($gig->applications->count()); ?> postulant(s)
                  </span>
                </div>
              </div>
              <a href="<?php echo e(route('client.gigs.show', $gig)); ?>"
                 class="<?php echo e($recentAppCount > 0 ? 'btn-harfa' : 'btn-harfa-ghost'); ?>"
                 style="white-space:nowrap;font-size:13px;padding:7px 14px">
                Voir candidatures
              </a>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state">
              <i class="bi bi-briefcase"></i>
              <h5>Aucune offre publiée</h5>
              <p>Publiez une offre pour recevoir des candidatures d'artisans.</p>
              <a href="<?php echo e(route('client.post-job')); ?>" class="btn-harfa">
                <i class="bi bi-plus"></i> Publier un job
              </a>
            </div>
          <?php endif; ?>
        </div>

        
        <?php if($newApplications->count() > 0): ?>
          <div class="card-premium mt-4">
            <div class="card-premium-title" style="color:#059669">
              <i class="bi bi-person-check"></i> Nouveaux postulants (48h)
            </div>
            <?php $__currentLoopData = $newApplications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="booking-row">
                <div class="booking-avatar" style="background:#dbeafe;color:#2563eb;font-size:18px">
                  <i class="bi bi-person-gear"></i>
                </div>
                <div class="booking-info">
                  <div class="booking-name"><?php echo e($app->craftsman->user->name); ?></div>
                  <div class="booking-meta">
                    <span class="badge-cat" style="font-size:11px"><?php echo e($app->gig->title); ?></span>
                    <?php if($app->craftsman->user->city): ?>
                      <span class="ms-2"><i class="bi bi-geo-alt me-1"></i><?php echo e($app->craftsman->user->city); ?></span>
                    <?php endif; ?>
                    <span class="ms-2 text-muted">· <?php echo e($app->created_at->diffForHumans()); ?></span>
                  </div>
                </div>
                <div class="d-flex gap-2">
                  <a href="<?php echo e(route('craftsmen.show', $app->craftsman)); ?>"
                     class="btn-harfa-ghost"
                     style="font-size:12px;padding:6px 10px"
                     title="Voir profil">
                    <i class="bi bi-person"></i>
                  </a>
                  <a href="<?php echo e(route('client.inbox.chat', $app->craftsman->user_id)); ?>"
                     class="btn-harfa"
                     style="font-size:12px;padding:6px 12px"
                     title="Contacter">
                    <i class="bi bi-chat me-1"></i> Contacter
                  </a>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        <?php endif; ?>
      </div>

      
      <div class="col-lg-5">
        <div class="card-premium">
          <div class="card-premium-title">
            <i class="bi bi-calendar-check"></i> Réservations récentes
          </div>

          <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="booking-row">
              <div class="booking-avatar" style="background:#e0f2fe;color:#0369a1;font-size:16px">
                <i class="bi bi-person"></i>
              </div>
              <div class="booking-info">
                <div class="booking-name"><?php echo e($booking->craftsman->user->name); ?></div>
                <div class="booking-meta">
                  <i class="bi bi-calendar me-1"></i><?php echo e($booking->booking_date->format('d/m/Y')); ?>

                </div>
                <span class="badge-status status-<?php echo e($booking->status); ?>"><?php echo e(ucfirst($booking->status)); ?></span>
              </div>
              <a href="<?php echo e(route('client.bookings')); ?>" style="color:#94a3b8;font-size:18px">
                <i class="bi bi-chevron-right"></i>
              </a>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state">
              <i class="bi bi-calendar-x"></i>
              <h5>Aucune réservation</h5>
              <p>Réservez un artisan pour démarrer.</p>
            </div>
          <?php endif; ?>

          <div class="mt-2">
            <a href="<?php echo e(route('client.bookings')); ?>" class="btn-harfa-ghost w-100 justify-content-center">
              Voir toutes les réservations
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\harfa\resources\views/client/dashboard.blade.php ENDPATH**/ ?>