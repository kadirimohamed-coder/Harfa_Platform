<?php $__env->startSection('title', 'Points plateforme — Admin'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Points plateforme</h1>
        <p class="portal-subtitle">Transactions de points des artisans</p>
      </div>
    </div>

    
    <div class="stats-grid mb-5" style="grid-template-columns:repeat(2,1fr);max-width:600px">
      <div class="stat-card stat-blue">
        <div class="stat-icon" style="background:#dbeafe;color:#2563eb"><i class="bi bi-coin"></i></div>
        <div class="stat-label">Points vendus (total)</div>
        <div class="stat-value" style="color:#2563eb"><?php echo e(number_format($totalPoints, 0)); ?></div>
        <div class="stat-sub">Via packs artisans</div>
      </div>
      <div class="stat-card stat-green">
        <div class="stat-icon" style="background:#d1fae5;color:#059669"><i class="bi bi-cart-check"></i></div>
        <div class="stat-label">Achats de packs</div>
        <div class="stat-value" style="color:#059669"><?php echo e(number_format($totalPurchases, 0)); ?></div>
        <div class="stat-sub">Transactions totales</div>
      </div>
    </div>

    
    <div class="card-premium" style="padding:0;overflow:hidden">
      <div style="padding:20px 24px;border-bottom:1px solid #e2e8f0">
        <h5 style="font-weight:700;margin:0">Historique des transactions de points</h5>
      </div>
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Date</th>
            <th>Artisan</th>
            <th>Description</th>
            <th>Points</th>
            <th>Type</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td style="font-size:12px;color:#94a3b8"><?php echo e($t->created_at->format('d/m/Y H:i')); ?></td>
              <td style="font-size:13px;font-weight:600"><?php echo e($t->user->name); ?></td>
              <td style="font-size:13px;color:#475569"><?php echo e($t->description); ?></td>
              <td style="font-weight:700;color:<?php echo e($t->amount > 0 ? '#059669' : '#ef4444'); ?>">
                <?php echo e($t->amount > 0 ? '+' : ''); ?><?php echo e($t->amount); ?>

              </td>
              <td>
                <span class="badge-status <?php echo e($t->amount > 0 ? 'status-done' : 'status-cancelled'); ?>" style="font-size:11px">
                  <?php echo e(ucfirst($t->type)); ?>

                </span>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="5">
                <div class="empty-state" style="padding:40px">
                  <i class="bi bi-coin"></i>
                  <h5>Aucune transaction</h5>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if($transactions->hasPages()): ?>
      <div class="d-flex justify-content-center mt-4"><?php echo e($transactions->links()); ?></div>
    <?php endif; ?>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/admin/payments.blade.php ENDPATH**/ ?>