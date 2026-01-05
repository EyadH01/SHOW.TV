@extends('layouts.app')

@section('content')
<div class="hero-section">
    <div class="container">
        <h1 class="display-4 mb-3">
            <i class="fas fa-star"></i> {{ __('home.latest_episodes') }}
        </h1>
        <p class="lead text-muted">{{ __('home.latest_episodes_desc') }}</p>
    </div>
</div>

<div class="container">
    <div class="row">
        @forelse($latestEpisodes as $episode)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card show-card h-100">
                    <div class="position-relative">
                        <img src="{{ $episode->thumbnail ?: 'https://img.youtube.com/vi/' . $episode->youtube_video_id . '/maxresdefault.jpg' }}"
                             alt="{{ $episode->title }}"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover;">
                        <div class="show-overlay">
                            <a href="{{ route('episodes.show', $episode) }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-play"></i> {{ __('nav.watch') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold">{{ $episode->show->title }}</h6>
                        <p class="card-text text-muted small">{{ $episode->title }}</p>
                        <p class="card-text text-muted small mb-2">
                            <i class="fas fa-clock me-1"></i>{{ $episode->duration }} دقيقة
                        </p>
                        <p class="card-text text-warning small mb-auto">
                            <i class="fas fa-calendar me-1"></i>{{ $episode->airing_time }}
                        </p>
                        <div class="mt-2">
                            <span class="badge bg-primary">{{ __('home.latest') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>{{ __('home.no_episodes_available') }}
                </div>
            </div>
        @endforelse
    </div>


    <div class="text-center mt-5">
        <a href="{{ route('shows.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-tv me-2"></i>{{ __('home.browse_all_shows') }}
        </a>
    </div>
</div>

<!-- User Images Gallery Section -->
@if($usersWithImages && count($usersWithImages) > 0)
<div class="user-gallery-section mt-5">
    <div class="container">


        <h2 class="text-center mb-4">
            <i class="fas fa-users me-2"></i>معرض صور المستخدمين
        </h2>
        <p class="text-center text-muted mb-4">صور مرفوعة من قبل المستخدمين النشطين</p>
        
        <div class="row">
            @foreach($usersWithImages as $user)
                <div class="col-md-3 col-lg-2 col-6 mb-4">
                    <div class="user-card text-center">
                        <div class="user-avatar-container mb-2">

                       <img src="{{ $user->avatar_url }}" 
                           alt="{{ $user->name }}" 
                           class="user-avatar img-fluid rounded-circle"
                           style="width: 80px; height: 80px; object-fit: cover;">
                            @if(Auth::check() && Auth::user()->id === $user->id)
                                <span class="badge bg-success position-absolute" style="top: 5px; right: 5px;">
                                    <i class="fas fa-user-check"></i>
                                </span>
                            @endif
                        </div>
                        <h6 class="user-name mb-1">{{ $user->name }}</h6>
                        <p class="user-date text-muted small mb-2">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $user->created_at->format('Y-m-d') }}
                        </p>

                        <a href="{{ route('profile.show') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>عرض البروفايل
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if(count($usersWithImages) >= 12)
            <div class="text-center mt-3">

                <a href="{{ route('profile.show') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>عرض المزيد من المستخدمين
                </a>
            </div>
        @endif
    </div>
</div>
@endif

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
@endsection
