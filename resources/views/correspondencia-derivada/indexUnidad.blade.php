@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>AREAS - UNIDADES - COMUNIDADES</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('correspondencia-local.partials.search-unidad')
        @include('correspondencia-local.partials.table-unidad')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function cancelar(){
            var url = "{{ route('correspondencia.local.index') }}";
            window.location.href = url;
        }
        $(function() {
            var table = $('.yajra-datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('correspondencia.local.unidadIndex') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'nombre_unidad',
                        name: 'u.nombre_unidad',
                        class: 'text-justify p-1 font-roboto-11'
                    },
                ],

                language: {
                    "decimal": "",
                    "emptyTable": "<span class='font-roboto-12'>No hay información</span>",
                    "info": "<span class='font-roboto-12'>Mostrando _START_ a _END_ de _TOTAL_ Entradas</span>",
                    "infoEmpty": "<span class='font-roboto-12'>Mostrando 0 to 0 of 0 Entradas</span>",
                    "infoFiltered": "<span class='font-roboto-12'>(Filtrado de _MAX_ total entradas)</span>",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "<span class='font-roboto-12'>Mostrar _MENU_ Entradas</span>",
                    "loadingRecords": "<span class='font-roboto-12'>Cargando...</span>",
                    "processing": "<span class='font-roboto-12'>Procesando...</span>",
                    "search": "<span class='font-roboto-12'>Buscar:</span>",
                    "zeroRecords": "<span class='font-roboto-12'>Sin resultados encontrados</span>",
                    "paginate": {
                        "first": "<span class='font-roboto-12'>Primero</span>",
                        "last": "<span class='font-roboto-12'>Ultimo</span>",
                        "next": "<span class='font-roboto-12'>Siguiente</span>",
                        "previous": "<span class='font-roboto-12'>Anterior</span>"
                    }
                }
            });



        });
    </script>
@endsection
