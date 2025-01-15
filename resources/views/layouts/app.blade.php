<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link type="text/css" href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/styles.min.css') }}">

    <script>
        window.Laravel = <?php echo json_encode(['token' => csrf_token(), 'url' => url('/')]);?>
    </script>

</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                @auth

                    @php
                        $group = Auth::user()->group;
                    @endphp

                    <ul class="navbar-nav">

                        @if ($group->verifyPermission('books.index'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('livros') }}">Livros<span class="sr-only"></span></a>
                            </li>
                        @endif

                        @if ($group->verifyPermission('users.index'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('usuarios') }}">Usuarios<span class="sr-only"></span></a>
                            </li>
                        @endif

                        @if ($group->verifyPermission('lending-books.index'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('emprestimos') }}">Emprestimos<span class="sr-only"></span></a>
                            </li>
                        @endif
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu">
                                <button type="button" class="dropdown-item btn-logout">Sair</button>
                            </div>
                        </li>
                    </ul>

                @endauth

            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

    <footer>
            <script type="text/javascript" src="{{ asset('assets/js/vendor.min.js') }}" defer></script>
            <script type="text/javascript" src="{{ asset('assets/js/scripts.min.js') }}" defer></script>
    </footer>

</html>
