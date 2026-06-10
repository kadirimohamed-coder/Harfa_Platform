<?php $__env->startSection('title', 'Parcourir les artisans — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">

  
  <div class="section-header mb-4">
    <div>
      <h2 class="section-title">Artisans disponibles</h2>
      <p class="section-subtitle"><?php echo e($craftsmen->total()); ?> artisan(s) trouvé(s)</p>
    </div>
  </div>

  
  <form action="<?php echo e(route('craftsmen.index')); ?>" method="GET" class="card-premium mb-4" style="padding:20px 24px">
    <div class="row g-3 align-items-end">
      <div class="col-md-4">
        <label class="form-label">Recherche</label>
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0" style="border:1.5px solid #e2e8f0">
            <i class="bi bi-search text-muted"></i>
          </span>
          <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                 class="form-control border-start-0" placeholder="Nom, ville, service...">
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label">Catégorie</label>
        <select name="category" class="form-select">
          <option value="">Toutes les catégories</option>
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($c->id); ?>" <?php echo e(request('category') == $c->id ? 'selected' : ''); ?>>
              <?php echo e($c->name); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Ville</label>
        <input type="text" name="city" value="<?php echo e(request('city')); ?>"
               class="form-control" placeholder="Casablanca, Rabat...">
      </div>
      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn-harfa flex-grow-1 justify-content-center">
          <i class="bi bi-search"></i>
        </button>
        <?php if(request()->hasAny(['search','city','category'])): ?>
          <a href="<?php echo e(route('craftsmen.index')); ?>" class="btn-harfa-outline" style="padding:9px 12px">
            <i class="bi bi-x"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </form>

  
  <div class="row g-4">
    <?php $__empty_1 = true; $__currentLoopData = $craftsmen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="<?php echo e(($loop->index % 3) * 80); ?>">
        <a href="<?php echo e(route('craftsmen.show', $cm->id)); ?>" class="text-decoration-none">
          <div class="artisan-card">
            <div class="artisan-cover">
              <?php if($cm->availability_status): ?>
                <span class="availability-badge position-absolute" style="top:10px;right:10px;font-size:11px">Disponible</span>
              <?php else: ?>
                <span class="availability-badge-off position-absolute" style="top:10px;right:10px;font-size:11px">Occupé</span>
              <?php endif; ?>
            </div>
            <div class="artisan-body">
              <div class="artisan-avatar">
                <?php echo e(strtoupper(substr($cm->user->name, 0, 2))); ?>

              </div>
              <h5 class="mb-1 fw-bold" style="font-size:15px;color:#0f172a"><?php echo e($cm->user->name); ?></h5>
              <p class="mb-2" style="font-size:12px;color:#64748b">
                <?php if($cm->user->city): ?> <?php echo e($cm->user->city); ?> <?php endif; ?>
                <?php if($cm->categories->count()): ?> · <?php echo e($cm->categories->first()->name); ?> <?php endif; ?>
              </p>

              
              <div class="mb-2 d-flex justify-content-center gap-1 align-items-center">
                <?php for($i = 1; $i <= 5; $i++): ?>
                  <i class="bi bi-star<?php echo e($i <= round($cm->reviews_avg_rating ?? 0) ? '-fill text-warning' : ' text-muted'); ?>" style="font-size:13px"></i>
                <?php endfor; ?>
                <span style="font-size:12px;color:#64748b;margin-left:4px">
                  <?php echo e(number_format($cm->reviews_avg_rating ?? 0, 1)); ?>

                </span>
              </div>

              
              <?php if($cm->categories->count()): ?>
                <div class="d-flex flex-wrap gap-1 justify-content-center mb-3">
                  <?php $__currentLoopData = $cm->categories->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="badge-cat"><?php echo e($cat->name); ?></span>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </a>

        
        <?php if(auth()->guard()->check()): ?>
          <?php if(auth()->user()->isClient()): ?>
            <a href="<?php echo e(route('client.book.form', $cm)); ?>"
               class="btn-harfa w-100 justify-content-center mt-2" style="border-radius:0 0 16px 16px">
              <i class="bi bi-calendar-check"></i> Réserver
            </a>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="col-12">
        <div class="empty-state">
          <i class="bi bi-search"></i>
          <h5>Aucun artisan trouvé</h5>
          <p>Essayez d'élargir votre recherche ou de changer de catégorie.</p>
          <a href="<?php echo e(route('craftsmen.index')); ?>" class="btn-harfa">Voir tous les artisans</a>
        </div>
      </div>
    <?php endif; ?>
  </div>

  
  <?php if($craftsmen->hasPages()): ?>
    <div class="d-flex justify-content-center mt-5">
      <?php echo e($craftsmen->withQueryString()->links()); ?>

    </div>
  <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/craftsmen/index.blade.php ENDPATH**/ ?>