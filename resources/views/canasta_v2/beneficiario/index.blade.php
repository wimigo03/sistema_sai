<!DOCTYPE html>
@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>BENEFICIARIOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.beneficiario.partials.search')
        @include('canasta_v2.beneficiario.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        var table = $("#dataTable");
        $(document).ready(function() {
            CargarDataTables();
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

            $('#usuario').select2({
                theme: "bootstrap4",
                placeholder: "--Usuario--",
                width: '100%'
            });

            $('#estado_censo').select2({
                theme: "bootstrap4",
                placeholder: "--Censo--",
                width: '100%'
            });

            $('#sexo').select2({
                theme: "bootstrap4",
                placeholder: "--H/M--",
                width: '100%'
            });

            $('#id_ocupacion').select2({
                theme: "bootstrap4",
                placeholder: "--Ocupacion--",
                width: '100%'
            });

            if($("#id_distrito >option:selected").val() != ''){
                var id = $("#id_distrito >option:selected").val();
                getBarrios(id);
            }
        });

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        $('#id_barrio').on('select2:open', function(e) {
            if($("#id_distrito >option:selected").val() == ""){
                Modal("Para continuar se debe seleccionar una <b>[DISTRITO]</b>.");
            }
        });

        $('#id_distrito').change(function() {
            document.getElementById('_id_barrio').value = '';
            var id = $(this).val();
            getBarrios(id);
        });

        $('#id_barrio').change(function() {
            document.getElementById('_id_barrio').value = $(this).val();
        });

        function getBarrios(id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'GET',
                url: '/beneficiarios/get_barrios',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data){
                    if(data.barrios){
                        var arr = Object.values($.parseJSON(data.barrios));
                        $("#id_barrio").empty();
                        var select = $("#id_barrio");
                        select.append($("<option></option>").attr("value", '').text('--Seleccionar--'));
                        var barrioIdSeleccionado = $("#_id_barrio").val();
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.id).text(json.nombre);
                            if (json.id == barrioIdSeleccionado) {
                                opcion.attr('selected', 'selected');
                            }
                            select.append(opcion);
                        });
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

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
                    url: "{{ route('beneficiarios.indexAjax') }}",
                    type: "GET",
                    dataType: "json",
                    data: {
                        id_distrito: $("#id_distrito").val(),
                        id_barrio: $("#_id_barrio").val(),
                        nombre_completo: $("#nombre_completo").val(),
                        ci: $("#ci").val(),
                        sexo: $("#sexo").val(),
                        edad_inicial: $("#edad_inicial").val(),
                        edad_final: $("#edad_final").val(),
                        id_ocupacion: $("#id_ocupacion").val(),
                        estado: $("#estado").val(),
                        usuario: $("#usuario").val(),
                        estado_censo: $("#estado_censo").val(),
                    }
                },
                columns: [
                    {
                        data: 'distrito',
                        name: 'c.nombre',
                        class: 'text-center p-1 font-roboto-10'
                    },
                    {
                        data: 'barrio',
                        name: 'b.nombre',
                        class: 'text-justify p-1 font-roboto-10'
                    },
                    {
                        data: 'nombre_completo',
                        name: 'nombre_completo',
                        class: 'text-justify p-1 font-roboto-10'
                    },
                    {
                        data: 'nro_carnet',
                        name: 'nro_carnet',
                        class: 'text-center p-1 font-roboto-10'
                    },
                    {
                        data: 'sexo',
                        name: 'a.sexo',
                        class: 'text-center p-1 font-roboto-10'
                    },
                    {
                        data: 'edad',
                        name: 'a.ci',
                        class: 'text-center p-1 font-roboto-10'
                    },
                    {
                        data: 'ocupacion',
                        name: 'd.ocupacion',
                        class: 'text-center p-1 font-roboto-10'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        class: 'text-center p-1 font-roboto-10',
                        render: function(data, type, row){
                            if(row.status === 'HABILITADO'){
                                return '<span class="badge-with-padding badge badge-success btn-block">HABILITADO</span>';
                            }else if(row.status == 'FALLECIDO'){
                                return '<span class="badge-with-padding badge badge-danger btn-block">FALLECIDO</span>';
                            }else if(row.status == 'BAJA'){
                                return '<span class="badge-with-padding badge badge-warning btn-block">BAJA</span>';
                            }if(row.status == 'PENDIENTE'){
                                return '<span class="badge-with-padding badge badge-secondary btn-block">PENDIENTE</span>';
                            }if(row.status == 'ELIMINADO'){
                                return '<span class="badge-with-padding badge badge-danger btn-block">ELIMINADO</span>';
                            }else{
                                return 'DESCONOCIDO';
                            }
                        }
                    },
                    {
                        data: 'usuario',
                        name: 'e.name',
                        class: 'text-center p-1 font-roboto-10',
                        render: function(data, type, row) {
                            return data ? data.toUpperCase() : '';
                        }
                    },
                    {
                        data: 'censo_2024',
                        name: 'censo_2024',
                        class: 'text-center p-1 font-roboto-10',
                        render: function(data, type, row){
                            if(row.censo_2024 === 'PENDIENTE'){
                                return '<span class="badge-with-padding badge badge-secondary btn-block">PENDIENTE</span>';
                            }else{
                                return '<span class="badge-with-padding badge badge-success btn-block">CENSADO</span>';
                            }
                        }
                    },
                    {
                        class: 'text-center p-1 font-roboto-10',
                        render: function(data, type, row) {
                            if (row.latitud == null && row.longitud == null) {
                                return 'x';
                            } else {
                                return '<a href="https://www.google.com/maps?q=' + row.latitud + ',' + row.longitud + '" target="_blank">' +
                                    '<i class="fa-solid fa-location-dot fa-lg text-danger"></i>' +
                                    '</a>';
                            }
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'columna_foto',
                        name: 'columna_foto',
                        class: 'text-center p-1 font-roboto-10',
                        orderable: false,
                        searchable: false
                    },
                    @canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.show'])
                    {
                        data: 'columna_btn',
                        name: 'columna_btn',
                        class: 'text-center p-1 font-roboto-10',
                        orderable: false,
                        searchable: false
                    },
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
                procesar();
                event.preventDefault();
            }
        });

        function procesar(){
            window.location.reload();
        }

        function _excel(){
            var url = "{{ route('beneficiarios.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function excel() {
            var url = "{{ route('beneficiarios.excel') }}";
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

        function pdf() {
            var url = "{{ route('beneficiarios.pdf.listar') }}"+"?"+$('#form').serialize();
            window.open(url,"_blank")
        }

        function limpiar(){
            window.location.href = "{{ route('beneficiarios.index') }}";
        }

        function create(){
            window.location.href = "{{ route('beneficiarios.create') }}";
        }
    </script>
@endsection
