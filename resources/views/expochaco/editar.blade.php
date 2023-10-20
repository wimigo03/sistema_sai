@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<br>
<div class="row font-verdana-bg">
    <div class="col-md-4 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/expochaco/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-8 text-right titulo">
        <b>EDITAR SOLICITUD </b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>
<div class="body-border" style="background-color: #FFFFFF;">

    <form method="post" action="{{ route('expochaco.update') }}" id="form">
        @csrf
        {{--@method('PUT')--}}
        <input type="text" name="idsolicitud" value="{{$solicitud->idsolicitud}}"
        class="form-control form-control-sm font-verdana-bg" id="telefonosol">
        <div class="form-group row">
            <div class="col-md-6">
                <label for="nombresolicitud" class="d-inline font-verdana-bg">
                    <b>NOMBRES Y APELLIDOS</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="nombresolicitud" cols="1" rows="3"
                class="form-control form-control-sm font-verdana-bg" id="nombresolicitud">{{$solicitud->nombresolicitud}}</textarea>
            </div>

            <div class="col-md-2">
                <label for="asociacionsol" class="d-inline font-verdana-bg">
                    <b>ASOCIACION</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="asociacionsol" id="asociacionsol" placeholder="--Seleccionar--" class="form-control form-control-sm select2">

                    <option {{old('asociacionsol',$solicitud->asociacionsol)=="1"? 'selected':''}}  value="1">UNO</option>
                    <option {{old('asociacionsol',$solicitud->asociacionsol)=="2"? 'selected':''}} value="2">DOS</option>
                    <option {{old('asociacionsol',$solicitud->asociacionsol)=="3"? 'selected':''}} value="3">TRES</option>
                    <option {{old('asociacionsol',$solicitud->asociacionsol)=="4"? 'selected':''}} value="4">CUATRO</option>
                    <option {{old('asociacionsol',$solicitud->asociacionsol)=="5"? 'selected':''}} value="5">CINCO</option>
                    <option {{old('asociacionsol',$solicitud->asociacionsol)=="6"? 'selected':''}} value="6">SEIS</option>
                    <option {{old('asociacionsol',$solicitud->asociacionsol)=="7"? 'selected':''}} value="7">SIETE</option>
                    <option {{old('asociacionsol',$solicitud->asociacionsol)=="8"? 'selected':''}} value="8">OCHO</option>
                    <option {{old('asociacionsol',$solicitud->asociacionsol)=="9"? 'selected':''}} value="9">NUEVE</option>

                </select>
            </div>


            <div class="col-md-2">
                <label for="ci" class="d-inline font-verdana-bg">
                    <b>C.I. No.</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="ci"
                class="form-control form-control-sm font-verdana-bg" id="ci"
                >{{$solicitud->ci}}</textarea>
            </div>


            <div class="col-md-6">
                <label for="direccionsol" class="d-inline font-verdana-bg">
                    <b>DIRECCION</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="direccionsol" cols="1" rows="3"
                class="form-control form-control-sm font-verdana-bg" id="direccionsol"
                >{{$solicitud->direccionsol}}</textarea>
            </div>

            <div class="col-md-2">
                <label for="telefonosol" class="d-inline font-verdana-bg">
                    <b>TELEFONO</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="telefonosol" value="{{$solicitud->telefonosol}}"
                class="form-control form-control-sm font-verdana-bg" id="telefonosol">
            </div>

            <div class="col-md-2">
                <label for="correosol" class="d-inline font-verdana-bg">
                    <b>E-MAIL</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="correosol" value="{{$solicitud->correosol}}"
                class="form-control form-control-sm font-verdana-bg" id="correosol" >
            </div>

            <div class="col-md-6">
                <label for="idrubro" class="d-inline font-verdana-bg">
                    <b>ASOCIACION</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idrubro" id="idrubro" placeholder="--Seleccionar--" class="form-control form-control-sm select2">

                    <option {{old('idrubro',$solicitud->idrubro)=="1"? 'selected':''}}  value="1">UNO</option>
                    <option {{old('idrubro',$solicitud->idrubro)=="2"? 'selected':''}} value="2">DOS</option>
                    <option {{old('idrubro',$solicitud->idrubro)=="3"? 'selected':''}} value="3">TRES</option>
                    <option {{old('idrubro',$solicitud->idrubro)=="4"? 'selected':''}} value="4">CUATRO</option>
                    <option {{old('idrubro',$solicitud->idrubro)=="5"? 'selected':''}} value="5">CINCO</option>
                    <option {{old('idrubro',$solicitud->idrubro)=="6"? 'selected':''}} value="6">SEIS</option>
                    <option {{old('idrubro',$solicitud->idrubro)=="7"? 'selected':''}} value="7">SIETE</option>
                    <option {{old('idrubro',$solicitud->idrubro)=="8"? 'selected':''}} value="8">OCHO</option>
                    <option {{old('idrubro',$solicitud->idrubro)=="9"? 'selected':''}} value="9">NUEVE</option>

                </select>
            </div>

        </div>
        <div class="form-group row">
            <div class="col-md-12 text-right">
                <button class="btn color-icon-2 font-verdana-bg" type="button" onclick="save();">
                    <i class="fa-solid fa-paper-plane"></i>
                    &nbsp;Actualizar
                </button>
                <button class="btn btn-danger font-verdana-bg" type="button" >

                    <a href="{{url()->previous()}}" style="color:white">Cancelar</a>
                </button>

                <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

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
            window.location.href = "{{url('expochaco')}}";
        }

        function validar_formulario(){
            if($("#nombresol").val() == ""){
                message_alert("El campo <b>[NOMBRES Y APELLIDOS]</b> es un dato obligatorio...");
                return false;
            }
            if($("#asociacionsol>option:selected").val() == ""){
                message_alert("El campo <b>[ASOCIACION]</b> es un dato obligatorio...");
                return false;
            }

            if($("#ci").val() == ""){
                message_alert("El campo <b>[C.I No]</b> es un dato obligatorio...");
                return false;
            }

            if($("#direccionsol").val() == ""){
                message_alert("El campo <b>[DIRECCION]</b> es un dato obligatorio...");
                return false;
            }

            if($("#telefonosol").val() == ""){
                message_alert("El campo <b>[TELEFONO]</b> es un dato obligatorio...");
                return false;
            }

            if($("#correosol").val() == ""){
                message_alert("El campo <b>[CORREO]</b> es un dato obligatorio...");
                return false;
            }

            if($("#idrubro >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[RUBRO]</b> es un dato obligatorio...");
                return false;
            }


     return true;
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
