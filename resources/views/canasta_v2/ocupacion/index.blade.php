<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>PROFESIONES / OCUPACIONES</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.ocupacion.partials.search')
        @include('canasta_v2.ocupacion.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        var table = $("#dataTable");
        $(document).ready(function() {
            CargarDataTables();
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });
        });

        function CargarDataTables(){
            if ( $.fn.DataTable.isDataTable( table ) ) {
                table.DataTable().destroy();
            }
            table.DataTable({
                bFilter: true,
                responsive: false,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('ocupacion.indexAjax') }}",
                    type: "GET",
                    dataType: "json",
                    data : {
                        ocupacion : $("#ocupacion").val(),
                        tipo : $("#tipo").val(),
                        estado : $("#estado").val(),
                    }
                },
                columns: [
                    {
                        data: 'ocupacion',
                        name: 'a.ocupacion',
                        class: 'text-justify p-1 font-roboto-10'
                    },
                    {
                        data: 'tipos',
                        name: 'tipos',
                        class: 'text-center p-1 font-roboto-10'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        class: 'text-center p-1 font-roboto-10',
                        render: function(data, type, row){
                            if(row.status === 'HABILITADO'){
                                return '<span class="badge-with-padding badge badge-success btn-block">HABILITADO</span>';
                            }else{
                                return '<span class="badge-with-padding badge badge-danger btn-block">NO HABILITADO</span>';
                            }
                        }
                    },
                    @canany(['canasta.barrios.editar'])
                        {
                            data: 'btnActions',
                            class: 'text-center p-1 font-roboto-10',
                            orderable: false,
                            searchable: false
                        }
                    @endcanany
                ],
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function () {
                            let column = this;
                            let title = column.footer().textContent;
                            if(title != ''){
                                let input = document.createElement('input');
                                input.placeholder = '';
                                input.className = 'form-control text-center font-roboto-12 UPPERCASE';
                                column.footer().replaceChildren(input);
                                input.addEventListener('keyup', () => {
                                    if (column.search() !== this.value) {
                                        column.search(input.value).draw();
                                    }
                                });
                            }
                        });
                },
                language: datatableLanguageConfig
            });
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function search(){
            window.location.reload();
        }

        function limpiar(){
            window.location.href = "{{ route('ocupacion.index') }}";
        }

        function create(){
            window.location.href = "{{ route('ocupacion.create') }}";
        }
    </script>
@endsection
