@extends('layouts.admin')

@section('content')
<div class="container">
<div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lista de Copias de Seguridad</div>

                    <div class="card-body">
                    <form action="{{ route('backups.create') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Realizar Copia de Seguridad</button>
            </form>
                        <a href=" class="btn btn-primary mb-3">Crear Copia de Seguridad</a>

                        <ul>
        
        </ul>
                    </div>
                </div>
            </div>
        </div>
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Lista General de Huellas Dactilares Registradas</b>
        </div>
        <div class="col-md-4 text-right">
            <form action="{{ route('backup.store') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Realizar Copia de Seguridad</button>
            </form>
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
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

    <div class="row font-verdana">
        <div class="col-md-12 center">
            <table id="dactilar-table" class="table-compact yajra-datatable hoverTable table display responsive font-verdana">

                <thead>
                    <tr>
                        <th>ID</th>

                        <th>FID</th>
                        <th>Nombres y Apellidos</th>
                        <th class="text-center p-1">Agregado por Usuario </th>
                        <th class="text-center p-1">Fecha</th>
                        <th class="text-center p-1">Hace</th>
                        <th class="text-center p-1">Acciones</th>
                    </tr>
                </thead>
            </table>
            <div class="row font-verdana-bg">
                <div class="col-md-12">
                    <hr class="hrr">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Confirmación -->
<div class="modal" id="confirmarEliminarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content  font-verdana-bg">
            <div class="modal-header ">
                <h5 class="modal-title">CONFIRMAR ELIMINACION</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  font-verdana-bg">
                <b>¿Estás seguro de que deseas eliminar la huella dactilar de <span id="nombreEmpleado"></span>?</b>
            </div>
            <div class="modal-footer  font-verdana-bg">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                <a id="confirmarEliminarBtn" class="btn btn-danger" href="#">ELIMINAR</a>
            </div>
        </div>
    </div>
</div>


@section('scripts')
<script>
    $(document).ready(function() {
        $('#dactilar-table').DataTable({
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
            orderFixed: [0, 'asc'],
            //    dataSrc: 'nombres'},
            columns: [{
                    data: 'empleado.idemp',
                    name: 'id',
                    className: 'text-center p-1 ',

                },
                {
                    data: 'fid',
                    name: 'fid',
                    className: 'text-center p-1 ',

                },
                {
                    data: 'nombres',
                    name: 'nombres',
                    orderable: false,

                    className: 'text-left p-1 ',

                },
                {
                    data: 'usuario_creac',
                    name: 'usuario_creac',
                    className: 'text-center p-1 ',

                },
                {
                    data: 'fecha',
                    name: 'fecha',
                    className: 'text-center p-1 ',

                },
                {
                    data: 'created',
                    name: 'created',
                    className: 'text-center p-1 ',

                },
                {
                    data: 'actions',
                    name: 'actions',
                    className: 'text-center p-1 ',

                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [3, 'asc'] // Ordenar por la primera columna ('created_at') de manera ascendente
            ],
            // Ordenar por la primera columna ('created_at') de manera ascendente



        });
        $('#descuentos-table').on('draw.dt', function() {
            $('ul.pagination').addClass('pagination-sm');
        }).DataTable();
        $('#confirmarEliminarModal').on('show.bs.modal', function(event) {
            var enlace = $(event.relatedTarget);
            var nombreEmpleado = enlace.data('nombre');
            var idDactilar = enlace.data('id');

            // Establecer el nombre del empleado en el modal
            $('#nombreEmpleado').text(nombreEmpleado);

            // Configurar el enlace de confirmar eliminación
        });
    });
</script>


@endsection
@endsection