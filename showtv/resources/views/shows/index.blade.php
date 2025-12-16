@extends('layouts.app')

@section('content')
<div class="hero-section">
    <div class="container">
        <h1 class="display-4 mb-3">
            <i class="fas fa-tv"></i> جميع المسلسلات
        </h1>
        <p class="lead text-muted">اختر مسلسلك المفضل وتابع الحلقات الجديدة</p>
    </div>
</div>

<div class="container">
    <div class="row">
        @forelse($shows as $show)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card show-card">
                    <img src="{{ $show->thumbnail ? (str_starts_with($show->thumbnail, 'http') ? $show->thumbnail : asset('storage/' . $show->thumbnail)) : 'https://via.placeholder.com/300x400/1a1a1a/e50914?text=' . urlencode($show->title) }}" alt="{{ $show->title }}">
                    <div class="show-overlay">
                        @if($show->video_url)
                            <a href="{{ route('shows.show', $show) }}" class="btn btn-danger btn-lg me-2">
                                <i class="fas fa-play"></i> تشغيل
                            </a>
                        @endif
                        <a href="{{ route('shows.show', $show) }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-eye"></i> عرض التفاصيل
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $show->title }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($show->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">{{ $show->episodes_count }} حلقة</span>
                            <small class="text-warning">
                                <i class="fas fa-calendar"></i> {{ $show->airing_time }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> لا توجد مسلسلات متاحة حالياً
                </div>
            </div>
        @endforelse
    </div>

    @if($shows instanceof \Illuminate\Pagination\Paginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $shows->links() }}
        </div>
    @endif
</div>
@endsection
