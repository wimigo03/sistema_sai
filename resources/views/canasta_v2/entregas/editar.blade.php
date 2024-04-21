@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>MODIFICAR PAQUETE</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.entregas.partials.editar-form')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });
        });

        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }
        function message_alert(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function confirmar(){
            var url = "{{ route('barrios.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('entregas.index') }}";
        }

        function save() {
            if (validar_formulario() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        }

        function validar_formulario() {

            if ($("#gestion>option:selected").val() == "") {
                message_alert("El campo <b>[Gestion]</b> es un dato obligatorio...");
                return false;
            }


            if ($("#items").val() == "") {
                message_alert("El campo <b>[Items]</b> es un dato obligatorio...");
                return false;
            }



            return true;
        }
    </script>
@endsection
