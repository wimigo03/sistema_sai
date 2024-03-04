@extends('layouts.admin')
@section('content')
    @include('layouts.message_alert')
    @if (Session::has('message'))
        <div class="alert alert-success">
            <em> {!! session('message') !!}</em>
        </div>
    @endif
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-2 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="{{ url('/entregas') }}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
        </div>
        <div class="col-md-10 text-right titulo">
            <b>MODULO ENTREGA DE CANASTAS</b>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>

    </div>
    <div>


        <button class="btn btn-outline-info" type="button" data-toggle="collapse" data-target="#collapseExample2"
            aria-expanded="false" aria-controls="collapseExample">
            <i class="fa fa-address-book" aria-hidden="true"></i>
            Agregar Beneficiarios por Barrio
        </button>

        @if($botonImprimir == 1)


            <button class="btn btn-outline-secondary" type="button" data-toggle="collapse" data-target="#collapseExample3"
            aria-expanded="false" aria-controls="collapseExample">
            <i class="fa fa-print" aria-hidden="true"></i>
            Imprimir Boleta por Barrio
        </button>

        @else

        @endif


    </div>


    {{-- collapse agregar por barrio --}}

    <div class="collapse" id="collapseExample2">
        <div class="body-border" style="background-color: #FFFFFF;">
            <form action="{{ route('entregas.agregarporbarrio', $idpaquete) }}" method="post" id="form2">
                @csrf
                <br>
                <input type="hidden" value="{{ $idpaquete }}" id="idcompra" name="idpaquete">
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="barrio" class="d-inline font-verdana-bg">
                            <b>Barrio</b>&nbsp;<span style="font-size:10px;"></span>
                        </label>
                        <select name="barrio" id="barrio" class="form-control form-control-sm ">
                            <option value="">-</option>
                            @foreach ($barrios as $barrio)
                                <option value="{{ $barrio->id }}">{{ $barrio->nombre }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-md-2 ">

                        <button class="btn btn-primary font-verdana-bg" type="button" onclick="save2();">
                            <i class="fa-solid fa-plus"></i>
                            Agregar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- collapse imprimir por barrio --}}

    <div class="collapse" id="collapseExample3">
        <div class="body-border" style="background-color: #FFFFFF;">
            <form action="{{ route('entregas.generarboleta') }}" method="get" id="form3" target="_blank">
                @csrf
                <br>
                <input type="hidden" value="{{ $idpaquete }}" id="idcompra" name="idpaquete">
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="barrio3" class="d-inline font-verdana-bg">
                            <b>Barrio</b>&nbsp;<span style="font-size:10px;"></span>
                        </label>
                        <select name="barrio3" id="barrio3" class="form-control form-control-sm">
                            <option value="">-</option>
                            @foreach ($barrios3 as $barrio3)
                                <option value="{{ $barrio3->id }}">{{ $barrio3->nombre }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-md-2 ">

                        <button class="btn btn-primary font-verdana-bg" type="button" onclick="save3();" >
                            <i class="fa fa-print" aria-hidden="true"></i>
                            Imprimir
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div>
        <hr class="hrr">
    </div>
    <div class="card-body">
        @include('canasta_v2.entregas.partials.search_entrega')
        @include('canasta_v2.entregas.partials.table_entrega')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {


            $('#barrio').select2({
                placeholder: "---------- Seleccionar un Barrio ----------"
            });

            $('#barrio2').select2({
                placeholder: "--Seleccionar--"
            });
            $('#barrio3').select2({
                placeholder: "--Seleccionar--"
            });
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
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }

        function limpiar() {
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('entregas.entrega_index', $idpaquete) }}";
        }

        function show() {
            $(".btn").hide();
            $(".spinner-btn-send").show();
            var idcompra = $("#idcompra").val();
            var url = "{{ route('compras.detalleparcial.principalorden', ':id') }}";
            url = url.replace(':id', idcompra);
            window.location.href = url;
        }

        function print() {
            $(".btn").hide();
            $(".spinner-btn-send").show();

            window.location.href = "{{ route('compras.detalleparcial.show') }}";
        }

        function create() {
            $(".btn").hide();
            $(".spinner-btn-send").show();
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

            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form2").submit();

        }

        function save3() {

            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form3").submit();

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
