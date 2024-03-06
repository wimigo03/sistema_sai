@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<br>
<div class="row font-verdana-bg">
    <div class="col-md-4 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{url('/pedidoparcialcomb/index')}}">
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
        <b>Fecha</b>  <b style='color:red'>{{$date->format('d-m-Y H:i:s')}}</b>
    </div>
</div>

<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('pedidoparcialcomb.store') }}" method="post" id="form">
        @csrf
        <input type="hidden" name="controlinterno2" id="controlinterno2">
        <div class="form-group row">

         <div class="col-md-6">
                <label for="oficina" class="d-inline font-verdana-bg">
                    <b>Oficina </b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <input type="text" disabled name="oficina" 
                value="{{$NomFci}}" 
                class="form-control form-control-sm font-verdana-bg" 
                id="oficina">

                <label for="dirigidoa" class="d-inline font-verdana-bg">
                    <b>Dirigido A:</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <input type="text" disabled name="dirigidoa" 
                value="{{$encargadodos->abrev}} {{$encargadodos->nombres}} {{$encargadodos->ap_pat}} {{$encargadodos->ap_mat}} " 
               class="form-control form-control-sm font-verdana-bg" 
               id="dirigidoa" data-language="es" autocomplete="off" >
            </div>

          

            <div class="col-md-6">
                <label for="justificacion" class="d-inline font-verdana-bg">
                    <b>Justificacion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea  name="justificacion" cols="1" rows="4" 
                class="form-control form-control-sm font-verdana-bg" 
                id="justificacion" onkeyup="convertirAMayusculas(this)" >{{request('justificacion')}}</textarea>
            </div>

            {{-- <div class="col-md-2">
                <label for="tipo" class="d-inline font-verdana-bg">
                    <b>Tipo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
               
                <input type="text" disabled name="tipo" 
                value="{{$Tipos}}" 
                class="form-control form-control-sm font-verdana-bg" id="tipo">
            </div> --}}

          


            <div class="col-md-6">
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


{{-- 
            <div class="col-md-7">
                <label for="idarea" class="d-inline font-verdana-bg">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="preventivo" 
                value="{{$personalArea->nombrearea}}" 
                class="form-control form-control-sm font-verdana-bg" id="preventivo">

            </div> --}}
            
            {{-- <div class="col-md-6">
                <label for="idprograma" class="d-inline font-verdana-bg">
                    <b>Programa</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
               
                <input type="text" disabled name="idprograma" 
                value="{{$nombrePro}}" 
                class="form-control form-control-sm font-verdana-bg" id="idprograma">
            
            </div> --}}
        
            <div class="col-md-4">
                <label for="objeto" class="d-inline font-verdana-bg">
                    <b>Objeto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input  name="objeto" cols="1" rows="2" class="form-control form-control-sm font-verdana-bg" 
                id="objeto" onkeyup="convertirAMayusculas(this)"  value="{{request('objeto')}}" autocomplete="off"  >
            </div>
         
            <div class="col-md-2">
                <label for="controlinterno" class="d-inline font-verdana-bg">
                    <b>N° Solicitud</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="controlinterno" value="{{request('controlinterno')}}" 
                class="form-control form-control-sm font-verdana-bg" 
                id="controlinterno" onchange="myFunction()" onkeypress="return valideNumber(event);">
            </div>
            <div class="col-md-6">
                <label for="idcatprogramatica" class="d-inline font-verdana-bg">
                    <b>Proyecto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idcatprogramatica" id="idcatprogramatica" placeholder="--Seleccionar--"
                 class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($catprogramaticas as $index => $value)
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
                  
                    <a href="{{url('/pedidoparcialcomb/index')}}" style="color:white">Cancelar</a>
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
            window.location.href = "{{url('/pedidoparcialcomb/index')}}";
        }

        function validar_formulario(){

            if($("#objeto").val() == ""){
                message_alert("El campo <b>[Objeto]</b> es un dato obligatorio...");
                return false;
            }
            if($("#justificacion").val() == ""){
                message_alert("El campo <b>[Justificacion]</b> es un dato obligatorio...");
                return false;
            }

            // if($("#tipo >option:selected").val() == ""){
            //     message_alert("El campo de seleccion <b>[Tipo]</b> es un dato obligatorio...");
            //     return false;
            // }

            if($("#controlinterno").val() == ""){
                message_alert("El campo <b>[N° de Solicitud]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#controlinterno2").val() == "comunicacion") {
                $("#controlinterno2").val('');
                $("#controlinterno").val('');
                $("#objeto").val('');
                message_alert("El numero de <b>[N° de Solicitud]</b> ya existe en nuestros registros...");
                return false;
            }

            // if($("#idprograma >option:selected").val() == ""){
            //     message_alert("El campo de seleccion <b>[Programa]</b> es un dato obligatorio...");
            //     return false;
            // }
            if($("#idcatprogramatica >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Proyecto]</b> es un dato obligatorio...");
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
        function myFunction() {
            respuesta();
        }
        function respuesta() {
            var ot_antigua = $("#controlinterno").val();
            $.ajax({
                url: "{{ route('pedidoparcialcomb.pregunta4') }}",
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
                        $("#controlinterno2").val('comunicacion');
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


    </script>
@endsection




