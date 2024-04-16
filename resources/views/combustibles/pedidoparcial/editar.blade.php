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
                <label for="objeto" class="d-inline font-verdana-12">
                    <b>Objeto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="objeto" cols="1" rows="3" class="form-control form-control-sm font-verdana-12" id="objeto" onkeyup="javascript:this.value=this.value.toUpperCase();">{{$compras->objeto}}</textarea>
            </div>
            <div class="col-md-6">
                <label for="justificacion" class="d-inline font-verdana-12">
                    <b>Justificacion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="justificacion" cols="1" rows="10" class="form-control form-control-sm font-verdana-12" id="justificacion" onkeyup="javascript:this.value=this.value.toUpperCase();">{{$compras->justificacion}}</textarea>
            </div>
            <div class="col-md-2">
                <label for="controlinterno" class="d-inline font-verdana-12">
                    <b>Control Interno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text"   name="controlinterno" id="controlinterno" onchange="myFunction()" value="{{$compras->controlinterno}}" class="form-control form-control-sm font-verdana-12" id="controlinterno" onkeypress="return valideNumber(event);">
            </div>

            <div class="col-md-2">
                <label for="tipo" class="d-inline font-verdana-12">
                    <b>Tipo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="tipo" 
                value="{{$Tipos}}" 
                class="form-control form-control-sm font-verdana-12" id="tipo">
            </div>


            <div class="col-md-7">
                <label for="idarea" class="d-inline font-verdana-12">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="idarea" 
                value="{{$personalArea->nombrearea}}" 
                class="form-control form-control-sm font-verdana-12" id="idarea">
            </div>
            <div class="col-md-4">
                <label for="idprograma" class="d-inline font-verdana-12">
                    <b>Programa</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="idprograma" 
                value="{{$nombrePro}}" 
                class="form-control form-control-sm font-verdana-12" id="idprograma">
            </div>
            <div class="col-md-5">
                <label for="idcatprogramatica" class="d-inline font-verdana-12">
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
                <button class="btn color-icon-2 font-verdana-12" type="button" onclick="save();">
                    <i class="fa-solid fa-paper-plane"></i>
                    &nbsp;Actualizar
                </button>
                <button class="btn btn-danger font-verdana-12" type="button" >

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
