@extends('layouts.dashboard')

@section('content')
@include('layouts.message_alert')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/combustibles/proveedor/index')}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>

            <div class="col-md-8 text-right titulo">
                <b>CREAR REGISTRO</b>
            </div>

            <div class="col-md-12">
                <hr color="red">
            </div>

        </div>


        <div class="body-border">
            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('proveedor.store') }}" id="form">
                    @csrf
                    <input type="hidden" name="cedula2" id="cedula2">

                    <div class="form-group row">
                        <label for="nombre" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Nombre Proveedor:</label>

                        <div class="col-md-6">
                            <input type="text" required name="nombre" id="nombre" class="form-control" placeholder="Nombre..."
                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="representante" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Representante Proveedor:</label>

                        <div class="col-md-6">
                            <input type="text" required name="representante" id="representante" class="form-control"
                                placeholder="representante..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();" onkeypress="return valideNumbertres(event);">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cedula" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Cedula:</label>

                        <div class="col-md-4">
                            <input type="number"  required name="cedula" id="cedula" onchange="myFunction()"  class="form-control" placeholder="cedula...">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nitci" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Fecha de Expiracion:</label>
                        <div class="col-md-4">
                            <input type="text" name="Ciexpiracion" id="Ciexpiracion" value="" placeholder="dd/mm/aaaa" class="form-control form-control-sm font-verdana-12" id="fechainicio" data-language="es" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nitci" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Nit/Ci:</label>

                        <div class="col-md-4">
                            <input type="text" required name="nitci" id="nitci" class="form-control" placeholder="Nit/Ci..." onkeypress="return valideNumberdos(event);">
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="telefono" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Telefono:</label>

                        <div class="col-md-4">
                            <input onkeypress="return valideNumber(event);" type="text" required name="telefono" id="telefono" class="form-control" placeholder="Telefono...">
                        </div>
                    </div>

                    <br>

                        <div align='center'>

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
            </font>

        </div>

    </div>
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
            window.location.href = "{{url('combustibles/proveedor/index')}}";
        }

        function validar_formulario(){


            if($("#nombre").val() == ""){
                message_alert("El campo <b>[nombre]</b> es un dato obligatorio...");
                return false;
            }
            if($("#representante").val() == ""){
                message_alert("El campo <b>[representante]</b> es un dato obligatorio...");
                return false;
            }
       
            if($("#cedula").val() == ""){
                message_alert("El campo <b>[cedula]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#cedula2").val() == "comunicacion") {
                $("#cedula2").val('');
                $("#cedula").val('');
                $("#representante").val('');

                message_alert("El numero de la <b>[CEDULA]</b> ya existe en nuestros registros...");
                return false;
            }
            
            if($("#Ciexpiracion").val() == ""){
                message_alert("El campo <b>[ci]</b> es un dato obligatorio...");
                return false;
            }
            if($("#nitci").val() == ""){
                message_alert("El campo <b>[nitci]</b> es un dato obligatorio...");
                return false;
            }
            if($("#telefono").val() == ""){
                message_alert("El campo <b>[telefono ]</b> es un dato obligatorio...");
                return false;
            }
            if($("#detallesouconsumo").val() == ""){
                message_alert("El campo <b>[Detalle]</b> es un dato obligatorio...");
                return false;
            }
          
            return true;
        }

        function myFunction() {
            respuesta();
        }
        function respuesta() {
            var ot_antigua = $("#cedula").val();
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
                        $("#cedula2").val('comunicacion');
                    }
                }
            });
        }

        $("#Ciexpiracion").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });


        function valideNumber(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if(code>=48 && code<=57){
                return true;
            }
            return false;
        }

        function valideNumberdos(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if(code>=48 && code<=57){
                return true;
            }
            return false;
        }

        function valideNumbertres(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 65 && code <= 90) || (code >= 97 && code <= 122) || code == 8 || (code >= 37 && code <= 40)) {
        return true;
    }
            return false;
        }

    </script>
@endsection
