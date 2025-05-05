@extends('layouts.dashboard')
@section('content')
@include('layouts.message_alert')
<br>
<div class="row font-verdana-12">
    <div class="col-md-2 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{url()->previous()}}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-10 text-right titulo">
        <b>FORMULARIO ORDEN DE COMPRA</b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{route('compras.detalle.principal.store')}}" method="post" id="form">
        @csrf
        <input name="idcompra" type="hidden" value="{{$idcompra}}">
        @include('compras.detalle.partials.form-principal')
    </form>
</div>
@endsection
@section('scripts')
    <script>

history.forward();
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
            $('#objeto').prop('disabled', true);
            $('#solicitante').prop('disabled', true);
            $('#modalidad').prop('disabled', true);
            $('#subtotal').prop('disabled', true);
            $('#proveedor').prop('disabled', true);
            $('#representante').prop('disabled', true);
            $('#cedula').prop('disabled', true);
            $('#nit').prop('disabled', true);
            $('#telefono').prop('disabled', true);
            $('#actitividad').prop('disabled', true);
            $('#preventivo').prop('disabled', true);
            $('#cedulaaceptacion').prop('disabled', true);
        });

        $("#fecha").datepicker({
            inline: false, 
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

        $("#fechainicio").datepicker({
            inline: false, 
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

        $("#fechaconclusion").datepicker({
            inline: false, 
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

        $("#fechainvitacion").datepicker({
            inline: false, 
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

        $("#fechaaceptacion").datepicker({
            inline: false, 
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

        $("#fechainiciosoli").datepicker({
            inline: false, 
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

        function message_alert(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function create(){
            if(validar_formulario() == true){
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{url('compras/detalle')}}";
        }

        function validar_formulario(){
            if($("#informe").val() == ""){   
                message_alert("El campo <b>[Informe de Cotizacion]</b> es un dato obligatorio...");
                return false;
            }
            if($("#orden").val() == ""){   
                message_alert("El campo <b>[Orden de Compra]</b> es un dato obligatorio...");
                return false;
            }
            if($("#fecha").val() == ""){   
                message_alert("El campo <b>[Fecha]</b> es un dato obligatorio...");
                return false;
            }
            if(validarFormatoFecha($("#fecha").val()) == false){   
                message_alert("La <b>[Fecha]</b> no tiene formato correcto...");
                return false;
            }
            if($("#apertura").val() == ""){   
                message_alert("El campo <b>[Apertura Programatica]</b> es un dato obligatorio...");
                return false;
            }
            if($("#partida").val() == ""){   
                message_alert("El campo <b>[Partida de Gasto]</b> es un dato obligatorio...");
                return false;
            }
            if($("#ruta").val() == ""){   
                message_alert("El campo <b>[Hoja de Ruta]</b> es un dato obligatorio...");
                return false;
            }
            if($("#cinterno").val() == ""){   
                message_alert("El campo <b>[Codigo Interno]</b> es un dato obligatorio...");
                return false;
            }
            if($("#entrega").val() == ""){   
                message_alert("El campo <b>[Plazo de Entrega]</b> es un dato obligatorio...");
                return false;
            }
            if($("#fechainicio").val() == ""){   
                message_alert("El campo <b>[Fecha de Inicio]</b> es un dato obligatorio...");
                return false;
            }
            if(validarFormatoFecha($("#fechainicio").val()) == false){   
                message_alert("La <b>[Fecha de Inicio]</b> no tiene formato correcto...");
                return false;
            }
            if($("#fechaconclusion").val() == ""){   
                message_alert("El campo <b>[Fecha de conclusion]</b> es un dato obligatorio...");
                return false;
            }
            if(validarFormatoFecha($("#fechaconclusion").val()) == false){   
                message_alert("La <b>[Fecha de conclusion]</b> no tiene formato correcto...");
                return false;
            }
            if($("#fechainvitacion").val() == ""){   
                message_alert("El campo <b>[Fecha Invitacion]</b> es un dato obligatorio...");
                return false;
            }
            if(validarFormatoFecha($("#fechainvitacion").val()) == false){   
                message_alert("La <b>[Fecha Invitacion]</b> no tiene formato correcto...");
                return false;
            }
            if($("#fechaaceptacion").val() == ""){   
                message_alert("El campo <b>[Fecha de Aceptacion]</b> es un dato obligatorio...");
                return false;
            }
            if(validarFormatoFecha($("#fechaaceptacion").val()) == false){   
                message_alert("La <b>[Fecha de Aceptacion]</b> no tiene formato correcto...");
                return false;
            }
            if($("#codigocite").val() == ""){   
                message_alert("El campo <b>[Codigo Cite]</b> es un dato obligatorio...");
                return false;
            }
            if($("#horapresentacion").val() == ""){   
                message_alert("El campo <b>[Hora]</b> es un dato obligatorio...");
                return false;
            }
            if($("#notaadjudicacion").val() == ""){   
                message_alert("El campo <b>[Nota de Adjudicacion]</b> es un dato obligatorio...");
                return false;
            }
            if($("#fechainiciosoli").val() == ""){   
                message_alert("El campo <b>[F. Inicio Solicitud]</b> es un dato obligatorio...");
                return false;
            }
            if(validarFormatoFecha($("#fechainiciosoli").val()) == false){   
                message_alert("La <b>[F. Inicio Solicitud]</b> no tiene formato correcto...");
                return false;
            }
            if($("#controlinterno").val() == ""){   
                message_alert("El campo <b>[Control Interno]</b> es un dato obligatorio...");
                return false;
            }
            if($("#solicitante").val() == ""){   
                message_alert("El campo <b>[Aut. Solicitante]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function valideNumberSinDecimal(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if(code>=48 && code<=57){
                return true;
            }else{
                return false;
            }
        }

        function valideNumberConDecimal(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if((code == 46) || (code>=48 && code<=57)){
                return true;
            }else{
                return false;
            }
        }

        function validarFormatoFecha(fecha) {
            var RegExPattern = /^\d{2}\/\d{2}\/\d{4}$/;
            if ((fecha.match(RegExPattern)) && (fecha!='')) {
                    return true;
            } else {
                    return false;
            }
        }
    </script>
@endsection