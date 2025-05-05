@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>CORRESPONDENCIA DERIVADA - {{ $area }}</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('correspondencia-derivada.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#users-table').DataTable({
            bFilter: true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('correspondencia.derivada.index') }}",
            columns: [{
                    data: 'fechaderivacion',
                    name: 'd.fechaderivacion',
                    class: 'text-justify p-1 font-roboto-10'
                },
                {
                    data: 'created_at',
                    name: 'd.created_at',
                    class: 'text-justify p-1 font-roboto-10'
                },
                {
                    data: 'asunto',
                    name: 'r.asunto',
                    class: 'text-justify p-1 font-roboto-10'
                },

                {
                    data: 'nombreinstruccion',
                    name: 'i.nombreinstruccion',
                    class: 'text-justify p-1 font-roboto-10'
                },

                {
                    data: 'btn',
                    name: 'btn',
                    class: 'text-center p-1 font-roboto-10',
                    orderable: false,
                    searchable: false
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
                "lengthMenu": "<span class='font-roboto-12'>_MENU_</span>",
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
    </script>
@endsection
