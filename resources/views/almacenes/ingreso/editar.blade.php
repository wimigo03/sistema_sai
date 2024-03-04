@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<br>
<div class="row font-verdana-12">
    <div class="col-md-4 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/transportes/uconsumo/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-8 text-right titulo">
        <b>EDITAR FORMULARIO </b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>
<div class="body-border" style="background-color: #FFFFFF;">

    <form method="post" action="{{ route('transportes.uconsumo.update') }}" id="form">
        @csrf
        {{--@method('PUT')--}}
        <input type="text" hidden name="idunidadconsumo" 
        value="{{$consumos->idunidadconsumo}}">
       
        <div class="form-group row">
            <div class="col-md-6">
                <label for="codigoc" class="d-inline font-verdana-12">
                    <b>codigoc</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="codigoc" cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-12" id="codigoc">
                {{$consumos->codigoconsumo}}</textarea>
            </div>


            <div class="col-md-6">
                <label for="desconsumo" class="d-inline font-verdana-12">
                    <b>desconsumoc</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="desconsumo" cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-12" id="desconsumo" 
                >{{$consumos->desconsumo}}</textarea>
            </div>


            <div class="col-md-2">
                <label for="modeloc" class="d-inline font-verdana-12">
                    <b>modeloc</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="modeloc" value="{{$consumos->modeloconsumo}}" 
                class="form-control form-control-sm font-verdana-12" id="modeloc">
            </div>

            <div class="col-md-2">
                <label for="colorc" class="d-inline font-verdana-12">
                    <b>colorc</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="colorc" value="{{$consumos->colorconsumo}}" 
                class="form-control form-control-sm font-verdana-12" id="colorc">
            </div>

            <div class="col-md-2">
                <label for="marcac" class="d-inline font-verdana-12">
                    <b>Nro. marcac</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="marcac" value="{{$consumos->marcaconsumo}}" 
                class="form-control form-control-sm font-verdana-12" id="marcac" >
            </div>

            <div class="col-md-2">
                <label for="klminicialc" class="d-inline font-verdana-12">
                    <b>Control Interno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="klminicialc" value="{{$consumos->kilometrajeinicialconsumo}}"
                 class="form-control form-control-sm font-verdana-12" id="klminicialc">
            </div>


            <div class="col-md-7">
                <label for="idarea" class="d-inline font-verdana-12">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idarea" id="idarea" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($areas as $area)

                    @if ($area->idarea==$consumos->idarea)
                    <option value="{{$area->idarea}}" selected>{{$area->nombrearea}}</option>
                    @else
                    <option disabled value="{{$area->idarea}}">{{$area->nombrearea}}</option>
                    @endif

                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="idprograma" class="d-inline font-verdana-12">
                    <b>Programa</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idprograma" id="idprograma" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($programas as $programa)

                    @if ($programa->idprograma==$consumos->idprograma)
                    <option value="{{$programa->idprograma}}" 
                        selected>{{$programa->nombreprograma}}
                    </option>
                    @else
                    <option value="{{$programa->idprograma}}">{{$programa->nombreprograma}}</option>
                    @endif

                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label for="idtipomovilidad" class="d-inline font-verdana-12">
                    <b>tipo movilidad</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idtipomovilidad" id="idtipomovilidad" 
                placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($tipos as $catprogramatica)

                   
                    @if ($catprogramatica->idtipomovilidad==$consumos->idtipomovilidad)
                    <option value="{{$catprogramatica->idtipomovilidad}}" selected>
                        {{$catprogramatica->nombremovilidad}}</option>
                    @else
                    <option value="{{$catprogramatica->idtipomovilidad}}">
                        {{$catprogramatica->nombremovilidad}}</option>
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

                <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

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
            window.location.href = "{{url('compras/pedido')}}";
        }

        function validar_formulario(){
            if($("#objeto").val() == ""){   
                message_alert("El campo <b>[Objeto]</b> es un dato obligatorio...");
                return false;
            }
            if($("#justificacion").val() == ""){   
                message_alert("El campo <b>[Justificacion]</b> es un dato obligatorio...");
                return false;
            }
            if($("#preventivo").val() == ""){   
                message_alert("El campo <b>[Preventivo]</b> es un dato obligatorio...");
                return false;
            }
            if($("#tipo >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Tipo]</b> es un dato obligatorio...");
                return false;
            }
            if($("#numcompra").val() == ""){   
                message_alert("El campo <b>[Nro. Compra]</b> es un dato obligatorio...");
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
            if($("#idprograma >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Programa]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idcatprogramatica >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Cat. Programatica]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idproveedor >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Proveedor]</b> es un dato obligatorio...");
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

    /*var permission_select = new SlimSelect({
        select: '#permissions-select select',
        //showSearch: false,
        placeholder: 'Select Permissions',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    });
    var permission_select2 = new SlimSelect({
        select: '#permissions-select2 select',
        //showSearch: false,
        placeholder: 'Select Permissions',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    });
    var permission_select = new SlimSelect({
        select: '#permissions-select3 select',
        //showSearch: false,
        placeholder: 'Select Permissions',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    });
    var permission_select2 = new SlimSelect({
        select: '#permissions-select4 select',
        //showSearch: false,
        placeholder: 'Select Permissions',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    });*/
    </script>
@endsection