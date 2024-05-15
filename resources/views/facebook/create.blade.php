@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR PUBLICACION</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('facebook.partials.create-form')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var cleave = new Cleave('#fecha', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha").datepicker({
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
            if ($("#fecha").val() == "") {
                Modal('El campo [FECHA] es un dato obligaorio.');
                return false;
            }
            if ($("#nombre").val() == "") {
                Modal('El campo [TITULO] es un dato obligatorio.');
                return false;
            }
            if ($("#enlace").val() == "") {
                Modal('El campo [ENLACE] es un dato obligatorio.');
                return false;
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('facebook.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('facebook.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
