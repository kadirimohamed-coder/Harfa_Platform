<?php $__env->startSection('title', 'Mon profil artisan — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-craftsman', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content mb-5">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Mon profil artisan</h1>
        <p class="portal-subtitle">Ces informations sont visibles par tous les clients</p>
      </div>
      <a href="<?php echo e(route('craftsmen.show', $craftsman)); ?>" class="btn-harfa-ghost" target="_blank">
        <i class="bi bi-eye"></i> Voir mon profil public
      </a>
    </div>
    <div class="mb-4 p-3 d-flex align-items-start gap-3"
        style="background:#fefce8;border:1.5px solid #fde047;border-radius:12px">
      <i class="bi bi-exclamation-triangle-fill" style="color:#d97706;font-size:18px;flex-shrink:0;margin-top:2px"></i>
      <div style="font-size:13px;color:#713f12;line-height:1.6">
        <strong>Vérifiez votre numéro de téléphone</strong> — il sera visible aux clients après confirmation de réservation.<br>
        <span dir="rtl" style="font-size:12px;color:#92400e">
          
          ✔ تأكد من صحة رقم هاتفك — سيحصل العميل على هذا الرقم فور تأكيد الحجز.

        </span>
      </div>
    </div>

    <form method="POST" action="<?php echo e(route('craftsman.profile.update')); ?>" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>

      <div class="row g-4">

        
        <div class="col-lg-8">
          <div class="card-premium">
            <div class="card-premium-title"><i class="bi bi-person-circle"></i> Informations personnelles</div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nom complet</label>
                <input class="form-control" name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">
                  <i class="bi bi-telephone me-1 text-success"></i>
                  Téléphone <small class="text-muted">(visible aux clients)</small>
                </label>
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

          <div class="card-premium">
            <div class="card-premium-title"><i class="bi bi-person-badge"></i> Informations professionnelles</div>

            <div class="mb-3">
              <label class="form-label">Description / Biographie</label>
              <textarea class="form-control" name="description" rows="5"
                placeholder="Décrivez votre expérience, vos spécialités, vos méthodes de travail...
                   عرف براسك، شحال عندك من عام فالخبرة، وشنو الخدمات اللي كتقدم للزبناء..."
                ><?php echo e(old('description', $craftsman->description)); ?></textarea>
                <small class="text-muted">
                  يمكنك الكتابة بالدارجة أو بالعربية أو بالفرنسية حسب ما تفضل.
              </small>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Années d'expérience</label>
                <input class="form-control" type="number" name="experience_years" min="0" max="50"
                       value="<?php echo e(old('experience_years', $craftsman->experience_years)); ?>" placeholder="Ex: 5">
              </div>
            </div>

            <div class="mt-3">
                <label class="form-label">
                  <i class="bi bi-patch-check me-1 text-success"></i>
                  Certification / Diplôme
                </label>
                <?php if($craftsman->certification): ?>
                  <div class="d-flex align-items-center gap-2 mb-2 p-2"
                      style="background:#f0fdf4;border:1px solid #d1fae5;border-radius:8px">
                    <i class="bi bi-file-earmark-pdf text-success fs-5"></i>
                    <span style="font-size:13px;color:#065f46">Certification déjà uploadée</span>
                    <a href="<?php echo e(asset('storage/'.$craftsman->certification)); ?>"
                      target="_blank" class="ms-auto btn-harfa-ghost" style="padding:4px 12px;font-size:12px">
                      <i class="bi bi-eye me-1"></i>Voir
                    </a>
                  </div>
                <?php endif; ?>
                <input type="file" class="form-control" name="certification_file"
                      accept=".pdf,.jpg,.jpeg,.png">
                      <small class="text-muted">
                        Ce document est facultatif. Il permet de renforcer la confiance des clients et de valoriser votre profil.
                        <br>
                        <span dir="rtl">هذا الملف اختياري ويساعد على زيادة ثقة العملاء في خدماتك.</span>
                        <br>
                        (PDF ou image – max 5 Mo)
                      </small>
            </div>

            
            <div class="mt-3 p-3" style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;font-size:13px;color:#166534">
              <i class="bi bi-info-circle-fill me-2"></i>
              Le tarif est convenu directement avec le client après prise de contact — par téléphone ou via le chat de la plateforme.
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\harfa\resources\views/craftsman/profile.blade.php ENDPATH**/ ?>