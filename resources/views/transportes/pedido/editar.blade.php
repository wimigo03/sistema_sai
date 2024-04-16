@extends('layouts.admin')
@section('content')
    @include('layouts.message_alert')
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-4 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="{{url()->previous()}}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
        </div>
        <div class="col-md-8 text-right titulo">
            <b>FORMULARIO DE SOLICITUD</b>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
        <div class="col-md-4 text-right titulo">
            <b>Fecha Sol.</b>  <b style='color:red'>{{$Fechayhora}}</b>
         
        
        </div> 
        @if($consumos->estadosoluconsumo == '2')
        <div class="col-md-6 text-right titulo">
            <b>Fecha Aprobacion Dir.</b>  <b style='color:red'>{{$Fechayhorar}}</b></div> 
            @elseif($consumos->estadosoluconsumo == '3')
         
            <div class="col-md-6 text-right titulo">
                <b>Fecha Aprobacion Trans.</b>  <b style='color:red'>{{$Fechayhorartra}}</b>
               
            </div> 
            @elseif($consumos->estadosoluconsumo == '10')
         
            <div class="col-md-6 text-right titulo">
                <b>Fecha Respuesta.</b>  <b style='color:red'>{{$Fechayhorar}}</b>
               
            </div> 
        @endif
        
       
    </div>
    <div class="body-border" style="background-color: #FFFFFF;">

        <input type="text" hidden name="idsoluconsumo" value="{{ $soluconsumos->idsoluconsumo }}">
        <div class="form-group row">
            <div class="col-md-3">
                <label for="oficina" class="d-inline font-verdana-bg">
                    <b>Oficina</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea  name="oficina" class="form-control form-control-sm font-verdana-bg" id="oficina">{{ $soluconsumos->oficina }}</textarea>
            </div>
            <div class="col-md-2">
                <label for="cominterna" class="d-inline font-verdana-bg">
                    <b>Control Interno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="cominterna" class="form-control form-control-sm font-verdana-bg" id="cominterna"  value="{{ $soluconsumos->cominterna }}">
            </div>
            {{-- <div class="col-md-3">
                <label for="fechasol" class="d-inline font-verdana-bg">
                    <b> Fecha de solicitud </b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="fechasol" id="fechasol" placeholder="dd/mm/aaaa" data-language="es"
                    class="form-control" value="{{ $soluconsumos->fechasol }} &nbsp;&nbsp;{{ $soluconsumos->horasol }} ">
            </div> --}}
            <div class="col-md-4">
                <label for="referencia" class="d-inline font-verdana-bg">
                    <b>Referencia</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea  name="referencia" class="form-control form-control-sm font-verdana-bg" id="referencia">{{ $soluconsumos->referencia }}</textarea>
            </div>
            <div class="col-md-2">
                <label for="tipo" class="d-inline font-verdana-bg">
                    <b>Tipo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select disabled name="tipo" id="tipo" placeholder="--Seleccionar--" class="form-control form-control-sm select2">

                    <option {{old('tipo',$soluconsumos->tiposoluconsumo)=="1"? 'selected':''}}  value="1">GASOLINA</option>
                    <option {{old('tipo',$soluconsumos->tiposoluconsumo)=="2"? 'selected':''}} value="2">DIESEL</option>

                </select>
            </div> 
            <div class="col-md-6">
                <label for="dirigidoa" class="d-inline font-verdana-bg">
                    <b>Dirigido a:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="dirigidoa" id="dirigidoa" placeholder="--Seleccionar--"
                    class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($encargadotres as $area)
                        @if ($area->idenc == $soluconsumos->dirigidoa)
                            <option value="{{ $area->idenc }}" selected>COD: {{ $area->idenc }} //NOMB:
                                {{ $area->abrev }} {{ $area->nombres }} {{ $area->ap_pat }} {{ $area->ap_mat }}
                                //AREA: {{ $area->nombrearea }} //CARGO: {{ $area->cargo }} </option>
                        @else
                            <option value="{{ $area->idenc }}">CODIGO: {{ $area->idenc }} //NOMBRE:
                                {{ $area->abrev }} {{ $area->nombres }} {{ $area->ap_pat }} {{ $area->ap_mat }}
                                //AREA: {{ $area->nombrearea }} //CARGO: {{ $area->cargo }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="viados" class="d-inline font-verdana-bg">
                    <b>Via:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="viados" id="viados" placeholder="--Seleccionar--"
                    class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($encargadodos as $area)
                        @if ($area->idenc == $soluconsumos->viados)
                            <option value="{{ $area->idenc }}" selected>COD: {{ $area->idenc }} //NOMB:
                                {{ $area->abrev }} {{ $area->nombres }} {{ $area->ap_pat }} {{ $area->ap_mat }}
                                //AREA: {{ $area->nombrearea }} //CARGO: {{ $area->cargo }} </option>
                        @else
                            <option value="{{ $area->idenc }}">CODIGO: {{ $area->idenc }} //NOMBRE:
                                {{ $area->abrev }} {{ $area->nombres }} {{ $area->ap_pat }} {{ $area->ap_mat }}
                                //AREA: {{ $area->nombrearea }} //CARGO: {{ $area->cargo }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="viauno" class="d-inline font-verdana-bg">
                    <b>Via:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="viauno" id="viauno" placeholder="--Seleccionar--"
                    class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($encargado as $area)
                        @if ($area->idenc == $soluconsumos->viauno)
                            <option value="{{ $area->idenc }}" selected>COD: {{ $area->idenc }} //NOMB:
                                {{ $area->abrev }} {{ $area->nombres }} {{ $area->ap_pat }} {{ $area->ap_mat }}
                                //AREA: {{ $area->nombrearea }} //CARGO: {{ $area->cargo }} </option>
                        @else
                            <option value="{{ $area->idenc }}">CODIGO: {{ $area->idenc }} //NOMBRE:
                                {{ $area->abrev }} {{ $area->nombres }} {{ $area->ap_pat }} {{ $area->ap_mat }}
                                //AREA: {{ $area->nombrearea }} //CARGO: {{ $area->cargo }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label for="idarea" class="d-inline font-verdana-bg">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select  name="idarea" id="idarea" class="form-control form-control select2 ">
                    @foreach ($areas as $ar)
                        @if ($ar->idarea == $soluconsumos->idarea)
                            <option value="{{ $ar->idarea }}" selected>{{ $ar->idarea }} - {{ $ar->nombrearea }}
                            </option>
                        @else
                            <option value="{{ $ar->idarea }}">{{ $ar->idarea }} - {{ $ar->nombrearea }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="fechasalida" class="d-inline font-verdana-bg">
                    <b> Fecha de salida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="date" disabled name="fechasalida" id="fechasalida" placeholder="dd/mm/aaaa"
                    data-language="es" class="form-control" value="{{ $soluconsumos->fechasalida }}">

                    <label for="tsalida" class="d-inline font-verdana-bg">
                        <b>Salida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                  
                    <input type="text" disabled name="oficina" 
                    value="{{$NmBraa}}" 
                    class="form-control form-control-sm font-verdana-bg" 
                    id="oficina">

            </div>
            <div class="col-md-3">
                <label for="fecharetorno" class="d-inline font-verdana-bg">
                    <b> Fecha de retorno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="date" disabled name="fecharetorno" id="fecharetorno" placeholder="dd/mm/aaaa"
                    data-language="es" class="form-control" value="{{ $soluconsumos->fecharetorno }}">

                    <label for="tllegada" class="d-inline font-verdana-bg">
                        <b>Llegada</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" disabled name="oficina" 
                    value="{{$NmBraad}}" 
                    class="form-control form-control-sm font-verdana-bg" 
                    id="oficina">
            </div>
            <div class="col-md-6">
                <label for="detallesouconsumo" class="d-inline font-verdana-bg">
                    <b>Detalle de solicitud</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea  name="detallesouconsumo" cols="1" rows="5"
                    class="form-control form-control-sm font-verdana-bg" id="detallesouconsumo">{{ $soluconsumos->detallesouconsumo }}</textarea>
            </div>
         
            <div class="col-md-6">
                <label for="idlocalidad" class="d-inline font-verdana-bg">
                    <b>Localidad</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idlocalidad" id="idlocalidad" class="form-control form-control-sm select2">
                
                    @foreach ($localidades as $local)
                    @if ($local->idlocalidad==$soluconsumos->idlocalidad)
                    <option value="{{$local->idlocalidad}}" selected>COD: {{$local->idlocalidad}} //NOMB: {{$local->nombrelocalidad}} //DISTA: {{$local->distancialocalidad}} KLM //DITRIT: {{$local->distrito}}</option>
                    @else
                    <option value="{{$local->idlocalidad}}">CODIGO: {{$local->idlocalidad}} //NOMBRE: {{$local->nombrelocalidad}} //DISTANCIA: {{$local->distancialocalidad}} KLM //DITRITO: {{$local->distrito}}</option>
                    @endif
                    @endforeach
                </select>
            </div>


        </div>
       
            @if ($soluconsumos->estadosoluconsumo == 1)
                <div class="form-group row">
                    <div class="col-md-4 text-right">
                        <a href="{{ route('upedido.aprovar', $soluconsumos->idsoluconsumo) }}"
                            onclick="return confirm('Se va a aprobar la solicitud...')">
                            <button type="button" class="btn btn-success font-verdana-bg">
                                <i class="fa fa-check" aria-hidden="true"></i>&nbsp;Aprobar&nbsp;
                            </button>
                        </a>
                    </div>

                        <div class="col-md-4 text-right">
                        <a href="{{ route('upedido.rechazar', $soluconsumos->idsoluconsumo) }}"
                            onclick="return confirm('Se va a rechazar la solicitud...')">
                            <button type="button" class="btn btn-danger font-verdana-bg">
                                <i class="fa fa-close" aria-hidden="true"></i>&nbsp;Rechazar&nbsp;
                            </button>
                        </a>
                    </div>
                        <div class="col-md-4 text-right">
                        <a href="{{ route('upedido.solicitud', $soluconsumos->idsoluconsumo) }}">
                            <button type="button" class="btn btn-success font-verdana-bg">
                                <i class="fa fa-check" aria-hidden="true"></i>&nbsp;Imprimir&nbsp;
                            </button>
                        </a>

                    </div>

                 
                </div>
            @endif
            <div class="form-group row">
            @if ($soluconsumos->estadosoluconsumo == 2)
            <div class="col-md-4 text-right titulo">
                
                <b><span style="font-size:20px; color: red;">FORMULARIO APROBADO</span></b>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('upedido.solicitud', $soluconsumos->idsoluconsumo) }}">
                    <button type="button" class="btn btn-success font-verdana-bg">
                        <i class="fa fa-check" aria-hidden="true"></i>&nbsp;Imprimir&nbsp;
                    </button>
                </a>

            </div>
      
            @endif

            @if ($soluconsumos->estadosoluconsumo == 10)
            <div class="col-md-4 text-right titulo">
                
                <b><span style="font-size:20px; color: red;">FORMULARIO RECHAZADO</span></b>

            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('upedido.solicitud', $soluconsumos->idsoluconsumo) }}">
                    <button type="button" class="btn btn-success font-verdana-bg">
                        <i class="fa fa-check" aria-hidden="true"></i>&nbsp;Imprimir&nbsp;
                    </button>
                </a>

            </div>
        </div>
            @endif
            {{-- <div class="form-group row">
            <div class="col-md-12 text-right">
                <a href="{{route('transportes.pedido.aprovar',$soluconsumos->idsoluconsumo)}}" target="_blank">

                <button class="btn color-icon-2 font-verdana-bg" type="button" onclick="save();">
                    <i class="fa-solid fa-paper-plane"></i>
                    &nbsp;Aprovar
                </button>
            </a>
            <a href="{{route('transportes.pedido.rechazar',$soluconsumos->idsoluconsumo)}}" target="_blank">

                <button class="btn btn-danger font-verdana-bg" type="button" >
                    <i class="fa-solid fa-paper-plane"></i>
                    &nbsp;Rechazar
                </button>
            </a>

                <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" 
                style="display: none;"></i>

            </div>
        </div> --}}

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
            window.location.href = "{{ url('transportes/pedidoparcial/index') }}";
        }

        function validar_formulario() {
            if ($("#oficina").val() == "") {
                message_alert("El campo <b>[OFICINA]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#cominterna").val() == "") {
                message_alert("El campo <b>[CONTROL INTERNO]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#fechasol").val() == "") {
                message_alert("El campo <b>[OFICINA]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#dirigidoa >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[Localidad]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#viauno >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[enc]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#referencia").val() == "") {
                message_alert("El campo <b>[OFICINA]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#fechasalida").val() == "") {
                message_alert("El campo <b>[CONTROL INTERNO]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#fecharetorno").val() == "") {
                message_alert("El campo <b>[CONTROL INTERNO]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#detallesouconsumo").val() == "") {
                message_alert("El campo <b>[Detalle]</b> es un dato obligatorio...");
                return false;
            }


            if ($("#tsalida").val() == "") {
                message_alert("El campo <b>[CONTROL INTERNO]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#tllegada").val() == "") {
                message_alert("El campo <b>[CONTROL INTERNO]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#idlocalidad >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[Localidad]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#idarea >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[enc]</b> es un dato obligatorio...");
                return false;
            }


            return true;
        };

        function valideNumber(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if (code >= 48 && code <= 57) {
                return true;
            } else {
                return false;
            }
        }

        $("#fechasol").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

        $("#fechasalida").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

        $("#fecharetorno").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });
    </script>
@endsection
