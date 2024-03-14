@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<br>
<div class="row font-verdana-bg">
    <div class="col-md-4 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{url('/upedidoparcial/index')}}">

                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
  
    <div class="col-md-8 text-right titulo">
       <b>SOLICITUD APROBADA</b>
    </div> 
    <div class="col-md-12">
        <hr class="hrr">
    </div>

    @if($consumos->estadosoluconsumo == '2')
    <div class="col-md-6 text-right titulo">
        <b>Fecha Solicitud</b>  <b style='color:red'>{{$Fechayhora}}</b> 
    </div> 
    <div class="col-md-6 text-right titulo">
        <b>Fecha Aprobacion Dir.</b>  <b style='color:red'>{{$Fechayhorar}}</b> 
    </div> 
    @elseif($consumos->estadosoluconsumo == '3')
    <div class="col-md-6 text-right titulo">
        <b>Fecha Aprobacion Dir.</b>  <b style='color:red'>{{$Fechayhorar}}</b> 
    </div> 
    <div class="col-md-6 text-right titulo">
     <b>Fecha Aprobacion Trans.</b>  <b style='color:red'>{{$Fechayhorartr}}</b>
    </div> 
    @endif
</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form method="post" action="{{ route('upedidoparcial.update') }}" id="form">
        @csrf
        {{--@method('PUT')--}}
        <input type="text" hidden name="idsoluconsumo" 
        value="{{$soluconsumos->idsoluconsumo}}">
        <input type="hidden" name="cominterna3" id="cominterna3">
   

        <div class="form-group row">

            <div class="col-md-3">
                <label for="cominterna" class="d-inline font-verdana-bg">
                    <b>Oficina:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea  name="referencia"  class="form-control form-control-sm font-verdana-bg" 
                id="referencia" >{{$soluconsumos->oficina}}</textarea>
            </div>

            <div class="col-md-2">
                <label for="cominterna" class="d-inline font-verdana-bg">
                    <b>control interno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="cominterna" class="form-control form-control-sm font-verdana-bg"
                  id="cominterna" onchange="myFunction()"  
                 onkeypress="return valideNumber(event);" value="{{$soluconsumos->cominterna}}">
            </div>
{{--             
            <div class="col-md-2">
                <label for="fechasol" class="d-inline font-verdana-bg">
                    <b> fechasol</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input   type="text" disabled name="fechasol" placeholder="dd/mm/aaaa" data-language="es"
            
                class="form-control" id="fechasol" value="{{$soluconsumos->fechasol}}" 
                >
            </div> --}}

            <div class="col-md-4">
                <label for="referencia" class="d-inline font-verdana-bg">
                    <b>referencia</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea  name="referencia"  class="form-control form-control-sm font-verdana-bg" 
                id="referencia" >{{$soluconsumos->referencia}}</textarea>
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
                    <b> fecha salida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input   type="date" disabled name="fechasalida" id="fechasalida" placeholder="dd/mm/aaaa"data-language="es"
            
                class="form-control" value="{{$soluconsumos->fechasalida}}">
                <label for="tsalidahr" class="d-inline font-verdana-bg">
                    <b>Salida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="time" disabled name="tsalidahr" id="tsalidahr" placeholder="HH:mm:ss" class="form-control form-control-sm font-verdana-bg" value="{{$soluconsumos->tsalidahr}}">
 
            </div>

            <div class="col-md-3">
                <label for="fecharetorno" class="d-inline font-verdana-bg">
                    <b> fecha retorno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input   type="date" disabled name="fecharetorno" id="fecharetorno" placeholder="dd/mm/aaaa" data-language="es"
            
                class="form-control" value="{{$soluconsumos->fecharetorno}}">

                <label for="tllegadahr" class="d-inline font-verdana-bg">
                    <b>Llegada</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="time" disabled name="tllegadahr" id="tllegadahr" placeholder="HH:mm:ss" class="form-control form-control-sm font-verdana-bg" value="{{$soluconsumos->tllegadahr}}">
 
            </div>


            <div class="col-md-6">
                <label for="detallesouconsumo" class="d-inline font-verdana-bg">
                    <b>Detalle:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea disabled name="detallesouconsumo" cols="1" rows="5" class="form-control form-control-sm font-verdana-bg" 
                id="detallesouconsumo" >{{$soluconsumos->detallesouconsumo}}</textarea>
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
            
            if ($("#cominterna3").val() == "comunicacion") {
                $("#cominterna3").val('');
                $("#cominterna").val('');
                $("#oficina").val('');

                message_alert("El numero de <b>[Control Interno]</b> ya existe en nuestros registros...");
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
        }

        
    function myFunction() {
        
        respuesta();
        
    }

  

    function respuesta() {
        var ot_antigua = $("#cominterna").val();

        $.ajax({
            url: "{{ route('pregunta2') }}",

            data: 'ot_antigua=' + ot_antigua,
         
            dataType: "html",
            asycn: false,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            dataType: 'JSON',
            success: function(data) {
              
                if (data.success == true) {

                   
                    $("#cominterna3").val('comunicacion');


                }

            }



        });



    }


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
