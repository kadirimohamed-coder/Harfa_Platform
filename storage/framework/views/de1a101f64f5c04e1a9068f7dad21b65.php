<?php $__env->startSection('title', $gig->title . ' — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    
    <div class="portal-header">
      <div>
        <a href="<?php echo e(route('client.post-job')); ?>" class="btn-harfa-ghost" style="margin-bottom:10px;display:inline-flex">
          <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
        <h1 class="portal-title"><?php echo e($gig->title); ?></h1>
        <p class="portal-subtitle">
          Publié <?php echo e($gig->created_at->diffForHumans()); ?>

          · <span class="badge-status status-<?php echo e($gig->status); ?>"><?php echo e(ucfirst($gig->status)); ?></span>
        </p>
      </div>
    </div>

    
    <?php if(session('status')): ?>
      <div class="alert-harfa alert-success mb-4">
        <i class="bi bi-check-circle me-2"></i><?php echo e(session('status')); ?>

      </div>
    <?php endif; ?>

    <div class="row g-4">

      
      <div class="col-lg-5">
        <div class="card-premium">
          <div class="card-premium-title">
            <i class="bi bi-briefcase"></i> Détails de l'offre
          </div>

          <p style="color:#374151;line-height:1.75;font-size:15px;white-space:pre-line"><?php echo e($gig->description); ?></p>

          <hr style="border-color:#e2e8f0;margin:20px 0">

          <div class="row g-3">
            <div class="col-6">
              <div style="background:#f8fafc;border-radius:10px;padding:12px 14px">
                <div style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:#94a3b8;font-weight:600;margin-bottom:4px">Catégorie</div>
                <div style="font-size:13px;font-weight:600"><span class="badge-cat"><?php echo e($gig->category->name); ?></span></div>
              </div>
            </div>
            <div class="col-6">
              <div style="background:#f8fafc;border-radius:10px;padding:12px 14px">
                <div style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:#94a3b8;font-weight:600;margin-bottom:4px">Ville</div>
                <div style="font-size:13px;font-weight:600;color:#0f172a"><i class="bi bi-geo-alt me-1 text-muted"></i><?php echo e($gig->city); ?></div>
              </div>
            </div>
            <div class="col-6">
              <div style="background:#f8fafc;border-radius:10px;padding:12px 14px">
                <div style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:#94a3b8;font-weight:600;margin-bottom:4px">Date limite</div>
                <div style="font-size:13px;font-weight:600;color:#0f172a">
                  <?php if($gig->deadline): ?>
                    <i class="bi bi-calendar me-1 text-muted"></i><?php echo e($gig->deadline->format('d/m/Y')); ?>

                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      
      <div class="col-lg-7">
        <div class="card-premium">
          <div class="card-premium-title">
            <i class="bi bi-people"></i> Candidatures
            <span class="badge-cat ms-auto" style="font-size:11px">
              <?php echo e($gig->applications->count()); ?> reçue<?php echo e($gig->applications->count() !== 1 ? 's' : ''); ?>

            </span>
          </div>

          <?php $__empty_1 = true; $__currentLoopData = $gig->applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="booking-row">
              <div class="booking-avatar" style="background:#dbeafe;color:#2563eb;font-size:18px">
                <i class="bi bi-person-gear"></i>
              </div>
              <div class="booking-info">
                <div class="booking-name"><?php echo e($app->craftsman->user->name); ?></div>
                <div class="booking-meta">
                  <i class="bi bi-geo-alt me-1"></i><?php echo e($app->craftsman->user->city ?? '—'); ?>

                  <?php if($app->craftsman->experience_years): ?>
                    <span class="ms-2"><i class="bi bi-briefcase me-1"></i><?php echo e($app->craftsman->experience_years); ?> ans exp.</span>
                  <?php endif; ?>
                  <?php if($app->craftsman->price): ?>
                    <span class="ms-2 fw-bold" style="color:#059669"><?php echo e(number_format($app->craftsman->price, 0)); ?> DH/h</span>
                  <?php endif; ?>
                  <span class="ms-2 text-muted">· <?php echo e($app->created_at->diffForHumans()); ?></span>
                </div>
              </div>
              <div class="d-flex gap-2">
                <a href="<?php echo e(route('craftsmen.show', $app->craftsman)); ?>"
                   class="btn-harfa-ghost"
                   style="font-size:12px;padding:6px 10px"
                   title="Voir le profil">
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
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state">
              <i class="bi bi-hourglass-split"></i>
              <h5>Aucune candidature pour l'instant</h5>
              <p>Les artisans correspondant à votre offre pourront postuler sous peu.</p>
            </div>
          <?php endif; ?>

        </div>
      </div>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/client/gig-show.blade.php ENDPATH**/ ?>