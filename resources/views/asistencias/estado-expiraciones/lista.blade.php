@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{url()->previous()}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
            <b>Lista de Expiracion de {{$descripcion}} del Personal</b>

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
    </div>

    <div class="row font-verdana">
        <div class="col-md-12 center">
            <table id="registrosTable" class="table-bordered yajra-datatable hoverTable table display responsive font-verdana" style="width:100%; margin: 0 auto;">
                <thead>
                    <tr>
                         <th>Nombres y Apellidos</th>
                         <th>Fecha Específica</th> <!-- Nombre genérico para la cuarta columna -->
                        <th>Descripcion</th> <!-- Nombre genérico para la cuarta columna -->
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
@section('scripts')
<script>
    $(document).ready(function() {
        $('#registrosTable').DataTable({
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
                url: "{{ route('lista.index', $id) }}",
                data: function(d) {
                    // Agregar parámetro de filtro de fecha
                    d.filtro = $('#filtro').val();
                }

            },

            columns: [{
                    data: 'nombre_completo',
                    name: 'nombre_completo',
                    class: 'text-justify p-1 font-verdana-sm'
                },{
                    data: 'fecha',
                    name: 'fecha',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'ColumnaPersonalizada',
                    name: 'ColumnaPersonalizada',
                    class: 'text-justify p-1 font-verdana-sm'
                }
                
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
</script>

@endsection
@endsection