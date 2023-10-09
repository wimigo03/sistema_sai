@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b> Lista de Retrasos </b>
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
                        <th>Fecha</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Retrasos (Minutos)</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>


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
            ajax: "{{ route('retrasos.index') }}",
            columns: [{
                    data: 'fecha',
                    name: 'fecha',
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
                    data: 'minutos',
                    name: 'minutos',
                    class: 'text-justify p-1 font-verdana-sm'
                }
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
</script>
@endsection
@endsection