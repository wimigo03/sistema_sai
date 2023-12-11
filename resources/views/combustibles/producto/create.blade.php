@extends('layouts.admin')

@section('content')
@include('layouts.message_alert')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-bg">
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
                <b>CREAR REGISTRO</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>


            <div class="body-border">

            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('producto.store') }}" id="form">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="nombreprodcomb2" id="nombreprodcomb2">

                    <div class="form-group row">
                        <label for="name" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Codigo') }}</label>
                        <div class="col-md-7">
                            <textarea id="codigoprodcomb" required type="text" require name="codigoprodcomb" placeholder="Codigo del producto..."
                            class="form-control"  cols="50" rows="2" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                        <div class="col-md-7">
                            <input id="nombreprodcomb" onchange="myFunction()" required type="text" require name="nombre" placeholder="Nombre..."
                            class="form-control"  cols="50" rows="2" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="detalle" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Detalle') }}</label>
                        <div class="col-md-7">
                            <textarea id="detalleprodcomb" required type="text" name="detalle" cols="50" rows="4"
                                placeholder="Detalle..." class="form-control"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="precio" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Precio') }}</label>
                        <div class="col-md-2">
                            <input id="precioprodcomb" class="form-control" required name="precio" type="number" placeholder="1,00" step="1,01"
                                placeholder="Precio...">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="required  col-md-4 col-form-label text-md-right"
                            style="color:black;font-weight: bold;">{{ __('Partida') }}</label>
                        <div class="col-md-8" >
                            <select name="idpartidacomb" id="permissions" class="col-md-6 form-control select2">
                                @foreach ($partidas as $par)

                                <option value="{{$par->idpartidacomb}}">{{$par->codigopartida}} -
                                    {{$par->nombrepartida}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div> 

                    

                   
            <div align='center'>
                               
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
            window.location.href = "{{url('combustibles/producto/index')}}";
        }

        function validar_formulario(){


            if($("#codigoprodcomb").val() == ""){
                message_alert("El campo <b>[Codigo]</b> es un dato obligatorio...");
                return false;
            }
            if($("#nombreprodcomb").val() == ""){
                message_alert("El campo <b>[Nombre]</b> es un dato obligatorio...");
                return false;
            }
     
            if ($("#nombreprodcomb2").val() == "comunicacion") {
                $("#nombreprodcomb2").val('');
                $("#nombreprodcomb").val('');
                $("#codigoprodcomb").val('');
                message_alert("El <b>[Nombre Producto]</b> ya existe en nuestros registros...");
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
            var ot_antigua = $("#nombreprodcomb").val();
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
                        $("#nombreprodcomb2").val('comunicacion');
                    }
                }
            });
        }
</script>
@endsection