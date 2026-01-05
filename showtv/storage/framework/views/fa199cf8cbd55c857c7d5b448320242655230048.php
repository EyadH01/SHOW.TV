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

<!-- User Images Gallery Section -->
<?php if($usersWithImages && count($usersWithImages) > 0): ?>
<div class="user-gallery-section mt-5">
    <div class="container">


        <h2 class="text-center mb-4">
            <i class="fas fa-users me-2"></i>معرض صور المستخدمين
        </h2>
        <p class="text-center text-muted mb-4">صور مرفوعة من قبل المستخدمين النشطين</p>
        
        <div class="row">
            <?php $__currentLoopData = $usersWithImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3 col-lg-2 col-6 mb-4">
                    <div class="user-card text-center">
                        <div class="user-avatar-container mb-2">

                       <img src="<?php echo e($user->avatar_url); ?>" 
                           alt="<?php echo e($user->name); ?>" 
                           class="user-avatar img-fluid rounded-circle"
                           style="width: 80px; height: 80px; object-fit: cover;">
                            <?php if(Auth::check() && Auth::user()->id === $user->id): ?>
                                <span class="badge bg-success position-absolute" style="top: 5px; right: 5px;">
                                    <i class="fas fa-user-check"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                        <h6 class="user-name mb-1"><?php echo e($user->name); ?></h6>
                        <p class="user-date text-muted small mb-2">
                            <i class="fas fa-calendar me-1"></i>
                            <?php echo e($user->created_at->format('Y-m-d')); ?>

                        </p>

                        <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>عرض البروفايل
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <?php if(count($usersWithImages) >= 12): ?>
            <div class="text-center mt-3">

                <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>عرض المزيد من المستخدمين
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<style>
.user-gallery-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 60px 0;
    border-radius: 15px;
    margin-top: 40px;
}

.user-card {
    background: white;
    border-radius: 15px;
    padding: 20px 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.user-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    border-color: #007bff;
}

.user-avatar-container {
    position: relative;
    display: inline-block;
}

.user-avatar {
    border: 3px solid #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.user-card:hover .user-avatar {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.user-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    font-size: 14px;
}

.user-date {
    font-size: 12px;
    margin-bottom: 12px;
}

.btn-outline-primary {
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 20px;
}

.badge.bg-success {
    border-radius: 50%;
    font-size: 10px;
    padding: 3px 6px;
}

@media (max-width: 768px) {
    .user-gallery-section {
        padding: 40px 0;
        margin-top: 30px;
    }
    
    .user-card {
        padding: 15px 10px;
    }
    
    .user-avatar {
        width: 60px !important;
        height: 60px !important;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/eyadhs/Downloads/SHOW.TV_f/showtv_complete/showtv/resources/views/home.blade.php ENDPATH**/ ?>