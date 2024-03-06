@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')

<br>
<div class="row font-verdana-bg">
    <div class="col-md-4 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/upedidoparcial/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-8 text-right titulo">
        <b style='color:red'>{{$personalArea->nombrearea}}</b>- <b>FORMULARIO DE SOLICITUD</b>
    
    
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

    <div class="col-md-4 text-right titulo">
        <b>Fecha</b>  <b style='color:red'>{{$date->format('d/m/Y H:i:s')}}</b>
    </div>
  
</div>

<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('upedidoparcial.store') }}" method="post" id="form">
        @csrf

        <input type="hidden" name="cominterna2" id="cominterna2">

        <div class="form-group row">

            <div class="col-md-4">
                <label for="oficina" class="d-inline font-verdana-bg">
                    <b>Oficina </b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <input type="text" disabled name="oficina" 
                value="{{$NomFci}}" 
                class="form-control form-control-sm font-verdana-bg" 
                id="oficina">
            </div>

            <div class="col-md-2">
                <label for="cominterna" class="d-inline font-verdana-bg">
                    <b>Control Interno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="number" name="cominterna"
                class="form-control form-control-sm font-verdana-bg" 
                id="cominterna"  onchange="myFunction()">
                {{-- onkeypress="return valideNumber(event);" --}}
            </div>

            {{-- <input type="hidden" name="cominterna2" id="cominterna2"> --}}
            <div class="col-md-4">
                <label for="referencia" class="d-inline font-verdana-bg">
                    <b> Referencia</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="referencia" 
                value="{{request('referencia')}}" 
                class="form-control form-control-sm font-verdana-bg" 
                id="referencia" onkeyup="convertirAMayusculas(this)">
            </div>

            {{-- <div class="col-md-3">
                <label for="fechasol" class="d-inline font-verdana-bg">
                    <b> Fecha de solicitud</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <input type="text" disabled name="fechasol" placeholder="dd/mm/yyyy HH:mm:ss"
                 value="{{$date->format('d/m/Y H:i:s')}}" 
                class="form-control form-control-sm font-verdana-bg" 
                id="fechasol" data-language="es" autocomplete="off" >
            </div> --}}
           
            <div class="col-md-2">
                <label for="tipo" class="d-inline font-verdana-bg">
                    <b>Tipo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="tipo" id="tipo" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    <option value="1" >GASOLINA</option>
                    <option value="2">DIESEL</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="dirigidoa" class="d-inline font-verdana-bg">
                    <b>Dirigido A:</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <input type="text" disabled name="dirigidoa" 
                value="{{$encargadotres->abrev}} {{$encargadotres->nombres}} {{$encargadotres->ap_pat}} {{$encargadotres->ap_mat}}" 
               class="form-control form-control-sm font-verdana-bg" 
               id="dirigidoa" data-language="es" autocomplete="off" >
                <td colspan="8" width="564" style="font-size: 12px;">
                    
                </td>
            </div>

            <div class="col-md-4">
                <label for="viauno" class="d-inline font-verdana-bg">
                    <b>VIA:</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <input type="text" disabled name="viauno" 
                value="{{$encargadodos->abrev}} {{$encargadodos->nombres}} {{$encargadodos->ap_pat}} {{$encargadodos->ap_mat}}" 
               class="form-control form-control-sm font-verdana-bg" 
               id="viauno" data-language="es" autocomplete="off" >
                <td colspan="8" width="564" style="font-size: 12px;">
                    
                </td>
            </div>

                
            <div class="col-md-4">
                <label for="viauno" class="d-inline font-verdana-bg">
                    <b>VIA:</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <input type="text" disabled name="viauno" 
                value="{{$encargado->abrev}} {{$encargado->nombres}} {{$encargado->ap_pat}} {{$encargado->ap_mat}}" 
               class="form-control form-control-sm font-verdana-bg" 
               id="viauno" data-language="es" autocomplete="off" >
                <td colspan="8" width="564" style="font-size: 12px;">
                    
                </td>
            </div>

            <div class="col-md-3">
                <label for="fechasalida" class="d-inline font-verdana-bg">
                    <b> Fecha de salida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="fechasalida" placeholder="dd/mm/aaaa"
                value="{{request('fechasalida')}}" 
                class="form-control form-control-sm font-verdana-bg" 
                id="fechasalida" data-language="es" autocomplete="off" >

                <label for="tsalidahr" class="d-inline font-verdana-bg">
                    <b> Salida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="time" id="tsalidahr" name="tsalidahr" placeholder="HH:mm:ss" 
                value="{{request('tsalidahr')}}" 
                class="form-control form-control-sm font-verdana-bg">
             
                
            </div>

            <div class="col-md-3">
                <label for="fecharetorno" class="d-inline font-verdana-bg" >
                    <b> Fecha de retorno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="fecharetorno" placeholder="dd/mm/aaaa"
                value="{{request('fecharetorno')}}" 
                class="form-control form-control-sm font-verdana-bg" 
                id="fecharetorno" data-language="es" autocomplete="off" >

                <label for="tllegadahr" class="d-inline font-verdana-bg">
                    <b> Llegada</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="time" id="tllegadahr" name="tllegadahr" placeholder="HH:mm:ss" 
                value="{{request('tllegadahr')}}" 
                class="form-control form-control-sm font-verdana-bg">      
            </div>
            <div class="col-md-6">
                <label for="detallesouconsumo" class="d-inline font-verdana-bg">
                    <b>Detalle de solicitud</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>

                <textarea name="detallesouconsumo" cols="1" rows="5" 
                class="form-control form-control-sm font-verdana-bg" 
                id="detallesouconsumo" onkeyup="convertirAMayusculas(this)">{{request('detallesouconsumo')}}</textarea>
            </div>


            <div class="col-md-5">
                <label for="idlocalidad" class="d-inline font-verdana-bg">
                    <b>Localidad::</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idlocalidad" id="idlocalidad" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($localidades as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
     

        </div>

        <div class="form-group row">

            <div class="col-md-12 text-right">
                <button class="btn color-icon-2 font-verdana-bg" type="button" onclick="save();">
                    <i class="fa-solid fa-paper-plane"></i>
                    &nbsp;Registrar
                </button>
                <button class="btn btn-danger font-verdana-bg" type="button" >
                   
                    <a href="{{url('/upedidoparcial/index')}}" style="color:white">Cancelar</a>
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

            var referenciad = $("#referencia").val();
            var detallesouconsumod = $("#detallesouconsumo").val();

            var tsalidahrd = $("#tsalidahr").val();
            var tllegadahrd = $("#tllegadahr").val();

            if($("#referencia").val() == ""){
                message_alert("El campo <b>[Referencia]</b> es un dato obligatorio...");
                return false;
            }
            if(referenciad.length > 50){
            //    $("#referenciad").val('');
            //    $("#objeto").val('');
               message_alert("El campo <b>[Referencia]</b> tiene muchos caracteres...");
               return false;
               }
            if($("#cominterna").val() == ""){
                message_alert("El campo <b>[CONTROL INTERNO]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#cominterna2").val() == "comunicacion") {
                $("#cominterna2").val('');
                $("#cominterna").val('');
                $("#referencia").val('');
                message_alert("El numero de <b>[Control Interno]</b> ya existe en nuestros registros...");
                return false;
            }
            if($("#tipo").val() == ""){
                message_alert("El campo <b>[Tipo]</b> es un dato obligatorio...");
                return false;
            }
            
            if($("#fechasalida").val() == ""){
                message_alert("El campo <b>[Fecha salida]</b> es un dato obligatorio...");
                return false;
            }
            if($("#fecharetorno").val() == ""){
                message_alert("El campo <b>[Fecha retorno]</b> es un dato obligatorio...");
                return false;
            }

            if($("#fechasalida").val() > $("#fecharetorno").val() ){
                message_alert("El campo <b>[Fecha retorno]</b> es un dato incorrecto...");
          
                $("#fecharetorno").val('');
                return false;
            }
       
            if($("#detallesouconsumo").val() == ""){
                message_alert("El campo <b>[Detalle]</b> es un dato obligatorio...");
                return false;
            }
            if(detallesouconsumod.length > 250){
            //    $("#referenciad").val('');
            //    $("#objeto").val('');
               message_alert("El campo <b>[Detalle]</b> tiene muchos caracteres...");
               return false;
               }

            if($("#tsalidahr").val() == ""){
                message_alert("El campo <b>[Tiempo Salida]</b> es un dato obligatorio...");
                return false;
            }
            if($("#tllegadahr").val() == ""){
                message_alert("El campo <b>[Tiempo Llegada]</b> es un dato obligatorio...");
                return false;
            }

            if($("#idlocalidad >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Localidad]</b> es un dato obligatorio...");
                return false;
            }
          
            return true;
        }
     
        var fechaSalida = new Date($("#fechasalida").val());
        var fechaRetorno = new Date($("#fecharetorno").val());

        function myFunction() {
            respuesta();
        }
        function respuesta() {
            var ot_antigua = $("#cominterna").val();
            $.ajax({
                url: "{{ route('upedidoparcial.pregunta7') }}",
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
                        $("#cominterna2").val('comunicacion');
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
        function convertirAMayusculas(input) {
    // Guarda la posición actual del cursor
    var inicioSeleccion = input.selectionStart;
    var finSeleccion = input.selectionEnd;
  
    // Convierte todo el texto a mayúsculas
    input.value = input.value.toUpperCase();
  
    // Restaura la posición del cursor
    input.setSelectionRange(inicioSeleccion, finSeleccion);
  }
        // revisar funcion validar que sean positivos
    //     function valideNumber(evt){
            
    //         var code = (evt.which) ? evt.which : evt.keyCode;
    //         var valipositi = $("#cominterna").val();
    //         if ($valipositi>=1){
          
    //         if (code>=48 && code<=57){
    //             return true;
                         
    //         }else{
    //             return false; 
    //         }

    //         }else{
              
    //             return false; 
       
    // }}
      
  
    
  
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
