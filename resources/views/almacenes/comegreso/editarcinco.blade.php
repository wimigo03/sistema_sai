@extends('layouts.admin')
@section('content')
    @include('layouts.message_alert')
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-4 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="{{ url('/comegreso/index') }}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
        </div>
        <div class="col-md-8 text-right titulo">
            <b>FORMULARIO DE EGRESO estado cinco</b>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
        <div class="col-md-2 text-right titulo">
            <b>Cpbte N° </b> <b style='color:red'>{{ $id2 }}</b>

        </div>
        <div class="col-md-4 text-right titulo">
            <b>Fecha</b> <b style='color:red'>{{ $Fechayhorartra }}</b>

        </div>
    </div>
    <div class="body-border" style="background-color: #FFFFFF;">
        <form method="post" action="{{ route('comegreso.updatedos') }}" id="form">
            @csrf
            {{-- @method('PUT') --}}
            <input type="hidden" class="form-control" name="id10" placeholder=""   value="{{$id10}}">
            <input type="text" hidden name="idcomegreso" value="{{ $comegresos->idcomegreso }}">

            <div class="form-group row">
                <div class="col-md-7">
                    <label for="idprograma" class="d-inline font-verdana-bg">
                        <b>Programa</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <select name="idprograma" id="idprograma" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($programacinco as $area)
                            @if ($area->idprogramacomb == $comegresos->idprogramacomb)
                                <option value="{{ $area->idprogramacomb }}" selected>COD:&nbsp;{{ $area->codigoprogr }}  //NOMBR: {{ $area->nombreprograma }} //ID: {{ $area->idprogramacomb }}
                                </option>
                            @else
                                <option value="{{ $area->idprogramacomb }}"> CODIGO:&nbsp;{{ $area->codigoprogr }}  //NOMBRE: {{ $area->nombreprograma }} //ID: {{ $area->idprogramacomb }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tipo" class="d-inline font-verdana-bg">
                        <b>Tipo</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                    </label>
                    <select name="tipo" id="tipo" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($tipos as $area)
                            @if ($area->idtipocomin == $comegresos->idtipocomin)
                                <option value="{{ $area->idtipocomin }}" selected>{{ $area->nombrecoming }}</option>
                            @else
                                <option  value="{{ $area->idtipocomin }}">{{ $area->nombrecoming }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

             
                <div class="col-md-2">
                    <label for="fechaegreso" class="d-inline font-verdana-bg">
                        <b> Fecha</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input   type="text" name="fechaegreso" id="fechaegreso" placeholder="dd/mm/aaaa" data-language="es"
                    class="form-control" value="{{date('d/m/Y', strtotime($comegresos->fechaegreso))}}">
                </div>
                <div class="col-md-7">
                    <label for="idcomingreso" class="d-inline font-verdana-bg">
                        <b>Proyecto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <select name="idcomingreso" id="idcomingreso" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($comingresocinco as $area)
                            @if ($area->idcomingreso == $comegresos->idcomingreso)
                                <option value="{{ $area->idcomingreso }}" selected>COD: {{ $area->codcatprogramatica }} //NOMBR: {{ $area->nombrecatprogramatica }} //ID: {{ $area->idcomingreso }}
                                </option>
                            @else
                                <option value="{{ $area->idcomingreso }}">CODIGO: {{ $area->codcatprogramatica }} //NOMBRE: {{ $area->nombrecatprogramatica }} //ID: {{ $area->idcomingreso }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <label for="idarea" class="d-inline font-verdana-bg">
                        <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <select name="idarea" id="idarea" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($areacinco as $area)
                            @if ($area->idarea == $comegresos->idarea)
                                <option value="{{ $area->idarea }}" selected>COD: {{ $area->idarea }}  //NOMBR: {{ $area->nombrearea }}</option>
                            @else
                                <option value="{{ $area->idarea }}"> CODIGO: {{ $area->idarea }}  //NOMBRE: {{ $area->nombrearea }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="idpartida" class="d-inline font-verdana-bg">
                        <b>Partida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <select name="idpartida" id="idpartida" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($partidacinco as $area)
                            @if ($area->idpartidacomb == $comegresos->idpartidacomb)
                                <option value="{{ $area->idpartidacomb }}" selected>COD: {{ $area->codigopartida }} //NOMBR: {{ $area->nombrepartida }}</option>
                            @else
                                <option value="{{ $area->idpartidacomb }}">CODIGO: {{ $area->codigopartida }} //NOMBRE: {{ $area->nombrepartida }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="idempleado" class="d-inline font-verdana-bg">
                        <b>Recibido Por</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <select name="idempleado" id="idempleado" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($empleadocinco as $area)
                            @if ($area->idemp == $comegresos->idusuario)
                            <option value="{{$area->idemp }}" selected>COD:{{$area->idemp }} //NOMBRES:{{$area->nombres }}&nbsp;{{$area->ap_pat }}&nbsp;{{$area->ap_mat }} //CARGO: {{$area->nombrecargo }} //AREA: {{$area->nombrearea }}</option>
                            @else
                            <option value="{{$area->idemp}}">CODIGO:{{$area->idemp }} //NOMBRES:{{$area->nombres }}&nbsp;{{$area->ap_pat }}&nbsp;{{$area->ap_mat }} //CARGO: {{$area->nombrecargo }} //AREA: {{$area->nombrearea }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <label for="detalle" class="d-inline font-verdana-bg">
                        <b>Glosa</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <textarea name="detalle" cols="1" rows="3" class="form-control form-control-sm font-verdana-bg" id="detalle" onkeyup="convertirAMayusculas(this)">{{$comegresos->detallecomegreso}}</textarea>
                </div>
                <div class="col-md-5">
                    <label for="idproveedor" class="d-inline font-verdana-bg">
                        <b>Proveedor</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <select  name="idproveedor" id="idproveedor" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($proveedores as $area)
                            @if ($area->idproveedor == $comegresos->idproveedor)
                                <option value="{{ $area->idproveedor }}" selected> COD: {{ $area->idproveedor }} //NOMBR: {{ $area->nombreproveedor }} //REPRES: {{ $area->representanteproveedor }} //DIRE:  {{ $area->direccionproveedor }}</option>
                            @else
                                <option value="{{ $area->idproveedor }}"> CODIGO: {{ $area->idproveedor }} //NOMBRE: {{ $area->nombreproveedor }} //REPRESENTANTE: {{ $area->representanteproveedor }} //DIRECCION:  {{ $area->direccionproveedor }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>


            </div>
            <div class="form-group row">
                <div class="col-md-12 text-right">
                    <button class="btn color-icon-2 font-verdana-bg" type="button" onclick="save();">
                        <i class="fa-solid fa-paper-plane"></i>
                        &nbsp;Actualizar
                    </button>
                    <button class="btn btn-danger font-verdana-bg" type="button">

                        <a href="{{ url('/comegreso/index') }}" style="color:white">Cancelar</a>
                    </button>

                    <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send"
                        style="display: none;"></i>

                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });

        function message_alert(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function save() {
            if (validar_formulario() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        }

        function cancelar() {
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ url('comegreso/index') }}";
        }

        function validar_formulario() {
        
            if ($("#idprograma >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[Programa]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#idcomingreso >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[Proyecto]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#idarea >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[Area]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#idpartida >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[Partida]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#detalle").val() == "") {
                message_alert("El campo <b>[Glosa]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#idempleado >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[empleado]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#idproveedor >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[proveedor]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function convertirAMayusculas(input) {
            // Guarda la posición actual del cursor
            var inicioSeleccion = input.selectionStart;
            var finSeleccion = input.selectionEnd;

            // Convierte todo el texto a mayúsculas
            input.value = input.value.toUpperCase();

            // Restaura la posición del cursor
            input.setSelectionRange(inicioSeleccion, finSeleccion);
        }

        function valideNumber(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if (code >= 48 && code <= 57) {
                return true;
            } else {
                return false;
            }
        }

        $("#fechaegreso").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

    </script>
@endsection
