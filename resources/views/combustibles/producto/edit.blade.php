@extends('layouts.admin')

@section('content')
@include('layouts.message_alert')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/combustibles/producto/index') }}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>
            <div class="col-md-8 text-right titulo">
                <b>EDITAR REGISTRO</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>


            <div class="body-border">

            <font size="2" face="Courier New" >
                <form method="POST" id="form" action="{{ route('producto.update', $productos->idprodcomb) }}">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="codigoprodcomb2" id="codigoprodcomb2">

                    <div class="form-group row">
                        <label style="color:black;font-weight: bold;" for="name"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Codigo') }}</label>
                        <div class="col-md-7">
                             <input type="text" name="codigoprodcomb" value="{{$productos->codigoprodcomb}}" class="form-control form-control-sm font-verdana-12" id="codigoprodcomb" onchange="myFunction()">

                            </div>
                    </div>

                    <div class="form-group row">
                        <label style="color:black;font-weight: bold;" for="name"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                        <div class="col-md-7">
                            <input type="text" name="nombre" id="nombreprodcomb" class="form-control"
                               placeholder="Nombre..."
                            onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$productos->nombreprodcomb}}">
                        </div>
                    </div>

            <div class="form-group row">
                <label style="color:black;font-weight: bold;" for="detalle"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Detalle') }}</label>
                <div class="col-md-7">
                    <textarea id="detalleprodcomb" required type="text" name="detalle" cols="51" rows="4"
                        placeholder="Detalle..." class="form-control"
                        onkeyup="javascript:this.value=this.value.toUpperCase();" >{{$productos->detalleprodcomb}}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label style="color:black;font-weight: bold;" for="precio"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Precio') }}</label>
                <div class="col-md-2">
                    <input id="precioprodcomb" required name="precio" type="number" placeholder="0.0" step="0.01" class="form-control"
                        placeholder="Precio..." value="{{$productos->precioprodcomb}}">
                </div>
            </div>


            <div class="form-group row">
                <label style="color:black;font-weight: bold;"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Partida') }}</label>
                <div class="col-md-8" >
                    <select name="idpartidacomb" id="permissions" class="col-md-10 form-control select2 ">
                        @foreach ($partidas as $par)
                        @if ($par->idpartidacomb==$productos->idpartidacomb)
                        <option value="{{$par->idpartidacomb}}" selected>{{$par->codigopartida}} - {{$par->nombrepartida}}</option>
                        @else
                        <option value="{{$par->idpartidacomb}}">{{$par->codigopartida}} - {{$par->nombrepartida}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>





            <div align='center'>
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

            </form>

        </font>
    </div>
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
            window.location.href = "{{url('combustibles/producto/index')}}";
        }

        function validar_formulario(){

            if($("#nombreprodcomb").val() == ""){
                message_alert("El campo <b>[Nombre]</b> es un dato obligatorio...");
                return false;
            }
            if($("#codigoprodcomb").val() == ""){
                message_alert("El campo <b>[Codigo]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#codigoprodcomb2").val() == "comunicacion") {
                $("#codigoprodcomb2").val('');
                $("#nombreprodcomb").val('');
                $("#codigoprodcomb").val('');
                message_alert("El <b>[CODIGO DEL PRODUCTO]</b> ya existe en nuestros registros...");
                return false;
            }

          
     
         
            
          
            if($("#detalleprodcomb").val() == ""){
                message_alert("El campo <b>[Detalle]</b> es un dato obligatorio...");
                return false;
            }
           
            if($("#precioprodcomb").val() == ""){
                message_alert("El campo <b>[Precio]</b> es un dato obligatorio...");
                return false;
            }

            if($("#permissions >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Partida]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }
        function myFunction() {
            respuesta();
        }
        function respuesta() {
            var ot_antigua = $("#codigoprodcomb").val();
            $.ajax({
                url: "{{ route('pregunta3') }}",
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
                        $("#codigoprodcomb2").val('comunicacion');
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