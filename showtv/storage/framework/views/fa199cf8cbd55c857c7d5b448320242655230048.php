<?php $__env->startSection('content'); ?>
<div class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="display-4 mb-3">
                    <i class="fas fa-star"></i> <?php echo e(__('home.latest_episodes')); ?>

                </h1>
                <p class="lead text-muted"><?php echo e(__('home.latest_episodes_desc')); ?></p>
            </div>
            <!-- User Profile Card (Facebook Style) -->
            <?php if(auth()->guard()->check()): ?>
            <div class="col-md-4">
                <div class="card profile-card shadow-lg" style="border: none; border-radius: 12px;">
                    <div class="profile-cover" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 60px;"></div>
                    <div class="card-body text-center" style="margin-top: -40px;">
                        <div class="profile-img-wrapper">
                            <img src="<?php echo e(auth()->user()->image ? asset('storage/' . auth()->user()->image) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(auth()->user()->email))) . '?s=128'); ?>" 
                                 alt="<?php echo e(auth()->user()->name); ?>" 
                                 class="rounded-circle" 
                                 style="width: 80px; height: 80px; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        </div>
                        <h5 class="card-title mt-3 fw-bold"><?php echo e(auth()->user()->name); ?></h5>
                        <p class="text-muted small"><?php echo e(auth()->user()->email); ?></p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-user me-1"></i> Profile
                            </a>
                            <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $latestEpisodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $episode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card show-card h-100">
                    <div class="position-relative">
                        <img src="<?php echo e($episode->thumbnail ?: 'https://img.youtube.com/vi/' . $episode->youtube_video_id . '/maxresdefault.jpg'); ?>"
                             alt="<?php echo e($episode->title); ?>"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover;">
                        <div class="show-overlay">
                            <a href="<?php echo e(route('episodes.show', $episode)); ?>" class="btn btn-primary btn-lg">
                                <i class="fas fa-play"></i> <?php echo e(__('nav.watch')); ?>

                            </a>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold"><?php echo e($episode->show->title); ?></h6>
                        <p class="card-text text-muted small"><?php echo e($episode->title); ?></p>
                        <p class="card-text text-muted small mb-2">
                            <i class="fas fa-clock me-1"></i><?php echo e($episode->duration); ?> دقيقة
                        </p>
                        <p class="card-text text-warning small mb-auto">
                            <i class="fas fa-calendar me-1"></i><?php echo e($episode->airing_time); ?>

                        </p>
                        <div class="mt-2">
                            <span class="badge bg-primary"><?php echo e(__('home.latest')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i><?php echo e(__('home.no_episodes_available')); ?>

                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="text-center mt-5">
        <a href="<?php echo e(route('shows.index')); ?>" class="btn btn-primary btn-lg">
            <i class="fas fa-tv me-2"></i><?php echo e(__('home.browse_all_shows')); ?>

        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/eyadhs/Downloads/SHOW.TV_f/showtv_complete/showtv/resources/views/home.blade.php ENDPATH**/ ?>