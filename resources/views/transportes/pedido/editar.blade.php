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
</div>
<div class="body-border" style="background-color: #FFFFFF;">
  
        <input type="text" hidden name="idsoluconsumo" 
        value="{{$soluconsumos->idsoluconsumo}}">
   

        <div class="form-group row">

            <div class="col-md-3">
                <label for="oficina" class="d-inline font-verdana-bg">
                    <b>oficina</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea disabled name="oficina"  class="form-control form-control-sm font-verdana-bg" 
                id="oficina" >{{$soluconsumos->oficina}}</textarea>
            </div>

            <div class="col-md-3">
                <label for="cominterna" class="d-inline font-verdana-bg">
                    <b>coninterna</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea disabled name="cominterna" class="form-control form-control-sm font-verdana-bg"
                 id="cominterna" >{{$soluconsumos->cominterna}}</textarea>
            </div>
            
            <div class="col-md-2">
                <label for="fechasol" class="d-inline font-verdana-bg">
                    <b> fechasol</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input   type="text" disabled name="fechasol" id="fechasol" placeholder="dd/mm/aaaa" data-language="es"
            
                class="form-control" value="{{$soluconsumos->fechasol}}"
                >
            </div>
            <div class="col-md-4">
                <label for="referencia" class="d-inline font-verdana-bg">
                    <b>referencia</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea disabled name="referencia"  class="form-control form-control-sm font-verdana-bg" 
                id="referencia" >{{$soluconsumos->referencia}}</textarea>
            </div>
         

            

            <div class="col-md-4">
                <label for="dirigidoa" class="d-inline font-verdana-bg">
                    <b>Dirigido a:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
             
                <input type="text" disabled name="dirigidoa" 
                value="{{$soluconsumos->dirnombre}} " 
               class="form-control form-control-sm font-verdana-bg" 
               id="dirigidoa" data-language="es" autocomplete="off" >
               
            </div>
            
            <div class="col-md-4">
                <label for="viauno" class="d-inline font-verdana-bg">
                    <b>Via:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="dirigidoa" 
                value="{{$soluconsumos->viaunonombre}} " 
               class="form-control form-control-sm font-verdana-bg" 
               id="dirigidoa" data-language="es" autocomplete="off" >
            </div>
         


            <div class="col-md-4">
                <label for="viados" class="d-inline font-verdana-bg">
                    <b>Via:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="dirigidoa" 
                value="{{$soluconsumos->viadosnombre}} " 
               class="form-control form-control-sm font-verdana-bg" 
               id="dirigidoa" data-language="es" autocomplete="off" >
            </div>

            <div class="col-md-3">
                <label for="fechasalida" class="d-inline font-verdana-bg">
                    <b> fechasalida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input   type="text" disabled name="fechasalida" id="fechasalida" placeholder="dd/mm/aaaa" data-language="es"
            
                class="form-control" value="{{$soluconsumos->fechasalida}}"
                >
            </div>

            <div class="col-md-3">
                <label for="fecharetorno" class="d-inline font-verdana-bg">
                    <b> fecharetorno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input   type="text" disabled name="fecharetorno" id="fecharetorno" placeholder="dd/mm/aaaa" data-language="es"
            
                class="form-control" value="{{$soluconsumos->fecharetorno}}"
                >
            </div>


            <div class="col-md-6">
                <label for="detallesouconsumo" class="d-inline font-verdana-bg">
                    <b>detallesouconsumo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea disabled name="detallesouconsumo" cols="1" rows="5" class="form-control form-control-sm font-verdana-bg" 
                id="detallesouconsumo" >{{$soluconsumos->detallesouconsumo}}</textarea>
            </div>


            <div class="col-md-3">
                <label for="tsalida" class="d-inline font-verdana-bg">
                    <b>tsalida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select disabled name="tsalida" id="tsalida" placeholder="--Seleccionar--" class="form-control form-control-sm select2">

                    <option {{old('tsalida',$soluconsumos->tsalida)=="1"? 'selected':''}}  value="1">MAÑANA</option>
                    <option {{old('tsalida',$soluconsumos->tsalida)=="2"? 'selected':''}} value="2">TARDE</option>

                </select>
            </div>

            <div class="col-md-3">
                <label for="tllegada" class="d-inline font-verdana-bg">
                    <b>tllegada</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select disabled name="tllegada" id="tllegada" placeholder="--Seleccionar--" class="form-control form-control-sm select2">

                    <option {{old('tllegada',$soluconsumos->tllegada)=="1"? 'selected':''}}  value="1">MAÑANA</option>
                    <option {{old('tllegada',$soluconsumos->tllegada)=="2"? 'selected':''}} value="2">TARDE</option>

                </select>
            </div>




            <div class="col-md-4">
                <label for="idlocalidad" class="d-inline font-verdana-bg">
                    <b>Localidad</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select disabled name="idlocalidad" id="idlocalidad" class="form-control form-control-sm select2">
                
                    @foreach ($localidades as $local)
                    @if ($local->idlocalidad==$soluconsumos->idlocalidad)
                    <option value="{{$local->idlocalidad}}" selected>
                        {{$local->nombrelocalidad}}</option>
                    @else
                    <option value="{{$local->idlocalidad}}">
                        {{$local->nombrelocalidad}}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-7">
                <label for="idarea" class="d-inline font-verdana-bg">
                    <b>idarea</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select disabled name="idarea" id="idarea" class="col-md-10 form-control select2 ">
                    @foreach ($areas as $ar)
                    @if ($ar->idarea==$soluconsumos->idarea)
                    <option value="{{$ar->idarea}}" selected>{{$ar->idarea}} - {{$ar->nombrearea}}</option>
                    @else
                    <option value="{{$ar->idarea}}">{{$ar->idarea}} - {{$ar->nombrearea}}</option>
                    @endif
                    @endforeach
                </select>
            </div> 

        </div>

        @if ($soluconsumos->estadosoluconsumo == 1)
            <div class="form-group row">
                <div class="col-md-12 text-right">
                    <a href="{{ route('transportes.pedido.aprovar',$soluconsumos->idsoluconsumo) }}">
                        <button type="button" class="btn btn-success font-verdana-bg">
                            <i class="fa fa-check" aria-hidden="true"></i>&nbsp;Aprobar&nbsp;
                        </button>
                    </a>
                    <a href="{{ route('transportes.pedido.rechazar',$soluconsumos->idsoluconsumo) }}">
                        <button type="button" class="btn btn-danger font-verdana-bg">
                            <i class="fa fa-close" aria-hidden="true"></i>&nbsp;Rechazar&nbsp;
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

        function message_alert(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function save(){
            if(validar_formulario() == true){
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{url('transportes/pedidoparcial/index')}}";
        }

        function validar_formulario(){
            if($("#oficina").val() == ""){
                message_alert("El campo <b>[OFICINA]</b> es un dato obligatorio...");
                return false;
            }
            if($("#cominterna").val() == ""){
                message_alert("El campo <b>[CONTROL INTERNO]</b> es un dato obligatorio...");
                return false;
            }

            if($("#fechasol").val() == ""){
                message_alert("El campo <b>[OFICINA]</b> es un dato obligatorio...");
                return false;
            }
           
            if($("#dirigidoa >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Localidad]</b> es un dato obligatorio...");
                return false;
            }

            if($("#viauno >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[enc]</b> es un dato obligatorio...");
                return false;
            }

            if($("#referencia").val() == ""){
                message_alert("El campo <b>[OFICINA]</b> es un dato obligatorio...");
                return false;
            }
            if($("#fechasalida").val() == ""){
                message_alert("El campo <b>[CONTROL INTERNO]</b> es un dato obligatorio...");
                return false;
            }
            if($("#fecharetorno").val() == ""){
                message_alert("El campo <b>[CONTROL INTERNO]</b> es un dato obligatorio...");
                return false;
            }
            if($("#detallesouconsumo").val() == ""){
                message_alert("El campo <b>[Detalle]</b> es un dato obligatorio...");
                return false;
            }


            if($("#tsalida").val() == ""){
                message_alert("El campo <b>[CONTROL INTERNO]</b> es un dato obligatorio...");
                return false;
            }
            if($("#tllegada").val() == ""){
                message_alert("El campo <b>[CONTROL INTERNO]</b> es un dato obligatorio...");
                return false;
            }

            if($("#idlocalidad >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Localidad]</b> es un dato obligatorio...");
                return false;
            }

            if($("#idarea >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[enc]</b> es un dato obligatorio...");
                return false;
            }

          
            return true;
        };

        function valideNumber(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if(code>=48 && code<=57){
                return true;
            }else{
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
