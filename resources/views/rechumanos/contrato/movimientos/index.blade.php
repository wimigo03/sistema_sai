@extends('layouts.admin')

@section('content')
<div class="container-xl">
 
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b> Movimientos Personal Contrato</b>
        </div>
        <div class="col-md-4 text-right">
            
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>

   
    <div class="row font-verdana">
        <div class="col-md-12">
            <table class="table-bordered table-hover display hover compact font-verdana" id="movimientosplanta-table" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Nombres Apellidos</th>
                        <th>Motivo</th>
                        <th>Area Anterior</th>
                        <th>Cargo Anterior</th>
                        <th>Nombre Cargo</th>
                        <th>Haber Basico</th>
                      
                        <th>Area Nueva</th>
                        <th>Cargo Nueva</th>
                        <th>Nombre Cargo</th>
                        <th>Haber Basico</th>
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
      
        $('#movimientosplanta-table').DataTable({
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
            ajax: "{{ route('movimientoscontrato.index') }}",
            columns: [{
                    data: 'fecha',
                    name: 'fecha',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'nombres_apellidos',
                    name: 'nombres_apellidos',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'motivo',
                    name: 'motivo',
                    class: 'text-justify p-1 font-verdana-sm'
                }
                ,
                {
                    data: 'areactual',
                    name: 'areactual',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'cargoactual',
                    name: 'cargoactual',
                    class: 'text-justify p-1 font-verdana-sm'
                }
                ,
                {
                    data: 'nombrecargoactualpt',
                    name: 'nombrecargoactualpt',
                    class: 'text-justify p-1 font-verdana-sm'
                },{
                    data: 'haberbasicoactualpt',
                    name: 'haberbasicoactualpt',
                    class: 'text-justify p-1 font-verdana-sm'
                }
                ,{
                    data: 'nombreareanuevopt',
                    name: 'haberbasicoactualpt',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                
                {
                    data: 'cargonuevopt',
                    name: 'cargonuevopt',
                    class: 'text-justify p-1 font-verdana-sm'
                }
                ,
                
                {
                    data: 'nombrecargonuevopt',
                    name: 'nombrecargonuevopt',
                    class: 'text-justify p-1 font-verdana-sm'
                }
                ,
                
                {
                    data: 'haberbasiconuevopt',
                    name: 'haberbasiconuevopt',
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