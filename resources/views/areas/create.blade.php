@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR AREA</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('areas.partials.create-form')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function procesar() {
            if(!validar()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validar() {
            if($("#tipo >option:selected").val() == ""){
                Modal("El campo de seleccion <b>[TIPO]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#nombre_area").val() == "") {
                Modal('El campo <b>[NOMBRE]</b> es un dato obligaorio.');
                return false;
            }
            if ($("#alias").val() == "") {
                Modal('El campo <b>[ALIAS]</b> es un dato obligaorio.');
                return false;
            }

            return true;
        }

        function confirmar(){
            var url = "{{ route('area.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('area.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
