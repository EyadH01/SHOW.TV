@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Left Column - Profile Summary -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '?s=120' }}" alt="{{ $user->name }}" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;">
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                    @if($user->bio)
                        <p>{{ Str::limit($user->bio, 100) }}</p>
                    @endif
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">{{ __('Edit Profile') }}</a>
                        <a href="{{ route('profile.settings') }}" class="btn btn-outline-secondary btn-sm">{{ __('Settings') }}</a>
                    </div>
                </div>
            </div>

            <!-- Account Stats -->
            <div class="card mt-3">
                <div class="card-header">{{ __('Account Statistics') }}</div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="text-primary">{{ $stats['total_shows'] }}</h5>
                            <small class="text-muted">{{ __('Shows') }}</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success">{{ $stats['total_episodes'] }}</h5>
                            <small class="text-muted">{{ __('Episodes') }}</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="text-info">{{ $stats['follows'] }}</h5>
                            <small class="text-muted">{{ __('Following') }}</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-warning">{{ $stats['likes'] }}</h5>
                            <small class="text-muted">{{ __('Likes') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Activity and Information -->
        <div class="col-md-8">
            <!-- Quick Info Cards -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">{{ __('Profile Completion') }}</h6>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $profileCompletion }}%"></div>
                            </div>
                            <small class="text-muted">{{ $profileCompletion }}% complete</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">{{ __('Account Status') }}</h6>
                            <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                {{ $user->is_active ? __('Active') : __('Inactive') }}
                            </span>
                            @if($user->last_login_at)
                                <br><small class="text-muted">{{ __('Last login:') }} {{ $user->last_login_at->diffForHumans() }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Recent Activity') }}</h5>
                </div>
                <div class="card-body">
                    @if($recentActivities->count() > 0)
                        <div class="timeline">
                            @foreach($recentActivities as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $activity->status === 'success' ? 'success' : 'warning' }}"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">{{ $activity->description }}</h6>
                                        <p class="timeline-text">{{ $activity->details['status'] ?? '' }}</p>
                                        <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                        @if($activity->ip_address)
                                            <br><small class="text-muted">IP: {{ $activity->ip_address }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('profile.activity') }}" class="btn btn-outline-primary btn-sm">{{ __('View All Activity') }}</a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{ __('No recent activity') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Active Sessions -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Active Sessions') }}</h5>
                </div>
                <div class="card-body">
                    @if($activeSessions->count() > 0)
                        @foreach($activeSessions as $session)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>{{ $session->device_type ?? __('Unknown Device') }}</strong>
                                    <br><small class="text-muted">{{ $session->ip_address }} • {{ $session->browser ?? __('Unknown Browser') }}</small>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted">{{ $session->last_activity->diffForHumans() }}</small>
                                    @if(!$session->is_current)
                                        <br><a href="{{ route('profile.sessions.destroy', $session) }}" class="btn btn-sm btn-outline-danger">{{ __('End Session') }}</a>
                                    @else
                                        <br><span class="badge bg-primary">{{ __('Current') }}</span>
                                    @endif
                                </div>
                            </div>
                            @if(!$loop->last)<hr>@endif
                        @endforeach
                        <div class="text-center mt-3">
                            <a href="{{ route('profile.sessions') }}" class="btn btn-outline-info btn-sm">{{ __('Manage All Sessions') }}</a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-laptop fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{ __('No active sessions') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Information Summary -->
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Profile Information') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>{{ __('Personal Information') }}</h6>
                    <dl class="row">
                        @if($user->phone)
                            <dt class="col-sm-4">{{ __('Phone:') }}</dt>
                            <dd class="col-sm-8">{{ $user->phone }}</dd>
                        @endif
                        @if($user->date_of_birth)
                            <dt class="col-sm-4">{{ __('Birth Date:') }}</dt>
                            <dd class="col-sm-8">{{ $user->date_of_birth->format('M d, Y') }}</dd>
                        @endif
                        @if($user->gender)
                            <dt class="col-sm-4">{{ __('Gender:') }}</dt>
                            <dd class="col-sm-8">{{ ucfirst($user->gender) }}</dd>
                        @endif
                        @if($user->language)
                            <dt class="col-sm-4">{{ __('Language:') }}</dt>
                            <dd class="col-sm-8">{{ $user->language }}</dd>
                        @endif
                    </dl>
                </div>
                <div class="col-md-6">
                    <h6>{{ __('Location & Social') }}</h6>
                    <dl class="row">
                        @if($user->country)
                            <dt class="col-sm-4">{{ __('Country:') }}</dt>
                            <dd class="col-sm-8">{{ $user->country }}</dd>
                        @endif
                        @if($user->city)
                            <dt class="col-sm-4">{{ __('City:') }}</dt>
                            <dd class="col-sm-8">{{ $user->city }}</dd>
                        @endif
                        @if($user->website)
                            <dt class="col-sm-4">{{ __('Website:') }}</dt>
                            <dd class="col-sm-8"><a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></dd>
                        @endif
                    </dl>
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
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.timeline-title {
    margin-bottom: 5px;
    color: #495057;
}

.timeline-text {
    margin-bottom: 5px;
    color: #6c757d;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh activity every 30 seconds
    setInterval(function() {
        // You can implement AJAX refresh here if needed
    }, 30000);
});
</script>
@endsection
