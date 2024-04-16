@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<br>
<div class="row font-verdana-12">
    <div class="col-md-4 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/almacenes/pedido/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-8 text-right titulo">
        <b>FORMULARIO DE SOLICITUD</b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form method="post" action="{{ route('almacenes.pedido.update') }}" id="form">
        @csrf
        {{--@method('PUT')--}}

        <input type="text" hidden name="idvale" value="{{$vales->idvale}}">

        <div class="form-group row">

            <div class="col-md-6">
                <label for="objeto" class="d-inline font-verdana-12">
                    <b>Objeto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea disabled name="objeto" cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-12" 
                id="objeto" onkeyup="javascript:this.value=this.value.toUpperCase();">
                {{$vales->objeto}}</textarea>
            </div>


            <div class="col-md-6">
                <label for="motivosoli" class="d-inline font-verdana-12">
                    <b>Justificacion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea disabled name="motivosoli" cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-12" 
                id="motivosoli" onkeyup="javascript:this.value=this.value.toUpperCase();">
                {{$vales->motivosoli}}</textarea>
            </div>


            <div class="col-md-2">
                <label for="controlinterno" class="d-inline font-verdana-12">
                    <b>controlinterno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" disabled name="controlinterno" value="{{$vales->controlinterno}}" 
                class="form-control form-control-sm font-verdana-12" id="controlinterno">
            </div>


           

            <div class="col-md-7">
                <label for="idarea" class="d-inline font-verdana-12">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select disabled name="idarea" id="idarea" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($areas as $area)

                    @if ($area->idarea==$vales->idarea)
                    <option value="{{$area->idarea}}" selected>{{$area->nombrearea}}</option>
                    @else
                    <option value="{{$area->idarea}}">{{$area->nombrearea}}</option>
                    @endif

                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="idlocalidad" class="d-inline font-verdana-12">
                    <b>Localidad</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select disabled name="idlocalidad" id="idlocalidad" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($localidades as $local)

                                @if ($local->idlocalidad==$vales->idlocalidad)
                                <option value="{{$local->idlocalidad}}" selected>{{$local->nombrelocalidad}}
                                </option>
                                @else
                                <option value="{{$local->idlocalidad}}">{{$local->nombrelocalidad}}</option>
                                @endif

                                @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label for="idunidadconsumo" class="d-inline font-verdana-12">
                    <b>Unidad Consumo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select disabled name="idunidadconsumo" id="idunidadconsumo" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($consumos as $consumo)

                   
                    @if ($consumo->idunidadconsumo==$vales->idunidadconsumo)
                    <option value="{{$consumo->idunidadconsumo}}" selected>
                        {{$consumo->codigoconsumo}}</option>
                    @else
                    <option value="{{$consumo->idunidadconsumo}}">
                        {{$consumo->codigoconsumo}}</option>
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
            window.location.href = "{{url('almacenes/pedido')}}";
        }

        function validar_formulario(){
            if($("#objeto").val() == ""){   
                message_alert("El campo <b>[Objeto]</b> es un dato obligatorio...");
                return false;
            }
            if($("#motivo").val() == ""){   
                message_alert("El campo <b>[Justificacion]</b> es un dato obligatorio...");
                return false;
            }
            
            if($("#controlinterno").val() == ""){   
                message_alert("El campo <b>[Control Interno]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idarea >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Area]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idlocalidad >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Localidad]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idunidadconsumo >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Unidad Consumo]</b> es un dato obligatorio...");
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
    </script>
@endsection