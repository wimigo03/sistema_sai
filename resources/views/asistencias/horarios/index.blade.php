@extends('layouts.admin')

@section('content')
<div class="container-xl font-verdana-bg">
    <div class="row font-verdana-bg">
        <div class="col-md-12">
            <hr>
            @if(Session::has('pendiente'))
            <div class="alert alert-danger font-verdana-bg">
                {{ Session::get('pendiente') }}
            </div>
            <hr>

            @endif

            @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            <hr>

            @endif
            @if(Session::has('error'))
            <div class="alert alert-danger font-verdana-bg">
                {{ Session::get('error') }}
            </div>
            <hr>

            @endif
        </div>
    </div>
    <div class="row font-verdana-bg">
        <div class="col-md-6 titulo">
            <b>Horario Activo:   </b> 
            @if(isset($horarioActivo))
            {{$horarioActivo->Nombre}}
            @else
            <span class="text-danger font-weight-bold">--Sin Horario--</span>
            @endif<p>
 
        </div>

        @can('horario_access')
        <div class="col-md-6 text-right">
            <a href="{{ route('horarios.fechas') }}" class="tts:left tts-slideIn tts-custom" aria-label="Ver Fechas">
                <button class="btn btn-sm btn-warning text-white font-verdana" type="button" aria-label="Ver Empleados ">
                    Fechas&nbsp;<i class="fa-sharp fa-solid fa-calendar"></i>&nbsp;
                </button>
            </a>
            <a href="{{ route('empleadoasistencias.index') }}" class="tts:left tts-slideIn tts-custom" aria-label="Ver Empleados">
                <button class="btn btn-sm btn-info font-verdana" type="button" aria-label="Ver Empleados ">
                    Empleados&nbsp;<i class="fa-sharp fa-solid fa-people-arrows"></i>&nbsp;
                </button>
            </a>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

            <a href="{{ route('horarios.create') }}" class="tts:left tts-slideIn tts-custom" aria-label="Crear Nuevo Horario">
                <button class="btn btn-sm btn-success font-verdana" type="button" aria-label="Agregar Nuevo Horario">
                    Agregar Nuevo Horario&nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
        @endcan
    </div>
    <div class="body-border ">

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="empleado">
                        <b>Fecha Actual</b>
                    </label>
                    <input type="date" id="fecha_actual" name="fecha_actual" value="{{ date('Y-m-d') }}" class="form-control" readonly>
                </div>
            </div>

            @if(isset($horarioActivo) && $horarioActivo->tipo == 1)
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fecha_inicio2"><b>Entrada</b> </label>
                    <input type="time" id="fecha_inicio" name="fecha_inicio" value="{{ $horarioActivo->hora_inicio }}" class="form-control" readonly>

                    <label for="fecha_inicio2"><b>Salida</b></label>
                    <input type="time" id="fecha_inicio" name="fecha_inicio" value="{{ $horarioActivo->hora_salida }}" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="hora_entrada"><b>Entrada</b></label>
                    <input type="time" id="hora_entrada" name="hora_entrada" value="{{ $horarioActivo->hora_entrada }}" class="form-control" readonly>

                    <label for="hora_final"><b>Salida</b></label>
                    <input type="time" id="hora_final" name="hora_final" value="{{ $horarioActivo->hora_final }}" class="form-control" readonly>
                </div>
            </div>
            @elseif(isset($horarioActivo) && $horarioActivo->tipo == 0)
            <div class="col-md-4">
                <div class="form-group">
                    <label for="hora_inicio">Horario Entrada</label>
                    <input type="time" id="hora_inicio" name="hora_inicio" value="{{ $horarioActivo->hora_inicio }}" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="hora_final">Horario Salida</label>
                    <input type="time" id="hora_final" name="hora_final" value="{{ $horarioActivo->hora_final }}" class="form-control" readonly>
                </div>
            </div>
            @else
            <div class="col-md-8">
                <div class="form-group">
                    <label for="fecha_inicio2"><b>Horario</b></label>
                    <div class="alert alert-warning">
                        No hay un horario activo selecionado para la fecha actual.
                    </div>
                </div>
            </div>
            @endif
        </div>

    </div>

    <hr>
    <div class="row font-verdana-bg">
        <div class="col-md-6 titulo">
            <b>Lista de Horarios de Trabajo</b>
        </div>

        <div class="col-md-12 table-responsive center">
            <table id="horarios-table" class="table-bordered yajra-datatable hoverTable table display responsive font-verdana" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Horario</th>
                        <th>Mañana</th>
                        <th>Tarde</th>
                        <th>Asignados</th>
                        <th>Excepcion</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmar Actualización de Estado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas cambiar el estado de este horario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmBtn">Confirmar</button>
            </div>
        </div>
    </div>
</div>



@section('scripts')
<script>
    function confirmUpdateState(form) {
        $('#confirmModal').modal('show');
        $('#confirmBtn').unbind().click(function () {
            $('#confirmModal').modal('hide');
            submitForm(form);
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#horarios-table').DataTable({
            serverSide: true,
            processing: true,
            lengthChange: false,
            searching: true,
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
            ajax: "{{ route('horarios.index') }}",
            

            columns: [{
                    className: 'text-center p-1 font-verdana',
                    data: 'Nombre',
                    name: 'Nombre'
                },
                {
                    className: 'text-center p-1 font-verdana',
                    data: 'mañana',
                    name: 'mañana'
                },
                {
                    className: 'text-center p-1 font-verdana',
                    data: 'tarde',
                    name: 'tarde'
                },
                {
                    className: 'text-center p-1 font-verdana',
                    data: 'asignados',
                    name: 'asignados'
                },
                {
                    className: 'text-center p-1 font-verdana',
                    data: 'excepcion',
                    name: 'excepcion'
                },

                {
                    className: 'text-center p-1 font-verdana',
                    data: 'estado',
                    name: 'estado'
                },
                {
                    className: 'text-center p-1 font-verdana',
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });
        $('#horarios-table').on('draw.dt', function() {
            $('ul.pagination').addClass('pagination-sm');
        }).DataTable();
    });
</script>
<script>
    function submitForm(link) {
        var form = link.parentNode; // Obtener el formulario padre del enlace
        form.submit(); // Enviar el formulario
    }
</script>

<!-- Agrega este código en tu vista Blade -->

@endsection
@endsection