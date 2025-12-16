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
@endsection
