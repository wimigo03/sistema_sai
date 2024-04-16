@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
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
        <b>EDITAR FORMULARIO DE BALANCE INICIAL</b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
    <div class="col-md-2 text-right titulo">
        <b>N° CPBTE:</b>  <b style='color:red'>{{$idco}}</b>
    </div>
    <div class="col-md-5 text-right titulo">
        <b>Fecha Ingreso: </b>  <b style='color:red'>{{$Fechayhora}}</b>
    </div>
</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form method="post" action="{{ route('comingreso.updaten') }}" id="form">
        @csrf
        {{--@method('PUT')--}}

        <input type="text" hidden name="idcomingreso" value="{{$comingresos->idcomingreso}}">
        <input type="hidden" class="form-control" name="id4" placeholder="" value="{{$id4}}">
        <input type="hidden" class="form-control" name="id6" placeholder="" value="{{$id6}}">
        <div class="form-group row">

            <div class="col-md-4">
             
                <label for="objeto" class="d-inline font-verdana-bg">
                    <b>Objeto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input  name="objeto" cols="1" rows="3" class="form-control form-control-sm font-verdana-bg" id="objeto" onkeyup="convertirAMayusculas(this)" value="{{$comingresos->objeto}}">
               
                <label for="idarea" class="d-inline font-verdana-bg">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select  name="idarea" id="idarea" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($areas as $area)

                    @if ($area->idarea==$comingresos->idarea)
                    <option value="{{$area->idarea}}" selected> {{$area->idarea }}  :  {{$area->nombrearea }}</option>
                    @else
                    <option value="{{$area->idarea}}">CODIGO: {{$area->idarea }} //NOMBRE: {{$area->nombrearea }}</option>
                    @endif

                    @endforeach
                </select>  
            </div>

            <div class="col-md-2">
                <label for="numcompra" class="d-inline font-verdana-bg">
                    <b>N° compra</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text"  name="numcompra" value="{{$comingresos->numcompra}}" 
                class="form-control form-control-sm font-verdana-bg" id="numcompra" onkeypress="return valideNumber(event);">
           
                <label for="numsolicitud" class="d-inline font-verdana-bg">
                    <b>N° solicitud</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text"  name="numsolicitud" value="{{$comingresos->numsolicitud}}" 
                class="form-control form-control-sm font-verdana-bg" id="numsolicitud" onkeypress="return valideNumber(event);">
          
            </div>
            <div class="col-md-4">
                <label for="detalle" class="d-inline font-verdana-bg">
                    <b>detalle</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea  name="detalle" cols="1" rows="4" 
                class="form-control form-control-sm font-verdana-bg" 
                id="detallecomingreso"  onkeyup="convertirAMayusculas(this)">{{$comingresos->detallecomingreso}}</textarea>
            </div>

    
            <div class="col-md-2">
                <label for="numpreventivo" class="d-inline font-verdana-bg">
                    <b>N° preventivo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="numpreventivo" value="{{$comingresos->numpreventivo}}" 
                class="form-control form-control-sm font-verdana-bg" id="numpreventivo" onkeypress="return valideNumber(event);">
                <label for="factura" class="d-inline font-verdana-bg">
                    <b>N° factura</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="number"  name="factura" value="{{$comingresos->numfactura}}" 
                class="form-control form-control-sm font-verdana-bg" id="numfactura" onkeypress="return valideNumber(event);">
            </div>

            <div class="col-md-6" >
                <label for="iddirigidoa" class="d-inline font-verdana-bg">
                    <b>Dirigido A:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select  name="iddirigidoa" id="iddirigidoa" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($encargadodos as $area)
                    @if ($area->idenc==$comingresos->iddirigidoa)
                    <option value="{{$area->idenc}}" selected> {{$area->idenc }}  :  {{$area->abrev }} {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }}  :  {{$area->cargo }}  :  {{$area->nombrearea }}  </option>
                    @else
                    <option  value="{{$area->idenc}}"> CODIGO: {{$area->idenc }} //NOMBRES: {{$area->abrev }} {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //CARGO: {{$area->cargo }} //AREA: {{$area->nombrearea }} </option>
                    @endif
                    @endforeach
                </select>
            </div>
          
            <div class="col-md-6" >
                <label for="idviaa" class="d-inline font-verdana-bg">
                    <b>Via:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idviaa" id="idviaa" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($encargado as $area)
                    @if ($area->idenc==$comingresos->idviaa)
                    <option  value="{{$area->idenc}}" selected> {{$area->idenc }}  :  {{$area->abrev }} {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }}  :  {{$area->cargo }}  :  {{$area->nombrearea }} </option>
                    @else
                    <option  value="{{$area->idenc}}">CODIGO: {{$area->idenc }} //NOMBRES: {{$area->abrev }} {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //CARGO: {{$area->cargo }} //AREA: {{$area->nombrearea }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
         
            <div class="col-md-6" >
                <label for="iddepartede" class="d-inline font-verdana-bg">
                    <b>De:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="iddepartede" id="iddepartede" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($departede as $area)
                    @if ($area->idemp==$comingresos->iddepartede)
                    <option value="{{$area->idemp}}" selected>  {{$area->idemp }}  :  {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }}  :  {{$area->cargo }}  :  {{$area->nombrecargo }}  :  {{$area->nombrearea }}  </option>
                    @else
                    <option  value="{{$area->idemp}}">CODIGO: {{$area->idemp }} //NOMBRES: {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //CARGO: {{$area->cargo }} //CARGO: {{$area->nombrecargo }} //AREA: {{$area->nombrearea }} </option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="idprograma" class="d-inline font-verdana-bg">
                    <b>Ubicacion fisica</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select  name="idprograma" id="idprograma" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($programas as $local)

                                @if ($local->idprogramacomb==$comingresos->idprogramacomb)
                                <option value="{{$local->idprogramacomb}}" selected> {{$local->idprogramacomb}}  :  {{$local->nombreprograma}}  :  {{$local->direccion}}
                                </option>
                                @else
                                <option value="{{$local->idprogramacomb}}">CODIGO: {{$local->idprogramacomb}} //NOMBRE: {{$local->nombreprograma}} //DIRECCION: {{$local->direccion}}</option>
                                @endif

                                @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="fechaingreso" class="d-inline font-verdana-bg">
                    <b> Fecha</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input   type="text" name="fechaingreso" id="fechaingreso" placeholder="dd/mm/aaaa" data-language="es"
                class="form-control" value="{{date('d/m/Y', strtotime($comingresos->fechaingreso))}}">
            </div>

            <div class="col-md-6">
                <label for="idcategoria" class="d-inline font-verdana-bg">
                    <b>Proyecto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select  name="idcategoria" id="idcategoria" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($catprogramaticas as $local)

                                @if ($local->idcatprogramaticacomb==$comingresos->idcatprogramaticacomb)
                                <option value="{{$local->idcatprogramaticacomb}}" selected> {{$local->idcatprogramaticacomb}}  :   {{$local->codcatprogramatica}}  :  {{$local->nombrecatprogramatica }}
                                </option>
                                @else
                                <option value="{{$local->idcatprogramaticacomb}}"> ID: {{$local->idcatprogramaticacomb}} //CODIGO: {{$local->codcatprogramatica}} //NOMBRE: {{$local->nombrecatprogramatica }}</option>
                                @endif

                                @endforeach
                </select>
            </div>
      
            <div class="col-md-6">
                <label for="idproveedor" class="d-inline font-verdana-bg">
                    <b>proveedor</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select  name="idproveedor" id="idproveedor" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($proveedores as $local)

                                @if ($local->idproveedor==$comingresos->idproveedor)
                                <option value="{{$local->idproveedor}}" selected>  {{$local->idproveedor}}  :  {{$local->nombreproveedor}}  :  {{$local->representanteproveedor}}  :  {{$local->direccionproveedor}}  :  {{$local->telefonoproveedor}}
                                </option>
                                @else
                                <option value="{{$local->idproveedor}}">CODIGO: {{$local->idproveedor}} //NOMBRE: {{$local->nombreproveedor}} //DUEÑO: {{$local->representanteproveedor}} //DIRECCION: {{$local->direccionproveedor}} //TELEFONO: {{$local->telefonoproveedor}}</option>
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
            window.location.href = "{{url('comingreso/index')}}";
        }

        function validar_formulario(){
            if($("#objeto").val() == ""){   
                message_alert("El campo <b>[Objeto]</b> es un dato obligatorio...");
                return false;
            }
            if($("#numcompra").val() == ""){   
                message_alert("El campo <b>[N° Compra]</b> es un dato obligatorio...");
                return false;
            }
            if($("#numsolicitud").val() == ""){   
                message_alert("El campo <b>[N° SOlicitud]</b> es un dato obligatorio...");
                return false;
            }
            if($("#detalle").val() == ""){   
                message_alert("El campo <b>[Detalle]</b> es un dato obligatorio...");
                return false;
            }
            if($("#numpreventivo").val() == ""){   
                message_alert("El campo <b>[N° Preventivo]</b> es un dato obligatorio...");
                return false;
            }
            if($("#numfactura").val() == ""){   
                message_alert("El campo <b>[N° Factura]</b> es un dato obligatorio...");
                return false;
            }
       
            if($("#idarea >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Area]</b> es un dato obligatorio...");
                return false;
            }

            if($("#iddirigidoa >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Dirigido A]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idviaa >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Via]</b> es un dato obligatorio...");
                return false;
            }
            if($("#iddepartede >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Departe De:]</b> es un dato obligatorio...");
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
            if($("#idprograma >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Ubicación Fisica]</b> es un dato obligatorio...");
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
            if(code>=48 && code<=57){
                return true;
            }else{
                return false;
            }
        }
        $("#fechaingreso").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true
            });

    </script>
@endsection