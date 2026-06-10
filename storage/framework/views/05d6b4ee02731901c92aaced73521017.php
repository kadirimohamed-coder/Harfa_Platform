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
  <?php echo $__env->make('partials.sidebar-client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Mes réservations</h1>
        <p class="portal-subtitle">Suivez l'avancement de toutes vos réservations</p>
      </div>
      <a href="<?php echo e(route('craftsmen.index')); ?>" class="btn-harfa">
        <i class="bi bi-plus"></i> Nouvelle réservation
      </a>
    </div>

    
    <div class="d-flex gap-2 mb-4 flex-wrap">
      <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $active = ($currentStatus ?? '') === $val; ?>
        <a href="<?php echo e(route('client.bookings', $val ? ['status' => $val] : [])); ?>"
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
            <th>Artisan</th>
            <th>Date</th>
            <th>Description</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td>
                <div style="font-weight:600;color:#0f172a"><?php echo e($b->craftsman->user->name); ?></div>
                <div style="font-size:12px;color:#64748b"><?php echo e($b->craftsman->user->city); ?></div>
              </td>
              <td style="font-size:13px">
                <?php echo e($b->booking_date->format('d/m/Y')); ?><br>
                <span style="color:#94a3b8"><?php echo e($b->booking_date->format('H:i')); ?></span>
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
                <?php if($b->status === 'done' && !$b->review): ?>
                  <a href="<?php echo e(route('client.review.form', $b)); ?>" class="btn-harfa" style="font-size:12px;padding:6px 12px">
                    <i class="bi bi-star"></i> Évaluer
                  </a>
                <?php elseif($b->review): ?>
                  <span style="font-size:12px;color:#059669;font-weight:600">
                    <i class="bi bi-check-circle me-1"></i>Évalué
                  </span>
                <?php elseif($b->status === 'pending'): ?>
                  <span style="font-size:12px;color:#d97706;font-weight:600">
                    <i class="bi bi-hourglass-split me-1"></i>En cours…
                  </span>
                <?php elseif($b->status === 'cancelled'): ?>
                  <span style="font-size:12px;color:#dc2626;font-weight:600">
                    <i class="bi bi-x-circle me-1"></i>Refusée
                  </span>
                <?php endif; ?>
                <a href="<?php echo e(route('client.inbox.chat', $b->craftsman->user_id)); ?>" class="btn-harfa-ghost ms-1" style="font-size:12px;padding:6px 10px">
                  <i class="bi bi-chat"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="5">
                <div class="empty-state">
                  <i class="bi bi-calendar-x"></i>
                  <h5>Aucune réservation<?php echo e($currentStatus ? ' pour ce statut' : ''); ?></h5>
                  <p>Trouvez un artisan et faites votre première réservation.</p>
                  <a href="<?php echo e(route('craftsmen.index')); ?>" class="btn-harfa">Trouver un artisan</a>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\Harfa_Platfomr_maroc\resources\views/client/bookings.blade.php ENDPATH**/ ?>