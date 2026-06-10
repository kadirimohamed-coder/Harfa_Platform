<?php $__env->startSection('title', 'Mon profil artisan — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-craftsman', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Mon profil artisan</h1>
        <p class="portal-subtitle">Ces informations sont visibles par tous les clients</p>
      </div>
      <a href="<?php echo e(route('craftsmen.show', $craftsman)); ?>" class="btn-harfa-ghost" target="_blank">
        <i class="bi bi-eye"></i> Voir mon profil public
      </a>
    </div>

    <form method="POST" action="<?php echo e(route('craftsman.profile.update')); ?>" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>

      <div class="row g-4">

        
        <div class="col-lg-8">
          <div class="card-premium">
            <div class="card-premium-title"><i class="bi bi-person-badge"></i> Informations professionnelles</div>

            <div class="mb-3">
              <label class="form-label">Description / Biographie</label>
              <textarea class="form-control" name="description" rows="5"
                placeholder="Décrivez votre expérience, vos spécialités, vos méthodes de travail..."><?php echo e(old('description', $craftsman->description)); ?></textarea>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Années d'expérience</label>
                <input class="form-control" type="number" name="experience_years" min="0" max="50"
                       value="<?php echo e(old('experience_years', $craftsman->experience_years)); ?>" placeholder="Ex: 5">
              </div>
            </div>

            <div class="mt-3">
              <label class="form-label">Certifications / Diplômes</label>
              <input class="form-control" name="certification"
                     value="<?php echo e(old('certification', $craftsman->certification)); ?>"
                     placeholder="Ex: Certificat de formation professionnelle OFPPT">
            </div>
          </div>

          <div class="card-premium">
            <div class="card-premium-title"><i class="bi bi-person-circle"></i> Informations personnelles</div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nom complet</label>
                <input class="form-control" name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Téléphone</label>
                <input class="form-control" name="phone" value="<?php echo e(old('phone', auth()->user()->phone)); ?>" placeholder="06 00 00 00 00">
              </div>
              <div class="col-md-6">
                <label class="form-label">Ville</label>
                <input class="form-control" name="city" value="<?php echo e(old('city', auth()->user()->city)); ?>" placeholder="Casablanca">
              </div>
              <div class="col-md-6">
                <label class="form-label">Adresse</label>
                <input class="form-control" name="address" value="<?php echo e(old('address', auth()->user()->address)); ?>" placeholder="123 Rue Mohammed V">
              </div>
            </div>
          </div>
        </div>

        
        <div class="col-lg-4">
          <div class="card-premium">
            <div class="card-premium-title"><i class="bi bi-toggle-on"></i> Disponibilité</div>
            <div class="d-flex align-items-center justify-content-between p-3"
                 style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px">
              <div>
                <div style="font-weight:600;font-size:14px">Je suis disponible</div>
                <div style="font-size:12px;color:#64748b">Activez pour recevoir des demandes</div>
              </div>
              <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" name="availability_status"
                       value="1" style="width:44px;height:24px;cursor:pointer"
                       <?php echo e($craftsman->availability_status ? 'checked' : ''); ?>>
              </div>
            </div>
          </div>

          <div class="card-premium">
            <div class="card-premium-title"><i class="bi bi-image"></i> Photo de profil</div>
            <?php if(auth()->user()->photo): ?>
              <div class="text-center mb-3">
                <img src="<?php echo e(asset('storage/'.auth()->user()->photo)); ?>"
                     class="rounded-circle" width="80" height="80" style="object-fit:cover;border:3px solid #d1fae5">
              </div>
            <?php else: ?>
              <div class="text-center mb-3">
                <div style="width:80px;height:80px;background:linear-gradient(135deg,#047857,#10b981);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:white;margin:0 auto">
                  <?php echo e(strtoupper(substr(auth()->user()->name,0,2))); ?>

                </div>
              </div>
            <?php endif; ?>
            <input type="file" class="form-control" name="photo" accept="image/*">
            <div style="font-size:12px;color:#94a3b8;margin-top:6px">JPG, PNG — max 2Mo</div>
          </div>

          <div class="card-premium">
            <div class="card-premium-title"><i class="bi bi-bar-chart"></i> Statistiques rapides</div>
            <div class="row g-2 text-center">
              <div class="col-6">
                <div style="background:#f0fdf4;border-radius:10px;padding:12px">
                  <div style="font-size:20px;font-weight:800;color:#059669"><?php echo e($craftsman->reviews->count()); ?></div>
                  <div style="font-size:11px;color:#64748b">Avis reçus</div>
                </div>
              </div>
              <div class="col-6">
                <div style="background:#dbeafe;border-radius:10px;padding:12px">
                  <div style="font-size:20px;font-weight:800;color:#2563eb"><?php echo e(number_format($craftsman->averageRating(),1)); ?></div>
                  <div style="font-size:11px;color:#64748b">Note moy.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="mt-2 d-flex justify-content-end gap-3">
        <a href="<?php echo e(route('craftsman.dashboard')); ?>" class="btn-harfa-outline">Annuler</a>
        <button type="submit" class="btn-harfa">
          <i class="bi bi-check-lg"></i> Enregistrer les modifications
        </button>
      </div>
    </form>

  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/craftsman/profile.blade.php ENDPATH**/ ?>