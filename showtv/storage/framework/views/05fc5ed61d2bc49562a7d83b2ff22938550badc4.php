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

                    <?php if($user->image): ?>
                        <img src="<?php echo e(asset('storage/' . $user->image)); ?>" alt="<?php echo e($user->name); ?>" class="rounded-circle mb-3" style="width:150px;height:150px;object-fit:cover;">
                    <?php else: ?>
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:150px;height:150px;">
                            <i class="fas fa-user fa-3x text-muted"></i>
                        </div>
                    <?php endif; ?>
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