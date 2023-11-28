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
        <b>EDITAR FORMULARIO DE SOLICITUD</b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form method="post" action="{{ route('combustibles.pedidoparcial.update') }}" id="form">
        @csrf
        {{--@method('PUT')--}}
        <input type="hidden" name="controlinterno2" id="controlinterno2">

        <input type="text" hidden name="idcompracomb" value="{{$compras->idcompracomb}}">
        <input type="text" hidden name="idproveedor" id="idproveedor" value="{{$compras->idproveedor}}">
        <input type="text" hidden name="numcompra" id="numcompra" value="{{$compras->numcompra}}">
        <input type="text" hidden name="preventivo" id="preventivo" value="{{$compras->preventivo}}">
        
        <div class="form-group row">
            <div class="col-md-6">
                <label for="objeto" class="d-inline font-verdana-bg">
                    <b>Objeto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="objeto" cols="1" rows="3" class="form-control form-control-sm font-verdana-bg" id="objeto" onkeyup="javascript:this.value=this.value.toUpperCase();">{{$compras->objeto}}</textarea>
            </div>
            <div class="col-md-6">
                <label for="justificacion" class="d-inline font-verdana-bg">
                    <b>Justificacion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="justificacion" cols="1" rows="10" class="form-control form-control-sm font-verdana-bg" id="justificacion" onkeyup="javascript:this.value=this.value.toUpperCase();">{{$compras->justificacion}}</textarea>
            </div>
            <div class="col-md-2">
                <label for="controlinterno" class="d-inline font-verdana-bg">
                    <b>Control Interno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text"   name="controlinterno" id="controlinterno" onchange="myFunction()" value="{{$compras->controlinterno}}" class="form-control form-control-sm font-verdana-bg" id="controlinterno" onkeypress="return valideNumber(event);">
            </div>

            <div class="col-md-2">
                <label for="tipo" class="d-inline font-verdana-bg">
                    <b>Tipo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="tipo" id="tipo" placeholder="--Seleccionar--" class="form-control form-control-sm select2">

                    <option {{old('tipo',$compras->tipo)=="1"? 'selected':''}}  value="1">PRODUCTO</option>
                    <option {{old('tipo',$compras->tipo)=="2"? 'selected':''}} value="2">SERVICIO</option>

                </select>
            </div>


            <div class="col-md-7">
                <label for="idarea" class="d-inline font-verdana-bg">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idarea" id="idarea" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($areas as $area)

                    @if ($area->idarea==$compras->idarea)
                    <option value="{{$area->idarea}}" selected>{{$area->nombrearea}}</option>
                    @else
                    <option disabled value="{{$area->idarea}}">{{$area->nombrearea}}</option>
                    @endif

                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="idprograma" class="d-inline font-verdana-bg">
                    <b>Programa</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idprograma" id="idprograma" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($programas as $programa)

                                @if ($programa->idprogramacomb==$compras->idprogramacomb)
                                <option value="{{$programa->idprogramacomb}}" selected>{{$programa->nombreprograma}}
                                </option>
                                @else
                                <option value="{{$programa->idprogramacomb}}">{{$programa->nombreprograma}}</option>
                                @endif

                                @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label for="idcatprogramatica" class="d-inline font-verdana-bg">
                    <b>Cat. Programatica</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idcatprogramatica" id="idcatprogramatica" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($catprogramaticas as $catprogramatica)

                    @if ($catprogramatica->idcatprogramaticacomb==$compras->idcatprogramaticacomb)
                    <option value="{{$catprogramatica->idcatprogramaticacomb}}" selected>
                        {{$catprogramatica->nombrecatprogramatica}}</option>
                    @else
                    <option value="{{$catprogramatica->idcatprogramaticacomb}}">
                        {{$catprogramatica->nombrecatprogramatica}}</option>
                    @endif
                    @endforeach
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
            if($("#preventivo").val() == ""){
                message_alert("El campo <b>[Preventivo]</b> es un dato obligatorio...");
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
            if($("#idarea >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Area]</b> es un dato obligatorio...");
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

    </script>
@endsection
