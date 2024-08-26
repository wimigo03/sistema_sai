<!DOCTYPE html>
@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>FORMULARIO ACTUALIZAR PROFESION / OCUPACION</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <form action="#" method="post" id="form">
            @csrf
            <input type="hidden" name="ocupacion_id" value="{{ $ocupacion->id }}">
            @include('canasta_v2.ocupacion.partials.form')
            <div class="form-group row">
                <div class="col-md-10 text-right">
                    <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                        <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar
                    </span>
                    <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                        <i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
                    </span>
                    <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </div>
            </div>
        </form>
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

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function procesar() {
            if (validar()) {
                var url = "{{ route('ocupacion.update') }}";
                $("#form").attr('action', url);
                $("#form").submit();
            }
        }

        function validar() {
            if ($("#tipo >option:selected").val() == "") {
                Modal("<b>[Tipo es obligatorio]</b>");
                return false;
            }

            if ($("#nombres").val() == "") {
                Modal("<b>[Detalle es obligaorio]</b>");
                return false;
            }

            return true;
        }

        function cancelar(){
            window.location.href = "{{ route('ocupacion.index') }}";
        }
    </script>
@endsection
