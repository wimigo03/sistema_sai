@extends('layouts.admin')

@section('content')
<div class="container-xl font-verdana-bg">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{url()->previous()}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
            <b>Lista de Personal Activo</b>
        </div>
        <div class="col-md-4 text-right">

            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>

        </div>
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
                                <th>Nombre</th>
                                <th>Exp. Inducción</th>
                                <th>Exp. Declaración Jurada</th>
                                <th>Exp. Sippase</th>
                                <th>Exp. Rejap</th>
                                <th>Exp. Poai</th>
                                <th>Exp. Programa Vacación</th>
                                <th>Acciones</th>

                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab2">
            <hr class="hr">
            <div class="row font-verdana">
                <hr class="hr">
                <div class="col-md-12 table-responsive center">
                    <table class="table-bordered yajra-datatable hoverTable table display responsive font-verdana" id="empleados-table2" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombres y Apellidos</th>
                                <th>Expiracion de SIPPASE</th>
                                <th>Expiracion de REJAP</th>
                                <th>Exp. Inducción</th>
                                <th>Acciones</th>

                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Modal para editar -->

<div class="modal fade" id="EditarModal" tabindex="-1" role="dialog" aria-labelledby="EditarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editarForm" method="POST" action="{{route('planta.actualizar')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="EditarModalLabel">Editar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Campos de edición -->
                    <input type="text" id="nombreEditar" class="form-control mb-2" readonly>
                    <input type="hidden" id="idEditar">

                    <!-- Campos de tipo date en dos columnas -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="fecha1">Fecha 1:</label>
                            <input type="date" id="fecha1" name="fecha1" class="form-control mb-2">
                            
                            <label for="fecha2">Fecha 2:</label>
                            <input type="date" id="fecha2" name="fecha2" class="form-control mb-2">
                            
                            <label for="fecha3">Fecha 3:</label>
                            <input type="date" id="fecha3" name="fecha3" class="form-control mb-2">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha4">Fecha 4:</label>
                            <input type="date" id="fecha4" name="fecha4" class="form-control mb-2">
                            
                            <label for="fecha5">Fecha 5:</label>
                            <input type="date" id="fecha5" name="fecha5" class="form-control mb-2">
                            
                            <label for="fecha6">Fecha 6:</label>
                            <input type="date" id="fecha6" name="fecha6" class="form-control mb-2">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
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
            ajax: "{{ route('planta') }}",

            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nomb_aps',
                    name: 'nomb_aps'
                },
                {
                    data: 'expinduccion',
                    name: 'expinduccion'
                },
                {
                    data: 'expdecjurada',
                    name: 'expdecjurada'
                },
                {
                    data: 'expsippase',
                    name: 'expsippase'
                },
                {
                    data: 'rejap',
                    name: 'rejap'
                },
                {
                    data: 'exppoai',
                    name: 'exppoai'
                },
                {
                    data: 'expprogvacacion',
                    name: 'expprogvacacion'
                }, {
                    data: 'actions',
                    name: 'actions'
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
                        ajax: "{{ route('contrato') }}",

                        columns: [{
                                data: 'idemp',
                                name: 'idemp'
                            },
                            {
                                data: 'nomb_aps',
                                name: 'nomb_aps'
                            },

                            {
                                data: 'expsippase',
                                name: 'expsippase'
                            },
                            {
                                data: 'rejap',
                                name: 'rejap'
                            },
                            {
                                data: 'expinduccion',
                                name: 'expinduccion'
                            }, {
                                data: 'actions',
                                name: 'actions'
                            }
                        ]

                    });
                }
            }
        });

    });
</script>




<script>
    // Captura el evento de mostrar el modal y actualiza los campos según el enlace
    $('#EditarModal').on('show.bs.modal', function(event) {
        var enlace = $(event.relatedTarget);
        var nombre = enlace.data('nombre');
        var id = enlace.data('id');

        // Actualiza los campos del modal con los datos del enlace
        $(this).find('#nombreEditar').val(nombre);
        $(this).find('#idEditar').val(id);
    });
</script>

@endsection
@endsection