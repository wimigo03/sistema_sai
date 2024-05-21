@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>ARCHIVOS - GENERAL</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('archivos.partials.table-full')
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
            ajax: "{{ route('archivos.index.ajax') }}",
            columns: [
                {
                    data: 'gestion',
                    name: 'a.gestion',
                    class: 'text-center p-1 font-roboto-11'
                },
                {
                    data: 'fecha',
                    name: 'a.fecha',
                    class: 'text-center p-1 font-roboto-11'
                },
                {
                    data: 'nombrearchivo',
                    name: 'a.nombrearchivo',
                    class: 'text-justify p-1 font-roboto-11'
                },
                {
                    data: 'referencia',
                    name: 'a.referencia',
                    class: 'text-justify p-1 font-roboto-11'
                },
                {
                    data: 'nombretipo',
                    name: 't.nombretipo',
                    class: 'text-justify p-1 font-roboto-11'
                },
                {
                    data: 'nombrearea',
                    name: 'ar.nombrearea',
                    class: 'text-center p-1 font-roboto-11'
                },
                {
                    data: 'created_at',
                    name: 'a.created_at',
                    class: 'text-center p-1 font-roboto-11'
                },
                {
                    data: 'btn',
                    name: 'btn',
                    orderable: false,
                    searchable: false
                }
            ],

            initComplete: function() {
                this.api().columns(0).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = "100%";
                    $(input).addClass('form-control font-roboto-11')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? val : '', true, false).draw();
                        });
                });


                this.api().columns(1).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = "100%";
                    $(input).addClass('form-control font-roboto-11')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? val : '', true, false).draw();
                        });
                });

                this.api().columns(2).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = "100%";
                    $(input).addClass('form-control font-roboto-11')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(3).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = "100%";
                    $(input).addClass('form-control font-roboto-11')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(4).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = "100%";
                    $(input).addClass('form-control font-roboto-11')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(5).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = "100%";
                    $(input).addClass('form-control font-roboto-11')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(6).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = "100%";
                    $(input).addClass('form-control font-roboto-11')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? val : '', true, false).draw();
                        });
                });

            },
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
