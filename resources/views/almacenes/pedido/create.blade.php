@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<br>
<div class="row font-verdana-bg">
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
    <form action="{{ route('almacenes.pedido.store') }}" method="post" id="form">
        @csrf
        <div class="form-group row">

            <div class="col-md-6">
                <label for="objeto" class="d-inline font-verdana-bg">
                    <b>Objeto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="objeto" cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-bg" 

                id="objeto">{{request('objeto')}}</textarea>
            </div>

            <div class="col-md-6">
                <label for="motivosoli" class="d-inline font-verdana-bg">
                    <b>Justificacion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="motivosoli" cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-bg" id="motivosoli">
                {{request('motivosoli')}}</textarea>
            </div>


            <div class="col-md-2">
                <label for="controlinterno" class="d-inline font-verdana-bg">
                    <b>control interno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="controlinterno" value="{{request('controlinterno')}}" 
                class="form-control form-control-sm font-verdana-bg" id="controlinterno">
            </div>
            
            
            <div class="col-md-7">
                <label for="idarea" class="d-inline font-verdana-bg">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idarea" id="idarea" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($areas as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="idlocalidad" class="d-inline font-verdana-bg">
                    <b>Localidad</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idlocalidad" id="idlocalidad" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($localidades as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-5">
                <label for="idunidadconsumo" class="d-inline font-verdana-bg">
                    <b>Unidad consumo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idunidadconsumo" id="idunidadconsumo" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($consumos as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
 
            
        </div>
        <div class="form-group row">
            <div class="col-md-12 text-right">
                <button class="btn color-icon-2 font-verdana-bg" 
                type="button" onclick="save();">
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
            window.location.href = "{{url('combustibles/pedido')}}";
        }

        function validar_formulario(){
            if($("#objeto").val() == ""){   
                message_alert("El campo <b>[Objeto]</b> es un dato obligatorio...");
                return false;
            }
            if($("#motivosoli").val() == ""){   
                message_alert("El campo <b>[Justificacion]</b> es un dato obligatorio...");
                return false;
            }
            if($("#controlinterno").val() == ""){   
                message_alert("El campo <b>[Control interno]</b> es un dato obligatorio...");
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
                message_alert("El campo de seleccion <b>[Unidad consumo]</b> es un dato obligatorio...");
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