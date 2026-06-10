<?php $__env->startSection('title', $craftsman->user->name . ' — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
  <div class="row g-4">

    
    <div class="col-lg-8">

      
      <div class="card-premium" style="padding:0;overflow:hidden">
        <div style="height:120px;background:linear-gradient(135deg,#064e3b 0%,#065f46 50%,#0f766e 100%)"></div>
        <div style="padding:0 28px 28px">
          <div class="d-flex align-items-end gap-4 flex-wrap" style="margin-top:-44px;margin-bottom:20px">
            <div style="width:88px;height:88px;border-radius:50%;background:linear-gradient(135deg,#047857,#10b981);border:4px solid white;display:flex;align-items:center;justify-content:center;font-size:30px;font-weight:800;color:white;flex-shrink:0;box-shadow:0 4px 16px rgba(0,0,0,.15)">
              <?php echo e(strtoupper(substr($craftsman->user->name, 0, 2))); ?>

            </div>
            <div style="padding-bottom:8px">
              <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                <h3 class="mb-0" style="color:#0f172a"><?php echo e($craftsman->user->name); ?></h3>
                <span style="background:#d1fae5;color:#065f46;font-size:11px;font-weight:700;padding:3px 10px;border-radius:999px">
                  <i class="bi bi-patch-check-fill me-1"></i>Vérifié
                </span>
              </div>
              <div class="d-flex align-items-center gap-3 flex-wrap" style="font-size:13px;color:#64748b">
                <span>
                  <?php for($i=1;$i<=5;$i++): ?>
                    <i class="bi bi-star<?php echo e($i <= round($craftsman->averageRating()) ? '-fill' : ''); ?>" style="color:#f59e0b;font-size:12px"></i>
                  <?php endfor; ?>
                  <strong style="color:#0f172a"><?php echo e($craftsman->averageRating()); ?></strong>
                  (<?php echo e($reviews->count()); ?> avis)
                </span>
                <?php if($craftsman->user->city): ?>
                  <span><i class="bi bi-geo-alt me-1"></i><?php echo e($craftsman->user->city); ?></span>
                <?php endif; ?>
                <span><i class="bi bi-briefcase me-1"></i><?php echo e($craftsman->experience_years); ?> ans exp.</span>
              </div>
              <div class="d-flex gap-2 mt-2">
                <?php $__currentLoopData = $craftsman->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <span class="badge-cat"><?php echo e($cat->name); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          </div>

          
          <div class="mb-3">
            <?php if($craftsman->availability_status): ?>
              <span class="availability-badge">Disponible pour missions</span>
            <?php else: ?>
              <span class="availability-badge-off">Actuellement occupé</span>
            <?php endif; ?>
          </div>

          
          <h5 style="font-weight:700;color:#0f172a;margin-bottom:10px">À propos</h5>
          <p style="color:#475569;line-height:1.75;white-space:pre-line">
            <?php echo e($craftsman->description ?? 'Cet artisan n\'a pas encore rédigé sa biographie.'); ?>

          </p>

          
          <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px;font-size:13px;color:#64748b;margin-top:16px">
            <div class="row g-2">
              <div class="col-sm-4">
                <strong style="color:#0f172a">ID Certification</strong><br>
                HRF-<?php echo e(str_pad($craftsman->id, 4, '0', STR_PAD_LEFT)); ?>

              </div>
              <div class="col-sm-4">
                <strong style="color:#0f172a">Zone d'intervention</strong><br>
                <?php echo e($craftsman->user->city ?? 'Maroc'); ?>

              </div>
              <div class="col-sm-4">
                <strong style="color:#0f172a">Expérience</strong><br>
                <?php echo e($craftsman->experience_years); ?> an(s)
              </div>
            </div>
          </div>
        </div>
      </div>

      
      <div class="card-premium">
        <div class="card-premium-title">
          <i class="bi bi-chat-left-text"></i> Avis clients (<?php echo e($reviews->count()); ?>)
        </div>

        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div style="background:#fafcfb;border:1px solid #e2e8f0;border-radius:12px;padding:18px;margin-bottom:12px">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span style="font-weight:700;font-size:14px;color:#059669">
                  <?php echo e($r->booking->client->name); ?>

                </span>
                <div style="margin-top:4px">
                  <?php for($i=1;$i<=5;$i++): ?>
                    <i class="bi bi-star<?php echo e($i <= $r->rating ? '-fill' : ''); ?>" style="color:#f59e0b;font-size:14px"></i>
                  <?php endfor; ?>
                </div>
              </div>
              <span style="font-size:12px;color:#94a3b8"><?php echo e($r->created_at->format('d/m/Y')); ?></span>
            </div>
            <?php if($r->comment): ?>
              <p style="color:#475569;font-size:14px;line-height:1.6;margin-top:10px;margin-bottom:0;font-style:italic">
                "<?php echo e($r->comment); ?>"
              </p>
            <?php endif; ?>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="empty-state">
            <i class="bi bi-chat-square-text"></i>
            <h5>Pas encore d'avis</h5>
            <p>Soyez le premier à laisser un avis sur cet artisan.</p>
          </div>
        <?php endif; ?>
      </div>

    </div>

    
    <div class="col-lg-4">
      <div class="card-premium" style="position:sticky;top:88px">
        <div class="card-premium-title"><i class="bi bi-calendar-check"></i> Réserver cet artisan</div>
        <p style="font-size:14px;color:#64748b;margin-bottom:20px">
          Discutez des détails ou envoyez directement une demande de réservation.
        </p>
        <?php if(auth()->guard()->check()): ?>
          <?php if(auth()->user()->isClient()): ?>
            <div class="d-grid gap-2">
              <a href="<?php echo e(route('client.inbox.chat', $craftsman->user->id)); ?>"
                 class="btn-harfa-ghost justify-content-center">
                <i class="bi bi-chat-dots"></i> Envoyer un message
              </a>
              <a href="<?php echo e(route('client.book.form', $craftsman)); ?>"
                 class="btn-harfa justify-content-center">
                <i class="bi bi-calendar-plus"></i> Réserver maintenant
              </a>
            </div>
          <?php elseif(auth()->user()->isCraftsman()): ?>
            <div class="alert alert-warning" style="font-size:13px">
              <i class="bi bi-info-circle me-2"></i>
              Seuls les comptes clients peuvent effectuer une réservation.
            </div>
          <?php endif; ?>
        <?php else: ?>
          <div class="d-grid">
            <a href="<?php echo e(route('login', ['redirect' => request()->fullUrl()])); ?>" class="btn-harfa justify-content-center">
              <i class="bi bi-box-arrow-in-right"></i> Se connecter pour réserver
            </a>
          </div>
          <p style="font-size:12px;color:#94a3b8;text-align:center;margin-top:12px">
            Pas de compte ? <a href="<?php echo e(route('register')); ?>" style="color:#059669">S'inscrire gratuitement</a>
          </p>
        <?php endif; ?>

        
        <?php if(auth()->guard()->check()): ?>
          <?php if($craftsman->user->phone): ?>
            <div style="border-top:1px solid #e2e8f0;margin-top:16px;padding-top:16px;font-size:14px;color:#64748b">
              <i class="bi bi-telephone me-2 text-green"></i><?php echo e($craftsman->user->phone); ?>

            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>

  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\harfa\resources\views/craftsmen/show.blade.php ENDPATH**/ ?>