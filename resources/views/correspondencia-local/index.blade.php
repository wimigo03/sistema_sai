@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>RECEPCION VENTANILLA</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('correspondencia-local.partials.search')
        @include('correspondencia-local.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        var table = $("#dataTable");
        $(document).ready(function() {
            cargarDatos();

            var cleave = new Cleave('#fecha_i', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_i").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            var cleave = new Cleave('#fecha_f', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_f").datepicker({
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
                    url: "{{ route('correspondencia.local.index.ajax') }}",
                    type: "get",
                    dataType: 'json',
                    data: {
                        nombre_completo: $("#nombre_completo").val(),
                        unidad: $("#unidad").val(),
                        asunto: $("#asunto").val(),
                        fecha_i: $("#fecha_i").val(),
                        fecha_f: $("#fecha_f").val(),
                        codigo: $("#codigo").val(),
                    }
                },
                "columns": [
                    {
                        data: 'remitente_completo',
                        name: 'remitente_completo',
                        class: 'text-justify p-1 font-roboto-10'
                    },
                    {
                        data: 'nombre_unidad',
                        name: 'u.nombre_unidad',
                        class: 'text-justify p-1 font-roboto-10'
                    },
                    {
                        data: 'asunto',
                        name: 'r.asunto',
                        class: 'text-justify p-1 font-roboto-10'
                    },
                    {
                        data: '_fecha_recepcion',
                        name: 'r.fecha_recepcion',
                        class: 'text-center p-1 font-roboto-10'
                    },
                    {
                        data: 'n_oficio',
                        name: 'r.n_oficio',
                        class: 'text-center p-1 font-roboto-10'
                    },
                    {
                        data: 'btn',
                        name: 'btn',
                        class: 'text-center p-1 font-roboto-10',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [[3, 'desc'],[4, 'asc']],
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

        function pdf(){
            var url = "{{ route('correspondencia.local.pdf') }}";
            $("#form").attr('action', url);
            $("#form").attr('target', '_blank');
            $("#form").submit();
        }

        function excel() {
            var url = "{{ route('correspondencia.local.excel') }}";
            $(".btn").hide();
            $(".badge-with-padding").hide();
            $(".spinner-btn-send").show();
            var form = $("#form");
            var formData = form.serialize();
            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(response);
                    a.href = url;
                    a.download = 'RecepcionVentanilla.xlsx';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    $(".spinner-btn-send").hide();
                    $(".btn").show();
                    $(".badge-with-padding").show();
                },
                error: function(xhr, status, error) {
                    alert('Hubo un error al exportar el archivo: ' + xhr.responseText);
                    $(".spinner-btn-send").hide();
                    $(".btn").show();
                }
            });
        }

        function limpiar(){
            window.location.href = "{{ route('correspondencia.local.index') }}";
        }

        function create(){
            window.location.href = "{{ route('correspondencia.local.crear') }}";
        }
    </script>
@endsection
