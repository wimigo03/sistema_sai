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
            <a href="{{ url('/comingreso/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-8 text-right titulo">
        <b>REGISTRO DE BALANCE INICIAL</b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
    <div class="col-md-4 text-right titulo">
        <b>Fecha</b>  <b style='color:red'>{{$date->format('d-m-Y H:i:s')}}</b>
    </div>
</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('comingreso.store') }}" method="post" id="form">
        @csrf
        <div class="form-group row">

            <div class="col-md-4">
                <label for="objeto" class="d-inline font-verdana-bg">
                    <b>Objeto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input  name="objeto" cols="1" rows="2" class="form-control form-control-sm font-verdana-bg" 
                id="objeto" onkeyup="convertirAMayusculas(this)"  value="{{request('objeto')}}" autocomplete="off"  >
           
                <label for="idarea" class="d-inline font-verdana-bg">
                    <b>Area:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idarea" id="idarea" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($areas as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

         

         <div class="col-md-2">
                <label for="numcompra" class="d-inline font-verdana-bg">
                    <b>N° compra</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="numcompra" value="{{request('numcompra')}}" 
                class="form-control form-control-sm font-verdana-bg" id="numcompra" onkeypress="return valideNumber(event);">
           
                <label for="numsolicitud" class="d-inline font-verdana-bg">
                    <b>N° solicitud</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="numsolicitud" value="{{request('numsolicitud')}}" 
                class="form-control form-control-sm font-verdana-bg" id="numsolicitud" onkeypress="return valideNumber(event);">
            </div>

         <div class="col-md-4">
                <label for="detalle" class="d-inline font-verdana-bg">
                    <b>detalle</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="detalle" cols="1" rows="4" 
                class="form-control form-control-sm font-verdana-bg" onkeyup="convertirAMayusculas(this)"  id="detalle">{{request('detalle')}}</textarea>
            </div>

            <div class="col-md-2">
                <label for="numpreventivo" class="d-inline font-verdana-bg">
                    <b>N° preventivo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="numpreventivo" value="{{request('numpreventivo')}}" 
                class="form-control form-control-sm font-verdana-bg" id="numpreventivo" onkeypress="return valideNumber(event);">
                <label for="factura" class="d-inline font-verdana-bg">
                    <b>N° factura</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="factura" value="{{request('factura')}}" 
                class="form-control form-control-sm font-verdana-bg" id="factura" onkeypress="return valideNumber(event);">
            </div>

         
              
            <div class="col-md-6">
                <label for="iddirigidoa" class="d-inline font-verdana-bg">
                    <b>Dirigido A:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="iddirigidoa" id="iddirigidoa" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($encargadodos as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="idvia" class="d-inline font-verdana-bg">
                    <b>Via:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idvia" id="idvia" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($encargado as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="idcategoria" class="d-inline font-verdana-bg">
                    <b>Proyecto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idcategoria" id="idcategoria" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($catprogramaticas as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            
            <div class="col-md-6">
                <label for="idproveedor" class="d-inline font-verdana-bg">
                    <b>Proveedor:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idproveedor" id="idproveedor" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($proveedores as $index => $value)
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
                    
                    <a href="{{url('/comingreso/index')}}" style="color:white">Cancelar</a>
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
            window.location.href = "{{url('/comingreso/index')}}";
        }

        function validar_formulario(){
            var objetod = $("#objeto").val();
            var detalled = $("#detalle").val();
            var numcomprad = $("#numcompra").val();
            var numsolicitudd = $("#numsolicitud").val();
            var numpreventivod = $("#numpreventivo").val();
            var facturad = $("#factura").val();
            if($("#objeto").val() == ""){   
                message_alert("El campo <b>[Objeto]</b> es un dato obligatorio...");
                return false;
            }
            if(objetod.length > 500){
            //    $("#objetod").val('');
            //    $("#objeto").val('');
               message_alert("El campo <b>[Objeto]</b> tiene muchos caracteres...");
               return false;
               }

            if($("#numcompra").val() == ""){   
                message_alert("El campo <b>[N° Compra]</b> es un dato obligatorio...");
                return false;
            }
            if(numcomprad <= 0){   
                $("#numcomprad").val('');
               $("#numcompra").val('');
                message_alert("El campo <b>[N° Compra]</b> es un dato incorrecto...");
                return false;
            }
            if($("#numsolicitud").val() == ""){   
                message_alert("El campo <b>[N° Solicitud]</b> es un dato obligatorio...");
                return false;
            }
            if(numsolicitudd <= 0){   
                $("#numsolicitudd").val('');
               $("#numsolicitud").val('');
                message_alert("El campo <b>[N° Solicitud]</b> es un dato incorrecto...");
                return false;
            }
            if($("#detalle").val() == ""){   
                message_alert("El campo <b>[Detalle]</b> es un dato obligatorio...");
                return false;
            }
            if(detalled.length > 500){
            //    $("#objetod").val('');
            //    $("#objeto").val('');
               message_alert("El campo <b>[Detalle]</b> tiene muchos caracteres...");
               return false;
               }
            if($("#numpreventivo").val() == ""){   
                message_alert("El campo <b>[N° Preventivo]</b> es un dato obligatorio...");
                return false;
            }
            if(numpreventivod <= 0){   
                $("#numpreventivod").val('');
               $("#numpreventivo").val('');
                message_alert("El campo <b>[N° Preventivo]</b> es un dato incorrecto...");
                return false;
            }
            if($("#factura").val() == ""){   
                message_alert("El campo <b>[N° Factura]</b> es un dato obligatorio...");
                return false;
            }
            if(facturad <= 0){   
                $("#facturad").val('');
               $("#factura").val('');
                message_alert("El campo <b>[N° Factura]</b> es un dato incorrecto...");
                return false;
            }
            if($("#iddirigidoa >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Dirigido A]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idvia >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Via]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idproveedor >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Proveedor]</b> es un dato obligatorio...");
                return false;
            }  
         
            if($("#idcategoria >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Proyecto]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idarea >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Area]</b> es un dato obligatorio...");
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