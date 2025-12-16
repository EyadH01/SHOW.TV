@extends('layouts.app')

@section('content')
@if($show->video_url)
<div class="video-player-page" style="min-height: 60vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <!-- Show Trailer Video -->
    <div class="video-player-section py-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="text-white text-center mb-4">
                        <i class="fas fa-play-circle"></i> ترويجة المسلسل
                    </h2>
                    <!-- Video Player Container -->
                    <div class="video-player-container mb-4" style="border-radius: 12px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
                        @if(str_contains($show->video_url, 'youtube.com') || str_contains($show->video_url, 'youtu.be'))
                            <!-- YouTube Video -->
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ $show->video_url }}" allowfullscreen style="border: none;"></iframe>
                            </div>
                        @else
                            <!-- Local Video File -->
                            <div class="ratio ratio-16x9">
                                <video controls class="w-100 h-100" style="object-fit: contain;" poster="{{ $show->wallpaper ?: asset('images/video-poster.jpg') }}">
                                    <source src="{{ asset('storage/' . $show->video_url) }}" type="video/mp4">
                                    <source src="{{ asset('storage/' . $show->video_url) }}" type="video/avi">
                                    <source src="{{ asset('storage/' . $show->video_url) }}" type="video/mkv">
                                    {{ __('messages.browser_not_support_video') }}
                                </video>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="hero-section" style="background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ $show->wallpaper ? (str_starts_with($show->wallpaper, 'http') ? $show->wallpaper : asset('storage/' . $show->wallpaper)) : asset('images/default-wallpaper.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="display-4 mb-3">{{ $show->title }}</h1>
                <p class="lead text-light">{{ $show->description }}</p>
                <p class="text-warning">
                    <i class="fas fa-calendar-alt"></i> موعد البث: <strong>{{ $show->airing_time }}</strong>
                </p>
            </div>
            <div class="col-md-4 text-end">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('series.upload', $show) }}" class="btn btn-warning btn-lg me-2">
                            <i class="fas fa-upload"></i> رفع وسائط
                        </a>
                    @endif

                    @if($isFollowing)
                        <form action="{{ route('shows.unfollow', $show) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-lg">
                                <i class="fas fa-heart-broken"></i> إلغاء المتابعة
                            </button>
                        </form>
                    @else
                        <form action="{{ route('shows.follow', $show) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-lg">
                                <i class="fas fa-heart"></i> متابعة
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-danger btn-lg">
                        <i class="fas fa-sign-in-alt"></i> دخول للمتابعة
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<div class="container">
    <h2 class="mb-4">
        <i class="fas fa-film"></i> الحلقات ({{ $show->episodes->count() }})
    </h2>

    <div class="row">
        @forelse($show->episodes as $episode)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ $episode->thumbnail ? (str_starts_with($episode->thumbnail, 'http') ? $episode->thumbnail : asset('storage/' . $episode->thumbnail)) : ($show->thumbnail ? (str_starts_with($show->thumbnail, 'http') ? $show->thumbnail : asset('storage/' . $show->thumbnail)) : 'https://via.placeholder.com/300x200/1a1a1a/e50914?text=E' . $loop->iteration) }}" class="img-fluid rounded-start" alt="{{ $episode->title }}">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <strong>الحلقة {{ $loop->iteration }}:</strong> {{ $episode->title }}
                                </h5>
                                <p class="card-text text-muted">{{ Str::limit($episode->description, 100) }}</p>
                                <p class="card-text">
                                    <small class="text-warning">
                                        <i class="fas fa-clock"></i> {{ $episode->duration }} دقيقة
                                    </small>
                                    <br>
                                    <small class="text-info">
                                        <i class="fas fa-calendar"></i> {{ $episode->airing_time }}
                                    </small>
                                </p>
                                <a href="{{ route('episodes.show', $episode) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-play"></i> مشاهدة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> لا توجد حلقات متاحة لهذا المسلسل حالياً
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
