@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<br>
<div class="row font-verdana-12">
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
        <b>SU SOLICITUD FUE RECHAZADA</b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form method="post" action="{{ route('transportes.pedidoparcial.update') }}" id="form">
        @csrf
        {{--@method('PUT')--}}
        <input type="hidden" name="cominterna3" id="cominterna3">
        <input type="text" hidden name="idsoluconsumo" 
        value="{{$soluconsumos->idsoluconsumo}}">
   

        <div class="form-group row">

            <div class="col-md-3">
                <label for="oficina" class="d-inline font-verdana-12">
                    <b>oficina</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="oficina" 
    value="{{$NomFci}}" 
    class="form-control form-control-sm font-verdana-12" 
    id="oficina">
            </div>

            <div class="col-md-3">
                <label for="cominterna" class="d-inline font-verdana-12">
                    <b>coninterna</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="cominterna" class="form-control form-control-sm font-verdana-12"
                  id="cominterna" onchange="myFunction()"  
                 onkeypress="return valideNumber(event);" value="{{$soluconsumos->cominterna}}">
            </div>
            
            <div class="col-md-2">
                <label for="fechasol" class="d-inline font-verdana-12">
                    <b> fechasol</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input   type="text" disabled name="fechasol" placeholder="dd/mm/aaaa" data-language="es"
            
                class="form-control" id="fechasol" value="{{$soluconsumos->fechasol}}" 
                >
            </div>

            <div class="col-md-4">
                <label for="referencia" class="d-inline font-verdana-12">
                    <b>referencia</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea disabled name="referencia"  class="form-control form-control-sm font-verdana-12" 
                id="referencia" >{{$soluconsumos->referencia}}</textarea>
            </div>

            <div class="col-md-4">
                <label for="dirigidoa" class="d-inline font-verdana-12">
                    <b>Dirigido a:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="dirigidoa" 
                value="{{$encargadotres->abrev}} {{$encargadotres->nombres}} {{$encargadotres->ap_pat}} {{$encargadotres->ap_mat}}" 
               class="form-control form-control-sm font-verdana-12" 
               id="dirigidoa" data-language="es" autocomplete="off" >
                <td colspan="8" width="564" style="font-size: 12px;">
            </div>
            
            <div class="col-md-4">
                <label for="viauno" class="d-inline font-verdana-12">
                    <b>Via:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="viauno" 
                value="{{$encargadodos->abrev}} {{$encargadodos->nombres}} {{$encargadodos->ap_pat}} {{$encargadodos->ap_mat}}" 
               class="form-control form-control-sm font-verdana-12" 
               id="viauno" data-language="es" autocomplete="off" >
                <td colspan="8" width="564" style="font-size: 12px;">
                    
                </td>
            </div>

            <div class="col-md-4">
                <label for="viauno" class="d-inline font-verdana-12">
                    <b>Via:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="viauno" 
                value="{{$encargado->abrev}} {{$encargado->nombres}} {{$encargado->ap_pat}} {{$encargado->ap_mat}}" 
               class="form-control form-control-sm font-verdana-12" 
               id="viauno" data-language="es" autocomplete="off" >
                <td colspan="8" width="564" style="font-size: 12px;">
                    
                </td>
            </div>
           

            <div class="col-md-3">
                <label for="fechasalida" class="d-inline font-verdana-12">
                    <b> fechasalida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input   type="text" disabled name="fechasalida" id="fechasalida" placeholder="dd/mm/aaaa"data-language="es"
            
                class="form-control" value="{{$soluconsumos->fechasalida}}"
                >
            </div>

            <div class="col-md-3">
                <label for="fecharetorno" class="d-inline font-verdana-12">
                    <b> fecharetorno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input   type="text" disabled name="fecharetorno" id="fecharetorno" placeholder="dd/mm/aaaa" data-language="es"
            
                class="form-control" value="{{$soluconsumos->fecharetorno}}"
                >
            </div>


            <div class="col-md-6">
                <label for="detallesouconsumo" class="d-inline font-verdana-12">
                    <b>detallesouconsumo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea disabled name="detallesouconsumo" cols="1" rows="5" class="form-control form-control-sm font-verdana-12" 
                id="detallesouconsumo" >{{$soluconsumos->detallesouconsumo}}</textarea>
            </div>


            <div class="col-md-3">
                <label for="tsalida" class="d-inline font-verdana-12">
                    <b>tsalida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select disabled name="tsalida" id="tsalida" placeholder="--Seleccionar--" class="form-control form-control-sm select2">

                    <option {{old('tsalida',$soluconsumos->tsalida)=="1"? 'selected':''}}  value="1">MAÑANA</option>
                    <option {{old('tsalida',$soluconsumos->tsalida)=="2"? 'selected':''}} value="2">TARDE</option>

                </select>
            </div>

            <div class="col-md-3">
                <label for="tllegada" class="d-inline font-verdana-12">
                    <b>tllegada</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select disabled name="tllegada" id="tllegada" placeholder="--Seleccionar--" class="form-control form-control-sm select2">

                    <option {{old('tllegada',$soluconsumos->tllegada)=="1"? 'selected':''}}  value="1">MAÑANA</option>
                    <option {{old('tllegada',$soluconsumos->tllegada)=="2"? 'selected':''}} value="2">TARDE</option>

                </select>
            </div>




            <div class="col-md-4">
                <label for="idlocalidad" class="d-inline font-verdana-12">
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
                <label for="idarea" class="d-inline font-verdana-12">
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
