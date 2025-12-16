@extends('layouts.app')

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="display-4 mb-3">
                    <i class="fas fa-star"></i> {{ __('home.latest_episodes') }}
                </h1>
                <p class="lead text-muted">{{ __('home.latest_episodes_desc') }}</p>
            </div>
            <!-- User Profile Card (Facebook Style) -->
            @auth
            <div class="col-md-4">
                <div class="card profile-card shadow-lg" style="border: none; border-radius: 12px;">
                    <div class="profile-cover" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 60px;"></div>
                    <div class="card-body text-center" style="margin-top: -40px;">
                        <div class="profile-img-wrapper">
                            <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(auth()->user()->email))) . '?s=128' }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="rounded-circle" 
                                 style="width: 80px; height: 80px; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        </div>
                        <h5 class="card-title mt-3 fw-bold">{{ auth()->user()->name }}</h5>
                        <p class="text-muted small">{{ auth()->user()->email }}</p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('profile.show') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-user me-1"></i> Profile
                            </a>
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endauth
        </div>
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
@endsection
