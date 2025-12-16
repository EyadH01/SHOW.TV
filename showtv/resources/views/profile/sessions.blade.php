@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Active Sessions') }}</div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <p class="text-muted">{{ __('Manage your active login sessions. You can end sessions from devices you no longer use.') }}</p>

                    @if($sessions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Device') }}</th>
                                        <th>{{ __('Location') }}</th>
                                        <th>{{ __('IP Address') }}</th>
                                        <th>{{ __('Last Activity') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sessions as $session)
                                        <tr>
                                            <td>
                                                <strong>{{ $session->device_type ?? __('Unknown Device') }}</strong>
                                                <br><small class="text-muted">{{ $session->browser ?? __('Unknown Browser') }}</small>
                                            </td>
                                            <td>{{ $session->location ?? __('Unknown') }}</td>
                                            <td>{{ $session->ip_address }}</td>
                                            <td>{{ $session->last_activity->diffForHumans() }}</td>
                                            <td>
                                                @if($session->is_current)
                                                    <span class="badge bg-primary">{{ __('Current Session') }}</span>
                                                @else
                                                    <form method="POST" action="{{ route('profile.sessions.destroy', $session->id) }}" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Are you sure you want to end this session?') }}')">
                                                            {{ __('End Session') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-laptop fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{ __('No active sessions found') }}</p>
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
                            <button type="button" class="btn btn-outline-warning" onclick="if(confirm('{{ __('Are you sure you want to end all other sessions?') }}')) { window.location.href='{{ route('profile.sessions.end-all') }}'; }">
                                {{ __('End All Other Sessions') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide success messages
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-success');
        alerts.forEach(function(alert) {
            alert.style.display = 'none';
        });
    }, 5000);
});
</script>
@endsection
