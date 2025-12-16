@extends('layouts.app')

@section('content')
<div class="hero-section">
    <div class="container">
        <h1 class="display-4 mb-3">
            <i class="fas fa-search"></i> نتائج البحث
        </h1>
        <p class="lead text-muted">البحث عن: <strong>{{ $query }}</strong></p>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-4">المسلسلات</h2>
            @forelse($shows as $show)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $show->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($show->description, 100) }}</p>
                        <a href="{{ route('shows.show', $show) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> عرض
                        </a>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> لم يتم العثور على مسلسلات
                </div>
            @endforelse
        </div>

        <div class="col-md-6">
            <h2 class="mb-4">الحلقات</h2>
            @forelse($episodes as $episode)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $episode->title }}</h5>
                        <p class="card-text text-muted small">من: {{ $episode->show->title }}</p>
                        <p class="card-text text-muted">{{ Str::limit($episode->description, 100) }}</p>
                        <a href="{{ route('episodes.show', $episode) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-play"></i> مشاهدة
                        </a>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> لم يتم العثور على حلقات
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
