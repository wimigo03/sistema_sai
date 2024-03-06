@extends('layouts.admin')

@section('content')
@include('layouts.message_alert')
<div class="row justify-content-center">
    <div class="col-md-10">

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
                <b>EDITAR DETALLE</b>
            </div>

            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>


        <div class="body-border">
            <font size="2" face="Courier New" >
                    <form method="POST" action="{{ route('comingreso.updatearchivonota',$docproveedor->iddetallecomingreso) }}" id="form">
                        @csrf
                        <input type="hidden" class="form-control" name="id3" placeholder="" value="{{$id3}}">
                        <input type="hidden" class="form-control" name="id4" placeholder="" value="{{$id4}}">
                        <input type="hidden" class="form-control" name="id5" placeholder="" value="{{$id5}}">
                        <input type="hidden" class="form-control" name="id6" placeholder="" value="{{$id6}}">

                      
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="idproducto" class="d-inline font-verdana-bg">
                                    <b>Producto -- Item</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                                </label>
                                <select  name="idproducto" id="idproducto" placeholder="--Seleccionar--" 
                                class="form-control form-control-sm select2">
                                    <option value="">-</option>
                                    @foreach ($productos as $local)
                
                                                @if ($local->idprodcomb==$docproveedor->idproducto)
                                                <option value="{{$local->idprodcomb}}" selected> ID: {{$local->idprodcomb}} //CODIGO: {{$local->detalleprodcomb}} //NOMBRE: {{$local->nombreprodcomb}} //PRECIO BS: {{$local->precioprodcomb}}
                                                </option>
                                                @else
                                                <option value="{{$local->idprodcomb}}"> ID: {{$local->idprodcomb}} //CODIGO: {{$local->detalleprodcomb}} //NOMBRE: {{$local->nombreprodcomb}} //PRECIO BS: {{$local->precioprodcomb}}</option>
                                                @endif
                
                                                @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="cantidadcargada" class="d-inline font-verdana-bg">
                                    <b>Cantidad:</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                                </label>
                                <input type="text"  disabled name="cantidadcargada" id="cantidadcargada"   value="{{$docproveedor->cantidadsalida }}" class="form-control form-control-sm font-verdana-bg" >
                            </div>
                          
                            <div class="col-md-3">
                                <label for="cantidadsubtotal" class="d-inline font-verdana-bg">
                                    <b>Sub Total:</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                                </label>
                                <input type="text"  disabled name="cantidadsubtotal" id="cantidadsubtotal"  value="{{$docproveedor->subtotalsalida }}" class="form-control form-control-sm font-verdana-bg" >
                            </div>


                            <div class="col-md-4">
                                <label for="cantidad" class="d-inline font-verdana-bg">
                                    <b>Cantidad</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <input type="text"   name="cantidad" id="cantidad" onkeypress="return valideNumber(event);"  value="{{$docproveedor->cantidadsalida }}" class="form-control form-control-sm font-verdana-bg" >
                            </div>
                          

                        </div>



                      


                        <div align='center'>
                            <div class="col-md-12 text-right">

                                <input class="btn btn-danger font-verdana-bg" type="button" id="cancelar" value="Cancelar">
                
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input  class="btn color-icon-2 font-verdana-bg" type="button" value="Guardar" onclick="save();" id="save">
                
                                </br></br>
                               
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

        $("#save").click(function() {
            if(validar_formulario() == true){
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        });

        $("#cancelar").click(function() {
$(".btn").hide();
$(".spinner-btn-send").show();
window.location.href =  "{{url()->previous()}}";

});
         
                function validar_formulario(){

            if($("#cantidad").val() == ""){
                message_alert("El campo <b>[Cantidad]</b> es un dato obligatorio...");
                return false;
            }
          
            return true;
        };

       
        function valideNumber(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if((code == 46) || (code>=48 && code<=57)){
                return true;
            }else{
                return false;
            }
        }

    
    </script>
@endsection
