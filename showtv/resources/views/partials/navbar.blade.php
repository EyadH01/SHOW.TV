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
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('profile.show') }}">
                            <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(auth()->user()->email))) . '?s=32' }}" alt="{{ auth()->user()->name }}" class="rounded-circle me-2" style="width:32px;height:32px;object-fit:cover;">
                            {{ auth()->user()->name }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-link nav-link">Logout</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
