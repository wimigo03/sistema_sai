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
            <a href="{{ url('/comegreso/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-8 text-right titulo">
        <b>CREAR FORMULARIO DE INGRESO</b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
    <div class="col-md-4 text-right titulo">
        <b>Fecha</b>  <b style='color:red'>{{$date->format('d-m-Y H:i:s')}}</b>
    </div>
</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('comegreso.store') }}" method="post" id="form">
        @csrf
        <div class="form-group row">

            {{-- <div class="col-md-6">
                <label for="objeto" class="d-inline font-verdana-bg">
                    <b>Objeto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="objeto" cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-bg" 

                id="objeto">{{request('objeto')}}</textarea>
            </div> --}}

            {{-- <div class="col-md-6">
                <label for="motivosoli" class="d-inline font-verdana-bg">
                    <b>Justificacion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="motivosoli" cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-bg" id="motivosoli">
                {{request('motivosoli')}}</textarea>
            </div> --}}


            {{-- <div class="col-md-2">
                <label for="numpreventivo" class="d-inline font-verdana-bg">
                    <b>control interno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="numpreventivo" value="{{request('numpreventivo')}}" 
                class="form-control form-control-sm font-verdana-bg" id="numpreventivo">
            </div> --}}
            
            {{-- <div class="col-md-5">
                <label for="idprograma" class="d-inline font-verdana-bg">
                    <b>Programa</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idprograma" id="idprograma" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($programas as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div> --}}

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

             <div class="col-md-5">
                <label for="detalle" class="d-inline font-verdana-bg">
                    <b>Glosa</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea  type="text" name="detalle"  cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-bg" id="detalle" 
                onkeyup="convertirAMayusculas(this)">{{request('detalle')}}</textarea>
            </div> 
            <div class="col-md-5">
                <label for="idusuario" class="d-inline font-verdana-bg">
                    <b>Recibido por:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idusuario" id="idusuario" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($empleados as $index => $value)
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
                    
                    <a href="{{url('/comegreso/index')}}" style="color:white">Cancelar</a>
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
            window.location.href = "{{url('/comegreso/index')}}";
        }

        function validar_formulario(){
       
            if($("#detalle").val() == ""){   
                message_alert("El campo <b>[Detalle]</b> es un dato obligatorio...");
                return false;
            }
         
  
            if($("#idcomingreso >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Proyecto]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idpartida >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Partida]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idusuario >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Recibido por]</b> es un dato obligatorio...");
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