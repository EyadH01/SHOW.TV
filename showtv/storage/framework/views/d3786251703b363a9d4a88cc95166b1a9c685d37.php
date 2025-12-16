<?php $__env->startSection('content'); ?>
<!-- Netflix-style Video Player Page -->
<div class="video-player-page" style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <!-- Episode Header -->
    <div class="episode-header py-4">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="episode-info">
                        <h1 class="episode-title text-white mb-2"><?php echo e($episode->title); ?></h1>
                        <div class="episode-meta text-white-50 mb-3">
                            <span class="me-3">
                                <i class="fas fa-tv"></i>
                                <a href="<?php echo e(route('shows.show', $episode->show)); ?>" class="text-white text-decoration-none ms-1">
                                    <?php echo e($episode->show->title); ?>

                                </a>
                            </span>
                            <span class="me-3">
                                <i class="fas fa-clock"></i> <?php echo e($episode->duration); ?> <?php echo e(__('messages.minutes')); ?>

                            </span>
                            <span>
                                <i class="fas fa-calendar"></i> <?php echo e($episode->airing_time); ?>

                            </span>
                        </div>
                        <p class="episode-description text-white-75 mb-0" style="max-width: 600px; line-height: 1.6;">
                            <?php echo e($episode->description); ?>

                        </p>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <!-- Back Button -->
                    <a href="<?php echo e(route('shows.show', $episode->show)); ?>" class="btn btn-outline-light me-2">
                        <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.back_to_series')); ?>

                    </a>

                    <!-- Reactions -->
                    <?php if(auth()->guard()->check()): ?>
                        <div class="btn-group" role="group">
                            <?php if($likeStatus === 'like'): ?>
                                <form action="<?php echo e(route('episodes.unlike', $episode)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-success btn-sm">
                                        <i class="fas fa-thumbs-up"></i> <?php echo e($episode->likes); ?>

                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="<?php echo e(route('episodes.like', $episode)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-outline-light btn-sm">
                                        <i class="fas fa-thumbs-up"></i> <?php echo e($episode->likes); ?>

                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if($likeStatus === 'dislike'): ?>
                                <form action="<?php echo e(route('episodes.unlike', $episode)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-thumbs-down"></i> <?php echo e($episode->dislikes); ?>

                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="<?php echo e(route('episodes.dislike', $episode)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-outline-light btn-sm">
                                        <i class="fas fa-thumbs-down"></i> <?php echo e($episode->dislikes); ?>

                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-sign-in-alt"></i> <?php echo e(__('messages.login_to_rate')); ?>

                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Player Section -->
    <div class="video-player-section bg-dark py-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Video Player Container -->
                    <div class="video-player-container mb-4" style="border-radius: 12px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
                        <?php if($episode->video_url): ?>
                            <?php
                                $isYoutube = str_contains($episode->video_url, 'youtube.com') || str_contains($episode->video_url, 'youtu.be') || str_contains($episode->video_url, 'youtube');
                                $embedUrl = null;
                                // Normalize local video path: allow '/storage/...' or 'storage/...' or plain path
                                $localPath = null;
                                if ($isYoutube) {
                                    // Extract video ID from YouTube URL
                                    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $episode->video_url, $matches)) {
                                        $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                    }
                                } else {
                                    if (str_starts_with($episode->video_url, '/storage/')) {
                                        $localPath = $episode->video_url;
                                    } elseif (str_starts_with($episode->video_url, 'storage/')) {
                                        $localPath = '/' . $episode->video_url;
                                    } else {
                                        // assume it's stored under storage path
                                        $localPath = '/storage/' . ltrim($episode->video_url, '/');
                                    }
                                }

                            ?>
                            <?php if($embedUrl): ?>
                                <!-- YouTube Video -->
                                <div class="ratio ratio-16x9">
                                    <iframe src="<?php echo e($embedUrl); ?>" allowfullscreen style="border: none;"></iframe>
                                </div>
                            <?php elseif($localPath): ?>
                                <!-- Local Video File with Netflix-style player -->
                                <div class="ratio ratio-16x9">
                                    <video controls class="w-100 h-100" style="object-fit: contain;" poster="<?php echo e($episode->show->wallpaper ?: asset('images/video-poster.jpg')); ?>">
                                        <source src="<?php echo e($localPath); ?>" type="video/mp4">
                                        <source src="<?php echo e($localPath); ?>" type="video/avi">
                                        <source src="<?php echo e($localPath); ?>" type="video/mkv">
                                        <?php echo e(__('messages.browser_not_support_video')); ?>

                                    </video>
                                </div>
                            <?php else: ?>
                                <!-- Unsupported video URL -->
                                <div class="ratio ratio-16x9 bg-dark d-flex align-items-center justify-content-center">
                                    <div class="text-center text-white">
                                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                        <h5><?php echo e(__('messages.unsupported_video_format')); ?></h5>
                                        <p class="text-white-75"><?php echo e($episode->video_url); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php elseif($episode->youtube_video_id): ?>
                            <!-- YouTube Video by ID -->
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/<?php echo e($episode->youtube_video_id); ?>" allowfullscreen style="border: none;"></iframe>
                            </div>
                        <?php else: ?>
                            <!-- No video available - Netflix style placeholder -->
                            <div class="ratio ratio-16x9 bg-dark d-flex align-items-center justify-content-center">
                                <div class="text-center text-white">
                                    <div class="mb-4">
                                        <i class="fas fa-play-circle fa-5x text-white-50"></i>
                                    </div>
                                    <h3 class="mb-3"><?php echo e(__('messages.no_video_available')); ?></h3>
                                    <p class="text-white-75 mb-4"><?php echo e(__('messages.upload_video_admin')); ?></p>
                                    <a href="https://www.youtube.com/@royatv" target="_blank" class="btn btn-danger btn-lg">
                                        <i class="fab fa-youtube"></i> <?php echo e(__('messages.watch_on_roya')); ?>

                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Episode Actions -->
                    <div class="episode-actions d-flex justify-content-between align-items-center">
                        <div class="episode-navigation">
                            <?php
                                $prevEpisode = $episode->show->episodes->where('id', '<', $episode->id)->sortByDesc('id')->first();
                                $nextEpisode = $episode->show->episodes->where('id', '>', $episode->id)->sortBy('id')->first();
                            ?>

                            <?php if($prevEpisode): ?>
                                <a href="<?php echo e(route('episodes.show', $prevEpisode)); ?>" class="btn btn-outline-light me-2">
                                    <i class="fas fa-chevron-right"></i> <?php echo e(__('messages.previous_episode')); ?>

                                </a>
                            <?php endif; ?>

                            <?php if($nextEpisode): ?>
                                <a href="<?php echo e(route('episodes.show', $nextEpisode)); ?>" class="btn btn-outline-light">
                                    <?php echo e(__('messages.next_episode')); ?> <i class="fas fa-chevron-left"></i>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="episode-share">
                            <button class="btn btn-outline-light" onclick="shareEpisode()">
                                <i class="fas fa-share"></i> <?php echo e(__('messages.share')); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- More Episodes Section -->
    <div class="more-episodes py-5 bg-black">
        <div class="container-fluid">
            <h3 class="text-white mb-4"><?php echo e(__('messages.more_episodes')); ?></h3>
            <div class="row">
                <?php $__currentLoopData = $episode->show->episodes->where('id', '!=', $episode->id)->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="episode-card position-relative" style="border-radius: 8px; overflow: hidden; cursor: pointer;" onclick="window.location.href='<?php echo e(route('episodes.show', $ep)); ?>'">
                            <div class="episode-thumbnail" style="height: 180px; background: url('<?php echo e($ep->thumbnail); ?>') center/cover no-repeat; display: flex; align-items: center; justify-content: center;">
                                <div class="episode-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s;">
                                    <i class="fas fa-play fa-3x text-white"></i>
                                </div>
                            </div>
                            <div class="episode-info p-3 bg-dark text-white">
                                <h6 class="mb-1"><?php echo e(Str::limit($ep->title, 30)); ?></h6>
                                <small class="text-white-50"><?php echo e($ep->duration); ?> <?php echo e(__('messages.minutes')); ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<script>
// Netflix-style episode card hover effects
document.addEventListener('DOMContentLoaded', function() {
    const episodeCards = document.querySelectorAll('.episode-card');

    episodeCards.forEach(card => {
        const overlay = card.querySelector('.episode-overlay');

        card.addEventListener('mouseenter', () => {
            overlay.style.opacity = '1';
        });

        card.addEventListener('mouseleave', () => {
            overlay.style.opacity = '0';
        });
    });
});

// Share episode function
function shareEpisode() {
    const url = window.location.href;
    const title = document.title;

    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        navigator.clipboard.writeText(url).then(() => {
            alert('<?php echo e(__("messages.link_copied")); ?>');
        });
    }
}

// Video player enhancements
document.addEventListener('DOMContentLoaded', function() {
    const video = document.querySelector('video');
    if (video) {
        // Auto-play next episode when current ends (optional)
        video.addEventListener('ended', function() {
            const nextBtn = document.querySelector('a[href*="next-episode"]');
            if (nextBtn && confirm('<?php echo e(__("messages.play_next_episode")); ?>')) {
                window.location.href = nextBtn.href;
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.target.tagName.toLowerCase() !== 'input') {
                switch(e.key) {
                    case ' ':
                    case 'k':
                        e.preventDefault();
                        video.paused ? video.play() : video.pause();
                        break;
                    case 'ArrowLeft':
                        e.preventDefault();
                        video.currentTime -= 10;
                        break;
                    case 'ArrowRight':
                        e.preventDefault();
                        video.currentTime += 10;
                        break;
                    case 'm':
                        e.preventDefault();
                        video.muted = !video.muted;
                        break;
                    case 'f':
                        e.preventDefault();
                        if (video.requestFullscreen) {
                            video.requestFullscreen();
                        }
                        break;
                }
            }
        });
    }
});
</script>

<style>
.video-player-page {
    font-family: 'Netflix Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
}

.episode-title {
    font-size: 2.5rem;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.episode-meta span {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.episode-description {
    font-size: 1.1rem;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.video-player-container {
    position: relative;
}

.episode-card:hover .episode-overlay {
    opacity: 1 !important;
}

.episode-card:hover .episode-thumbnail {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

/* Custom video controls styling */
video::-webkit-media-controls-panel {
    background: rgba(0,0,0,0.8);
}

video::-webkit-media-controls-current-time-display,
video::-webkit-media-controls-time-remaining-display {
    color: white;
}

/* Fullscreen support */
video:fullscreen {
    background: black;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/eyadhs/Downloads/SHOW.TV_f/showtv_complete/showtv/resources/views/episodes/show.blade.php ENDPATH**/ ?>