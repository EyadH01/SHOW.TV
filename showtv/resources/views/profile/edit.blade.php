@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit Profile') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information Section -->
                        <h5 class="mb-3">{{ __('Basic Information') }}</h5>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Account Type') }}</label>
                            <div class="col-md-6">
                                <select id="role" class="form-control" name="role" disabled>
                                    <option value="user" {{ ($user->role ?? 'user') == 'user' ? 'selected' : '' }}>{{ __('Regular User') }}</option>
                                    <option value="admin" {{ ($user->role ?? '') == 'admin' ? 'selected' : '' }}>{{ __('Administrator') }}</option>
                                </select>
                                <small class="text-muted">{{ __('Account type cannot be changed') }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Profile Photo') }}</label>
                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="text-muted">{{ __('Upload a new profile photo (max 2MB, jpeg, png, jpg, gif)') }}</small>

                                <div class="mt-2">
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded" style="width:96px;height:96px;object-fit:cover;" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=96&background=random'">
                                    
                                    <small class="text-muted d-block">{{ __('Current Profile Photo') }}</small>
                                    <small class="text-muted d-block">{{ __('Current Profile Photo') }}</small>
                                </div>
                            </div>
                        </div>


                        <hr class="my-4">

                        <!-- Personal Information Section -->
                        <h5 class="mb-3">{{ __('Personal Information') }}</h5>
                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="bio" class="col-md-4 col-form-label text-md-end">{{ __('Bio') }}</label>
                            <div class="col-md-6">
                                <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" name="bio" rows="3">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="text-muted">{{ __('Tell us about yourself (max 500 characters)') }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth') }}</label>
                            <div class="col-md-6">
                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}">
                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>
                            <div class="col-md-6">
                                <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender">
                                    <option value="">{{ __('Prefer not to say') }}</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Location Information Section -->
                        <h5 class="mb-3">{{ __('Location Information') }}</h5>
                        <div class="row mb-3">
                            <label for="country" class="col-md-4 col-form-label text-md-end">{{ __('Country') }}</label>
                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country', $user->country) }}">
                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('City') }}</label>
                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', $user->city) }}">
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Social Media and Website Section -->
                        <h5 class="mb-3">{{ __('Social Media & Website') }}</h5>
                        <div class="row mb-3">
                            <label for="website" class="col-md-4 col-form-label text-md-end">{{ __('Website') }}</label>
                            <div class="col-md-6">
                                <input id="website" type="url" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website', $user->website) }}" placeholder="https://example.com">
                                @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="facebook_url" class="col-md-4 col-form-label text-md-end">{{ __('Facebook URL') }}</label>
                            <div class="col-md-6">
                                <input id="facebook_url" type="url" class="form-control @error('facebook_url') is-invalid @enderror" name="facebook_url" value="{{ old('facebook_url', $user->facebook_url) }}" placeholder="https://facebook.com/username">
                                @error('facebook_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="twitter_url" class="col-md-4 col-form-label text-md-end">{{ __('Twitter URL') }}</label>
                            <div class="col-md-6">
                                <input id="twitter_url" type="url" class="form-control @error('twitter_url') is-invalid @enderror" name="twitter_url" value="{{ old('twitter_url', $user->twitter_url) }}" placeholder="https://twitter.com/username">
                                @error('twitter_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="instagram_url" class="col-md-4 col-form-label text-md-end">{{ __('Instagram URL') }}</label>
                            <div class="col-md-6">
                                <input id="instagram_url" type="url" class="form-control @error('instagram_url') is-invalid @enderror" name="instagram_url" value="{{ old('instagram_url', $user->instagram_url) }}" placeholder="https://instagram.com/username">
                                @error('instagram_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="linkedin_url" class="col-md-4 col-form-label text-md-end">{{ __('LinkedIn URL') }}</label>
                            <div class="col-md-6">
                                <input id="linkedin_url" type="url" class="form-control @error('linkedin_url') is-invalid @enderror" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}" placeholder="https://linkedin.com/in/username">
                                @error('linkedin_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="youtube_url" class="col-md-4 col-form-label text-md-end">{{ __('YouTube URL') }}</label>
                            <div class="col-md-6">
                                <input id="youtube_url" type="url" class="form-control @error('youtube_url') is-invalid @enderror" name="youtube_url" value="{{ old('youtube_url', $user->youtube_url) }}" placeholder="https://youtube.com/channel/username">
                                @error('youtube_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Preferences Section -->
                        <h5 class="mb-3">{{ __('Preferences') }}</h5>
                        <div class="row mb-3">
                            <label for="language" class="col-md-4 col-form-label text-md-end">{{ __('Preferred Language') }}</label>
                            <div class="col-md-6">
                                <select id="language" class="form-control @error('language') is-invalid @enderror" name="language">
                                    <option value="en" {{ old('language', $user->language ?? 'en') == 'en' ? 'selected' : '' }}>{{ __('English') }}</option>
                                    <option value="ar" {{ old('language', $user->language ?? '') == 'ar' ? 'selected' : '' }}>{{ __('Arabic') }}</option>
                                    <option value="es" {{ old('language', $user->language ?? '') == 'es' ? 'selected' : '' }}>{{ __('Spanish') }}</option>
                                    <option value="fr" {{ old('language', $user->language ?? '') == 'fr' ? 'selected' : '' }}>{{ __('French') }}</option>
                                    <option value="de" {{ old('language', $user->language ?? '') == 'de' ? 'selected' : '' }}>{{ __('German') }}</option>
                                </select>
                                @error('language')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" value="1" {{ old('email_notifications', $user->email_notifications) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="email_notifications">
                                        {{ __('I want to receive email notifications') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sms_notifications" name="sms_notifications" value="1" {{ old('sms_notifications', $user->sms_notifications) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sms_notifications">
                                        {{ __('I want to receive SMS notifications') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Account Information Section -->
                        <h5 class="mb-3">{{ __('Account Information') }}</h5>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Member Since') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $user->created_at->format('M d, Y') }}" readonly>
                                <small class="text-muted">{{ __('Account creation date') }}</small>
                            </div>
                        </div>

                        @if($user->last_login_at)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Last Login') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $user->last_login_at->format('M d, Y H:i') }}" readonly>
                                <small class="text-muted">{{ __('Last login time') }}</small>
                            </div>
                        </div>
                        @endif

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save Changes') }}
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
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide error messages after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.invalid-feedback');
        alerts.forEach(function(alert) {
            alert.style.display = 'none';
        });
    }, 5000);

    // Image preview
    const imageInput = document.getElementById('image');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const currentImage = document.querySelector('.mt-2 img');
                    if (currentImage) {
                        currentImage.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const password = document.getElementById('password') ? document.getElementById('password').value : '';
        const passwordConfirm = document.getElementById('password-confirm') ? document.getElementById('password-confirm').value : '';

        if (password && password !== passwordConfirm) {
            e.preventDefault();
            alert('Passwords do not match!');
            return false;
        }
    });
});
</script>
@endsection
