@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Activity Log') }}</div>

                <div class="card-body">
                    <p class="text-muted">{{ __('View your recent account activity and security events.') }}</p>

                    @if($activities->count() > 0)
                        <div class="timeline">
                            @foreach($activities as $activity)
                                <div class="timeline-item mb-4">
                                    <div class="timeline-marker bg-{{ $activity->status === 'success' ? 'success' : ($activity->status === 'warning' ? 'warning' : 'info') }}"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="timeline-title mb-1">{{ $activity->description }}</h6>
                                                <p class="timeline-text mb-2">{{ $activity->details['status'] ?? '' }}</p>
                                                <small class="text-muted">
                                                    {{ $activity->created_at->format('M d, Y \a\t H:i') }}
                                                    @if($activity->ip_address)
                                                        • IP: {{ $activity->ip_address }}
                                                    @endif
                                                    @if($activity->user_agent)
                                                        • {{ Str::limit($activity->user_agent, 50) }}
                                                    @endif
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-{{ $activity->status === 'success' ? 'success' : ($activity->status === 'warning' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($activity->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $activities->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('No Activity Found') }}</h5>
                            <p class="text-muted">{{ __('Your account activity will appear here.') }}</p>
                        </div>
                    @endif

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('profile.settings') }}" class="btn btn-outline-secondary">
                                {{ __('Back to Settings') }}
                            </a>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('profile.export') }}" class="btn btn-outline-success">
                                {{ __('Export Activity Data') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.timeline-title {
    color: #495057;
    font-weight: 600;
}

.timeline-text {
    color: #6c757d;
    margin-bottom: 10px;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh activity every 30 seconds
    setInterval(function() {
        // Could implement AJAX refresh here if needed
    }, 30000);
});
</script>
@endsection
