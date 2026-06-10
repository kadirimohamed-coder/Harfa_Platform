<?php $__env->startSection('title', 'Harfa.ma — Trouvez un artisan de confiance'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">

  
  <section class="hero-section text-center" data-aos="fade-down">

    <span class="hero-badge">
      <i class="bi bi-stars me-1"></i> Plateforme Artisans au Maroc
    </span>

    <h1 class="hero-title mt-3">
      Trouvez un artisan de <span>confiance</span><br>près de chez vous
    </h1>

    <p class="hero-subtitle">
      Plombiers, électriciens, peintres et bien plus — disponibles partout au Maroc
    </p>

    
    <form action="<?php echo e(route('craftsmen.index')); ?>" method="GET" class="hero-search-wrapper">

      
      <div class="hero-search-bar">
        <div class="search-main">
          <i class="bi bi-search"></i>
          <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                placeholder="Rechercher un artisan, service...">
        </div>
        <button type="submit" class="search-btn">
          <i class="bi bi-search"></i>
        </button>
      </div>

      
      <div class="hero-filters mt-3">
        <div class="filter-item">
          <i class="bi bi-grid"></i>
          <select name="category">
            <option value="">Tous les services</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($c->id); ?>" <?php echo e(request('category') == $c->id ? 'selected' : ''); ?>>
                <?php echo e($c->name); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="filter-item">
          <i class="bi bi-geo-alt"></i>
          <input type="text" name="city" value="<?php echo e(request('city')); ?>" placeholder="Ville">
        </div>
        <button type="submit" class="more-filters">
            Plus de filtres
        </button>
      </div>

    </form>

    
    <div class="hero-tags">
      <?php $__currentLoopData = $categories->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('categories.show', $c)); ?>" style="text-decoration:none">
          <span><?php echo e($c->name); ?></span>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    

  </section>

  
  <section class="mb-5" data-aos="fade-up">
    <div class="section-header">
      <div>
        <h2 class="section-title">Catégories populaires</h2>
        <p class="section-subtitle">Trouvez rapidement le bon artisan selon votre besoin</p>
      </div>
      <a href="<?php echo e(route('craftsmen.index')); ?>" class="section-link">
        Voir tout <i class="bi bi-arrow-right"></i>
      </a>
    </div>
    <div class="row g-3">
      <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-6 col-md-3 col-lg-2" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 60); ?>">
          <a href="<?php echo e(route('categories.show', $c)); ?>" class="category-card">
            <div class="cat-icon">
              <i class="bi <?php echo e($c->icon ?? 'bi-tools'); ?>"></i>
            </div>
            <h5><?php echo e($c->name); ?></h5>
            <span><?php echo e($c->craftsmen_count ?? ''); ?> artisans</span>
          </a>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>

  
  <section class="mb-5" data-aos="fade-up">
    <div class="section-header">
      <div>
        <h2 class="section-title">Artisans top-notés</h2>
        <p class="section-subtitle">Les meilleurs professionnels près de chez vous</p>
      </div>
      <a href="<?php echo e(route('craftsmen.index')); ?>" class="section-link">
        Voir tous <i class="bi bi-arrow-right"></i>
      </a>
    </div>
    <div class="row g-4">
      <?php $__empty_1 = true; $__currentLoopData = $top; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 80); ?>">
          <a href="<?php echo e(route('craftsmen.show', $cm)); ?>" class="text-decoration-none">
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
                <h5 class="mb-1 fw-bold" style="font-size:16px;color:#0f172a"><?php echo e($cm->user->name); ?></h5>
                <p class="mb-2" style="font-size:13px;color:#64748b">
                  <?php if($cm->categories->count()): ?>
                    <?php echo e($cm->categories->first()->name); ?>

                  <?php endif; ?>
                  <?php if($cm->user->city): ?> · <?php echo e($cm->user->city); ?> <?php endif; ?>
                </p>
                <div class="mb-2 d-flex justify-content-center align-items-center gap-1">
                  <?php for($i = 1; $i <= 5; $i++): ?>
                    <i class="bi bi-star<?php echo e($i <= round($cm->reviews_avg_rating ?? 0) ? '-fill text-warning' : ' text-muted'); ?>" style="font-size:14px"></i>
                  <?php endfor; ?>
                  <span style="font-size:12px;color:#64748b;margin-left:4px">
                    <?php echo e(number_format($cm->reviews_avg_rating ?? 0, 1)); ?>

                  </span>
                </div>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
          <div class="empty-state">
            <i class="bi bi-people"></i>
            <h5>Aucun artisan disponible</h5>
            <p>Revenez bientôt, de nouveaux artisans rejoignent la plateforme chaque jour.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>

  
  <section class="how-section" data-aos="fade-up">
    <div class="text-center mb-5">
      <span style="background:#d1fae5;color:#059669;padding:5px 16px;border-radius:999px;font-size:12px;font-weight:700">SIMPLE & RAPIDE</span>
      <h2 class="section-title mt-3">Comment ça marche ?</h2>
      <p class="section-subtitle">En 3 étapes, trouvez l'artisan qu'il vous faut</p>
    </div>
    <div class="row g-4 position-relative">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="step-card">
          <div class="step-num">1</div>
          <div class="step-icon"><i class="bi bi-search"></i></div>
          <h5>Recherchez un service</h5>
          <p>Plomberie, peinture, électricité — sélectionnez la catégorie qui correspond à votre besoin.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="step-card active">
          <div class="step-num">2</div>
          <div class="step-icon"><i class="bi bi-person-check"></i></div>
          <h5>Choisissez un artisan</h5>
          <p>Consultez les profils, les avis et choisissez l'artisan qui vous convient le mieux.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="step-card">
          <div class="step-num">3</div>
          <div class="step-icon"><i class="bi bi-calendar-check"></i></div>
          <h5>Réservez facilement</h5>
          <p>Choisissez la date, confirmez votre adresse — c'est tout ! Votre artisan se déplace.</p>
        </div>
      </div>
    </div>
  </section>

  
  <section class="cta-section" data-aos="fade-up">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <span class="cta-badge"><i class="bi bi-tools me-2"></i>Vous êtes artisan ?</span>
        <h3>Rejoignez Harfa.ma et développez votre clientèle</h3>
        <p>Créez votre profil gratuitement, recevez des demandes de réservation et gérez votre activité en toute simplicité.</p>
        <div class="d-flex gap-3 flex-wrap">
          <a href="<?php echo e(route('register', ['role' => 'craftsman'])); ?>" class="btn-harfa">
            <i class="bi bi-person-plus"></i> Créer mon profil artisan
          </a>
          <a href="<?php echo e(route('craftsmen.index')); ?>"
             style="background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.3);color:white;padding:9px 20px;border-radius:8px;font-weight:600;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:.2s">
            Voir les artisans
          </a>
        </div>
      </div>
      <div class="col-lg-4 text-center d-none d-lg-block">
        <div class="cta-icon-wrap">
          <i class="bi bi-tools"></i>
        </div>
      </div>
    </div>
  </section>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\Harfa_Platfomr_maroc\resources\views/home/index.blade.php ENDPATH**/ ?>