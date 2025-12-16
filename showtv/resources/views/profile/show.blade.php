@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body text-center">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '?s=200' }}" alt="{{ $user->name }}" class="rounded-circle mb-3" style="width:150px;height:150px;object-fit:cover;">
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>

                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">{{ __('Edit Profile') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
