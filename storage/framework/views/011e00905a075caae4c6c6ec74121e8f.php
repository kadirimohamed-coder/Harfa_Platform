<?php $__env->startSection('title', 'À propos — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">

  
  <div class="text-center mb-5" data-aos="fade-down">
    <span style="background:#d1fae5;color:#059669;padding:5px 18px;border-radius:999px;font-size:13px;font-weight:700">
      Notre histoire
    </span>
    <h1 style="font-size:clamp(28px,5vw,48px);font-weight:800;color:#0f172a;margin:20px 0 16px;line-height:1.15">
      Harfa.ma, la confiance<br>au cœur du Maroc
    </h1>
    <p style="font-size:17px;color:#64748b;max-width:640px;margin:0 auto;line-height:1.7">
      Nous connectons les particuliers et entreprises avec des artisans qualifiés,
      vérifiés et de confiance partout au Maroc.
    </p>
  </div>

  
  <div class="how-section mb-5" data-aos="fade-up">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span style="background:#d1fae5;color:#059669;padding:4px 14px;border-radius:999px;font-size:12px;font-weight:700">Notre mission</span>
        <h2 style="font-size:28px;font-weight:800;color:#0f172a;margin:16px 0 16px;line-height:1.2">
          Rendre chaque artisan facilement accessible
        </h2>
        <p style="color:#475569;font-size:15px;line-height:1.75;margin-bottom:20px">
          En 2023, nous avons constaté qu'il était difficile pour les particuliers de trouver
          un artisan fiable rapidement. Harfa.ma est né de cette frustration : une plateforme
          simple, transparente et locale pour valoriser le savoir-faire marocain.
        </p>
        <ul style="list-style:none;padding:0;margin:0">
          <?php $__currentLoopData = ['Artisans vérifiés par notre équipe','Avis authentiques de vraies personnes','Réservation simple et rapide','Support en arabe et en français']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="d-flex align-items-center gap-3 mb-3">
              <div style="width:28px;height:28px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <i class="bi bi-check" style="color:#059669;font-size:14px;font-weight:900"></i>
              </div>
              <span style="font-size:15px;color:#334155"><?php echo e($pt); ?></span>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="col-lg-6">
        <div class="row g-3">
          <?php $__currentLoopData = [
            ['500+','Artisans vérifiés','#d1fae5','#059669','bi-person-check'],
            ['2K+','Clients satisfaits','#dbeafe','#2563eb','bi-people'],
            ['4.8★','Note moyenne','#fef3c7','#d97706','bi-star-fill'],
            ['6','Villes couvertes','#ede9fe','#7c3aed','bi-geo-alt'],
          ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6">
              <div style="background:white;border:1.5px solid #e2e8f0;border-radius:16px;padding:24px;text-align:center">
                <div style="width:48px;height:48px;background:<?php echo e($s[2]); ?>;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:<?php echo e($s[3]); ?>;margin:0 auto 12px">
                  <i class="bi <?php echo e($s[4]); ?>"></i>
                </div>
                <div style="font-size:28px;font-weight:800;color:<?php echo e($s[3]); ?>;line-height:1"><?php echo e($s[0]); ?></div>
                <div style="font-size:13px;color:#64748b;margin-top:4px"><?php echo e($s[1]); ?></div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </div>
  </div>

  
  <section class="mb-5" data-aos="fade-up">
    <div class="text-center mb-4">
      <h2 class="section-title">Nos valeurs</h2>
      <p class="section-subtitle">Ce qui nous guide au quotidien</p>
    </div>
    <div class="row g-4">
      <?php $__currentLoopData = [
        ['bi-shield-check','Confiance','Chaque artisan est vérifié par notre équipe avant d\'apparaître sur la plateforme.','#d1fae5','#059669'],
        ['bi-star','Excellence','Nous valorisons le travail bien fait et l\'artisanat de qualité marocain.','#fef3c7','#d97706'],
        ['bi-people','Communauté','Harfa.ma construit des liens durables entre clients et artisans locaux.','#dbeafe','#2563eb'],
        ['bi-lightning','Simplicité','Une expérience simple, rapide et sans friction pour tous les utilisateurs.','#ede9fe','#7c3aed'],
      ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 80); ?>">
          <div class="step-card h-100">
            <div class="step-icon" style="background:<?php echo e($v[3]); ?>;color:<?php echo e($v[4]); ?>">
              <i class="bi <?php echo e($v[0]); ?>"></i>
            </div>
            <h5><?php echo e($v[1]); ?></h5>
            <p><?php echo e($v[2]); ?></p>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>

  
  <section class="mb-5" data-aos="fade-up">
    <div class="text-center mb-4">
      <h2 class="section-title">Notre équipe</h2>
      <p class="section-subtitle">Des passionnés au service des artisans marocains</p>
    </div>
    <div class="row g-4 justify-content-center">
      <?php $__currentLoopData = [
        ['Youssef','Fondateur & CEO','#059669'],
        ['Sara','Responsable Qualité','#2563eb'],
        ['Omar','Développeur Lead','#7c3aed'],
        ['Imane','Relations Artisans','#d97706'],
      ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 60); ?>">
          <div style="background:white;border:1.5px solid #e2e8f0;border-radius:16px;padding:28px 20px;text-align:center;transition:.3s"
               onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(0,0,0,.08)'"
               onmouseout="this.style.transform='none';this.style.boxShadow='none'">
            <div style="width:72px;height:72px;background:linear-gradient(135deg,<?php echo e($t[2]); ?>,<?php echo e($t[2]); ?>cc);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:800;color:white;margin:0 auto 14px">
              <?php echo e(strtoupper(substr($t[0],0,2))); ?>

            </div>
            <div style="font-weight:700;font-size:15px;color:#0f172a;margin-bottom:4px"><?php echo e($t[0]); ?></div>
            <div style="font-size:12px;color:#64748b"><?php echo e($t[1]); ?></div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>

  
  <div class="cta-section text-center" data-aos="fade-up">
    <span class="cta-badge">Rejoignez-nous</span>
    <h3>Prêt à rejoindre la communauté Harfa.ma ?</h3>
    <p style="max-width:500px;margin-left:auto;margin-right:auto">
      Que vous soyez client à la recherche d'un artisan ou un artisan souhaitant développer son activité.
    </p>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <a href="<?php echo e(route('register')); ?>" class="btn-harfa">
        <i class="bi bi-person-plus"></i> Créer un compte gratuit
      </a>
      <a href="<?php echo e(route('craftsmen.index')); ?>"
         style="background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.3);color:white;padding:9px 20px;border-radius:8px;font-weight:600;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:6px">
        Explorer les artisans
      </a>
    </div>
  </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/about.blade.php ENDPATH**/ ?>