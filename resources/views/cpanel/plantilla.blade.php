<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title')</title>

<!-- CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css') }}">

<style>

:root{
    --primary:#1F364A;
    --secondary:#386173;
    --accent:#B8D67A;
    --text:#ffffff;
}

/* BODY */
body{
    background:#f5f7fa;
}

/* NAVBAR */
.navbar{
    background: var(--primary) !important;
}

.navbar-brand-wrapper{
    background: var(--primary);
    display:flex;
    align-items:center;
    justify-content:center;
}

/* LOGO */
.logo-wrapper{
    display:flex;
    align-items:center;
    gap:10px;
}

.logo-img{
    width:40px;
}

.logo-text{
    color:var(--text);
    font-size:22px;
    font-weight:bold;
}

/* SIDEBAR */
.sidebar{
    background: var(--primary) !important;
}

.sidebar .nav-link{
    color:var(--text) !important;
    display:flex;
    align-items:center;
    gap:10px;
}

.sidebar .nav-link i{
    color:var(--accent) !important;
}

.sidebar .nav-link:hover{
    background:var(--secondary) !important;
}

/* PERFIL */
.nav-profile-img img{
    width:35px;
    height:35px;
    border-radius:50%;
    object-fit:cover;
}

/* FOOTER */
.footer{
    background: var(--primary);
    color:white;
}

/* CHATBOT */
df-messenger{
    --df-messenger-button-titlebar-color: var(--primary);
    --df-messenger-chat-background-color: #f5f7fa;
    z-index:9999;
}

</style>

</head>

<body>

<div class="container-scroller">

<!-- NAVBAR -->
<nav class="navbar fixed-top d-flex flex-row">

    <!-- LOGO -->
    <div class="navbar-brand-wrapper">

        <div class="logo-wrapper">

            <img src="{{ asset('assets/images/logo.png') }}"
                 class="logo-img">

            <span class="logo-text">
                SOPAD
            </span>

        </div>

    </div>

    <!-- MENU SUPERIOR -->
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

        <!-- BOTON SIDEBAR -->
        <button class="navbar-toggler" data-toggle="minimize">

            <span class="mdi mdi-menu text-white"></span>

        </button>

        <!-- PERFIL -->
        <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle d-flex align-items-center"
                   href="#"
                   data-toggle="dropdown">

                    <div class="nav-profile-img">

                        <img src="{{ session('usuario')->foto
                            ? asset('storage/' . session('usuario')->foto)
                            : asset('assets/images/faces/mujer.png') }}">

                    </div>

                    <span class="ml-2 text-white">

                        {{ session('usuario')->nombre ?? 'Invitado' }}

                    </span>

                </a>

                <!-- DROPDOWN -->
                <div class="dropdown-menu dropdown-menu-right">

                    <!-- PERFIL -->
                    <a class="dropdown-item"
                       href="{{ route('perfil') }}">

                        <i class="mdi mdi-account"></i>
                        Perfil

                    </a>

                    <div class="dropdown-divider"></div>

                    <!-- LOGOUT -->
                    <form method="POST"
                          action="{{ route('logout') }}">

                        @csrf

                        <button class="dropdown-item">

                            <i class="mdi mdi-logout"></i>
                            Cerrar sesión

                        </button>

                    </form>

                </div>

            </li>

        </ul>

    </div>

</nav>

<!-- BODY -->
<div class="container-fluid page-body-wrapper">

<!-- SIDEBAR -->
<nav class="sidebar sidebar-offcanvas">

<ul class="nav">

@php
    $idProyectoActual = session('id_proyecto_actual');
@endphp

<!-- TITULO -->
<li class="nav-item nav-category">
    Menú
</li>

{{-- =========================
    ADMIN
========================= --}}
@if(session('usuario')->rol == 'admin')

<!-- INICIO -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ url('/materiaprima/grafica') }}">

        <i class="mdi mdi-chart-bar"></i>
        <span>Inicio</span>

    </a>

</li>

<!-- USUARIOS -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ url('/admon/usuarios') }}">

        <i class="mdi mdi-table"></i>
        <span>Usuarios</span>

    </a>

</li>

<!-- EVENTOS -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ url('/admon/eventos') }}">

        <i class="mdi mdi-calendar"></i>
        <span>Eventos</span>

    </a>

</li>

<!-- MATERIA PRIMA -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ $idProyectoActual
            ? url('/admon/proyecto/'.$idProyectoActual.'/materiaprima')
            : url('/admon/proyecto') }}">

        <i class="mdi mdi-cube"></i>
        <span>Materia Prima</span>

    </a>

</li>

<!-- LABOR DIRECTA -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ $idProyectoActual
            ? url('/admon/proyecto/'.$idProyectoActual.'/labordirecta')
            : url('/admon/proyecto') }}">

        <i class="mdi mdi-account-hard-hat"></i>
        <span>Labor Directa</span>

    </a>

</li>

<!-- VENTAS -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ $idProyectoActual
            ? url('/admon/proyecto/'.$idProyectoActual.'/ventasanuales')
            : url('/admon/proyecto') }}">

        <i class="mdi mdi-cash"></i>
        <span>Ventas</span>

    </a>

</li>

<!-- REPORTE -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ $idProyectoActual
            ? url('/reporte-financiero/'.$idProyectoActual)
            : url('/admon/proyecto') }}">

        <i class="mdi mdi-file-chart"></i>
        <span>Reporte</span>

    </a>

</li>

<!-- PROYECTO -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ url('/admon/proyecto') }}">

        <i class="mdi mdi-briefcase"></i>
        <span>Proyecto</span>

    </a>

</li>

@endif

{{-- =========================
    ESTUDIANTE
========================= --}}
@if(session('usuario')->rol == 'estudiante')

<!-- INICIO -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ url('/materiaprima/grafica') }}">

        <i class="mdi mdi-chart-bar"></i>
        <span>Inicio</span>

    </a>

</li>

<!-- EVENTOS -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ url('/admon/eventos') }}">

        <i class="mdi mdi-calendar"></i>
        <span>Eventos</span>

    </a>

</li>

<!-- MATERIA PRIMA -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ $idProyectoActual
            ? url('/admon/proyecto/'.$idProyectoActual.'/materiaprima')
            : url('/admon/proyecto') }}">

        <i class="mdi mdi-cube"></i>
        <span>Materia Prima</span>

    </a>

</li>

<!-- LABOR -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ $idProyectoActual
            ? url('/admon/proyecto/'.$idProyectoActual.'/labordirecta')
            : url('/admon/proyecto') }}">

        <i class="mdi mdi-account-hard-hat"></i>
        <span>Labor Directa</span>

    </a>

</li>

<!-- VENTAS -->
<li class="nav-item">

    <a class="nav-link"
       href="{{ $idProyectoActual
            ? url('/admon/proyecto/'.$idProyectoActual.'/ventasanuales')
            : url('/admon/proyecto') }}">

        <i class="mdi mdi-cash"></i>
        <span>Ventas</span>

    </a>

</li>

@endif

{{-- =========================
    PROFESOR
========================= --}}
@if(session('usuario')->rol == 'profesor')

<li class="nav-item">

    <a class="nav-link"
       href="{{ $idProyectoActual
            ? url('/reporte-financiero/'.$idProyectoActual)
            : url('/admon/proyecto') }}">

        <i class="mdi mdi-file-chart"></i>
        <span>Reporte General</span>

    </a>

</li>

@endif

</ul>

</nav>

<!-- CONTENIDO -->
<div class="main-panel">

<div class="content-wrapper">

@yield('content')

</div>

</div>

</div>

<!-- FOOTER -->
<footer class="footer text-center py-2">

© 2025 SOPAD

</footer>

</div>

<!-- JS -->
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>

<script src="{{ asset('assets/js/off-canvas.js') }}"></script>

<script src="{{ asset('assets/js/misc.js') }}"></script>

<!-- CHATBOT -->
<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>

<df-messenger
    intent="WELCOME"
    chat-title="SOPAD"
    agent-id="985164b6-eba2-4c0a-b2f0-684f1d4452b5"
    language-code="es">
</df-messenger>

</body>
</html>