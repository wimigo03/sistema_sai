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
                    <form method="POST" action="{{ route('proveedor.update', $proveedores->idproveedor) }}" id="form">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="cedula2" id="cedula2">

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Nombre Proveedor:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="nombre" placeholder=""
                                    value="{{$proveedores->nombreproveedor}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="representante" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Representante:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="representante" placeholder=""
                                    value="{{$proveedores->representanteproveedor}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nit" style="color:black;font-weight: bold;"
                                class="required  col-md-4 col-form-label text-md-right">Cedula:</label>
                            <div class="col-md-4">
                                <input type="number" required class="form-control" name="cedula" placeholder=""
                                    value="{{$proveedores->cedulaproveedor}}"
                                    onchange="myFunction()">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nitci" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Fecha de Expiracion:</label>
                            <div class="col-md-4">
                                <input type="text" value="{{$proveedores->validezciproveedor}}" name="Ciexpiracion" id="Ciexpiracion"  placeholder="dd/mm/aaaa" class="form-control form-control-sm font-verdana-12"  data-language="es" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nit" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Nit/Ci:</label>
                            <div class="col-md-4">
                                <input type="text" required class="form-control" name="nitci" placeholder=""
                                    value="{{$proveedores->nitciproveedor}}"
                                    onkeypress="return valideNumberdos(event);">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telefono" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Telefono:</label>
                            <div class="col-md-4">
                                <input type="text" required class="form-control" name="telefono" placeholder=""
                                    value="{{$proveedores->telefonoproveedor}}"
                                    onkeypress="return valideNumber(event);">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 text-right">
                                <button class="btn color-icon-2 font-verdana-12" type="button" onclick="save();">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    &nbsp;Actualizar
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
            }else{
                return false;
            }
        }

        function valideNumberdos(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if(code>=48 && code<=57){
                return true;
            }else{
                return false;
            }
        }

    </script>
@endsection


