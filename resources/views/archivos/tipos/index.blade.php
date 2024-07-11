@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>TIPOS DE ARCHIVOS - {{ $personal->nombrearea }}</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('archivos.tipos.partials.search')
        @include('archivos.tipos.partials.table')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
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
            },
                order: [[ 0, "asc" ]]
            });

            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });

        function Modal(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function save(){
            if(validar() == true){
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        }

        function validar(){
            if($("#tipo >option:selected").val() == ""){
                Modal("El <b>[Tipo de archivo]</b> es un dato obligatorio.");
                return false;
            }
            return true;
        }
    </script>
@endsection
