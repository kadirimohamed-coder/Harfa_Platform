<?php $__env->startSection('title', 'Artisans — Admin'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Gestion des artisans</h1>
        <p class="portal-subtitle">Validez et gérez les profils professionnels</p>
      </div>
    </div>

    <div class="card-premium" style="padding:0;overflow:hidden">
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Artisan</th>
            <th>Catégories</th>
            <th>Note</th>
            <th>Réservations</th>
            <th>Disponible</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $craftsmen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#047857,#10b981);color:white;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0">
                    <?php echo e(strtoupper(substr($cm->user->name,0,2))); ?>

                  </div>
                  <div>
                    <div style="font-weight:600;font-size:14px;color:#0f172a"><?php echo e($cm->user->name); ?></div>
                    <div style="font-size:12px;color:#64748b"><?php echo e($cm->user->city ?? '—'); ?></div>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-flex flex-wrap gap-1">
                  <?php $__currentLoopData = $cm->categories->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="badge-cat"><?php echo e($cat->name); ?></span>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php if($cm->categories->count() > 2): ?>
                    <span class="badge-cat">+<?php echo e($cm->categories->count()-2); ?></span>
                  <?php endif; ?>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center gap-1">
                  <i class="bi bi-star-fill" style="color:#f59e0b;font-size:12px"></i>
                  <span style="font-size:13px;font-weight:600"><?php echo e(number_format($cm->averageRating(),1)); ?></span>
                </div>
              </td>
              <td style="font-size:13px;font-weight:600"><?php echo e($cm->bookings->count()); ?></td>
              <td>
                <?php if($cm->availability_status): ?>
                  <span class="availability-badge" style="font-size:11px">Oui</span>
                <?php else: ?>
                  <span class="availability-badge-off" style="font-size:11px">Non</span>
                <?php endif; ?>
              </td>
              <td>
                <span class="badge-status status-<?php echo e($cm->user->status === 'active' ? 'active' : 'inactive'); ?>">
                  <?php echo e($cm->user->status === 'active' ? 'Actif' : 'Inactif'); ?>

                </span>
              </td>
              <td>
                <div class="d-flex gap-1">
                  <a href="<?php echo e(route('craftsmen.show', $cm)); ?>" class="btn-harfa-ghost" style="font-size:12px;padding:5px 10px" target="_blank">
                    <i class="bi bi-eye"></i>
                  </a>
                  <form method="POST" action="<?php echo e(route('admin.craftsmen.toggle', $cm)); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-harfa-ghost" style="font-size:12px;padding:5px 10px">
                      <i class="bi bi-toggle-on"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7"><div class="empty-state"><i class="bi bi-person-check"></i><h5>Aucun artisan</h5></div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if($craftsmen->hasPages()): ?>
      <div class="d-flex justify-content-center mt-4"><?php echo e($craftsmen->links()); ?></div>
    <?php endif; ?>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/admin/craftsmen.blade.php ENDPATH**/ ?>