<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img alt="Logo" class="d-inline-block align-text-top" height="30" src="/images/funkos.bmp" width="30">
            Funkos Madirex
        </a>
        <button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
                data-target="#navbarNav" data-toggle="collapse" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Funkos</a>
                </li>
                @if (auth()->check() && auth()->user()->hasRole('admin')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('funkos.create') }}">Nuevo Funko</a>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories.index') }}">Categorías</a>
                </li>
                @if (auth()->check() && auth()->user()->hasRole('admin')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.create') }}">Nueva Categoría</a>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav ml-auto" style="flex-direction: column;">
                <li class="nav-item">
                    @guest
                        <a class="nav-link" href="{{ route('register') }}">Registro</a>
                    @else
                        <div class="nav-username">{{ auth()->user()->name }}</div>
                    @endguest
                </li>
                <li class="nav-item">
                    @guest
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    @else
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    @endguest
                </li>
            </ul>
        </div>
    </nav>
</header>