@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>ENTREGA DE CANASTA</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.entregas.partials.search_entrega')
        <div class="form-group row">
            <div class="col-md-6 pr-1 pl-1">
                @can('canasta.entregas.generar.boleta')
                    @if ($botonImprimir == 1)
                        <button class="btn btn-outline-success font-roboto-12 tts:right tts-slideIn tts-custom" type="button" data-toggle="collapse" aria-label='Imprimir boletas por bloques o barrios.' data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-print fa-fw" aria-hidden="true"></i> Imp.Bol.X.Barrio
                        </button>
                    @endif
                @endcan
                @can('canasta.entregas.generar.boleta')
                    @if ($botonImprimir == 1)
                        <button class="btn btn-outline-danger font-roboto-12 tts:right tts-slideIn tts-custom" type="button" data-toggle="collapse" aria-label='Impresión del detalle de la entrega por barrio - modelo 1' data-target="#collapseExample4" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-print fa-fw" aria-hidden="true"></i> Imp.Det.X.Barrio
                        </button>
                    @endif
                @endcan
                @can('canasta.entregas.generar.boleta')
                    @if ($botonImprimir == 1)
                        <button class="btn btn-outline-warning font-roboto-12 tts:right tts-slideIn tts-custom" type="button" data-toggle="collapse" aria-label='Impresión del detalle de la entrega por barrio - modelo 2' data-target="#collapseExample5" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-print fa-fw" aria-hidden="true"></i> Imp.Det.X.Barrio2
                        </button>
                    @endif
                @endcan
                @can('canasta.entregas.generar.boleta')
                    @if ($botonImprimir == 1)
                        <button class="btn btn-outline-info font-roboto-12 tts:right tts-slideIn tts-custom" type="button" data-toggle="collapse" aria-label='Confirmar la entrega de paquetes por barrio.' data-target="#collapseExample6" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-check fa-fw" aria-hidden="true"></i> Confirmar.Ent.
                        </button>
                    @endif
                @endcan
            </div>
            <div class="col-md-6 pr-1 pl-1">
                @include('canasta_v2.entregas.partials.generar-boleta')
                @include('canasta_v2.entregas.partials.detalle-barrio')
                @include('canasta_v2.entregas.partials.detalle-barrio2')
                @include('canasta_v2.entregas.partials.confirmar_entrega')
                {{--@include('canasta_v2.entregas.partials.agregar-beneficiario')--}}
            </div>
        </div>

        @include('canasta_v2.entregas.partials.agregar-por-barrio')
        @include('canasta_v2.entregas.partials.table_entrega')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            localStorage.clear();
            $('#barrio').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar un Barrio--",
                width: '100%'
            });

            $('#barrio2').select2({
                theme: "bootstrap4",
                placeholder: "--Barrio--",
                width: '100%'
            });
            $('#barrio3').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar un Barrio--",
                width: '100%'
            });
            $('#barrio4').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar un Barrio--",
                width: '100%'
            });

            $('#barrio5').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar un Barrio--",
                width: '100%'
            });

            $('#barrio10').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar un Barrio--",
                width: '100%'
            });

            $('#barrio6').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar un Barrio--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function message_alert(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function procesar() {
            var url = "{{ route('entregas.search_entrega', $idpaquete) }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar() {
            window.location.href = "{{ route('entregas.entrega_index', $idpaquete) }}";
        }

        function show() {
            var idcompra = $("#idcompra").val();
            var url = "{{ route('compras.detalleparcial.principalorden', ':id') }}";
            url = url.replace(':id', idcompra);
            window.location.href = url;
        }

        function print() {
            window.location.href = "{{ route('compras.detalleparcial.show') }}";
        }

        function create() {
            var idcompra = $("#idcompra").val();
            var url = "{{ route('compras.detalleparcial.principal', ':id') }}";
            url = url.replace(':id', idcompra);
            window.location.href = url;
        }

        function save() {
            if (validar_formulario() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        }

        function save2() {
            if (validar_formulario2() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form2").submit();
            }


        }

        function save3() {
            if (validar_formulario3() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form3").submit();
            }

        }

        function save4() {
            if (validar_formulario4() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form4").submit();
            }
        }

        function save5() {
            if (validar_formulario5() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form5").submit();
            }
        }

        function save6() {
            if (validar_formulario6() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form6").submit();
            }
        }

        function cancelar() {
            var url = "{{ route('entregas.index') }}";
            window.location.href = url;
        }

        function validar_formulario() {

            if ($("#beneficiariodatos1").val() == "") {
                message_alert("El campo <b>[Beneficiario]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function validar_formulario2() {

            if ($("#barrio").val() == "") {
                message_alert("El campo <b>[Barrio]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function validar_formulario3() {

            if ($("#barrio3").val() == "") {
                message_alert("El campo <b>[Barrio]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function validar_formulario4() {

            if ($("#barrio4").val() == "") {
                message_alert("El campo <b>[Barrio]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function validar_formulario5() {

            if ($("#barrio5").val() == "") {
                message_alert("El campo <b>[Barrio]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function validar_formulario6() {

            if ($("#barrio6").val() == "") {
                message_alert("El campo <b>[Barrio]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function valideNumber(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code == 46) || (code >= 48 && code <= 57)) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endsection
