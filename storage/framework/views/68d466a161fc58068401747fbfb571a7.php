<?php $__env->startSection('title', 'Mon profil — Harfa.ma'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4" style="max-width:720px">

  <div class="profile-page">
    
    <div class="profile-hero d-flex align-items-center gap-4">
      <?php if($user->photo): ?>
        <img src="<?php echo e(asset('storage/'.$user->photo)); ?>"
            class="profile-big-avatar"
            style="object-fit:cover;padding:0;border:3px solid rgba(255,255,255,.3)"
            alt="<?php echo e($user->name); ?>">
      <?php else: ?>
        <div class="profile-big-avatar">
          <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

        </div>
      <?php endif; ?>
        <div>
          <h3><?php echo e($user->name); ?></h3>
          <p style="font-size:14px;color:rgba(255,255,255,.75);margin-bottom:8px">
            <?php echo e($user->email); ?>

            <?php if($user->city): ?>
              &nbsp;·&nbsp;<?php echo e($user->city); ?>

            <?php endif; ?>
          </p>
        <div class="d-flex align-items-center gap-2 flex-wrap">
          
          <span style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);
                      color:white;padding:3px 12px;border-radius:999px;font-size:12px;font-weight:600">
            <?php switch($user->role):
              case ('craftsman'): ?> Artisan      <?php break; ?>
              <?php case ('client'): ?>    Client       <?php break; ?>
              <?php case ('admin'): ?>     Administrateur <?php break; ?>
              <?php default: ?>           <?php echo e(ucfirst($user->role)); ?>

            <?php endswitch; ?>
          </span>
          
          <span class="badge-status status-<?php echo e($user->status ?? 'active'); ?>">
            <?php echo e(($user->status ?? 'active') === 'active' ? 'Actif' : 'Inactif'); ?>

          </span>
        </div>
      </div>
    </div>

    
    <div class="card-premium">
      <div class="card-premium-title">
        <i class="bi bi-person-gear"></i> Modifier mes informations
      </div>

      <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="row g-3">
          <div class="col-12">
            <label class="form-label">Nom complet</label>
            <input class="form-control" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Téléphone</label>
            <input class="form-control" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" placeholder="06 00 00 00 00">
          </div>
          <div class="col-md-6">
            <label class="form-label">Ville</label>
            <input class="form-control" name="city" value="<?php echo e(old('city', $user->city)); ?>" placeholder="Casablanca">
          </div>
          <div class="col-12">
            <label class="form-label">Adresse complète</label>
            <input class="form-control" name="address" value="<?php echo e(old('address', $user->address)); ?>" placeholder="123 Rue Mohammed V">
          </div>
          <div class="col-12">
            <label class="form-label">Photo de profil</label>
            <?php if($user->photo): ?>
              <div class="mb-2">
                <img src="<?php echo e(asset('storage/'.$user->photo)); ?>" class="rounded-circle" width="60" height="60" style="object-fit:cover">
              </div>
            <?php endif; ?>
            <input type="file" class="form-control" name="photo" accept="image/*">
          </div>
        </div>

        <div class="mt-4">
          <button type="submit" class="btn-harfa">
            <i class="bi bi-check-lg"></i> Enregistrer les modifications
          </button>
        </div>
      </form>
    </div>

    
    <?php if(auth()->user()->isCraftsman()): ?>
      <div class="card-premium">
        <div class="card-premium-title"><i class="bi bi-link-45deg"></i> Liens rapides</div>
        <div class="d-flex gap-3 flex-wrap">
          <a href="<?php echo e(route('craftsman.dashboard')); ?>" class="btn-harfa-ghost">
            <i class="bi bi-grid"></i> Mon tableau de bord
          </a>
          <a href="<?php echo e(route('craftsman.profile')); ?>" class="btn-harfa-ghost">
            <i class="bi bi-person-badge"></i> Profil artisan
          </a>
        </div>
      </div>
    <?php elseif(auth()->user()->isClient()): ?>
      <div class="card-premium">
        <div class="card-premium-title"><i class="bi bi-link-45deg"></i> Liens rapides</div>
        <div class="d-flex gap-3 flex-wrap">
          <a href="<?php echo e(route('client.dashboard')); ?>" class="btn-harfa-ghost">
            <i class="bi bi-grid"></i> Mon tableau de bord
          </a>
          <a href="<?php echo e(route('client.bookings')); ?>" class="btn-harfa-ghost">
            <i class="bi bi-calendar-check"></i> Mes réservations
          </a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\Harfa_Platfomr_maroc\resources\views/auth/profile.blade.php ENDPATH**/ ?>