<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My App</title>

    <!-- Agrega los estilos CSS de DataTables -->
 
    <link rel="stylesheet" href="{{asset('dataTable_1.10.22\css\responsive.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('dataTable_1.10.22\css\jquery.dataTables.min.css')}}">
    <!--<link rel="stylesheet" href="{{asset('DataTables\datatables.css')}}"> -->
     <link rel="stylesheet" href="{{asset('DataTables\datatables.min.css')}}">
    
    

    
    <!-- Agrega tus estilos personalizados -->

   <link href="{{ asset('admin_assets/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/tooltips.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">-->
</head>

<body>
    <div class="container">
        <!-- Aquí puedes agregar una barra de navegación, encabezado u otros elementos comunes -->
        

        <!-- Contenido de la página -->
        @yield('content')
    </div>

    <!-- Agrega la biblioteca jQuery -->
    
    <script src="{{asset('dataTable_1.10.22\js\jquery-3.5.1.js')}}"></script>
   

    <!-- Agrega el script de DataTables -->
    <script src="{{asset('DataTables\datatables.min.js')}}"></script>
    <script src="{{asset('dataTable_1.10.22\js\jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('dataTable_1.10.22\js\dataTables.responsive.min.js')}}"></script>


    <!-- Scripts adicionales -->
    @stack('scripts')
</body>

</html>
