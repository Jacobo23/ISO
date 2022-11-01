<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ISO') }}</title>
        <style>
            body
            {
                /*
                background-image: url("{{ asset('storage/images/background.jpg') }}");
                background-repeat: repeat;
                background-size: 40px 40px;
                */
            }
        </style>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/common.css') }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- bootstrap css -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        @yield('headers')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen shadow container-fluid"> <!-- bg-gray-100 -->
            @include('layouts.navigation')

            <!-- Page Heading -->
<header class="bg-white shadow">

<div id="divUL">
    <div class="dropdown">
    <button class="dropbtn">Inicio</button>
    <div class="dropdown-content">
        <a href="/inicio/actas_de_reunion"><i class="fa-solid fa-angle-right"></i> Actas de reunión</a>
        <a href="/folders/Lista_de_Pendientes"><i class="fa-solid fa-angle-right"></i> Lista de pendientes</a>
        <a href="/inicio/nosotros"><i class="fa-solid fa-circle-info"></i> Nosotros </a>
    </div>
    </div>

    <div class="dropdown">
    <button class="dropbtn">Usuarios</button>
    <div class="dropdown-content">
        <a href="/usuarios/perfiles_de_usuario"><i class="fa-solid fa-angle-right"></i> Perfiles de usuario</a>
    </div>
    </div>

    <div class="dropdown">
    <button class="dropbtn">Documentos</button>
    <div class="dropdown-content">
        <a href="/documentos/documentos"><i class="fa-solid fa-magnifying-glass"></i> Lista Maestra </a>
        <a href="/documentos/formatos_llenos"><i class="fa-solid fa-angle-right"></i> Formatos llenos</a>
    </div>
    </div>

    <div class="dropdown">
    <button class="dropbtn">4. Contexto de la Organización</button>
    <div class="dropdown-content">
        <a href="/documentos/activo/DGE-MA-GC-02"><i class="fa-solid fa-angle-right"></i> FODA</a>
        <a href="/documentos/activo/DGE-MA-GC-04"><i class="fa-solid fa-angle-right"></i> Partes interesadas</a>
        <a href="/documentos/activo/DGE-MA-GC-01"><i class="fa-solid fa-angle-right"></i> Alcance del SGC</a>
        <a href="/documentos/activo/DGE-MA-GC-07"><i class="fa-solid fa-angle-right"></i> Mapa de procesos</a>
    </div>
    </div>

    <div class="dropdown">
    <button class="dropbtn">5. Liderazgo</button>
    <div class="dropdown-content">
        <a href="/documentos/activo/DGE-MA-GC-05"><i class="fa-solid fa-angle-right"></i> Organigrama Ecex</a>
        <a href="/documentos/activo/DI-MA-GC-48"><i class="fa-solid fa-angle-right"></i> Organigrama David's</a>
        <a href="/liderazgo/perfiles_de_puesto"><i class="fa-solid fa-angle-right"></i> Perfiles de puesto</a>
    </div>
    </div>

    <div class="dropdown">
    <button class="dropbtn">6. Planificación</button>
    <div class="dropdown-content">
        <a href="/documentos/activo/DGE-FR-GC-56"><i class="fa-solid fa-angle-right"></i> Gestion de riesgos</a>
        <a href="/folders/Matriz_de_Riesgos"><i class="fa-solid fa-angle-right"></i> Matríz de riesgos</a>
        <a href="/documentos/activo/DGE-MA-GC-08"><i class="fa-solid fa-angle-right"></i> Planificación de cambios</a>
    </div>
    </div>

    <div class="dropdown">
    <button class="dropbtn">7. Soporte</button>
    <div class="dropdown-content">
        <a href="/documentos/activo/DGE-FR-GC-103"><i class="fa-solid fa-angle-right"></i> Determinación de ambiente de trabajo</a>
        <strong>Capacitaciones</strong>
        <a href="/folders/Matriz_de_Capactaciones"><i class="fa-solid fa-angle-right"></i> Matriz de capacitaciones</a>
        <a href="/documentos/activo/DGE-IT-GC-12"><i class="fa-solid fa-angle-right"></i> Instrucción de trabajo de informacion documentada</a>
    </div>
    </div>

    <div class="dropdown">
    <button class="dropbtn">8. Operaciones</button>
    <div class="dropdown-content">
        <strong>Proveedores</strong>
        <a href="/folders/Lista_de_Proveedores"><i class="fa-solid fa-angle-right"></i> Lista de proveedores</a>
        <a href="/folders/Evaluacion_de_Proveedores"><i class="fa-solid fa-angle-right"></i> Evaluación de poroveedores</a>
        <strong>Salidas no conformes</strong>
        <a href="/documentos/formatos_llenos"><i class="fa-solid fa-angle-right"></i> Formatos llenos</a>
        <a href="/folders/Matriz_de_Salidas_no_Conformes"><i class="fa-solid fa-angle-right"></i> Matriz de salidas <strong>NC</strong></a>
    </div>
    </div>

    <div class="dropdown">
    <button class="dropbtn">9. Evaluación de desempeño</button>
    <div class="dropdown-content">
        <strong>Auditorias</strong>
        <!-- <a href="#"><i class="fa-solid fa-xmark"></i> Calendario de auditorias</a> -->
        <strong></strong>
        <a href="/folders/Auditorias_Internas"><i class="fa-solid fa-angle-right"></i> Auditorias Internas</a>
        <a href="/folders/Auditorias_Externas"><i class="fa-solid fa-angle-right"></i> Auditorias Externas</a>
        <strong></strong>
        <a href="/documentos/activo/DGE-FR-GC-55"><i class="fa-solid fa-angle-right"></i> Revisión por la dirección</a>
        <!-- <a href="#"><i class="fa-solid fa-xmark"></i> Información documentada de los procesos</a> -->
        <strong>Métricos</strong>
        <a href="/folders/Encuestas_de_satisfaccion_al_cliente"><i class="fa-solid fa-angle-right"></i> Evidencia de Métricos</a>
    </div>
    </div>

    <div class="dropdown">
    <button class="dropbtn">10. Mejora</button>
    <div class="dropdown-content">
        <a href="/documentos/activo/DGE-FR-GC-32"><i class="fa-solid fa-angle-right"></i> Mejora continua</a>
        <strong>Acciones correctivas</strong>
        <a href="/folders/Listado_de_Acciones"><i class="fa-solid fa-angle-right"></i> Listado de acciones</a>
        <a href="/folders/Matriz_de_AC"><i class="fa-solid fa-angle-right"></i> Matriz de AC</a>
        <a href="/folders/AC_Pendientes"><i class="fa-solid fa-angle-right"></i> AC pendientes</a>
    </div>
    </div>
</div>

</header>

        <!-- Page Content -->
        @yield('content')
            
        </div>
        <!-- bootstrap JS (down at the end of body) -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

        <!-- MODAL -->

        <!-- Button trigger modal -->
        <button id="linkmodal" type="button" data-bs-toggle="modal" data-bs-target="#alertModal" style="display:none;"></button>

        <!-- Modal -->
        <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="TituloModal" aria-hidden="true">
        <div class="modal-dialog" id="alertModal_content">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModal">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="MsgModal" class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
        </div>

        <script>
            function showModal(titulo,msg)
            {
                $("#MsgModal").html(msg);
                $("#TituloModal").html(titulo);
                $("#linkmodal").click();
            }
        </script>

        <!-- FIN MODAL -->
        @yield('scripts')     
    </body>
</html>