<?php $__env->startSection('content'); ?>
<div class="hero-section">
    <div class="container">
        <h1 class="display-4 mb-3">
            <i class="fas fa-star"></i> <?php echo e(__('home.latest_episodes')); ?>

        </h1>
        <p class="lead text-muted"><?php echo e(__('home.latest_episodes_desc')); ?></p>
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