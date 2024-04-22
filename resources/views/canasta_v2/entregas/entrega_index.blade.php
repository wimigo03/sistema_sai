@extends('layouts.admin')
@section('content')
    {{--@include('layouts.message_alert')
    @if (Session::has('message'))
        <div class="alert alert-success">
            <em> {!! session('message') !!}</em>
        </div>
    @endif--}}
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>ENTREGA DE CANASTA</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row">
            <div class="col-md-6 pr-1 pl-1">
                @can('canasta.entregas.agregar.porbarrio')
                    <button class="btn btn-outline-info font-roboto-12" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa fa-address-book fa-fw" aria-hidden="true"></i> Agr.X.Barrio
                    </button>
                @endcan
                @can('canasta.entregas.generar.boleta')
                    @if($botonImprimir == 1)
                        <button class="btn btn-outline-secondary font-roboto-12" type="button" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-print fa-fw" aria-hidden="true"></i> Imp.Bol.X.Barrio
                        </button>
                    @endif
                @endcan
                @can('canasta.entregas.generar.boleta')
                    @if($botonImprimir == 1)
                        <button class="btn btn-outline-secondary font-roboto-12" type="button" data-toggle="collapse" data-target="#collapseExample4" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-print fa-fw" aria-hidden="true"></i> Imp.Det.X.Barrio
                        </button>
                    @endif
                @endcan
            </div>
            <div class="col-md-6 pr-1 pl-1">
                @include('canasta_v2.entregas.partials.agregar-por-barrio')
                @include('canasta_v2.entregas.partials.generar-boleta')
                @include('canasta_v2.entregas.partials.detalle-barrio')
            </div>
        </div>
        @include('canasta_v2.entregas.partials.search_entrega')
        @include('canasta_v2.entregas.partials.table_entrega')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
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
            $("#form2").submit();

        }

        function save3() {
            $("#form3").submit();
        }
        function save4() {
            $("#form4").submit();
        }

        function cancelar(){
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
