<?php $__env->startSection('title', 'Mes réservations — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>

<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-craftsman', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Mes réservations</h1>
        <p class="portal-subtitle">Gérez les demandes de vos clients</p>
      </div>
    </div>

    
    <?php
      $pending   = $bookings->where('status','pending')->count();
      $confirmed = $bookings->where('status','confirmed')->count();
      $done      = $bookings->where('status','done')->count();
      $cancelled = $bookings->where('status','cancelled')->count();
    ?>

    <div class="row g-3 mb-4">
      <div class="col-6 col-md-3">
        <div class="booking-stat-card">
          <p class="stat-number"><?php echo e($pending); ?></p>
          <span class="stat-label badge-pending">⏳ En attente</span>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="booking-stat-card">
          <p class="stat-number"><?php echo e($confirmed); ?></p>
          <span class="stat-label badge-confirmed">✓ Confirmées</span>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="booking-stat-card">
          <p class="stat-number"><?php echo e($done); ?></p>
          <span class="stat-label badge-done">● Terminées</span>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="booking-stat-card">
          <p class="stat-number"><?php echo e($cancelled); ?></p>
          <span class="stat-label badge-cancelled">✗ Annulées</span>
        </div>
      </div>
    </div>

    
    <div class="booking-filters mb-3">
      <button class="filter-pill active" data-filter="all">
        Toutes (<?php echo e($bookings->count()); ?>)
      </button>
      <button class="filter-pill" data-filter="pending">
        ⏳ En attente (<?php echo e($pending); ?>)
      </button>
      <button class="filter-pill" data-filter="confirmed">
        ✓ Confirmées (<?php echo e($confirmed); ?>)
      </button>
      <button class="filter-pill" data-filter="done">
        ● Terminées (<?php echo e($done); ?>)
      </button>
      <button class="filter-pill" data-filter="cancelled">
        ✗ Annulées (<?php echo e($cancelled); ?>)
      </button>
    </div>

    
    <div class="card-premium" style="padding:0;overflow:hidden">
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Client</th>
            <th>Date prévue</th>
            <th>Description</th>
            <th>Statut</th>
            <th>Contact</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr data-status="<?php echo e($b->status); ?>">

              
              <td>
                <div style="font-weight:600;color:#0f172a"><?php echo e($b->client->name); ?></div>
                <div style="font-size:12px;color:#94a3b8"><?php echo e($b->client->city ?? ''); ?></div>
              </td>

              
              <td style="font-size:13px;white-space:nowrap">
                <?php echo e($b->booking_date->format('d/m/Y')); ?><br>
                <span style="color:#94a3b8;font-size:12px"><?php echo e($b->booking_date->format('H:i')); ?></span>
              </td>

              
              <td style="max-width:180px;font-size:13px;color:#475569">
                <?php echo e(Str::limit($b->description, 55)); ?>

              </td>

              
              <td>
                <span class="badge-status status-<?php echo e($b->status); ?>">
                  <?php switch($b->status):
                    case ('pending'): ?>   ⏳ En attente  <?php break; ?>
                    <?php case ('confirmed'): ?> ✓ Confirmée   <?php break; ?>
                    <?php case ('done'): ?>      ● Terminée    <?php break; ?>
                    <?php case ('cancelled'): ?> ✗ Annulée     <?php break; ?>
                  <?php endswitch; ?>
                </span>
              </td>

              
              <td>
                <?php if($b->status === 'confirmed'): ?>
                  <div style="font-size:13px;color:#059669;font-weight:600">
                    <i class="bi bi-telephone-fill me-1"></i><?php echo e($b->client->phone); ?>

                  </div>
                  <?php
                    $wp = preg_replace('/\D/', '', $b->client->phone ?? '');
                    if(strlen($wp) === 10 && str_starts_with($wp, '0')) $wp = '212'.substr($wp,1);
                  ?>
                  <?php if($wp): ?>
                    <a href="https://wa.me/<?php echo e($wp); ?>" target="_blank"
                      style="margin-top:4px;display:inline-flex;align-items:center;gap:4px;
                              background:#25D366;color:#fff;text-decoration:none;
                              padding:3px 10px;border-radius:999px;font-size:11px;font-weight:600">
                      <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                  <?php endif; ?>
                <?php else: ?>
                  <span style="font-size:12px;color:#94a3b8">
                    <i class="bi bi-lock me-1"></i>Après confirmation
                  </span>
                <?php endif; ?>
              </td>

              
              <td>
                <?php if($b->status === 'pending'): ?>
                  <div class="d-flex gap-2 flex-wrap">
                    <form method="POST" action="<?php echo e(route('craftsman.bookings.update', $b)); ?>">
                      <?php echo csrf_field(); ?>
                      <input type="hidden" name="status" value="confirmed">
                      <button type="submit" class="btn-confirm">
                        <i class="bi bi-check-lg me-1"></i>Confirmer
                      </button>
                    </form>
                    <form method="POST" action="<?php echo e(route('craftsman.bookings.update', $b)); ?>">
                      <?php echo csrf_field(); ?>
                      <input type="hidden" name="status" value="cancelled">
                      <button type="submit" class="btn-refuse">
                        <i class="bi bi-x-lg me-1"></i>Refuser
                      </button>
                    </form>
                  </div>

                <?php elseif($b->status === 'confirmed'): ?>
                  <div class="d-flex gap-2 flex-wrap align-items-center">
                    <form method="POST" action="<?php echo e(route('craftsman.bookings.update', $b)); ?>">
                      <?php echo csrf_field(); ?>
                      <input type="hidden" name="status" value="done">
                      <button type="submit" class="btn-done"
                        onclick="return confirm('Marquer comme terminée ?')">
                        <i class="bi bi-flag-fill me-1"></i>Terminer
                      </button>
                    </form>
                    
                    <?php if(Route::has('craftsman.inbox.chat')): ?>
                      <a href="<?php echo e(route('craftsman.inbox.chat', $b->client_id)); ?>"
                         title="Chat avec <?php echo e($b->client->name); ?>"
                         style="width:34px;height:34px;border-radius:50%;background:#dbeafe;color:#2563eb;
                                display:flex;align-items:center;justify-content:center;font-size:16px;
                                text-decoration:none;transition:.2s;border:1.5px solid #93c5fd"
                         onmouseover="this.style.background='#2563eb';this.style.color='white'"
                         onmouseout="this.style.background='#dbeafe';this.style.color='#2563eb'">
                        <i class="bi bi-chat-dots-fill"></i>
                      </a>
                    <?php endif; ?>
                  </div>

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
                  <h5>Aucune réservation</h5>
                  <p>Complétez votre profil pour recevoir des demandes de clients.</p>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if($bookings->hasPages()): ?>
      <div class="d-flex justify-content-center mt-4">
        <?php echo e($bookings->withQueryString()->links()); ?>

      </div>
    <?php endif; ?>

  </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.querySelectorAll('.filter-pill').forEach(pill => {
  pill.addEventListener('click', function () {
    document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
    this.classList.add('active');
    const filter = this.dataset.filter;
    document.querySelectorAll('tbody tr[data-status]').forEach(row => {
      row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
    });
  });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\harfa\resources\views/craftsman/bookings.blade.php ENDPATH**/ ?>