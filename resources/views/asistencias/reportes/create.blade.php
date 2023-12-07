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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="empleado">Nombre de Personal</label>
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
                            <label for="fecha_inicio">Fecha Inicio</label>
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
                                <button class="btn btn-primary" id="verBtn">Ver</button>
                                <!-- Botón para generar PDF -->

                                <button class="btn btn-info" id="generarPdfBtn" type="button">
                                    Imprimir Reporte
                                </button>




                            </div>
                        </div>
                    </div>
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="area">Area</label>
                            <div id="area-select2" class="col-md-12">

                                <select name="area_id" id="area_id" aria-label="Selecion de Área" required>
                                    <option value=""></option>
                                    @foreach ($areas as $index => $value)
                                    <option value="{{ $value->idarea }}"> {{ $value->nombrearea }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_inicio2">Fecha Inicio</label>
                            <input type="date" id="fecha_inicio2" name="fecha_inicio2" value="" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_final2">Fecha Final</label>
                            <input type="date" id="fecha_final2" name="fecha_final2" value="" class="form-control" required>
                        </div>
                    </div>


                    <div class="col-md-4">

                        <label for="opciones">Opciones</label>
                        <div class="form-group">
                            <div class="">
                                <button class="btn btn-primary" id="verBtn2">Ver</button>
                                <!-- Botón para guardar -->
                                <button class="btn btn-info" id="generarPdfBtn2" type="button">
                                    Imprimir Reporte
                                </button>
                            </div>

                        </div>
                    </div>
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
        <div class="tab-pane fade" id="tab3">
            <div class="body-border ">
                <div class="row">


                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_inicio3">Fecha Inicio</label>
                            <input type="date" id="fecha_inicio3" name="fecha_inicio3" value="" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_final3">Fecha Final</label>
                            <input type="date" id="fecha_final3" name="fecha_final3" value="" class="form-control" required>
                        </div>
                    </div>


                    <div class="col-md-4">

                        <label for="opciones">Opciones</label>
                        <div class="form-group">

                            <button class="btn btn-primary" id="verBtn3">Ver</button>
                            <!-- Botón para Imprimir -->
                            <button class="btn btn-info" id="generarPdfBtn3" type="button">
                                Imprimir Reporte
                            </button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 table-responsive center">
                <table class="table-bordered  hoverTable table display responsive" style="width:100%" id="all-personal-reportes-table">
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

<script id="details-template" type="text/x-handlebars-template">
    @verbatim
        <table class="display compact hoverTable" id="registros-{{idemp}}" style="width:100%">
                <thead>
                    <tr>
                        <th>Fecha</th>
                
                        <th>Horario</th>
                        <th> Entrada Mañana</th>
                        <th> Salida Mañana</th>
                        <th> Entrada Tarde</th>
                        <th> Salida Tarde</th>
                        <th>Minutos Retraso</th>
                  
                    </tr>
                </thead>
        </table>
    @endverbatim
</script>
<!-- Agrega estas líneas en tu vista para incluir las bibliotecas -->

<script>
    $(document).ready(function() {

        $('#empleado').select2({
            placeholder: "--Seleccionar--"
        });

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


        $('#personal-reportes-table tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = dataTable.row(tr);
            var tableId = 'registros-' + row.data().idemp;
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(template(row.data())).show();
                initTable(tableId, row.data());
                console.log(row.data());
                tr.addClass('shown');
                tr.next().find('td').addClass('no-padding bg-gray');
            }
        });

        function initTable(tableId, data) {
            $('#' + tableId).DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                lengthChange: false,
                info: false,
                searching: false, // Oculta la barra de búsqueda
                paging: false, // Desactiva la paginación

                ajax: data.details_url,
                columns: [{
                        data: 'fecha',
                        name: 'fecha',
                        class: 'text-justify p-1 font-verdana-sm'
                    },

                    {
                        data: 'horario',
                        name: 'horario',
                        class: 'text-center p-1 font-verdana-sm'
                    },
                    {
                        data: 'registro_inicio',
                        name: 'registro_inicio',
                        class: 'text-center p-1 font-verdana-sm'
                    },
                    {
                        data: 'registro_salida',
                        name: 'registro_salida',
                        class: 'text-center p-1 font-verdana-sm'
                    },
                    {
                        data: 'registro_entrada',
                        name: 'registro_entrada',
                        class: 'text-center p-1 font-verdana-sm'
                    },

                    {
                        data: 'registro_final',
                        name: 'registro_final',
                        class: 'text-center p-1 font-verdana-sm'
                    },
                    {
                        data: 'minutos_retraso',
                        name: 'minutos_retraso',
                        class: 'text-justify p-1 font-verdana-sm'
                    },
                ],
            });
        };


        function verificarFechas() {
            var fechaInicio = $('#fecha_inicio').val();
            var fechaFinal = $('#fecha_final').val();
            $('#verBtn').prop('disabled', !fechaInicio || !fechaFinal);
            $('#generarPdfBtn').prop('disabled', !fechaInicio || !fechaFinal);
        }

        $('#fecha_inicio, #fecha_final', ).on('change', function() {
            // Verificar si ambas fechas están seleccionadas
            var fechaInicio = $('#fecha_inicio').val();
            var fechaFinal = $('#fecha_final').val();
            var empleadoId = $('#empleado').val();

            // Habilitar o deshabilitar el botón "Ver" según la presencia de fechas
            $('#verBtn').prop('disabled', !fechaInicio || !fechaFinal || !empleadoId);
            $('#generarPdfBtn').prop('disabled', !fechaInicio || !fechaFinal || !empleadoId);
        });


        // Apply filter on button click
        $('#verBtn').on('click', function() {
            // Reload the DataTable with new parameters
            dataTable.ajax.reload();
            $('#guardarBtn').prop('disabled', false);
            $('#verBtn').prop('disabled', false);

        });

        $('#generarPdfBtn').on('click', function() {
            // Obtener los datos necesarios para la generación del PDF
            var empleadoId = $('#empleado').val();
            var fechaInicio = $('#fecha_inicio').val();
            var fechaFinal = $('#fecha_final').val();

            // Construir la URL con los parámetros
            var url = "{{ route('previsualizarPdf') }}?empleadoId=" + empleadoId + "&fechaInicio=" + fechaInicio + "&fechaFinal=" + fechaFinal;

            // Redirigir el navegador a la URL
            window.location.href = url;
        });







        var area_select = new SlimSelect({
            select: '#area-select2 select',
            //showSearch: false,
            placeholder: 'Select Permissions',
            deselectLabel: '<span>&times;</span>',
            hideSelectedOption: true,
        });
        verificarFechas2();

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

        function verificarFechas2() {

            var area_id = $('#area_id').val();
            var fechaInicio2 = $('#fecha_inicio2').val();
            var fechaFinal2 = $('#fecha_final2').val();
            $('#verBtn2').prop('disabled', !fechaInicio2 || !fechaFinal2 || !area_id);
            $('#generarPdfBtn2').prop('disabled', !fechaInicio2 || !fechaFinal2 || !area_id);
        }
        $('#fecha_inicio2, #fecha_final2', ).on('change', function() {
            // Verificar si ambas fechas están seleccionadas
            var area_id = $('#area_id').val();
            var fechaInicio = $('#fecha_inicio2').val();
            var fechaFinal = $('#fecha_final2').val();

            // Habilitar o deshabilitar el botón "Ver" según la presencia de fechas
            $('#verBtn2').prop('disabled', !fechaInicio || !fechaFinal || !area_id);
            $('#generarPdfBtn2').prop('disabled', !fechaInicio || !fechaFinal || !area_id);

        });
        $('#verBtn2').on('click', function() {
            // Reload the DataTable with new parameters
            dataTable2.ajax.reload();
            $('#generarPdfBtn2').prop('disabled', false);
            $('#verBtn2').prop('disabled', false);

        });
        $('#generarPdfBtn2').click(function() {
            // Obtener los datos necesarios para la generación del PDF
            var area_id = $('#area_id').val();
            var fechaInicio = $('#fecha_inicio2').val();
            var fechaFinal = $('#fecha_final2').val();

            // Construir la URL con los parámetros
            var url = "{{ route('areaprevisualizarPdf') }}?area_id=" + area_id + "&fechaInicio=" + fechaInicio + "&fechaFinal=" + fechaFinal;

            // Redirigir el navegador a la URL
            window.location.href = url;

        });

        verificarFechas3();

        var dataTable3 = $('#all-personal-reportes-table').DataTable({
            processing: false,
            serverSide: false, // Changed to false if you're not using server-side processing
            ajax: {
                url: "{{ route('allGetReportes.getReporte') }}",
                type: "GET", // Change the request type to GET
                data: function(d) {
                    // Append parameters to the URL

                    d.fecha_inicio2 = $('#fecha_inicio3').val();
                    d.fecha_final2 = $('#fecha_final3').val();
                }
            },
            dom: '<"top"Bf>lrtip',
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

        function verificarFechas3() {
            var fechaInicio3 = $('#fecha_inicio3').val();
            var fechaFinal3 = $('#fecha_final3').val();
            $('#verBtn3').prop('disabled', !fechaInicio3 || !fechaFinal3);
        }
        $('#fecha_inicio3, #fecha_final3', ).on('change', function() {
            // Verificar si ambas fechas están seleccionadas
            var fechaInicio = $('#fecha_inicio3').val();
            var fechaFinal = $('#fecha_final3').val();

            // Habilitar o deshabilitar el botón "Ver" según la presencia de fechas
            $('#verBtn3').prop('disabled', !fechaInicio || !fechaFinal);
        });
        $('#verBtn3').on('click', function() {
            // Reload the DataTable with new parameters
            dataTable3.ajax.reload();
            $('#generarPdfBtn3').prop('disabled', false);
            $('#verBtn3').prop('disabled', false);

        });
        $('#generarPdfBtn3').on('click', function() {
            // Obtener los datos necesarios para la generación del PDF

            var fechaInicio = $('#fecha_inicio3').val();
            var fechaFinal = $('#fecha_final3').val();

            // Construir la URL con los parámetros
            var url = "{{ route('generalReportePdf') }}?fechaInicio=" + fechaInicio + "&fechaFinal=" + fechaFinal;

            // Redirigir el navegador a la URL
            window.location.href = url;
        });





    });
</script>
@endsection
@endsection