<?php $__env->startSection('title', 'Utilisateurs — Admin'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Gestion des utilisateurs</h1>
        <p class="portal-subtitle"><?php echo e($users->total()); ?> compte(s) enregistré(s)</p>
      </div>
    </div>

    
    <form action="<?php echo e(route('admin.users')); ?>" method="GET" class="card-premium mb-4" style="padding:16px 20px">
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <input class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Nom, email...">
        </div>
        <div class="col-md-3">
          <select class="form-select" name="role">
            <option value="">Tous les rôles</option>
            <option value="client"    <?php echo e(request('role')=='client'    ? 'selected' : ''); ?>>Clients</option>
            <option value="craftsman" <?php echo e(request('role')=='craftsman' ? 'selected' : ''); ?>>Artisans</option>
            <option value="admin"     <?php echo e(request('role')=='admin'     ? 'selected' : ''); ?>>Admins</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn-harfa w-100 justify-content-center">Filtrer</button>
        </div>
      </div>
    </form>

    <div class="card-premium" style="padding:0;overflow:hidden">
      <table class="table-harfa">
        <thead>
          <tr>
            <th>#</th>
            <th>Utilisateur</th>
            <th>Rôle</th>
            <th>Ville</th>
            <th>Inscrit le</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td style="color:#94a3b8;font-size:13px"><?php echo e($u->id); ?></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#047857,#10b981);color:white;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0">
                    <?php echo e(strtoupper(substr($u->name,0,2))); ?>

                  </div>
                  <div>
                    <div style="font-weight:600;font-size:14px;color:#0f172a"><?php echo e($u->name); ?></div>
                    <div style="font-size:12px;color:#64748b"><?php echo e($u->email); ?></div>
                  </div>
                </div>
              </td>
              <td><span class="badge-role"><?php echo e(ucfirst($u->role)); ?></span></td>
              <td style="font-size:13px;color:#64748b"><?php echo e($u->city ?? '—'); ?></td>
              <td style="font-size:13px;color:#64748b"><?php echo e($u->created_at->format('d/m/Y')); ?></td>
              <td>
                <span class="badge-status status-<?php echo e($u->status === 'active' ? 'active' : 'inactive'); ?>">
                  <?php echo e($u->status === 'active' ? 'Actif' : 'Inactif'); ?>

                </span>
              </td>
              <td>
                <div class="d-flex gap-1">
                  <form method="POST" action="<?php echo e(route('admin.users.toggle', $u)); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-harfa-ghost" style="font-size:12px;padding:5px 10px"
                            title="<?php echo e($u->status === 'active' ? 'Désactiver' : 'Activer'); ?>">
                      <i class="bi <?php echo e($u->status === 'active' ? 'bi-toggle-on' : 'bi-toggle-off'); ?>"></i>
                    </button>
                  </form>
                  <form method="POST" action="<?php echo e(route('admin.users.destroy', $u)); ?>"
                        onsubmit="return confirm('Supprimer cet utilisateur ?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn-harfa-ghost" style="font-size:12px;padding:5px 10px;color:#ef4444;border-color:#ef4444">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7"><div class="empty-state"><i class="bi bi-people"></i><h5>Aucun utilisateur</h5></div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if($users->hasPages()): ?>
      <div class="d-flex justify-content-center mt-4"><?php echo e($users->links()); ?></div>
    <?php endif; ?>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/admin/users.blade.php ENDPATH**/ ?>