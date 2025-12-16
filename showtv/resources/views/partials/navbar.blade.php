<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">SHOW.TV</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                @php
                    $randomShows = \App\Models\Show::inRandomOrder()->take(5)->get();
                @endphp
                @foreach($randomShows as $show)
                    <li class="nav-item"><a class="nav-link" href="{{ route('shows.show', $show) }}">{{ $show->title }}</a></li>
                @endforeach
            </ul>
            <form class="d-flex me-3" action="{{ route('search') }}" method="GET">
                <input class="form-control me-2" type="search" name="q" placeholder="Search episodes / tv-shows">
                <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
            </form>
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.shows.index') }}">Admin</a></li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                            @if(auth()->user()->image)
                                <img src="{{ Storage::url(auth()->user()->image) }}" alt="{{ auth()->user()->name }}" class="rounded me-2" style="width:32px;height:32px;object-fit:contain; border: 2px solid rgba(255,255,255,0.3);">
                            @else
                                <i class="fas fa-user-circle me-2" style="font-size: 24px; color: rgba(255,255,255,0.7);"></i>
                            @endif
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>{{ __('Dashboard') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user me-2"></i>{{ __('Profile') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-edit me-2"></i>{{ __('Edit Profile') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.settings') }}"><i class="fas fa-cog me-2"></i>{{ __('Settings') }}</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
