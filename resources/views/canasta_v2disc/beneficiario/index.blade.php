@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>BENEFICIARIOS DISC.</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2disc.beneficiario.partials.search')
        @include('canasta_v2disc.beneficiario.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });

            $('#id_distrito').select2({
                theme: "bootstrap4",
                placeholder: "--Distrito--",
                width: '100%'
            });

            $('#id_barrio').select2({
                theme: "bootstrap4",
                placeholder: "--Barrio--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            $('#sexo').select2({
                theme: "bootstrap4",
                placeholder: "--Sexo--",
                width: '100%'
            });

            $('#dataTable').DataTable({
                bFilter: true,
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('beneficiariosdisc.index') }}",
                columns: [{
                        data: 'beneficiario_id',
                        name: 'a.id',
                        class: 'text-center p-1 font-roboto-11'
                    },
                    {
                        data: 'distrito',
                        name: 'c.nombre',
                        class: 'text-center p-1 font-roboto-11'
                    },
                    {
                        data: 'barrio',
                        name: 'b.nombre',
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'nombres',
                        name: 'a.nombres',
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'ap',
                        name: 'a.ap',
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'am',
                        name: 'a.am',
                        class: 'text-justify p-1 font-roboto-11'
                    },
                    {
                        data: 'nro_carnet',
                        name: 'nro_carnet',
                        class: 'text-center p-1 font-roboto-11'
                    },
                    {
                        data: 'sexo',
                        name: 'a.sexo',
                        class: 'text-center p-1 font-roboto-11'
                    },
                    {
                        data: 'edad',
                        name: 'a.ci',
                        class: 'text-center p-1 font-roboto-11'
                    },
                    {
                        data: 'columna_estado',
                        name: 'columna_estado',
                        class: 'text-center p-1 font-roboto-11',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'columna_foto',
                        name: 'columna_foto',
                        class: 'text-center p-1 font-roboto-11',
                        orderable: false,
                        searchable: false
                    },
                    @canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.show'])
                    {
                        data: 'columna_btn',
                        name: 'columna_btn',
                        class: 'text-center p-1 font-roboto-11',
                        orderable: false,
                        searchable: false
                    },
                    @endcanany
                ],
                initComplete: function () {
                    var api = this.api();
                    var columnCount = api.columns().nodes().length;

                    api.columns().every(function (index) {
                        if (index >= columnCount - 2) {
                            return;
                        }
                        var column = this;
                        var input = document.createElement("input");
                        input.style.width = "100%";
                        $(input).addClass('form-control font-roboto-12').appendTo($(column.footer()).empty()).on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? val : '', true, false).draw();
                        });
                    });
                },
                order: [[0, 'desc']],
                language: datatableLanguageConfig
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function procesar(){
            var url = "{{ route('beneficiariosdisc.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }

        function excel() {
            var url = "{{ route('beneficiariosdisc.excel') }}";
            $(".btn").hide();
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
                    a.download = 'beneficiarios.xlsx';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    $(".spinner-btn-send").hide();
                    $(".btn").show();
                },
                error: function(xhr, status, error) {
                    alert('Hubo un error al exportar el archivo: ' + xhr.responseText);
                    $(".spinner-btn-send").hide();
                    $(".btn").show();
                }
            });
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('beneficiariosdisc.index') }}";
        }

        function create(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('beneficiariosdisc.create') }}";
        }
    </script>
@endsection

