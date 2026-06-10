<?php $__env->startSection('title', 'Offres d\'emploi — Admin'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Offres d'emploi</h1>
        <p class="portal-subtitle"><?php echo e($gigs->total()); ?> offre(s) publiée(s)</p>
      </div>
    </div>

    <div class="card-premium" style="padding:0;overflow:hidden">
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Titre</th>
            <th>Client</th>
            <th>Catégorie</th>
            <th>Candidatures</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $gigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td>
                <div style="font-weight:600;font-size:14px;color:#0f172a"><?php echo e($gig->title); ?></div>
                <div style="font-size:12px;color:#64748b"><?php echo e($gig->city); ?></div>
              </td>
              <td style="font-size:13px"><?php echo e($gig->client->name); ?></td>
              <td><span class="badge-cat"><?php echo e($gig->category->name); ?></span></td>
              <td style="font-size:13px;font-weight:600"><?php echo e($gig->applications->count()); ?></td>
              <td>
                <span class="badge-status status-<?php echo e($gig->status === 'open' ? 'open' : 'closed'); ?>">
                  <?php echo e($gig->status === 'open' ? 'Ouverte' : 'Fermée'); ?>

                </span>
              </td>
              <td>
                <div class="d-flex gap-1">
                  <form method="POST" action="<?php echo e(route('admin.gigs.toggle', $gig)); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-harfa-ghost" style="font-size:12px;padding:5px 10px">
                      <i class="bi <?php echo e($gig->status === 'open' ? 'bi-lock' : 'bi-unlock'); ?>"></i>
                    </button>
                  </form>
                  <form method="POST" action="<?php echo e(route('admin.gigs.destroy', $gig)); ?>"
                        onsubmit="return confirm('Supprimer ?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn-harfa-ghost" style="font-size:12px;padding:5px 10px;color:#ef4444;border-color:#ef4444">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6"><div class="empty-state"><i class="bi bi-briefcase"></i><h5>Aucune offre</h5></div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if($gigs->hasPages()): ?>
      <div class="d-flex justify-content-center mt-4"><?php echo e($gigs->links()); ?></div>
    <?php endif; ?>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/admin/gigs.blade.php ENDPATH**/ ?>