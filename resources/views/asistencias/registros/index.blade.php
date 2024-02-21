@extends('layouts.admin')
@section('content')
<div class="container-xl">

    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Lista de Registros de Asistencia</b>

        </div>
        <div class="col-md-4 text-right titulo">
            <b>FECHA:</b>

            <input type="date" id="filtro" name="fecha_final4" value="{{ $fechaHoy }}" class="form-control-sm" required>
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>


        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <div class="row font-verdana">
        <div class="col-md-12">
            <table id="myTable" class="table-bordered yajra-datatable hoverTable font-verdana-sm" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Nombres Apellidos</th>
                        <th>Horario</th>
                        <th> Entrada<br> Mañana</th>
                        <th> Salida<br> Mañana</th>
                        <th> Entrada <br>Tarde</th>
                        <th> Salida <br>Tarde</th>
                        <th>Minutos <br> Retraso</th>
                        <th>Estado</th>

                        <th>Observaciones</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
 



@section('scripts')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
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
            orderFixed: [0, 'desc'],

            ajax: {
                url: "{{ route('registroasistencia.index') }}",
                data: function(d) {
                    // Agregar parámetro de filtro de fecha
                    d.filtro = $('#filtro').val();
                }

            },

            columns: [{
                    data: 'fecha',
                    name: 'fecha',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'nom_ap',
                    name: 'nom_ap',
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
                    class: 'text-center p-1 font-verdana-sm'
                },
                {
                    data: 'estado',
                    name: 'estado',
                    class: 'text-center p-1 font-verdana-sm'
                },
                {
                    data: 'observ',
                    name: 'observ',
                    class: 'text-center p-1 font-verdana-sm'
                },
            ],

            buttons: [{
                extend: 'colvis',
                collectionLayout: 'fixed columns',
                collectionTitle: 'Control de Visibilidad de Columnas',
                className: 'btn btn-sm btn-info',
            }],
            // cambiar lenguaje a español

            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            }


        });
        $('#myTable').on('draw.dt', function() {
            $('ul.pagination').addClass('pagination-sm');
        }).DataTable();
    });
    $('#filtro').on('change', function() {
        $('#myTable').DataTable().ajax.reload();
        $('#myTable').on('draw.dt', function() {
            $('ul.pagination').addClass('pagination-sm');
        }).DataTable();
    });
</script>
@endsection
@endsection