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
        <b style='color:red'>{{$personalArea->nombrearea}}</b>- <b>FORMULARIO DE SOLICITUD</b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>

<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('combustibles.pedidoparcial.store') }}" method="post" id="form">
        @csrf
        <input type="hidden" name="controlinterno2" id="controlinterno2">


        <div class="form-group row">

            <div class="col-md-2">
                <label for="fechasoli" class="d-inline font-verdana-bg">
                    <b> fecha de solicitud</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="fechasoli" placeholder="dd/mm/yyyy"
                 value="{{$date->format('d/m/Y')}}" 
                class="form-control form-control-sm font-verdana-bg" 
                id="fechasoli" data-language="es" autocomplete="off" >
            </div>

            <div class="col-md-4">
                <label for="objeto" class="d-inline font-verdana-bg">
                    <b>Objeto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="objeto" cols="1" rows="3" class="form-control form-control-sm font-verdana-bg" 
                id="objeto" onkeyup="javascript:this.value=this.value.toUpperCase();">{{request('objeto')}}</textarea>
            </div>

            <div class="col-md-6">
                <label for="justificacion" class="d-inline font-verdana-bg">
                    <b>Justificacion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="justificacion" cols="1" rows="10" 
                class="form-control form-control-sm font-verdana-bg" 
                id="justificacion" onkeyup="javascript:this.value=this.value.toUpperCase();">{{request('justificacion')}}</textarea>
            </div>

            <div class="col-md-2">
                <label for="tipo" class="d-inline font-verdana-bg">
                    <b>Tipo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
               
                <input type="text" disabled name="tipo" 
                value="{{$Tipos}}" 
                class="form-control form-control-sm font-verdana-bg" id="tipo">
            </div>

            <div class="col-md-2">
                <label for="controlinterno" class="d-inline font-verdana-bg">
                    <b>Control Interno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="controlinterno" value="{{request('controlinterno')}}" 
                class="form-control form-control-sm font-verdana-bg" 
                id="controlinterno" onchange="myFunction()" onkeypress="return valideNumber(event);">
            </div>

            <div class="col-md-7">
                <label for="idarea" class="d-inline font-verdana-bg">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="preventivo" 
                value="{{$personalArea->nombrearea}}" 
                class="form-control form-control-sm font-verdana-bg" id="preventivo">

            </div>
            
            <div class="col-md-6">
                <label for="idprograma" class="d-inline font-verdana-bg">
                    <b>Programa</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
               
                <input type="text" disabled name="idprograma" 
                value="{{$nombrePro}}" 
                class="form-control form-control-sm font-verdana-bg" id="idprograma">
            
            </div>
            <div class="col-md-5">
                <label for="idcatprogramatica" class="d-inline font-verdana-bg">
                    <b>Cat. Programatica</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
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
            window.location.href = "{{url('combustibles/pedidoparcial/index')}}";
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

            if($("#tipo >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Tipo]</b> es un dato obligatorio...");
                return false;
            }

            if($("#controlinterno").val() == ""){
                message_alert("El campo <b>[Control Interno]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#controlinterno2").val() == "comunicacion") {
                $("#controlinterno2").val('');
                $("#controlinterno").val('');
                $("#objeto").val('');
                message_alert("El numero de <b>[Control Interno]</b> ya existe en nuestros registros...");
                return false;
            }

            if($("#idprograma >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Programa]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idcatprogramatica >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Cat. Programatica]</b> es un dato obligatorio...");
                return false;
            }

            return true;
        }

        function myFunction() {
            respuesta();
        }
        function respuesta() {
            var ot_antigua = $("#controlinterno").val();
            $.ajax({
                url: "{{ route('pregunta4') }}",
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

    /*var permission_select = new SlimSelect({
        select: '#permissions-select select',
        //showSearch: false,
        placeholder: 'Select Permissions',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    });
    var permission_select2 = new SlimSelect({
        select: '#permissions-select2 select',
        //showSearch: false,
        placeholder: 'Select Permissions',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    });
    var permission_select = new SlimSelect({
        select: '#permissions-select3 select',
        //showSearch: false,
        placeholder: 'Select Permissions',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    });
    var permission_select2 = new SlimSelect({
        select: '#permissions-select4 select',
        //showSearch: false,
        placeholder: 'Select Permissions',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    });*/
    </script>
@endsection




