<?php $__env->startSection('title', 'Réservations — Admin'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Toutes les réservations</h1>
        <p class="portal-subtitle"><?php echo e($bookings->total()); ?> réservation(s) enregistrée(s)</p>
      </div>
    </div>

    
    <div class="d-flex gap-2 mb-4 flex-wrap">
      <?php $__currentLoopData = [''=>'Toutes','pending'=>'En attente','confirmed'=>'Confirmées','done'=>'Terminées','cancelled'=>'Annulées']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('admin.bookings', ['status' => $val])); ?>"
           style="padding:7px 16px;border-radius:999px;font-size:13px;font-weight:600;text-decoration:none;border:1.5px solid <?php echo e(request('status') === $val ? '#059669' : '#e2e8f0'); ?>;background:<?php echo e(request('status') === $val ? '#d1fae5' : 'white'); ?>;color:<?php echo e(request('status') === $val ? '#059669' : '#64748b'); ?>;transition:.2s">
          <?php echo e($label); ?>

        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="card-premium" style="padding:0;overflow:hidden">
      <table class="table-harfa">
        <thead>
          <tr>
            <th>#</th>
            <th>Client</th>
            <th>Artisan</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td style="color:#94a3b8;font-size:13px"><?php echo e($b->id); ?></td>
              <td>
                <div style="font-weight:600;font-size:13px;color:#0f172a"><?php echo e($b->client->name); ?></div>
                <div style="font-size:12px;color:#64748b"><?php echo e($b->client->phone); ?></div>
              </td>
              <td>
                <div style="font-weight:600;font-size:13px;color:#0f172a"><?php echo e($b->craftsman->user->name); ?></div>
                <div style="font-size:12px;color:#64748b"><?php echo e($b->craftsman->user->city); ?></div>
              </td>
              <td style="font-size:13px;color:#475569"><?php echo e($b->booking_date->format('d/m/Y H:i')); ?></td>
              <td><span class="badge-status status-<?php echo e($b->status); ?>"><?php echo e(ucfirst($b->status)); ?></span></td>
              <td>
                <form method="POST" action="<?php echo e(route('admin.bookings.update', $b)); ?>" class="d-flex gap-2">
                  <?php echo csrf_field(); ?>
                  <select name="status" class="form-select form-select-sm" style="width:auto">
                    <?php $__currentLoopData = ['pending','confirmed','done','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($s); ?>" <?php echo e($b->status === $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <button type="submit" class="btn-harfa" style="padding:5px 10px;font-size:12px">
                    <i class="bi bi-check"></i>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6"><div class="empty-state"><i class="bi bi-calendar-x"></i><h5>Aucune réservation</h5></div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if($bookings->hasPages()): ?>
      <div class="d-flex justify-content-center mt-4"><?php echo e($bookings->withQueryString()->links()); ?></div>
    <?php endif; ?>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/admin/bookings.blade.php ENDPATH**/ ?>