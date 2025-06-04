<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Notas y Horario')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Iconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Font Awesome 5 CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>

<body>

    <header>
        <div class="left">
            <div class="menu-container">
                <div class="menu" id="menu">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="brand">
                <span class="name">SGNH</span>
            </div>
        </div>
        <div class="right">
            @auth
            <div class="dropdown">
                <a href="#" class="dropdown-toggle h6 mb-0 text-decoration-none" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Cerrar sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </header>

    <div class="sidebar" id="sidebar">
        <nav>
            <ul>
                <li>
                    <a href="#">
                        <i class="bi bi-house-door me-2"></i>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-calendar-week me-2"></i>
                        <span>Horarios</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-journal-text me-2"></i>
                        <span>Asignaturas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('estudiantes.index') }}">
                        <i class="bi bi-person-lines-fill me-2"></i>
                        <span>Estudiantes</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-person-badge me-2"></i>
                        <span>Profesores</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <main id="main">
        @yield('content')
    </main>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script personalizados -->
    <script src="{{ asset('js/script.js') }}"></script>

    @yield('scripts')

</body>

</html>