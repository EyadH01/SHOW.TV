<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h4><?php echo e(\App\Models\User::count()); ?></h4>
                    <p class="text-muted">Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-tv fa-3x text-success mb-3"></i>
                    <h4><?php echo e(\App\Models\Show::count()); ?></h4>
                    <p class="text-muted">Total Shows</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-play-circle fa-3x text-warning mb-3"></i>
                    <h4><?php echo e(\App\Models\Episode::count()); ?></h4>
                    <p class="text-muted">Total Episodes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-heart fa-3x text-danger mb-3"></i>
                    <h4><?php echo e(\App\Models\Episode::sum('likes')); ?></h4>
                    <p class="text-muted">Total Likes</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="<?php echo e(route('admin.shows.index')); ?>" class="btn btn-primary mb-2">Manage Shows</a>
                    <a href="<?php echo e(route('admin.episodes.index')); ?>" class="btn btn-success mb-2">Manage Episodes</a>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-warning">Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Activity</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">No recent activity</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/eyadhs/Downloads/SHOW.TV_f/showtv_complete/showtv/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>