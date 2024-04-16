@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
@if(Session::has('message'))
    <div class="alert alert-success">
        <em> {!! session('message') !!}</em>
    </div>
@endif
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
        <b style='color:red'>{{$personalArea->nombrearea}}</b>- <b>FORMULARIO DE SOLICITUD</b>
    
    
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>

<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('transportes.pedidoparcial.store') }}" method="post" id="form">
        @csrf
        <div class="form-group row">

            <div class="col-md-5">
                <label for="oficina" class="d-inline font-verdana-12">
                    <b>Oficina </b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="oficina" 
                value="{{request('oficina')}}" 
                class="form-control form-control-sm font-verdana-12" 
                id="oficina">
            </div>

            <div class="col-md-4">
                <label for="cominterna" class="d-inline font-verdana-12">
                    <b>Control Interno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="cominterna" 
                value="{{request('cominterna')}}" 
                class="form-control form-control-sm font-verdana-12" 
                id="cominterna" onkeypress="return valideNumber(event);" onchange="myFunction()" >
            </div>

            
            <div class="col-md-2">
                <label for="fechasol" class="d-inline font-verdana-12">
                    <b> fechasol</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="fechasol" placeholder="dd/mm/aaaa"
                value="{{request('fechasol')}}" 
                class="form-control form-control-sm font-verdana-12" 
                id="fechasol" data-language="es" autocomplete="off" >
            </div>

            <div class="col-md-5">
                <label for="dirigidoa" class="d-inline font-verdana-12">
                    <b>Dirigido A:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="dirigidoa" id="dirigidoa" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($empleados as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="viauno" class="d-inline font-verdana-12">
                    <b>VIA:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="viauno" id="viauno" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($empleados as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

          


            <div class="col-md-2">
                <label for="referencia" class="d-inline font-verdana-12">
                    <b> referencia</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="referencia" 
                value="{{request('referencia')}}" 
                class="form-control form-control-sm font-verdana-12" 
                id="referencia" >
            </div>


            <div class="col-md-3">
                <label for="fechasalida" class="d-inline font-verdana-12">
                    <b> fechasalida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="fechasalida" placeholder="dd/mm/aaaa"
                value="{{request('fechasalida')}}" 
                class="form-control form-control-sm font-verdana-12" 
                id="fechasalida" data-language="es" autocomplete="off" >
            </div>

            <div class="col-md-3">
                <label for="fecharetorno" class="d-inline font-verdana-12" cols="2" rows="3">
                    <b> fecharetorno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="fecharetorno" placeholder="dd/mm/aaaa"
                value="{{request('fecharetorno')}}" 
                class="form-control form-control-sm font-verdana-12" 
                id="fecharetorno" data-language="es" autocomplete="off" >
            </div>


          


            <div class="col-md-6">
                <label for="detallesouconsumo" class="d-inline font-verdana-12">
                    <b>detallesouconsumo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>

                <textarea name="detallesouconsumo" cols="1" rows="5" 
                class="form-control form-control-sm font-verdana-12" 
                id="detallesouconsumo">{{request('detallesouconsumo')}}</textarea>
            </div>


            
            <div class="col-md-3">
                <label for="tsalida" class="d-inline font-verdana-12">
                    <b> tsalida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select type="text" id="tsalida" name="tsalida" placeholder="--Seleccionar--" 
                 
                class="form-control form-control-sm select2">
                <option value="">-</option>
                <option value="1" >Mañana</option>
                <option value="2">Tarde</option>
            </select>

            </div>

            <div class="col-md-3">
                <label for="tllegada" class="d-inline font-verdana-12">
                    <b> t llegada</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select type="text" name="tllegada"  id="tllegada"  placeholder="--Seleccionar--" 
                
                class="form-control form-control-sm select2"   >

                <option value="">-</option>
                <option value="1" >Mañana</option>
                <option value="2">Tarde</option>
            </select>
            </div>


            <div class="col-md-4">
                <label for="idlocalidad" class="d-inline font-verdana-12">
                    <b>localidad::</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idlocalidad" id="idlocalidad" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($localidades as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-7">
                <label for="idarea" class="d-inline font-verdana-12">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>

                <select name="idarea" id="idarea" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($areas as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

           
       

        </div>
        <div class="form-group row">
            <div class="col-md-12 text-right">
                <button class="btn color-icon-2 font-verdana-12" type="button" onclick="save();">
                    <i class="fa-solid fa-paper-plane"></i>
                    &nbsp;Registrar
                </button>
                <button class="btn btn-danger font-verdana-12" type="button" >

                    <a href="{{url()->previous()}}" style="color:white">Cancelar</a>
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
                message_alert("El campo <b>[CONTROL INTERNO]</b> es un dato obligatorio...");
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
