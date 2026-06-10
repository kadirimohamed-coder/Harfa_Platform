<?php $__env->startSection('title', 'Mes réservations — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>

<?php
$statusLabels = [
    'pending'   => 'En attente',
    'confirmed' => 'Acceptée',
    'done'      => 'Terminée',
    'cancelled' => 'Refusée',
];
$tabs = ['' => 'Toutes'] + $statusLabels;
?>

<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-craftsman', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Mes réservations</h1>
        <p class="portal-subtitle">Gérez les demandes de vos clients</p>
      </div>
    </div>

    
    <div class="d-flex gap-2 mb-4 flex-wrap">
      <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $active = ($currentStatus ?? '') === $val; ?>
        <a href="<?php echo e(route('craftsman.bookings', $val ? ['status' => $val] : [])); ?>"
           style="padding:7px 16px;border-radius:999px;font-size:13px;font-weight:600;text-decoration:none;
                  border:1.5px solid <?php echo e($active ? '#059669' : '#e2e8f0'); ?>;
                  background:<?php echo e($active ? '#d1fae5' : 'white'); ?>;
                  color:<?php echo e($active ? '#059669' : '#64748b'); ?>;
                  transition:.2s">
          <?php echo e($label); ?>

        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="card-premium" style="padding:0;overflow:hidden">
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Client</th>
            <th>Date prévue</th>
            <th>Description</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td>
                <div style="font-weight:600;color:#0f172a"><?php echo e($b->client->name); ?></div>
                <div style="font-size:12px;color:#64748b"><?php echo e($b->client->phone); ?></div>
              </td>
              <td style="font-size:13px">
                <?php echo e($b->booking_date->format('d/m/Y H:i')); ?>

              </td>
              <td style="max-width:200px;font-size:13px;color:#475569">
                <?php echo e(Str::limit($b->description, 60)); ?>

              </td>
              <td>
                <span class="badge-status status-<?php echo e($b->status); ?>">
                  <?php echo e($statusLabels[$b->status] ?? ucfirst($b->status)); ?>

                </span>
              </td>
              <td>
                

                <?php if($b->status === 'pending'): ?>
                  
                  <div class="d-flex gap-2 flex-wrap">
                    <form method="POST" action="<?php echo e(route('craftsman.bookings.update', $b)); ?>">
                      <?php echo csrf_field(); ?>
                      <input type="hidden" name="status" value="confirmed">
                      <button type="submit" class="btn-harfa" style="font-size:12px;padding:6px 14px;background:#059669;border-color:#059669">
                        <i class="bi bi-check-lg me-1"></i>Accepter
                      </button>
                    </form>
                    <form method="POST" action="<?php echo e(route('craftsman.bookings.update', $b)); ?>">
                      <?php echo csrf_field(); ?>
                      <input type="hidden" name="status" value="cancelled">
                      <button type="submit" class="btn-harfa" style="font-size:12px;padding:6px 14px;background:#dc2626;border-color:#dc2626"
                        onclick="return confirm('Refuser cette réservation ?')">
                        <i class="bi bi-x-lg me-1"></i>Refuser
                      </button>
                    </form>
                  </div>

                <?php elseif($b->status === 'confirmed'): ?>
                  
                  <form method="POST" action="<?php echo e(route('craftsman.bookings.update', $b)); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="status" value="done">
                    <button type="submit" class="btn-harfa" style="font-size:12px;padding:6px 14px;background:#7c3aed;border-color:#7c3aed"
                      onclick="return confirm('Marquer cette réservation comme terminée ?')">
                      <i class="bi bi-flag-fill me-1"></i>Terminer
                    </button>
                  </form>

                <?php elseif($b->status === 'done'): ?>
                  
                  <span style="font-size:12px;color:#7c3aed;font-weight:600">
                    <i class="bi bi-check2-all me-1"></i>Terminée
                  </span>

                <?php elseif($b->status === 'cancelled'): ?>
                  
                  <span style="font-size:12px;color:#dc2626;font-weight:600">
                    <i class="bi bi-x-circle me-1"></i>Refusée
                  </span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="5">
                <div class="empty-state">
                  <i class="bi bi-calendar-x"></i>
                  <h5>Aucune réservation<?php echo e($currentStatus ? ' pour ce statut' : ''); ?></h5>
                  <p>Complétez votre profil pour recevoir des demandes de clients.</p>
                </div>
              </td>
            </tr>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/craftsman/bookings.blade.php ENDPATH**/ ?>