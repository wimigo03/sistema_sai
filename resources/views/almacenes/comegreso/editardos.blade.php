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
            <b>FORMULARIO DE EGRESO</b>
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
        <form method="post" action="{{ route('comegreso.update') }}" id="form">
            @csrf
            {{-- @method('PUT') --}}

            <input type="text" hidden name="idcomegreso" value="{{ $comegresos->idcomegreso }}">

            <div class="form-group row">
                <div class="col-md-7">
                    <label for="idprograma" class="d-inline font-verdana-bg">
                        <b>Ubicacion Fisica</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                    </label>
                    <select name="idprograma" id="idprograma" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($programados as $catprogramatica)
                        @if ($catprogramatica->id==$comegresos->iddea)
                        <option value="{{$catprogramatica->id}}" selected>CODIGO: {{$catprogramatica->id}} //NOMBRE: {{$catprogramatica->nombre}} //DESCRIPCION: {{$catprogramatica->descripcion}}</option>
                        @else
                        <option value="{{$catprogramatica->id}}">CODIGO: {{$catprogramatica->id}} //NOMBRE: {{$catprogramatica->nombre}} //DESCRIPCION: {{$catprogramatica->descripcion}}</option>
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
                    <label for="numvale" class="d-inline font-verdana-bg">
                        <b>Nro vale:</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                    </label>
                    <input type="text" disabled name="numvale" value="{{ $comegresos->numvale}} "
                        class="form-control form-control-sm font-verdana-bg" id="numvale" data-language="es"
                        autocomplete="off">
                    <td colspan="8" width="564" style="font-size: 12px;">
                </div>

                <div class="col-md-7">
                    <label for="idcomingreso" class="d-inline font-verdana-bg">
                        <b>Proyecto</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                    </label>
                    <select name="idcomingreso" id="idcomingreso" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($comingresotres as $area)
                            @if ($area->idcomingreso == $comegresos->idcomingreso)
                                <option value="{{ $area->idcomingreso }}" selected>
                                    Nombre:&nbsp;{{ $area->codcatprogramatica }}&nbsp;{{ $area->nombrecatprogramatica }}
                                </option>
                            @else
                                <option value="{{ $area->idcomingreso }}">
                                    Nombre:&nbsp;{{ $area->codcatprogramatica }}&nbsp;{{ $area->nombrecatprogramatica }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <label for="idarea" class="d-inline font-verdana-bg">
                        <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                    </label>
                    <select name="idarea" id="idarea" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($areados as $area)
                            @if ($area->idarea == $comegresos->idarea)
                                <option value="{{ $area->idarea }}" selected>Nombre:&nbsp;{{ $area->idarea }}&nbsp;{{ $area->nombrearea }}</option>
                            @else
                                <option value="{{ $area->idarea }}"> Nombre:&nbsp;{{ $area->idarea }}&nbsp;{{ $area->nombrearea }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="idpartida" class="d-inline font-verdana-bg">
                        <b>Partida</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                    </label>
                    <select name="idpartida" id="idpartida" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($partidados as $area)
                            @if ($area->idpartidacomb == $comegresos->idpartidacomb)
                                <option value="{{ $area->idpartidacomb }}" selected>
                                    Nombre:&nbsp;{{ $area->codigopartida }}&nbsp;{{ $area->nombrepartida }}</option>
                            @else
                                <option value="{{ $area->idpartidacomb }}">
                                    Nombre:&nbsp;{{ $area->codigopartida }}&nbsp;{{ $area->nombrepartida }}</option>
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
                        @foreach ($empleadodos as $area)
                            @if ($area->idemp == $comegresos->idusuario)
                            <option value="{{$area->idemp }}" selected>COD:&nbsp;&nbsp;{{$area->idemp }}&nbsp;&nbsp;NOMB:&nbsp;&nbsp;{{$area->nombres }}&nbsp;{{$area->ap_pat }}&nbsp;{{$area->ap_mat }}&nbsp;Cargo: {{$area->nombrecargo }}&nbsp;Area: {{$area->nombrearea }}</option>
                            @else
                            <option value="{{$area->idemp}}">COD:&nbsp;&nbsp;{{$area->idemp }}&nbsp;&nbsp;NOMB:&nbsp;&nbsp;{{$area->nombres }}&nbsp;{{$area->ap_pat }}&nbsp;{{$area->ap_mat }}&nbsp;Cargo: {{$area->nombrecargo }}&nbsp;Area: {{$area->nombrearea }}</option>
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
                <div class="col-md-6">
                    <label for="idproveedor" class="d-inline font-verdana-bg">
                        <b>Proveedor</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <select  name="idproveedor" id="idproveedor" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($proveedordos as $proveedor)
                        @if ($proveedor->idproveedor==$comegresos->idproveedor)
                        <option value="{{$proveedor->idproveedor}}" selected>COD: {{$proveedor->idproveedor}} //NOMB: {{$proveedor->nombreproveedor}} //DUEÑO: {{$proveedor->representanteproveedor}} //Dir: {{$proveedor->direccionproveedor}} //Tel: {{$proveedor->telefonoproveedor}}
                        </option>
                        @else
                        <option value="{{$proveedor->idproveedor}}">CODIGO: {{$proveedor->idproveedor}} //NOMBRE: {{$proveedor->nombreproveedor}} //DUEÑO: {{$proveedor->representanteproveedor}} //DIRECCION: {{$proveedor->direccionproveedor}} //TELEFONO: {{$proveedor->telefonoproveedor}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>


            </div>
            <div class="form-group row">
                <div class="col-md-12 text-right">
                    {{-- <button class="btn color-icon-2 font-verdana-bg" type="button" onclick="save();">
                        <i class="fa-solid fa-paper-plane"></i>
                        &nbsp;Actualizar
                    </button> --}}
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
    </script>
@endsection
