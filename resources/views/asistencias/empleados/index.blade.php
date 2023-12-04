@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">


        <div class="col-md-12">
            <!-- Dentro de tu vista -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @if(session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
            @endif
        </div>
    </div>
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Lista de Personal Activo</b>
        </div>
        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('horarios.index')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>
        <!-- Vista de retorno (por ejemplo, index.blade.php) -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Resto del contenido de la vista -->
        <!-- Vista de retorno (por ejemplo, index.blade.php) -->
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <!-- Mostrar mensaje de error -->
        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
        @endif


        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab1">Personal Planta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab2">Personal Contrato</a>
            </li>

        </ul>
    </div>
    <div class="tab-content font-verdana">
        <div class="tab-pane fade show active" id="tab1">
            <hr class="hr">

            <div class="row font-verdana">
                <hr class="hr">
                <div class="col-md-12 table-responsive center">
                    <table class="table-bordered yajra-datatable hoverTable table display responsive font-verdana" id="empleados-table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Horarios</th>
                         
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab2">

            <div class="row font-verdana">
                <div class="col-md-12 table-responsive center">
                    <table class="table-bordered yajra-datatable hoverTable table display responsive font-verdana" id="empleados-table2" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Horarios</th>
        
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>

    </div>


</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $('#empleados-table').DataTable({

            responsive: true,
            serverSide: true,
            processing: true,
            language: {
                info: "<span class='font-verdana'>Mostrando _START_ al _END_ de _TOTAL_</span>",
                search: '',
                searchPlaceholder: "Buscar",
                paginate: {
                    next: "<span class='font-verdana'><b>Siguiente</b></span>",
                    previous: "<span class='font-verdana'><b>Anterior</b></span>",
                },
                lengthMenu: "<span class='font-verdana'>Mostrar </span>" +
                    "<select class='form form-control-sm'>" +
                    "<option value='15'>15</option>" +
                    "<option value='50'>50</option>" +
                    "<option value='100'>100</option>" +
                    "<option value='-1'>Todos</option>" +
                    "</select> <span class='font-verdana'>Registros </span>",
                loadingRecords: "<span class='font-verdana'>...Cargando...</span>",
                processing: "<span class='font-verdana'>...Procesando...</span>",
                emptyTable: "<span class='font-verdana'>No hay datos</span>",
                zeroRecords: "<span class='font-verdana'>No hay resultados para mostrar</span>",
                infoEmpty: "<span class='font-verdana'>Ningun registro encontrado</span>",
                infoFiltered: "<span class='font-verdana'>(filtrados de un total de _MAX_ registros)</span>"
            },
            ajax: "{{ route('empleadoasistencias.planta') }}",

            columns: [{
                    data: 'id',
                    name: 'id',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'nombres',
                    name: 'nombres',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'apellidos',
                    name: 'apellidos',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'horario',
                    name: 'horario',
                    class: 'text-justify p-1 font-verdana-sm'
                },
        
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    class: 'text-justify p-1 font-verdana-sm'
                }
            ]

        });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var targetTab = $(e.target).attr("href"); // Get the target tab id

            if (targetTab === "#tab2") {
                // If the second tab is shown, initialize the DataTable for it
                if (!$.fn.DataTable.isDataTable('#empleados-table2')) {
                    $('#empleados-table2').DataTable({

                        responsive: true,
                        serverSide: true,
                        processing: true,
                        language: {
                            info: "<span class='font-verdana'>Mostrando _START_ al _END_ de _TOTAL_</span>",
                            search: '',
                            searchPlaceholder: "Buscar",
                            paginate: {
                                next: "<span class='font-verdana'><b>Siguiente</b></span>",
                                previous: "<span class='font-verdana'><b>Anterior</b></span>",
                            },
                            lengthMenu: "<span class='font-verdana'>Mostrar </span>" +
                                "<select class='form form-control-sm'>" +
                                "<option value='15'>15</option>" +
                                "<option value='50'>50</option>" +
                                "<option value='100'>100</option>" +
                                "<option value='-1'>Todos</option>" +
                                "</select> <span class='font-verdana'>Registros </span>",
                            loadingRecords: "<span class='font-verdana'>...Cargando...</span>",
                            processing: "<span class='font-verdana'>...Procesando...</span>",
                            emptyTable: "<span class='font-verdana'>No hay datos</span>",
                            zeroRecords: "<span class='font-verdana'>No hay resultados para mostrar</span>",
                            infoEmpty: "<span class='font-verdana'>Ningun registro encontrado</span>",
                            infoFiltered: "<span class='font-verdana'>(filtrados de un total de _MAX_ registros)</span>"
                        },
                        ajax: "{{ route('empleadoasistencias.contrato') }}",

                        columns: [{
                                data: 'id',
                                name: 'id',
                                class: 'text-justify p-1 font-verdana-sm'
                            },
                            {
                                data: 'nombres',
                                name: 'nombres',
                                class: 'text-justify p-1 font-verdana-sm'
                            },
                            {
                                data: 'apellidos',
                                name: 'apellidos',
                                class: 'text-justify p-1 font-verdana-sm'
                            },
                            {
                                data: 'horario',
                                name: 'horario',
                                class: 'text-justify p-1 font-verdana-sm'
                            } ,
                            {
                                data: 'actions',
                                name: 'actions',
                                orderable: false,
                                searchable: false,
                                class: 'text-justify p-1 font-verdana-sm'
                            }
                        ]

                    });
                }
            }
        });

    });
</script>
@endsection
@endsection