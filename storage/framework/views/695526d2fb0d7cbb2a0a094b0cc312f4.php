<?php $__env->startSection('title', 'Messages — Harfa.ma'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-layout">
  <?php echo $__env->make('partials.sidebar-craftsman', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="portal-content" style="padding:20px">

    <div class="chat-layout">

      <div class="chat-list">
        <div class="chat-list-header">
          <i class="bi bi-chat-dots me-2" style="color:#059669"></i>Messages
        </div>
        <div class="chat-list-scroll">
          <?php $__empty_1 = true; $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('craftsman.inbox.chat', $p->id)); ?>"
               class="chat-contact <?php echo e(isset($partner) && $partner->id === $p->id ? 'active' : ''); ?>">
              <div class="contact-avatar"><?php echo e(strtoupper(substr($p->name, 0, 2))); ?></div>
              <div>
                <div class="contact-name"><?php echo e($p->name); ?></div>
                <div class="contact-preview">Cliquer pour discuter</div>
              </div>
            </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div style="padding:24px;text-align:center;color:#94a3b8;font-size:13px">
              Aucune conversation pour l'instant
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="chat-main">
        <?php if(isset($partner)): ?>
          <div class="chat-header">
            <div class="header-avatar"><?php echo e(strtoupper(substr($partner->name, 0, 2))); ?></div>
            <div>
              <div class="header-name"><?php echo e($partner->name); ?></div>
              <div class="header-status">Client</div>
            </div>
          </div>

          <div class="chat-messages" id="chatMessages">
            <?php $__empty_1 = true; $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <div class="message-bubble <?php echo e($msg->sender_id === auth()->id() ? 'outgoing' : 'incoming'); ?>">
                <?php echo e($msg->message); ?>

                <div class="msg-time"><?php echo e($msg->created_at->format('H:i')); ?></div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <div style="text-align:center;color:#94a3b8;font-size:14px;margin:auto">
                Démarrez la conversation avec <?php echo e($partner->name); ?>

              </div>
            <?php endif; ?>
          </div>

          <div class="chat-input-area">
            <form method="POST" action="<?php echo e(route('craftsman.inbox.send')); ?>" class="d-flex gap-2 flex-grow-1">
              <?php echo csrf_field(); ?>
              <input type="hidden" name="receiver_id" value="<?php echo e($partner->id); ?>">
              <input type="text" name="message" placeholder="Tapez votre message..." required autocomplete="off">
              <button type="submit"><i class="bi bi-send-fill"></i></button>
            </form>
          </div>
        <?php else: ?>
          <div style="display:flex;align-items:center;justify-content:center;flex:1;flex-direction:column;color:#94a3b8">
            <i class="bi bi-chat-dots" style="font-size:56px;opacity:.3;margin-bottom:16px"></i>
            <p style="font-size:15px">Sélectionnez une conversation</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
  const msgs = document.getElementById('chatMessages');
  if(msgs) msgs.scrollTop = msgs.scrollHeight;
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\Downloads\harfa_cash_only\harfa_complete_fixed\harfa\resources\views/craftsman/inbox.blade.php ENDPATH**/ ?>