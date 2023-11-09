@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b> Lector Dactilar</b>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('retrasos.index') }}" class="tts:left tts-slideIn tts-custom" aria-label="Crear Nuevo Horario">
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
            <table class="table-bordered table-hover display hover compact font-verdana" id="retrasos-table" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Descripcion</th>
                        <th>Modelo</th>
                        <th>Serial</th>
                        <th>Fecha Creacion</th>
                        <th>Fecha Modificacion</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="miModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Regularizar Asistencia</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body form">
                <div class="container">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="book_id" />
                        <div class="form-body">

                            <div class="form-group">
                                <label class="control-label">Nombre y Apellido</label>
                                <input name="book_isbn" placeholder="Nombre y Apellido" class="form-control" type="text" readonly>

                            </div>
                            <div class="form-group">
                                <label class="control-label">Fecha Asistencia</label>

                                <input name="Fecha" placeholder="Fecha Asistencia" class="form-control" type="text" readonly>

                            </div>
                            <div class="form-group">
                                <label class="control-label"></label>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



@section('scripts')
<script>
    var groupColumn = 0;
    var table = $(document).ready(function() {
        $('#retrasos-table').DataTable({
            responsive: true,
            serverSidez: true,
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
            ajax: "{{ route('lectordactilar.index') }}",
            columns: [{
                    data: 'descrip',
                    name: 'descrip',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'serial_lector',
                    name: 'nombres',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'model_lector',
                    name: 'model_lector',
                    class: 'text-justify p-1 font-verdana-sm ', // You can use text-danger for red text
                }
                ,      {
                    data: 'created_at',
                    name: 'created_at',
                    class: 'text-justify p-1 font-verdana-sm ', // You can use text-danger for red text
                }
                ,      {
                    data: 'updated_at',
                    name: 'updated_at',
                    class: 'text-justify p-1 font-verdana-sm ', // You can use text-danger for red text
                },
                      {
                    data: 'estado',
                    name: 'estado',
                    class: 'text-justify p-1 font-verdana-sm', // You can use text-danger for red text
                },
                {
                    data: 'opciones',
                    name: 'opciones',
                    class: 'text-justify p-1 font-verdana-sm'
                },
            ],
            order: [
                [0, 'desc']
            ],
            rowGroup: {
                dataSrc: 'fecha'
            }
        });
        $('#retrasos-table').on('draw.dt', function() {
            $('ul.pagination').addClass('pagination-sm');
        }).DataTable();
    });
    $(document).ready(function() {
        $('#miModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var id = button.data('id'); // Obtener el valor de data-id
            $('#modalIdField').val(id); // Actualizar el campo oculto con el valor del ID
        });
    });
</script>
@endsection
@endsection