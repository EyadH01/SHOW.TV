<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><?php echo e(__('Profile')); ?></div>

                <div class="card-body text-center">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success"><?php echo e(session('status')); ?></div>
                    <?php endif; ?>

                    <img src="<?php echo e($user->image ? asset('storage/' . $user->image) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '?s=200'); ?>" alt="<?php echo e($user->name); ?>" class="rounded-circle mb-3" style="width:150px;height:150px;object-fit:cover;">
                    <h4><?php echo e($user->name); ?></h4>
                    <p class="text-muted"><?php echo e($user->email); ?></p>

                    <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-primary"><?php echo e(__('Edit Profile')); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/eyadhs/Downloads/SHOW.TV_f/showtv_complete/showtv/resources/views/profile/show.blade.php ENDPATH**/ ?>