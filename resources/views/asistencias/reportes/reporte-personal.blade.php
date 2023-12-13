@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b> Reporte de Retrasos de Asistencia Personal  </b>
        </div>
        <div class="col-md-4 text-right">
        <a href="{{ route('previsualizarPdf', ['empleadoId' => $empleado_id, 'fechaInicio' => $fechaInicio, 'fechaFinal' => $fechaFinal]) }}" target="blank_">
            <button class="btn btn-sm btn-info font-verdana " type="button">
                &nbsp;&nbsp;Generar PDF
            </button>
        </a>
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('reportes.create')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>

        </div>
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

            <hr class="hrr">
        </div>
    </div>

    <div class="row font-verdana">
       
        <input type="hidden" id="data1" name="fecha_final" value="{{$empleado_id}}" class="form-control" required>
        <input type="hidden" id="data2" name="fecha_inicio" value="{{ $fechaInicio }}" class="form-control" required>
        <input type="hidden" id="data3" name="fecha_final" value="{{ $fechaFinal }}" class="form-control" required>

        <div class="col-md-12">
            <table class="table-bordered  font-verdana   yajra-datatable hoverTable font-verdana" id="retrasos-table" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>Nombres y Apellidos</th>
                        <th>Minutos de Retraso</th>
                        <th>Descuento Según Haber Básico</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>

</div>
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


@section('scripts')

<script>
    $(document).ready(function() {
        var template = Handlebars.compile($("#details-template").html());

        var dataTable = $('#retrasos-table').DataTable({

            processing: false,
            serverSide: false,
            lengthChange: false,
            searching: false,
            ordering: false,
            // Changed to false if you're not using server-side processing
            ajax: {
                url: "{{route('personalreportes.getReporte') }}",
                type: "GET", // Change the request type to GET
                data: function(d) {
                    // Append parameters to the URL
                    // Append parameters to the URL
                    d.empleado = $('#data1').val();
                    d.fecha_inicio = $('#data2').val();
                    d.fecha_final = $('#data3').val();
                }
            },
            columns: [{
                    className: 'details-control',
                    orderable: false,
                    searchable: false,
                    data: null,
                    defaultContent: ''


                }, {
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

        $('#retrasos-table tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = dataTable.row(tr);
          //  console.log(row.data());

            var tableId = 'registros-' + row.data().idemp;
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(template(row.data())).show();
                initTable(tableId, row.data());
               // console.log(row.data());
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
                ajax: {
                    url: data.details_url,
                    type: "GET", // Change the request type to GET

                },

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


        $('#retrasos-table').on('draw.dt', function() {
            $('ul.pagination').addClass('pagination-sm');
        }).DataTable();
    });
</script>
@endsection
@endsection