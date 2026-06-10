<?php $__env->startSection('title', 'Trouver du travail — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">

  
  <div style="background:linear-gradient(135deg,#1e3a5f 0%,#1d4ed8 100%);border-radius:20px;padding:56px 40px;color:white;margin-bottom:40px;position:relative;overflow:hidden">
    <div style="position:absolute;top:-60px;right:-60px;width:280px;height:280px;background:radial-gradient(circle,rgba(255,255,255,.07) 0%,transparent 70%)"></div>
    <div class="row align-items-center">
      <div class="col-lg-7">
        <span style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);border-radius:999px;padding:5px 16px;font-size:13px;font-weight:600;display:inline-block;margin-bottom:20px">
          <i class="bi bi-briefcase me-2"></i>Espace artisans
        </span>
        <h1 style="font-size:clamp(28px,4vw,44px);font-weight:800;line-height:1.15;margin-bottom:16px;color:white">
          Trouvez des chantiers<br>qui vous correspondent
        </h1>
        <p style="font-size:16px;color:rgba(255,255,255,.8);line-height:1.6;margin-bottom:32px">
          Des clients postent leurs besoins chaque jour. Postulez avec vos points et développez votre clientèle.
        </p>
        <?php if(auth()->guard()->guest()): ?>
          <div class="d-flex gap-3">
            <a href="<?php echo e(route('register', ['role'=>'craftsman'])); ?>" class="btn-harfa">
              <i class="bi bi-person-plus"></i> Créer mon profil artisan
            </a>
            <a href="<?php echo e(route('login')); ?>" style="color:rgba(255,255,255,.85);font-size:14px;font-weight:600;text-decoration:none;padding:10px 0;display:inline-flex;align-items:center;gap:6px">
              Déjà inscrit ? <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-lg-5 d-none d-lg-flex justify-content-center">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;max-width:280px">
          <?php $__currentLoopData = ['Plomberie','Électricité','Peinture','Menuiserie']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:16px;text-align:center;backdrop-filter:blur(8px)">
              <i class="bi bi-tools" style="font-size:24px;color:rgba(255,255,255,.8);display:block;margin-bottom:8px"></i>
              <div style="font-size:13px;color:rgba(255,255,255,.8);font-weight:600"><?php echo e($s); ?></div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </div>
  </div>

  
  <form action="<?php echo e(route('find-work')); ?>" method="GET" class="card-premium mb-5" style="padding:20px 24px">
    <div class="row g-3 align-items-end">
      <div class="col-md-4">
        <label class="form-label">Mot-clé</label>
        <input class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Plombier, peinture...">
      </div>
      <div class="col-md-3">
        <label class="form-label">Catégorie</label>
        <select class="form-select" name="category">
          <option value="">Toutes</option>
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($c->id); ?>" <?php echo e(request('category') == $c->id ? 'selected' : ''); ?>><?php echo e($c->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Ville</label>
        <input class="form-control" name="city" value="<?php echo e(request('city')); ?>" placeholder="Casablanca">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn-harfa w-100 justify-content-center">
          <i class="bi bi-search"></i> Filtrer
        </button>
      </div>
    </div>
  </form>

  
  <div class="section-header mb-4">
    <div>
      <h2 class="section-title">Offres disponibles</h2>
      <p class="section-subtitle"><?php echo e($gigs->total()); ?> offre(s) publiée(s)</p>
    </div>
  </div>

  <div class="row g-4">
    <?php $__empty_1 = true; $__currentLoopData = $gigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?php echo e(($loop->index % 2) * 60); ?>">
        <div class="card-modern" style="padding:24px">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="d-flex align-items-center gap-3">
              <div style="width:48px;height:48px;background:linear-gradient(135deg,#1e3a5f,#1d4ed8);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <i class="bi <?php echo e($gig->category->icon ?? 'bi-briefcase'); ?>" style="color:white;font-size:20px"></i>
              </div>
              <div>
                <h5 style="font-size:15px;font-weight:700;color:#0f172a;margin-bottom:2px"><?php echo e($gig->title); ?></h5>
                <span class="badge-cat"><?php echo e($gig->category->name); ?></span>
              </div>
            </div>
            <span class="badge-status status-open" style="white-space:nowrap">Ouverte</span>
          </div>

          <p style="font-size:14px;color:#475569;line-height:1.6;margin-bottom:16px">
            <?php echo e(Str::limit($gig->description, 120)); ?>

          </p>

          <div class="d-flex flex-wrap gap-3 mb-4" style="font-size:13px;color:#64748b">
            <span><i class="bi bi-geo-alt me-1" style="color:#059669"></i><?php echo e($gig->city); ?></span>
            <?php if($gig->deadline): ?>
              <span><i class="bi bi-calendar me-1" style="color:#059669"></i><?php echo e(\Carbon\Carbon::parse($gig->deadline)->format('d/m/Y')); ?></span>
            <?php endif; ?>
            <span><i class="bi bi-people me-1" style="color:#059669"></i><?php echo e($gig->applications->count()); ?> candidature(s)</span>
            <span><i class="bi bi-clock me-1" style="color:#94a3b8"></i><?php echo e($gig->created_at->diffForHumans()); ?></span>
          </div>

          <div class="d-flex gap-2">
            <?php if(auth()->guard()->check()): ?>
              <?php if(auth()->user()->isCraftsman()): ?>
                <?php if($gig->applications->where('craftsman_id', auth()->user()->craftsman->id)->count()): ?>
                  <span class="btn-harfa-ghost" style="pointer-events:none;opacity:.7">
                    <i class="bi bi-check"></i> Déjà postulé
                  </span>
                <?php else: ?>
                  <form method="POST" action="<?php echo e(route('craftsman.gigs.apply', $gig)); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-harfa" style="font-size:13px;padding:9px 18px">
                      <i class="bi bi-send"></i> Postuler (5 pts)
                    </button>
                  </form>
                <?php endif; ?>
              <?php endif; ?>
            <?php else: ?>
              <a href="<?php echo e(route('login')); ?>" class="btn-harfa">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter pour postuler
              </a>
            <?php endif; ?>
            <a href="<?php echo e(route('craftsmen.show', $gig->client_user_id ?? 1)); ?>"
               class="btn-harfa-ghost" style="font-size:13px;padding:9px 14px">
              <i class="bi bi-info-circle"></i>
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="col-12">
        <div class="empty-state">
          <i class="bi bi-briefcase"></i>
          <h5>Aucune offre disponible</h5>
          <p>De nouvelles offres sont publiées quotidiennement. Revenez bientôt ou élargissez vos critères.</p>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <?php if($gigs->hasPages()): ?>
    <div class="d-flex justify-content-center mt-5"><?php echo e($gigs->withQueryString()->links()); ?></div>
  <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\harfa\resources\views/find-work.blade.php ENDPATH**/ ?>