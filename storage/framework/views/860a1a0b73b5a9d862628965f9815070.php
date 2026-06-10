<?php $__env->startSection('title', 'Dashboard Artisan — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-craftsman', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Espace artisan 🔧</h1>
        <p class="portal-subtitle">Bienvenue, <?php echo e(auth()->user()->name); ?> — gérez vos chantiers et votre activité.</p>
      </div>
      <div class="page-actions">
        <form method="POST" action="<?php echo e(route('craftsman.availability.toggle')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" class="btn-harfa-ghost">
            <?php if($craftsman->availability_status): ?>
              <span style="width:8px;height:8px;background:#059669;border-radius:50%;display:inline-block;animation:pulse-dot 1.5s infinite"></span>
              Disponible
            <?php else: ?>
              <span style="width:8px;height:8px;background:#94a3b8;border-radius:50%;display:inline-block"></span>
              Occupé
            <?php endif; ?>
          </button>
        </form>
        <a href="<?php echo e(route('craftsman.profile')); ?>" class="btn-harfa">
          <i class="bi bi-person-gear"></i> Mon profil
        </a>
      </div>
    </div>

    
    <?php if(session('status')): ?>
      <div class="alert-harfa alert-success mb-4">
        <i class="bi bi-check-circle me-2"></i><?php echo e(session('status')); ?>

      </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
      <div class="alert-harfa alert-danger mb-4">
        <i class="bi bi-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

      </div>
    <?php endif; ?>

    
    <div class="stats-grid">
      <div class="stat-card stat-green">
        <div class="stat-icon" style="background:#d1fae5;color:#059669"><i class="bi bi-check-circle"></i></div>
        <div class="stat-label">Travaux terminés</div>
        <div class="stat-value" style="color:#059669"><?php echo e($completedBookings); ?></div>
        <div class="stat-sub">Missions accomplies</div>
      </div>
      <div class="stat-card stat-blue">
        <div class="stat-icon" style="background:#dbeafe;color:#2563eb"><i class="bi bi-coin"></i></div>
        <div class="stat-label">Points</div>
        <div class="stat-value" style="color:#2563eb"><?php echo e(auth()->user()->points); ?></div>
        <div class="stat-sub">5 pts par candidature</div>
      </div>
      <div class="stat-card stat-amber">
        <div class="stat-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-star-fill"></i></div>
        <div class="stat-label">Note moyenne</div>
        <div class="stat-value" style="color:#d97706"><?php echo e(number_format($avgRating, 1)); ?></div>
        <div class="stat-sub">/ 5 étoiles</div>
      </div>
      <div class="stat-card stat-purple">
        <div class="stat-icon" style="background:#ede9fe;color:#7c3aed"><i class="bi bi-calendar-check"></i></div>
        <div class="stat-label">Chantiers actifs</div>
        <div class="stat-value" style="color:#7c3aed"><?php echo e($activeBookings); ?></div>
        <div class="stat-sub">En cours ou confirmés</div>
      </div>
    </div>

    <div class="row g-4">

      
      <div class="col-lg-7">
        <div class="card-premium">
          <div class="card-premium-title">
            <i class="bi bi-briefcase"></i> Jobs disponibles à proximité
            <span class="badge-cat ms-auto" style="font-size:11px">5 pts par candidature</span>
          </div>
          <p style="font-size:13px;color:#64748b;margin-top:-8px;margin-bottom:16px">
            Jobs correspondant à vos catégories
          </p>

          <?php $__empty_1 = true; $__currentLoopData = $matchingGigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $alreadyApplied = $gig->applications->where('craftsman_id', $craftsman->id)->count() > 0; ?>
            <div class="booking-row" style="<?php echo e($alreadyApplied ? 'opacity:.85' : ''); ?>">
              <div class="booking-avatar" style="background:<?php echo e($alreadyApplied ? '#f0fdf4' : '#f0fdf4'); ?>;color:#059669">
                <i class="bi bi-briefcase" style="font-size:18px"></i>
              </div>
              <div class="booking-info">
                <div class="booking-name"><?php echo e($gig->title); ?></div>
                <div class="booking-meta">
                  <span class="badge-cat"><?php echo e($gig->category->name); ?></span>
                  <span class="ms-2"><i class="bi bi-geo-alt me-1"></i><?php echo e($gig->city); ?></span>
                  <span class="ms-2 text-muted">· <?php echo e($gig->created_at->diffForHumans()); ?></span>
                </div>
              </div>

              <?php if($alreadyApplied): ?>
                
                <a href="<?php echo e(route('craftsman.gigs.show', $gig)); ?>"
                   style="display:inline-flex;align-items:center;gap:6px;font-size:13px;padding:7px 14px;white-space:nowrap;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;color:#15803d;font-weight:600;text-decoration:none">
                  <i class="bi bi-check-circle-fill"></i> Postulé
                </a>
              <?php else: ?>
                <a href="<?php echo e(route('craftsman.gigs.show', $gig)); ?>"
                   class="btn-harfa"
                   style="font-size:13px;padding:7px 14px;white-space:nowrap">
                  Postuler
                </a>
              <?php endif; ?>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state">
              <i class="bi bi-briefcase"></i>
              <h5>Aucun job disponible</h5>
              <p>Ajoutez plus de catégories à votre profil pour voir plus d'offres.</p>
              <a href="<?php echo e(route('craftsman.categories')); ?>" class="btn-harfa-ghost">
                Gérer mes catégories
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>

      
      <div class="col-lg-5">
        <div class="card-premium">
          <div class="card-premium-title">
            <i class="bi bi-calendar-check"></i> Demandes de réservation
          </div>

          <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="booking-row">
              <div class="booking-avatar" style="background:#ede9fe;color:#7c3aed;font-size:16px">
                <i class="bi bi-person"></i>
              </div>
              <div class="booking-info">
                <div class="booking-name"><?php echo e($booking->client->name); ?></div>
                <div class="booking-meta">
                  <i class="bi bi-calendar me-1"></i><?php echo e($booking->booking_date->format('d/m/Y')); ?>

                </div>
                <span class="badge-status status-<?php echo e($booking->status); ?>"><?php echo e(ucfirst($booking->status)); ?></span>
              </div>
              <a href="<?php echo e(route('craftsman.bookings')); ?>" style="color:#94a3b8;font-size:18px">
                <i class="bi bi-chevron-right"></i>
              </a>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state">
              <i class="bi bi-calendar-x"></i>
              <h5>Aucune réservation</h5>
              <p>Complétez votre profil pour recevoir des demandes.</p>
            </div>
          <?php endif; ?>

          <div class="mt-2">
            <a href="<?php echo e(route('craftsman.bookings')); ?>" class="btn-harfa-ghost w-100 justify-content-center">
              Voir toutes les réservations
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\harfa\resources\views/craftsman/dashboard.blade.php ENDPATH**/ ?>