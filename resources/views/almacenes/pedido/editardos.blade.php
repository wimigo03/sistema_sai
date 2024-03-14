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
        <b>FORMULARIO DE SOLICITUD VALIDADO</b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">

    </div>
    <div class="col-md-2 text-right titulo">
        <b>N° </b>  <b style='color:red'>{{$id3}}</b>
    
    
    </div>
</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form method="post" action="{{ route('apedido.update') }}" id="form">
        @csrf
        {{--@method('PUT')--}}
        <input type="hidden" class="form-control" name="id3" placeholder=""
        value="{{$id3}}">
        <input type="hidden" class="form-control" name="id4" placeholder=""
                            value="{{$id4}}">
        <input type="hidden" class="form-control" name="id5" placeholder=""
                            value="{{$id5}}">
        <input type="hidden" class="form-control" name="id6" placeholder=""
                            value="{{$id6}}">
        <input type="text" hidden name="idvale" value="{{$vales->idvale}}">

        <div class="form-group row">
            <div class="col-md-6" >
                <label for="idprograma" class="d-inline font-verdana-bg">
                    <b>Programa</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <select name="idprograma" id="idprograma" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>

                    @foreach ($programados as $catprogramatica)
                    @if ($catprogramatica->id==$vales->iddea)
                    <option value="{{$catprogramatica->id}}" selected>CODIGO: {{$catprogramatica->id}} //NOMBRE: {{$catprogramatica->nombre}} //DESCRIPCION: {{$catprogramatica->descripcion}}</option>
                    @else
                    <option value="{{$catprogramatica->id}}">CODIGO: {{$catprogramatica->id}} //NOMBRE: {{$catprogramatica->nombre}} //DESCRIPCION: {{$catprogramatica->descripcion}}</option>
                    @endif

                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="idarea" class="d-inline font-verdana-bg">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <select name="idarea" id="idarea" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($areados as $area)

                    @if ($area->idarea==$vales->idarea)
                    <option value="{{$area->idarea}}" selected>&nbsp;C:&nbsp;{{$area->idarea}}&nbsp;//N:&nbsp;{{$area->nombrearea}}</option>
                    @else
                    <option value="{{$area->idarea}}">&nbsp;CODIGO:&nbsp;{{$area->idarea}}&nbsp;NOMBRE:&nbsp;{{$area->nombrearea}}</option>
                    @endif

                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="fechasolicitud" class="d-inline font-verdana-bg">
                    <b> Fecha</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <input   type="text" disabled name="fechasolicitud" id="fechasolicitud" placeholder="dd/mm/aaaa" data-language="es"
                class="form-control" value="{{date('d/m/Y', strtotime($vales->fechasolicitud))}}">
            </div>

            <div class="col-md-6" >
                <label for="idcomingreso" class="d-inline font-verdana-bg">
                    <b>PROYECTO</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <select name="idcomingreso" id="idcomingreso" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>

                    @foreach ($comingresotres as $area)

                    @if ($area->idcomingreso ==$vales->idcomingreso)
                    <option value="{{$area->idcomingreso }}" selected>COD:&nbsp;&nbsp;{{$area->codcatprogramatica }}&nbsp;&nbsp;NOMB:&nbsp;&nbsp;{{$area->nombrecatprogramatica }}</option>
                    @else
                    <option value="{{$area->idcomingreso}}">COD:&nbsp;&nbsp;{{$area->codcatprogramatica }}&nbsp;&nbsp;NOMB:&nbsp;&nbsp;{{$area->nombrecatprogramatica }}</option>
                    @endif

                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="idunidadconsumo" class="d-inline font-verdana-bg">
                    <b>Unidad</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select  name="idunidadconsumo" id="idunidadconsumo" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($consumos as $area)

                    @if ($area->idunidadconsumo ==$vales->idunidad )
                    <option value="{{$area->idunidadconsumo }}" selected>COD: {{$area->codigoconsumo }}&nbsp;Nombr:{{$area->nombreuconsumo }}&nbsp;Placa:{{$area->placaconsumo }}&nbsp;klm ant:{{$area->kilometrajeinicialconsumo }}&nbsp;klm actual:{{$area->kilometrajefinalconsumo }}</option>
                    @else
                    <option value="{{$area->idunidadconsumo }}">COD: {{$area->codigoconsumo }}&nbsp;Nombr:{{$area->nombreuconsumo }}&nbsp;Placa:{{$area->placaconsumo }}&nbsp;klm ant:{{$area->kilometrajeinicialconsumo }}&nbsp;klm actual:{{$area->kilometrajefinalconsumo }}</option>
                    @endif

                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="cantidad" class="d-inline font-verdana-bg">
                    <b>klm actual</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                    <input type="text" required class="form-control" name="cantidad" id="cantidad" placeholder=""
                        value="{{$vales->kilometrajeactualconsumo}}"
                        onkeypress="return valideNumber(event);">
               
            </div>

            <div class="col-md-6" >
                <label for="idpartida" class="d-inline font-verdana-bg">
                    <b>Partida</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <select name="idpartida" id="idpartida" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>

                    @foreach ($partidados as $area)

                    @if ($area->idpartidacomb ==$vales->idpartidacomb)
                    <option value="{{$area->idpartidacomb }}" selected>COD:&nbsp;&nbsp;{{$area->codigopartida }}&nbsp;&nbsp;NOMB:&nbsp;&nbsp;{{$area->nombrepartida }}</option>
                    @else
                    <option value="{{$area->idpartidacomb}}">COD:&nbsp;&nbsp;{{$area->codigopartida }}&nbsp;&nbsp;NOMB:&nbsp;&nbsp;{{$area->nombrepartida }}</option>
                    @endif

                    @endforeach
                </select>
            </div>

            <div class="col-md-6" >
                <label for="idusuario" class="d-inline font-verdana-bg">
                    <b>Funcionario</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select name="idusuario" id="idusuario" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>

                    @foreach ($empleados as $area)

                    @if ($area->idemp ==$vales->idusuario)
                    <option value="{{$area->idemp }}" selected>COD:&nbsp;&nbsp;{{$area->idemp }}&nbsp;&nbsp;NOMB:&nbsp;&nbsp;{{$area->nombres }}&nbsp;{{$area->ap_pat }}&nbsp;{{$area->ap_mat }}&nbsp;Cargo: {{$area->nombrecargo }}&nbsp;Area: {{$area->nombrearea }}</option>
                    @else
                    <option value="{{$area->idemp}}">COD:&nbsp;&nbsp;{{$area->idemp }}&nbsp;&nbsp;NOMB:&nbsp;&nbsp;{{$area->nombres }}&nbsp;{{$area->ap_pat }}&nbsp;{{$area->ap_mat }}&nbsp;Cargo: {{$area->nombrecargo }}&nbsp;Area: {{$area->nombrearea }}</option>
                    @endif

                    @endforeach
                </select>
            </div>

            

            <div class="col-md-5">
                <label for="detalle" class="d-inline font-verdana-bg">
                    <b>Motivo</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <textarea name="detalle" cols="1" rows="3" class="form-control form-control-sm font-verdana-bg" id="detalle" onkeyup="convertirAMayusculas(this)">{{$vales->detallesouconsumo}}</textarea>
            </div>
            <div class="col-md-5">
                <label for="idlocalidad" class="d-inline font-verdana-bg">
                    <b>Localidad</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <select name="idlocalidad" id="idlocalidad" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($localidadedos as $area)

                    @if ($area->idlocalidad  ==$vales->idlocalidad  )
                    <option value="{{$area->idlocalidad  }}" selected>&nbsp;COD: {{$area->codlocalidad  }}&nbsp;NOMB: {{$area->nombrelocalidad  }}&nbsp;DISTANCIA: {{$area->distancialocalidad  }}&nbsp;DISTRITO: {{$area->distrito  }}</option>
                    @else
                    <option value="{{$area->idlocalidad  }}">&nbsp;COD: {{$area->codlocalidad  }}&nbsp;NOMB: {{$area->nombrelocalidad  }}&nbsp;DISTANCIA: {{$area->distancialocalidad  }}&nbsp;DISTRITO: {{$area->distrito  }}</option>
                    @endif

                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="preventivo" class="d-inline font-verdana-bg">
                    <b>N° Preventivo</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                    <input type="text" required class="form-control" name="preventivo" id="preventivo" placeholder=""
                        value="{{$vales->numpreventivo}}" onkeypress="return valideNumber(event);">
               
            </div>

        </div>
        <div class="form-group row">
            <div class="col-md-12 text-right">
              
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
            if($("#fechasolicitud").val() == ""){   
                message_alert("El campo <b>[Fecha]</b> es un dato obligatorio...");
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
           
            if($("#idprograma >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Programa]</b> es un dato obligatorio...");
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
        $("#fechasolicitud").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });
    </script>
@endsection