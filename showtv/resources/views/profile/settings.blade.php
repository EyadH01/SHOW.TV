@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Profile Settings & Privacy') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.settings.update') }}">
                        @csrf

                        <!-- Privacy Settings Section -->
                        <h5 class="mb-3">{{ __('Privacy Settings') }}</h5>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="profile_public" name="profile_public" value="1" {{ old('profile_public', $user->preferences->profile_public ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="profile_public">
                                        {{ __('Make my profile public') }}
                                    </label>
                                    <small class="text-muted d-block">{{ __('Allow others to view your profile information') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show_email" name="show_email" value="1" {{ old('show_email', $user->preferences->show_email ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_email">
                                        {{ __('Show email address on profile') }}
                                    </label>
                                    <small class="text-muted d-block">{{ __('Display your email address on your public profile') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show_phone" name="show_phone" value="1" {{ old('show_phone', $user->preferences->show_phone ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_phone">
                                        {{ __('Show phone number on profile') }}
                                    </label>
                                    <small class="text-muted d-block">{{ __('Display your phone number on your public profile') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show_location" name="show_location" value="1" {{ old('show_location', $user->preferences->show_location ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_location">
                                        {{ __('Show location on profile') }}
                                    </label>
                                    <small class="text-muted d-block">{{ __('Display your country and city on your public profile') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show_social_media" name="show_social_media" value="1" {{ old('show_social_media', $user->preferences->show_social_media ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_social_media">
                                        {{ __('Show social media links on profile') }}
                                    </label>
                                    <small class="text-muted d-block">{{ __('Display your social media profiles on your public profile') }}</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Notification Preferences Section -->
                        <h5 class="mb-3">{{ __('Notification Preferences') }}</h5>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" value="1" {{ old('email_notifications', $user->preferences->email_notifications ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="email_notifications">
                                        {{ __('Email notifications') }}
                                    </label>
                                    <small class="text-muted d-block">{{ __('Receive notifications via email') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sms_notifications" name="sms_notifications" value="1" {{ old('sms_notifications', $user->preferences->sms_notifications ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sms_notifications">
                                        {{ __('SMS notifications') }}
                                    </label>
                                    <small class="text-muted d-block">{{ __('Receive notifications via SMS') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="login_alerts" name="login_alerts" value="1" {{ old('login_alerts', $user->preferences->login_alerts ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="login_alerts">
                                        {{ __('Login alerts') }}
                                    </label>
                                    <small class="text-muted d-block">{{ __('Get notified when someone logs into your account') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="security_alerts" name="security_alerts" value="1" {{ old('security_alerts', $user->preferences->security_alerts ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="security_alerts">
                                        {{ __('Security alerts') }}
                                    </label>
                                    <small class="text-muted d-block">{{ __('Get notified about security-related activities') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="marketing_emails" name="marketing_emails" value="1" {{ old('marketing_emails', $user->preferences->marketing_emails ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="marketing_emails">
                                        {{ __('Marketing emails') }}
                                    </label>
                                    <small class="text-muted d-block">{{ __('Receive updates about new features and promotions') }}</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Security Settings Section -->
                        <h5 class="mb-3">{{ __('Security Settings') }}</h5>
                        <div class="row mb-3">
                            <label for="two_factor_enabled" class="col-md-4 col-form-label text-md-end">{{ __('Two-Factor Authentication') }}</label>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="two_factor_enabled" name="two_factor_enabled" value="1" {{ old('two_factor_enabled', $user->preferences->two_factor_enabled ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="two_factor_enabled">
                                        {{ __('Enable two-factor authentication') }}
                                    </label>
                                    <small class="text-muted d-block">{{ __('Add an extra layer of security to your account') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="session_timeout" class="col-md-4 col-form-label text-md-end">{{ __('Session Timeout') }}</label>
                            <div class="col-md-6">
                                <select id="session_timeout" class="form-control" name="session_timeout">
                                    <option value="30" {{ old('session_timeout', $user->preferences->session_timeout ?? '60') == '30' ? 'selected' : '' }}>{{ __('30 minutes') }}</option>
                                    <option value="60" {{ old('session_timeout', $user->preferences->session_timeout ?? '60') == '60' ? 'selected' : '' }}>{{ __('1 hour') }}</option>
                                    <option value="120" {{ old('session_timeout', $user->preferences->session_timeout ?? '60') == '120' ? 'selected' : '' }}>{{ __('2 hours') }}</option>
                                    <option value="240" {{ old('session_timeout', $user->preferences->session_timeout ?? '60') == '240' ? 'selected' : '' }}>{{ __('4 hours') }}</option>
                                    <option value="480" {{ old('session_timeout', $user->preferences->session_timeout ?? '60') == '480' ? 'selected' : '' }}>{{ __('8 hours') }}</option>
                                </select>
                                <small class="text-muted">{{ __('Automatically log out after this period of inactivity') }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="notify_new_devices" name="notify_new_devices" value="1" {{ old('notify_new_devices', $user->preferences->notify_new_devices ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="notify_new_devices">
                                        {{ __('Notify about new device logins') }}
                                    </label>
                                    <small class="text-muted d-block">{{ __('Get alerted when someone logs in from a new device') }}</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Account Management Section -->
                        <h5 class="mb-3">{{ __('Account Management') }}</h5>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('profile.password.change') }}" class="btn btn-outline-primary">{{ __('Change Password') }}</a>
                                <small class="text-muted d-block mt-1">{{ __('Update your account password') }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('profile.sessions') }}" class="btn btn-outline-info">{{ __('Manage Active Sessions') }}</a>
                                <small class="text-muted d-block mt-1">{{ __('View and manage your active login sessions') }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('profile.activity') }}" class="btn btn-outline-secondary">{{ __('View Activity Log') }}</a>
                                <small class="text-muted d-block mt-1">{{ __('See your recent account activity') }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('profile.export') }}" class="btn btn-outline-success">{{ __('Export My Data') }}</a>
                                <small class="text-muted d-block mt-1">{{ __('Download a copy of your account data') }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                    {{ __('Delete Account') }}
                                </button>
                                <small class="text-muted d-block mt-1">{{ __('Permanently delete your account and all data') }}</small>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save Settings') }}
                                </button>
                                <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">{{ __('Confirm Account Deletion') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <strong>{{ __('Warning!') }}</strong>
                    {{ __('This action cannot be undone. All your data will be permanently deleted.') }}
                </div>
                <p>{{ __('Are you sure you want to delete your account?') }}</p>
                <form method="POST" action="{{ route('profile.delete') }}" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <label for="delete_confirmation" class="form-label">{{ __('Type "DELETE" to confirm:') }}</label>
                        <input type="text" class="form-control" id="delete_confirmation" name="delete_confirmation" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">{{ __('Delete Account') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete() {
    const confirmation = document.getElementById('delete_confirmation').value;
    if (confirmation === 'DELETE') {
        document.getElementById('deleteAccountForm').submit();
    } else {
        alert('{{ __("Please type DELETE to confirm account deletion.") }}');
    }
}

// Auto-hide success messages
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert-success');
    alerts.forEach(function(alert) {
        alert.style.display = 'none';
    });
}, 5000);
</script>
@endsection
