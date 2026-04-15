<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    tfoot {
        display: table-row-group;
    }

    thead {
        display: table-header-group;
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
        var table = null;

        $(document).ready(function() {
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

            cargarDatos();

            $('.intro').on('keydown', function(event) {
                if (event.key === 'Enter' || event.which === 13) {
                    event.preventDefault();
                    procesar();
                }
            });
        });

        function cargarDatos() {
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
                $('#dataTable tbody').empty();
            }

            table = $('#dataTable').DataTable({
                bFilter: true,
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                searching: true,
                ajax: {
                    url: "{{ route('archivos.index.ajax') }}",
                    type: "GET",
                    dataType: "json",
                    cache: false,
                    data: function(d) {
                        d.area_id = $('#area_id').length ? $('#area_id').val() : '';
                        d.gestion = $('#gestion').val();
                        d.fecha = $('#fecha').val();
                        d.nro_documento = $('#nro_documento').val();
                        d.referencia = $('#referencia').val();
                        d.tipo_id = $('#tipo_id').val();
                        d._token_time = new Date().getTime(); // rompe caché en Chrome
                    }
                },
                columns: [{
                        data: 'nombrearea',
                        name: 'ar.nombrearea',
                        className: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'gestion',
                        name: 'a.gestion',
                        className: 'text-center p-1 font-roboto-11'
                    },
                    {
                        data: 'fecha_c',
                        name: 'a.fecha',
                        className: 'text-center p-1 font-roboto-11'
                    },
                    {
                        data: 'nombrearchivo',
                        name: 'a.nombrearchivo',
                        className: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'referencia',
                        name: 'a.referencia',
                        className: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'nombretipo',
                        name: 't.nombretipo',
                        className: 'text-left p-1 font-roboto-11'
                    },
                    {
                        data: 'btn',
                        name: 'btn',
                        className: 'text-center p-1 font-roboto-11',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'desc'],
                    [2, 'asc']
                ],
                language: datatableLanguageConfig
            });
        }

        function valideNumberSinDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            return ((code >= 48 && code <= 57) || code === 8);
        }

        function procesar() {
            if (table) {
                table.ajax.reload(null, true);
            } else {
                cargarDatos();
            }
        }

        function excel() {
            var url = "{{ route('archivos.excel') }}";
            $("#form").attr('action', url);
            $("#form").removeAttr('target');
            $("#form").submit();
        }

        function pdf() {
            var url = "{{ route('archivos.pdf') }}";
            $("#form").attr('action', url);
            $("#form").attr('target', '_blank');
            $("#form").submit();
        }

        function limpiar() {
            window.location.href = "{{ route('archivos.index') }}";
        }

        function create() {
            window.location.href = "{{ route('archivos.create') }}";
        }

        $(document).on('submit', '.formulario-eliminar', function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();

            if (!confirm('¿Estás seguro de eliminar este registro?')) {
                return false;
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (table) {
                        table.ajax.reload(null, false);
                    }
                },
                error: function(xhr) {
                    alert('Ocurrió un error al eliminar el registro.');
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
