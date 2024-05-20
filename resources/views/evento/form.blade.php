@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR EVENTO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('evento.partials.form')
    </div>
@endsection
@section('scripts')
    <script>
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

        function confirmar(){
            var url = "{{ route('agenda.create') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            window.location.href = "{{ route('agenda.ej.index') }}";
        }

        function validar() {
            if ($("#hora").val() == "") {
                Modal('[EL CAMPO HORA ES OBLIGATORIO]');
                return false;
            }
            if ($("#titulo").val() == "") {
                Modal('[EL CAMPO EVENTO NO PUEDE ESTAR VACIO]');
                return false;
            }
            if ($("#descripcion").val() == "") {
                Modal('[EL CAMPO DETALLES NO PUEDE ESTAR VACIO]');
                return false;
            }
            if ($("#lugar").val() == "") {
                Modal('[EL CAMPO LUGAR NO PUEDE ESTAR VACIO]');
                return false;
            }
            if ($("#coordinar").val() == "") {
                Modal('[EL CAMPO COORDINAR CON, NO PUEDE ESTAR VACIO]');
                return false;
            }
            if ($("#representante").val() == "") {
                Modal('[EL CAMPO REPRESENTANTE NO PUEDE ESTAR VACIO]');
                return false;
            }
            return true;
        }
    </script>
@endsection
