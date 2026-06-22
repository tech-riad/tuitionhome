<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="{{ asset('/dashboard/tutor/') }}/assets/logo.svg" /></a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mx-3" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tutor Hub</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('blog.index')}}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Job Board</a>
                </li>

                @if(Auth::guard('tutor')->check())
                    <li class="nav-item">
                        <a href="{{ route('tutor.dashboard') }}" class="nav-link">{{ Auth::guard('tutor')->user()->name }}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tutor.register') }}">Tutor Register</a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link" href="{{ route('tutor.login') }}">Tutor Login</a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>