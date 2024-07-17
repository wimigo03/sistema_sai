@extends('layouts.admin')
<style>
    tfoot {
        display: table-row-group;
    }

    thead {
        display: table-header-group ;
    }
</style>
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>ARCHIVOS - {{ $personal->nombrearea }}</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('archivos.partials.search')
        @include('archivos.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#tipo_id').select2({
            theme: "bootstrap4",
            placeholder: "-- Tipo --",
            width: '100%'
        });

        var cleave = new Cleave('#fecha', {
            date: true,
            datePattern: ['d', 'm', 'Y']
        });

        $("#fecha").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true,
        });

        $('#dataTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('archivos.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    class: 'text-center p-1 font-roboto-10'
                },
                {
                    data: 'gestion',
                    name: 'a.gestion',
                    class: 'text-center p-1 font-roboto-10'
                },
                {
                    data: 'fecha',
                    name: 'a.fecha',
                    class: 'text-center p-1 font-roboto-10'
                },
                {
                    data: 'nombrearchivo',
                    name: 'a.nombrearchivo',
                    class: 'text-center p-1 font-roboto-10'
                },
                {
                    data: 'referencia',
                    name: 'a.referencia',
                    class: 'text-justify p-1 font-roboto-10'
                },
                {
                    data: 'nombretipo',
                    name: 't.nombretipo',
                    class: 'text-justify p-1 font-roboto-10'
                },
                {
                    data: 'btn',
                    name: 'btn',
                    class: 'text-center p-1 font-roboto-10',
                    orderable: false,
                    searchable: false
                }
            ],
            initComplete: function () {
                    this.api()
                        .columns()
                        .every(function () {
                            let column = this;
                            let title = column.footer().textContent;
                            if(title != ''){
                                let input = document.createElement('input');
                                input.placeholder = title;
                                input.className = 'form-control form-control-sm font-roboto-12';
                                column.footer().replaceChildren(input);
                                $(input).appendTo($(column.footer()).empty()).on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? val : '', true, false).draw();
                                });
                            }
                        });
                },
                order: [[2, 'desc'],[3, 'asc']],
                language: datatableLanguageConfig
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function valideNumberSinDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 8) {
                return true;
            } else {
                return false;
            }
        }

        function procesar(){
            var url = "{{ route('archivos.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function excel(){
            var url = "{{ route('archivos.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            window.location.href = "{{ route('archivos.index') }}";
        }

        function create(){
            window.location.href = "{{ route('archivos.create') }}";
        }
    </script>
@endsection

