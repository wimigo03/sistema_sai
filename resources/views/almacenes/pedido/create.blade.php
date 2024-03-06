@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
@if(Session::has('message'))
    <div class="alert alert-success">
        <em> {!! session('message') !!}</em>
    </div>
@endif
<br>
<div class="row font-verdana-bg">
    <div class="col-md-4 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/apedido/index') }}">
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
    <div class="col-md-4 text-right titulo">
        <b>Fecha</b>  <b style='color:red'>{{$date->format('d-m-Y H:i:s')}}</b>
    </div>
</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('apedido.store') }}" method="post" id="form">
        @csrf
        <div class="form-group row">

            <div class="col-md-6">
                <label for="idcomingreso" class="d-inline font-verdana-bg">
                    <b>Proyecto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idcomingreso" id="idcomingreso" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($comingresos as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="idpartida" class="d-inline font-verdana-bg">
                    <b>Partida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idpartida" id="idpartida" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($partidas as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
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
            <div class="col-md-2">
                <label for="preventivo" class="d-inline font-verdana-bg">
                    <b>N° Preventivo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="preventivo" value="{{request('preventivo')}}" placeholder=""
                class="form-control form-control-sm font-verdana-bg" id="preventivo"  onkeypress="return valideNumber(event);">
            </div> 
            <div class="col-md-5">
                <label for="idusuario" class="d-inline font-verdana-bg">
                    <b>Funcionario</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idusuario" id="idusuario" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($empleados as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label for="idunidadconsumo" class="d-inline font-verdana-bg">
                    <b>Unidad</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idunidadconsumo" id="idunidadconsumo" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($consumos as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
           <div class="col-md-2">
                <label for="cantidad" class="d-inline font-verdana-bg">
                    <b>klm actual</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="cantidad" value="{{request('cantidad')}}" placeholder="mayor a klm Ant."
                class="form-control form-control-sm font-verdana-bg" id="cantidad"  onkeypress="return valideNumber(event);">
            </div> 

           

             <div class="col-md-5">
                <label for="detalle" class="d-inline font-verdana-bg">
                    <b>Motivo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea  type="text" name="detalle"  cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-bg" id="detalle" 
                onkeyup="convertirAMayusculas(this)">{{request('detalle')}}</textarea>
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
                    
                    <a href="{{url('/apedido/index')}}" style="color:white">Cancelar</a>
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
            window.location.href = "{{url('/apedido/index')}}";
        }

        function validar_formulario(){
            if($("#cantidad").val() == ""){   
                message_alert("El campo <b>[klm actual]</b> es un dato obligatorio...");
                return false;
            }
            if($("#detalle").val() == ""){   
                message_alert("El campo <b>[Detalle]</b> es un dato obligatorio...");
                return false;
            }
            if($("#preventivo").val() == ""){   
                message_alert("El campo <b>[Preventivo]</b> es un dato obligatorio...");
                return false;
            }
            if($("#preventivo").val() <=0){   
                message_alert("El campo <b>[Preventivo]</b> es un dato incorrecto...");
                return false;
            }
            // if($("#idcomingreso").val() == ""){   
            //     message_alert("El campo <b>[Proyecto]</b> es un dato obligatorio...");
            //     return false;
            // }
            // if($("#idpartida").val() == ""){   
            //     message_alert("El campo <b>[Partida]</b> es un dato obligatorio...");
            //     return false;
            // }
           
            // if($("#idprograma >option:selected").val() == ""){   
            //     message_alert("El campo de seleccion <b>[Programa]</b> es un dato obligatorio...");
            //     return false;
            // }
            if($("#idcomingreso >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Proyecto]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idpartida >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Partida]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idarea >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Area]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idusuario >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Funcionario]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idunidadconsumo >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[unidad]</b> es un dato obligatorio...");
                return false;
            }
          
            if($("#idlocalidad >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Localidad]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }
        function convertirAMayusculas(input) {
    // Guarda la posición actual del cursor
    var inicioSeleccion = input.selectionStart;
    var finSeleccion = input.selectionEnd;
    // Convierte todo el texto a mayúsculas
    input.value = input.value.toUpperCase();
    // Restaura la posición del cursor
    input.setSelectionRange(inicioSeleccion, finSeleccion);
  }

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