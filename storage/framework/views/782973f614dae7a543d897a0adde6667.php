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
          Harfa.ma est une plateforme marocaine qui simplifie la mise en relation entre
          clients et artisans qualifiés. Notre objectif : valoriser le savoir-faire local
          et faciliter l'accès aux services artisanaux dans tout le Maroc.
        </p>
        <ul style="list-style:none;padding:0;margin:0">
          <?php $__currentLoopData = [
            'Artisans vérifiés par notre équipe',
            'Avis authentiques de vraies personnes',
            'Réservation simple et rapide',
            'Support en arabe et en français',
          ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
            ['🇲🇦','100% Marocain',   'Une plateforme locale, pensée pour le marché marocain.',          '#d1fae5','#059669'],
            ['🕐','Disponible 24/7',  'Trouvez et réservez un artisan à tout moment de la journée.',      '#dbeafe','#2563eb'],
            ['📅','Réservation simple','Quelques clics suffisent pour planifier votre intervention.',       '#fef3c7','#d97706'],
            ['💬','Communication directe','Contactez votre artisan directement par téléphone ou chat.',    '#ede9fe','#7c3aed'],
          ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6">
              <div style="background:white;border:1.5px solid #e2e8f0;border-radius:16px;padding:22px 16px;text-align:center;height:100%">
                <div style="font-size:32px;margin-bottom:10px"><?php echo e($s[0]); ?></div>
                <div style="font-size:15px;font-weight:700;color:#0f172a;margin-bottom:6px"><?php echo e($s[1]); ?></div>
                <div style="font-size:12px;color:#64748b;line-height:1.5"><?php echo e($s[2]); ?></div>
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
        ['bi-shield-check','Confiance',   'Chaque artisan est vérifié avant d\'apparaître sur la plateforme.',       '#d1fae5','#059669'],
        ['bi-star',        'Excellence',  'Nous valorisons le travail bien fait et l\'artisanat de qualité.',         '#fef3c7','#d97706'],
        ['bi-people',      'Communauté',  'Harfa.ma construit des liens durables entre clients et artisans locaux.',  '#dbeafe','#2563eb'],
        ['bi-lightning',   'Simplicité',  'Une expérience simple, rapide et sans friction pour tous.',                '#ede9fe','#7c3aed'],
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
      <h2 class="section-title">Pourquoi Harfa.ma ?</h2>
      <p class="section-subtitle">Ce qui nous distingue des autres plateformes</p>
    </div>
    <div class="row g-4">
      <?php $__currentLoopData = [
        ['bi-lock-fill',        'Réservation sécurisée',      'Vos données et vos réservations sont protégées à tout moment.',                                          '#d1fae5','#059669'],
        ['bi-chat-dots-fill',   'Chat intégré',               'Communiquez directement avec votre artisan via notre messagerie intégrée — sans partager votre numéro avant confirmation.', '#dbeafe','#2563eb'],
        ['bi-geo-alt-fill',     'Artisans locaux',            'Trouvez des artisans disponibles dans votre ville, pour des interventions rapides.',                      '#fef3c7','#d97706'],
        ['bi-star-fill',        'Avis vérifiés',              'Chaque avis est lié à une réservation réelle — aucun avis fictif sur notre plateforme.',                 '#ede9fe','#7c3aed'],
        ['bi-telephone-fill',   'Contact direct',             'Une fois la réservation confirmée, le numéro de l\'artisan est débloqué pour vous.',                      '#fce7f3','#be185d'],
        ['bi-award-fill',       'Artisans qualifiés',         'Nous vérifions les compétences et l\'expérience de chaque artisan avant validation de son profil.',       '#ecfdf5','#047857'],
      ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 60); ?>">
          <div class="why-card">
            <div class="why-icon" style="background:<?php echo e($r[3]); ?>;color:<?php echo e($r[4]); ?>">
              <i class="bi <?php echo e($r[0]); ?>"></i>
            </div>
            <div>
              <div class="why-title"><?php echo e($r[1]); ?></div>
              <div class="why-desc"><?php echo e($r[2]); ?></div>
            </div>
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
         style="background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.3);color:white;
                padding:9px 20px;border-radius:8px;font-weight:600;font-size:14px;
                text-decoration:none;display:inline-flex;align-items:center;gap:6px">
        Explorer les artisans
      </a>
    </div>
  </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\harfa\resources\views/about.blade.php ENDPATH**/ ?>