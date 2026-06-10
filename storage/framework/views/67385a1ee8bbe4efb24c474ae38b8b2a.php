<?php $__env->startSection('title', 'Avis — Admin'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Modération des avis</h1>
        <p class="portal-subtitle"><?php echo e($reviews->total()); ?> avis publiés</p>
      </div>
    </div>

    <div class="card-premium" style="padding:0;overflow:hidden">
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Client</th>
            <th>Artisan</th>
            <th>Note</th>
            <th>Commentaire</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td style="font-size:13px;font-weight:600"><?php echo e($r->booking->client->name); ?></td>
              <td style="font-size:13px;font-weight:600"><?php echo e($r->booking->craftsman->user->name); ?></td>
              <td>
                <div class="d-flex align-items-center gap-1">
                  <?php for($i=1;$i<=5;$i++): ?>
                    <i class="bi bi-star<?php echo e($i<=$r->rating?'-fill':''); ?>" style="color:#f59e0b;font-size:12px"></i>
                  <?php endfor; ?>
                  <strong style="font-size:13px;margin-left:3px"><?php echo e($r->rating); ?></strong>
                </div>
              </td>
              <td style="max-width:240px;font-size:13px;color:#475569;font-style:italic">
                "<?php echo e(Str::limit($r->comment, 80)); ?>"
              </td>
              <td style="font-size:12px;color:#94a3b8"><?php echo e($r->created_at->format('d/m/Y')); ?></td>
              <td>
                <form method="POST" action="<?php echo e(route('admin.reviews.destroy', $r)); ?>"
                      onsubmit="return confirm('Supprimer cet avis ?')">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn-harfa-ghost" style="font-size:12px;padding:5px 10px;color:#ef4444;border-color:#ef4444">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6"><div class="empty-state"><i class="bi bi-chat-heart"></i><h5>Aucun avis</h5></div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if($reviews->hasPages()): ?>
      <div class="d-flex justify-content-center mt-4"><?php echo e($reviews->links()); ?></div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/admin/reviews.blade.php ENDPATH**/ ?>