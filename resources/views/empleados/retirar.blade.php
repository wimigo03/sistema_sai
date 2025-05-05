@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>RETIRAR PERSONAL</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('empleados.partials.retirar-form')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            var cleave = new Cleave('#fecha_retiro', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_retiro").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
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
            if ($("#fecha_retiro").val() == "") {
                Modal('El campo <b>[Fecha de retiro]</b> es un dato obligaorio.');
                return false;
            }
            if ($("#obs_retiro").val() == "") {
                Modal('El campo <b>[Causa del retiro]</b> es un dato obligatorio.');
                return false;
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('empleado.procesar.retiro') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('empleado.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
