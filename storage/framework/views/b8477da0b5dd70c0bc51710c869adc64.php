<?php $__env->startSection('title', 'Mes points — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-craftsman', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content">

    <div class="portal-header">
      <div>
        <h1 class="portal-title">Mes points</h1>
        <p class="portal-subtitle">Rechargez vos points pour postuler aux offres d'emploi (5 pts / candidature)</p>
      </div>
      <div style="background:#f0fdf4;border:1.5px solid rgba(5,150,105,.2);border-radius:12px;padding:12px 20px;text-align:center">
        <div style="font-size:12px;color:#64748b">Solde actuel</div>
        <div style="font-size:24px;font-weight:800;color:#059669"><?php echo e(auth()->user()->points); ?> pts</div>
      </div>
    </div>

    
    <div class="row g-4 mb-5">
      <?php $__currentLoopData = [
        ['key'=>'starter','pts'=>50, 'price'=>99, 'label'=>'Starter', 'icon'=>'bi-lightning', 'color'=>'#3b82f6', 'bg'=>'#dbeafe'],
        ['key'=>'pro',    'pts'=>120,'price'=>199,'label'=>'Pro',     'icon'=>'bi-star',      'color'=>'#059669', 'bg'=>'#d1fae5', 'popular'=>true],
        ['key'=>'elite',  'pts'=>300,'price'=>399,'label'=>'Élite',   'icon'=>'bi-gem',       'color'=>'#7c3aed', 'bg'=>'#ede9fe'],
      ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4">
          <div style="background:white;border:2px solid <?php echo e(isset($pkg['popular']) ? '#059669' : '#e2e8f0'); ?>;border-radius:20px;padding:32px 24px;text-align:center;position:relative;transition:.3s;height:100%"
               onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(0,0,0,.1)'"
               onmouseout="this.style.transform='none';this.style.boxShadow='none'">
            <?php if(isset($pkg['popular'])): ?>
              <span style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:#059669;color:white;font-size:11px;font-weight:700;padding:4px 16px;border-radius:999px">
                Populaire
              </span>
            <?php endif; ?>

            <div style="width:64px;height:64px;background:<?php echo e($pkg['bg']); ?>;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:28px;color:<?php echo e($pkg['color']); ?>;margin:0 auto 16px">
              <i class="bi <?php echo e($pkg['icon']); ?>"></i>
            </div>

            <h4 style="font-weight:800;color:#0f172a;margin-bottom:4px">Pack <?php echo e($pkg['label']); ?></h4>
            <div style="font-size:40px;font-weight:800;color:<?php echo e($pkg['color']); ?>;line-height:1;margin:12px 0 4px">
              <?php echo e($pkg['pts']); ?>

            </div>
            <div style="font-size:14px;color:#64748b;margin-bottom:16px">points</div>

            <div style="font-size:22px;font-weight:700;color:#0f172a;margin-bottom:24px">
              <?php echo e($pkg['price']); ?> <span style="font-size:14px;color:#64748b">MAD</span>
            </div>

            <ul style="list-style:none;padding:0;margin:0 0 24px;text-align:left;font-size:14px;color:#475569">
              <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color:#059669"></i><?php echo e(floor($pkg['pts'] / 5)); ?> candidatures possibles</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color:#059669"></i>Valable à vie</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color:#059669"></i>Accès aux jobs en temps réel</li>
            </ul>

            <form method="POST" action="<?php echo e(route('craftsman.billing.buy')); ?>">
              <?php echo csrf_field(); ?>
              <input type="hidden" name="package" value="<?php echo e($pkg['key']); ?>">
              <button type="submit" class="btn-harfa w-100 justify-content-center"
                      style="background:linear-gradient(135deg,<?php echo e($pkg['color']); ?>,<?php echo e($pkg['color']); ?>cc)">
                <i class="bi bi-cart-plus"></i> Acheter
              </button>
            </form>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="card-premium" style="padding:0;overflow:hidden">
      <div style="padding:20px 24px;border-bottom:1px solid #e2e8f0">
        <h5 style="font-weight:700;margin:0">Historique des transactions</h5>
      </div>
      <table class="table-harfa">
        <thead>
          <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Points</th>
            <th>Type</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td style="font-size:13px"><?php echo e($t->created_at->format('d/m/Y H:i')); ?></td>
              <td style="font-size:13px;color:#475569"><?php echo e($t->description); ?></td>
              <td style="font-weight:700;color:<?php echo e($t->amount > 0 ? '#059669' : '#ef4444'); ?>">
                <?php echo e($t->amount > 0 ? '+' : ''); ?><?php echo e($t->amount); ?>

              </td>
              <td>
                <span class="badge-status <?php echo e($t->amount > 0 ? 'status-done' : 'status-cancelled'); ?>">
                  <?php echo e(ucfirst($t->type)); ?>

                </span>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="4">
                <div class="empty-state" style="padding:40px">
                  <i class="bi bi-receipt"></i>
                  <h5>Aucune transaction</h5>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\harfa\resources\views/craftsman/billing.blade.php ENDPATH**/ ?>