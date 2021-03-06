<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,  user-scalable=no, initial-scale=1, maximum-scale=1.0, minimum-scale=1">
    <link rel="stylesheet" href={{asset('css/bootstrap.min.css')}}>
    <title>Hotel</title>
</head>
<body>
<div class="container-fluid">
    <header class="row">
        <div class="col">
            <nav class="navbar  navbar-toggler nav-pills bg-dark">
                <ul class="nav">
                    <li class="navbar-item">
                        <a class="nav-link btn-outline-primary" href="{{route('inicio')}}">Inicio</a>
                    </li>
                    <li class="navbar-item dropdown">
                        <a class="nav-link dropdown-toggle btn-outline-primary" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Archivo</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('nuevaSimulacion')}}">Nueva Simulacion</a>
                            <a class="dropdown-item" href="#">Guardar</a>
                        </div>
                    </li>
                    <li class="navbar-item">
                        <a class="nav-link btn-outline-primary" href="#">Reportes</a>
                    </li>
                    <li class="navbar-item">
                        <a class="nav-link btn-outline-primary" href="#">Ayuda</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="row">
        <div class="col">
            <main>
                @yield('contenido')
            </main>
        </div>
    </div>
</div>
    <script src={{asset('js/popper.min.js')}}></script>
    <script src={{asset('js/jquery-3.4.1.min.js')}}></script>
    <script src={{asset('js/bootstrap.min.js')}}></script>
    <script src={{asset('js/f.js')}}></script>
</body>
</html>