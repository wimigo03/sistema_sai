@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>MODIFICAR TIPO DE ARCHIVO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('archivos.tipos.partials.editar-form')
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

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function valideNumberSinDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 8) {
                return true;
            } else {
                return false;
            }
        }

        function cancelar(){
            window.location.href = "{{ route('tipos.archivos.index') }}";
        }

        function procesar() {
            var url = "{{ route('tipos.archivos.update') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }
    </script>
@endsection
