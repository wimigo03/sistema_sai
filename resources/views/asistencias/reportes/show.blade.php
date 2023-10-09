@extends('layouts.admin')

@section('content')
<div class="container ">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Reporte de Retrasos</b>
        </div>

        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('reportes.index')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>


            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
        <div class="col-md-12">
            <b>Fecha Inicio: {{$reporte->fecha_inicio}} Fecha Final {{$reporte->fecha_final}} </b>

            <hr class="hrr">
        </div>
    </div>
    <div class="row font-verdana">
        <div class="col-md-12 table-responsive center">
            <table class="table-bordered display compact yajra-datatable hoverTable table display responsive font-verdana" id="empleados-reportes-table">
                <thead class="font-verdana">
                    <tr class="text-center">
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Minutos de Retraso</th>
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
        $('#empleados-reportes-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
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
            dom: '<"top"Bf>lrtip',
            ajax: "{{ route('reportes.show', $reporte->id) }}",
            columns: [{
                    data: 'empleado',
                    name: 'empleado'
                },
                {
                    data: 'apellidos',
                    name: 'apellidos'
                },
                {
                    data: 'total_retrasos',
                    name: 'total_retrasos'
                },
                {
                    data: 'observaciones',
                    name: 'observaciones'
                }
            ]
        });
    });
</script>
@endsection
@endsection