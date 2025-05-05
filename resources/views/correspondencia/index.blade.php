@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>_*RECEPCION VENTANILLA*_</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1">
                @can('correspondencia_local.index')
                    <a href="{{ route('correspondencia.local.index') }}" class="btn btn-warning font-roboto-12">
                        <i class="fa fa-envelope fa-fw"></i> Ir a correspondencia actual
                    </a>
                @endcan
            </div>
        </div>
        @include('correspondencia.partials.table')
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
            ajax: "{{ route('correspondencia.index') }}",
            columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'nombres',
                        name: 'e.nombres',
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'ap_pat',
                        name: 'e.ap_pat',
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'ap_mat',
                        name: 'e.ap_mat',
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'nombre_unidad',
                        name: 'u.nombre_unidad',
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'asunto',
                        name: 'r.asunto',
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'fecha_recepcion',
                        name: 'r.fecha_recepcion',
                        class: 'text-center p-1 font-roboto-11'
                    },
                    {
                        data: 'n_oficio',
                        name: 'r.n_oficio',
                        class: 'text-center p-1 font-roboto-11'
                    },
                    {
                        data: 'observaciones',
                        name: 'r.observaciones',
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'btn',
                        name: 'btn',
                        class: 'text-center p-1 font-roboto-11',
                        orderable: false,
                        searchable: false
                    },
                ],


            initComplete: function () {
            this.api().columns(1).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "50px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });


            this.api().columns(2).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "50px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });

            this.api().columns(3).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "50px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });
            this.api().columns(4).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "300px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });
            this.api().columns(5).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "200px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });
            this.api().columns(7).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "50px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });


        }
,
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
    </script>
@endsection


