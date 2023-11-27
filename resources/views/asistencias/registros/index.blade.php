@extends('layouts.admin')
@section('content')
<div class="container-xl">

    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Lista de Registros de Asistencia</b>

        </div>
        <div class="col-md-4 text-right">
            <div class="btn-group">
                <select id="filtro" aria-label="Seleciona los registros" class="form-control">
                    <option value="todos" {{ $filtro == 'todos' ? 'selected' : '' }}>Todos</option>
                    <option value="actual" {{ $filtro == 'actual' ? 'selected' : '' }}>Hoy</option>
                    <option value="mensual" {{ $filtro == 'mensual' ? 'selected' : '' }}>Mensual</option>
                </select>
            </div>
            <div class="btn-group">

            </div>

            <a class="tts:left tts-slideIn tts-custom" aria-label="Registrar Asistencia" href="{{route('registroasistencia.create')}}">
                <button class="btn btn-sm btn-primary font-verdana" type="button">
                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                </button>
            </a>

            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
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
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="registroAsistenciaModal" tabindex="-1" role="dialog" aria-labelledby="registroAsistenciaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registroAsistenciaModalLabel">Registrar Asistencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div id="error-message" class="alert alert-danger" style="display: none;"></div>


            <!-- Aquí puedes agregar los campos del formulario para registrar la asistencia -->
            <div class="modal-body">
                <form id="registroAsistenciaForm" method="POST" action="{{ route('registroasistencia.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="pin">PIN</label>
                        <div class="row">
                            <div class="col-3">
                                <input type="text" class="form-control pin-input" id="pin1" name="pin[]" maxlength="1" required>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control pin-input" id="pin2" name="pin[]" maxlength="1" required>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control pin-input" id="pin3" name="pin[]" maxlength="1" required>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control pin-input" id="pin4" name="pin[]" maxlength="1" required>
                            </div>
                        </div>
                    </div>


                    <!-- Aquí puedes agregar los campos del formulario -->
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" readonly="true" required>
                    </div>

                    <div class="form-group">
                        <label for="hora">Hora</label>
                        <input type="time" class="form-control" id="hora" name="hora" value="{{ date('H:i:s') }}" readonly="true" required>
                    </div>

                    <!-- Otros campos del formulario -->

                </form>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>



@section('scripts')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "dom": '<"top"Bf>lrtip',
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
            rowGroup: {
                dataSrc: 'fecha'
            },
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
                    class: 'text-justify p-1 font-verdana-sm'
                },
            ],

            buttons: [{
                extend: 'colvis',
                collectionLayout: 'fixed columns',
                collectionTitle: 'Control de Visibilidad de Columnas',
                className: 'btn btn-sm btn-info',
            }],



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