<!DOCTYPE html>
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
        var table = $("#dataTable");
        $(document).ready(function() {
            cargarDatos();
            $('#area_id').select2({
                theme: "bootstrap4",
                placeholder: "-- Area --",
                width: '100%'
            });

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
        });

        function cargarDatos(){
            if ( $.fn.DataTable.isDataTable( table ) ) {
                table.DataTable().destroy();
            }
            table.DataTable({
                "bFilter":true,
                "responsive":true,
                "processing":true,
                "serverSide":true,
                "autoWidth":false,
                'ajax': {
                    url: "{{ route('archivos.index.ajax') }}",
                    type: "get",
                    dataType: 'json',
                    data: {
                        area_id: $("#area_id").val(),
                        gestion: $("#gestion").val(),
                        fecha: $("#fecha").val(),
                        nro_documento: $("#nro_documento").val(),
                        referencia: $("#referencia").val(),
                        tipo_id: $("#tipo_id").val(),
                    }
                },
                "columns": [
                    {
                        data: 'nombrearea',
                        name: 'ar.nombrearea',
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'gestion',
                        name: 'a.gestion',
                        class: 'text-center p-1 font-roboto-11'
                    },
                    {
                        data: 'fecha_c',
                        name: 'a.fecha',
                        class: 'text-center p-1 font-roboto-11',
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
                        class: 'text-left p-1 font-roboto-11'
                    },
                    {
                        data: 'btn',
                        name: 'btn',
                        class: 'text-center p-1 font-roboto-11',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [[1, 'desc'],[2, 'asc']],
                language: datatableLanguageConfig
            });
        }

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
            window.location.reload();
        }

        function excel(){
            var url = "{{ route('archivos.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function pdf(){
            var url = "{{ route('archivos.pdf') }}";
            $("#form").attr('action', url);
            $("#form").attr('target', '_blank');
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

