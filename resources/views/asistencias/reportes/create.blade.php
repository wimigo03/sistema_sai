@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Generar Reportes</b>
        </div>
        <div class="col-md-4  text-right">
            <a href="{{ route('retrasos.index') }}" class="tts:left tts-slideIn tts-custom" aria-label="Ver Historial de Rgularizaciones">
                <button class="btn btn-sm btn-success font-verdana" type="button">
                    <i class="fa-regular fa-address-card"></i>
                    &nbsp; Historial de retrasos General
                </button>
            </a>

            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
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
                <a class="nav-link active" data-toggle="tab" href="#tab1"><b>Reporte de Retrasos de Asistencia</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab2"> <b>Reporte de Registros de Asistencias</b>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab3"></a>
            </li>
        </ul>
    </div>
    <div class="tab-content font-verdana">
        <div class="tab-pane fade show active" id="tab1">
            <div class="col-md-8 titulo">
                <b>Reporte Personal</b>
            </div>
            <div class="body-border ">
                <form method="POST" action="{{ route('reportes.visualizar') }}" id="crearForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="empleado"><b>Nombre de Personal :</b> </label>
                                <select name="empleado" id="empleado" aria-label="Seleciona Personal" required class="form-control">
                                    <option value="">-</option>
                                    @foreach ($empleados as $index => $value)
                                    <option value="{{ $value->idemp }}"> {{ $value->nombres }} {{ $value->ap_pat }} {{ $value->ap_mat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_inicio"><b>Fecha Inicio: </b></label>
                                <?php
                                // Calcular la fecha del mes anterior
                                $fechaMesAnterior = date('Y-m-d', strtotime('first day of last month'));
                                ?>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ $fechaMesAnterior }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_final">Fecha Final</label>
                                <input type="date" id="fecha_final" name="fecha_final" value="" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-4">

                            <label for="fecha_final">Opciones</label>
                            <div class="form-group">
                                <div class="">
                                    <button class="btn btn-info" id="verBtn">Ver Reporte</button>
                                    <!-- Botón para generar PDF -->

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-8 titulo">
                <b>Reporte por Unidad/Area</b>
            </div>
            <div class="body-border ">
                <form method="POST" action="{{ route('reportes.visualizar2') }}" id="crearForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="area"><b>Nombre de Unidad/Area :</b></label>
                                <select name="area_id" id="area_id" aria-label="Selecion de Área" class="form-control" required>
                                    <option value=""></option>
                                    @foreach ($areas as $index => $value)
                                    <option value="{{ $value->idarea }}"> {{ $value->nombrearea }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_inicio2"><b>Fecha Inicio : </b></label>
                                <?php
                                // Calcular la fecha del mes anterior
                                $fechaMesAnterior = date('Y-m-d', strtotime('first day of last month'));
                                ?>
                                <input type="date" id="fecha_inicio2" name="fecha_inicio2" value="{{ $fechaMesAnterior }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_final2"><b>Fecha Final : </b> </label>
                                <input type="date" id="fecha_final2" name="fecha_final2" value="" class="form-control" required>
                            </div>
                        </div>


                        <div class="col-md-4">

                            <label for="opciones"><b>Opciones</b></label>
                            <div class="form-group">
                                <div class="">
                                    <button class="btn btn-info" id="verBtn2">Ver Reporte</button>
                                    <!-- Botón para guardar -->

                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-8 titulo">
                <b>Reporte General</b>
            </div>
            <div class="body-border ">
                <form method="POST" action="{{ route('reportes.visualizar3') }}" id="crearForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha_inicio3"><b>Fecha Inicio : </b></label>
                                <input type="date" id="fecha_inicio3" name="fecha_inicio3" value="" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha_final3"><b>Fecha Final : </b></label>
                                <input type="date" id="fecha_final3" name="fecha_final3" value="" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <label for="opciones"><b>Opciones</b></label>
                            <div class="form-group">

                                <button class="btn btn-info" id="verBtn3">Ver Reporte</button>
                                <!-- Botón para Imprimir -->


                            </div>
                        </div>
                    </div>
                </form>
            </div>


        </div>
        <div class="tab-pane fade" id="tab2">
            <div class="col-md-8 titulo">
                <b>Reporte Personal</b>
            </div>
            <div class="body-border ">
                <form method="POST" action="{{ route('registro.visualizar') }}" id="crearForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="empleado"><b>Nombre de Personal :</b> </label>
                                <select name="empleado2" id="empleado2" aria-label="Seleciona Personal" required class="form-control">
                                    <option value="">-</option>
                                    @foreach ($empleados as $index => $value)
                                    <option value="{{ $value->idemp }}"> {{ $value->nombres }} {{ $value->ap_pat }} {{ $value->ap_mat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_inicio"><b>Fecha Inicio: </b></label>
                                <?php
                                // Calcular la fecha del mes anterior
                                $fechaMesAnterior = date('Y-m-d', strtotime('first day of last month'));
                                ?>
                                <input type="date" id="fecha_inicio4" name="fecha_inicio4" value="{{ $fechaMesAnterior }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_final">Fecha Final</label>
                                <input type="date" id="fecha_final4" name="fecha_final4" value="" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-4">

                            <label for="fecha_final">Opciones</label>
                            <div class="form-group">
                                <div class="">
                                    <button class="btn btn-info" id="verBtn">Ver Reporte</button>
                                    <!-- Botón para generar PDF -->

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="tab3">

        </div>
    </div>
</div>
@section('scripts')
<script>
    $('#empleado').select2({
        placeholder: "--Seleccionar--"
    });
    $('#area_id').select2({
        placeholder: "--Seleccionar--"
    });
</script>
<!-- Agrega estas líneas en tu vista para incluir las bibliotecas -->



@endsection

@endsection


@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Reporte de Retrasos</b>
        </div>
        <div class="col-md-4  text-right">
            <a href="{{ route('retrasos.index') }}" class="tts:left tts-slideIn tts-custom" aria-label="Ver Historial de Rgularizaciones">
                <button class="btn btn-sm btn-success font-verdana" type="button">
                    <i class="fa-regular fa-address-card"></i>
                    &nbsp; Historial de retrasos General
                </button>
            </a>

            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
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
                <a class="nav-link active" data-toggle="tab" href="#tab1">Retrasos por Personal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab2">Retrasos por Unidad</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab3">Retrasos en General</a>
            </li>
        </ul>
    </div>
    <div class="tab-content font-verdana">
        <div class="tab-pane fade show active" id="tab1">
            <div class="body-border ">

                <div class="row">

                </div>
            </div>
            <div class="col-md-12 table-responsive center">
                <table class="table-bordered  hoverTable table display responsive" style="width:100%" id="personal-reportes-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombres</th>
                            <th>Minutos de Retraso</th>
                            <th>Descuento Según Haber Básico</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="tab2">
            <div class="body-border ">
                <div class="row">

                </div>
            </div>
            <div class="col-md-12 table-responsive center">
                <table class="table-bordered  hoverTable table display responsive" style="width:100%" id="area-personal-reportes-table">
                    <thead>
                        <tr class="text-center">
                            <th>Nombres</th>
                            <th>Minutos de Retraso</th>
                            <th>Descuento Según Haber Básico</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>

    </div>
</div>




@section('scripts')


<script>
    $(document).ready(function() {



        verificarFechas();
        var template = Handlebars.compile($("#details-template").html());
        var dataTable = $('#personal-reportes-table').DataTable({
            processing: false,
            serverSide: false,
            dom: '<"top"Bf>lrtip', // Changed to false if you're not using server-side processing
            ajax: {
                url: "{{ route('personalreportes.getReporte') }}",
                type: "GET", // Change the request type to GET
                data: function(d) {
                    // Append parameters to the URL
                    d.empleado = $('#empleado').val();
                    d.fecha_inicio = $('#fecha_inicio').val();
                    d.fecha_final = $('#fecha_final').val();
                }
            },
            columns: [{
                    className: 'details-control',
                    orderable: false,
                    searchable: false,
                    data: null,
                    defaultContent: ''


                }, // Nueva columna para el botón o enlace
                {
                    data: "empleado"
                },
                {
                    data: "total_retrasos"
                },
                {
                    data: "observaciones"
                }
            ],
            initComplete: function(settings, json) {
                // Almacenar los datos en la variable global
                tableDataTab1 = json.data;
            },

        });



        var dataTable2 = $('#area-personal-reportes-table').DataTable({
            processing: false,
            serverSide: false,
            dom: '<"top"Bf>lrtip', // Changed to false if you're not using server-side processing
            ajax: {
                url: "{{ route('areaGetReportes.getReporte') }}",
                type: "GET", // Change the request type to GET
                data: function(d) {
                    // Append parameters to the URL
                    d.area_id = $('#area_id').val();
                    d.fecha_inicio2 = $('#fecha_inicio2').val();
                    d.fecha_final2 = $('#fecha_final2').val();
                }
            },
            columns: [{
                    data: 'empleado',
                    name: 'empleado'
                },
                {
                    data: 'total_retrasos',
                    name: 'total_retrasos'
                },
                {
                    data: 'observaciones',
                    name: 'observaciones'
                },
            ]
        });














    });
</script>
@endsection
@endsection