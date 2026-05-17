<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WheelyGoodCars</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body>
<nav class="navbar navbar-expand-md navbar-dark d-print-none bg-black">
    <div class="container-fluid">

        <a class="navbar-brand" href="{{ route('home') }}">
            <strong class="text-primary">Wheely</strong> good cars<strong class="text-primary">!</strong>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">

            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('cars.index') }}">
                        Alle auto's
                    </a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('cars.mine') }}">
                            Mijn aanbod
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('cars.create') }}">
                            Aanbod plaatsen
                        </a>
                    </li>

                    @if(auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="{{ route('admin.dashboard') }}">
                                Admin Dashboard
                            </a>
                        </li>
                    @endif
                @endauth

            </ul>

            <ul class="navbar-nav">

                @guest
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="{{ route('register') }}">
                            Registreren
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="{{ route('login') }}">
                            Inloggen
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="nav-link text-secondary bg-transparent border-0">
                                Uitloggen
                            </button>
                        </form>
                    </li>
                @endauth

            </ul>

        </div>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

</body>
</html>