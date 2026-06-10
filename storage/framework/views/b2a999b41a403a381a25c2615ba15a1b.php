<?php $__env->startSection('title', 'Travaux terminés — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-craftsman', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Travaux terminés</h1>
        <p class="portal-subtitle">Historique de vos missions accomplies</p>
      </div>
      <div style="background:#f0fdf4;border:1.5px solid rgba(5,150,105,.2);border-radius:12px;padding:12px 20px;text-align:center">
        <div style="font-size:12px;color:#64748b">Total accompli</div>
        <div style="font-size:24px;font-weight:800;color:#059669"><?php echo e($completedBookings->total()); ?> missions</div>
      </div>
    </div>

    <div class="card-premium" style="padding:0;overflow:hidden">
      <div style="padding:20px 24px;border-bottom:1px solid #e2e8f0">
        <h5 style="font-weight:700;margin:0">Historique des missions</h5>
      </div>
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Date</th>
            <th>Client</th>
            <th>Description</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $completedBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td style="font-size:13px"><?php echo e($b->booking_date->format('d/m/Y')); ?></td>
              <td style="font-size:13px;font-weight:600">
                <?php echo e($b->client->name); ?>

                <?php if($b->client->phone): ?>
                  <div style="font-size:12px;color:#94a3b8;font-weight:400"><?php echo e($b->client->phone); ?></div>
                <?php endif; ?>
              </td>
              <td style="font-size:13px;color:#475569;max-width:220px">
                <?php echo e(Str::limit($b->description, 60)); ?>

              </td>
              <td><span class="badge-status status-done">Terminé</span></td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="4">
                <div class="empty-state">
                  <i class="bi bi-calendar-check"></i>
                  <h5>Aucune mission terminée</h5>
                  <p>Marquez vos réservations comme "done" pour les voir apparaître ici.</p>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if($completedBookings->hasPages()): ?>
      <div class="d-flex justify-content-center mt-4"><?php echo e($completedBookings->links()); ?></div>
    <?php endif; ?>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\harfa\resources\views/craftsman/earnings.blade.php ENDPATH**/ ?>