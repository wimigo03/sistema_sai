@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<br>
<div class="row font-verdana-bg">
    <div class="col-md-4 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/pedidocomb/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left">atras</i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-8 text-right titulo">
        <b>FORMULARIO DE SOLICITUD </b> <b style='color:red'>RECHAZADO</b> estado 10
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
    <div class="col-md-2 text-right titulo">
        <b>N° Compra:</b>  <b style='color:red'>{{$idco}}</b>
    </div> 
    <div class="col-md-5 text-right titulo">
        <b>Fecha Solicitud:</b>  <b style='color:red'>{{$Fechayhora}}</b>
    </div> 
    <div class="col-md-5 text-right titulo">
        <b>Fecha Respuesta:</b>  <b style='color:red'>{{$Fechayhorados}}</b>
    </div> 
</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form method="post" action="{{ route('pedidocomb.update') }}" id="form">
        @csrf
        {{--@method('PUT')--}}
        <input type="hidden" name="preventivo2" id="preventivo2">
        <input type="hidden" name="numcompra2" id="numcompra2">
        
        <input type="text" hidden name="idcompracomb" value="{{$compras->idcompracomb}}">

        <div class="form-group row">
            <div class="col-md-4">
                <label for="oficinade" class="d-inline font-verdana-bg">
                    <b>Oficina</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <input type="text"  name="oficinade" onkeyup="convertirAMayusculas(this)" value="{{$compras->oficinade}}" class="form-control form-control-sm font-verdana-bg" id="oficinade">
                <label for="objeto" class="d-inline font-verdana-bg">
                    <b>Objeto</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <input  name="objeto" cols="1" rows="3" class="form-control form-control-sm font-verdana-bg" id="objeto" onkeyup="convertirAMayusculas(this)" value="{{$compras->objeto}}">
               
            </div>

            <div class="col-md-2">
                <label for="controlinterno" class="d-inline font-verdana-bg">
                    <b>N° Solicitud</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <input type="text"  name="controlinterno" value="{{$compras->controlinterno}}" class="form-control form-control-sm font-verdana-bg" id="controlinterno" onkeypress="return valideNumber(event);">
            
                <label for="tipo" class="d-inline font-verdana-bg">
                    <b>Tipo</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <input type="text"  name="tipo" value="{{$compras->tipo}}" class="form-control form-control-sm font-verdana-bg" id="tipo" onkeypress="return valideNumber(event);">
            
            
            </div>
         
            <div class="col-md-4">
                <label for="justificacion" class="d-inline font-verdana-bg">
                    <b>Justificacion</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <textarea  name="justificacion" cols="1" rows="4" class="form-control form-control-sm font-verdana-bg" id="justificacion" onkeyup="convertirAMayusculas(this)" >{{$compras->justificacion}}</textarea>
            </div>
            <div class="col-md-2">
                <label for="preventivo" class="d-inline font-verdana-bg">
                    <b>Preventivo</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <input type="text"  name="preventivo" id="preventivo" onchange="myFunction()" value="{{$compras->preventivo}}" class="form-control form-control-sm font-verdana-bg" id="preventivo" onkeypress="return valideNumber(event);">
            
                <label for="numcompra" class="d-inline font-verdana-bg">
                    <b>N° Compra</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <input type="text" name="numcompra" id="numcompra" onchange="myFunctiondos()" value="{{$compras->numcompra}}" class="form-control form-control-sm font-verdana-bg" id="numcompra" onkeypress="return valideNumber(event);">
           

            </div>
            <div class="col-md-6" >
                <label for="iddirigidoa" class="d-inline font-verdana-bg">
                    <b>Dirigido A:</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select  name="iddirigidoa" id="iddirigidoa" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($encargadodos as $area)
                    @if ($area->idenc==$compras->iddirigidoa)
                    <option value="{{$area->idenc}}" selected>{{$area->abrev }} {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }}  //CARGO: {{$area->cargo }} //AREA: {{$area->nombrearea }}  </option>
                    @else
                    <option disabled value="{{$area->idenc}}">         {{$area->abrev }} {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //CARGO: {{$area->cargo }} //AREA: {{$area->nombrearea }} </option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-6" >
                <label for="idviaa" class="d-inline font-verdana-bg">
                    <b>Via:</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select name="idviaa" id="idviaa" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($encargado as $area)
                    @if ($area->idenc==$compras->idviaa)
                    <option  value="{{$area->idenc}}" selected>{{$area->abrev }} {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //CARGO: {{$area->cargo }} //AREA: {{$area->nombrearea }} </option>
                    @else
                    <option disabled value="{{$area->idenc}}">{{$area->abrev }} {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //CARGO: {{$area->cargo }} //AREA: {{$area->nombrearea }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
         
            <div class="col-md-6" >
                <label for="iddepartede" class="d-inline font-verdana-bg">
                    <b>De:</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select name="iddepartede" id="iddepartede" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($departede as $area)
                    @if ($area->idemp==$compras->iddepartede)
                    <option value="{{$area->idemp}}" selected>{{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //CARGO: {{$area->cargo }} //CARGO: {{$area->nombrecargo }} //AREA: {{$area->nombrearea }}  </option>
                    @else
                    <option disabled value="{{$area->idemp}}">{{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }}//CARGO: {{$area->cargo }} //CARGO: {{$area->nombrecargo }} //AREA: {{$area->nombrearea }} </option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label for="idarea" class="d-inline font-verdana-bg">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select    name="idarea" id="idarea" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($areas as $area)
                    @if ($area->idarea==$compras->idarea)
                    <option  value="{{$area->idarea}}" selected>{{$area->nombrearea}}</option>
                    @else
                    <option  value="{{$area->idarea}}">{{$area->nombrearea}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="idprograma" class="d-inline font-verdana-bg">
                    <b>Ubicacion Fisica</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select   name="idprograma" id="idprograma" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($programas as $catprogramatica)

                    @if ($catprogramatica->id==$compras->iddea)
                    <option value="{{$catprogramatica->id}}" selected>CODIGO: {{$catprogramatica->id}} //NOMBRE: {{$catprogramatica->nombre}} //DESCRIPCION: {{$catprogramatica->descripcion}}</option>
                    @else
                    <option value="{{$catprogramatica->id}}">CODIGO: {{$catprogramatica->id}} //NOMBRE: {{$catprogramatica->nombre}} //DESCRIPCION: {{$catprogramatica->descripcion}}</option>
                    @endif

                                @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="idcatprogramatica" class="d-inline font-verdana-bg">
                    <b>Proyecto</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select name="idcatprogramatica" id="idcatprogramatica" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($catprogramaticas as $catprogramatica)

                   
                    @if ($catprogramatica->idcatprogramaticacomb==$compras->idcatprogramaticacomb)
                    <option value="{{$catprogramatica->idcatprogramaticacomb}}" selected>COD: {{$catprogramatica->codcatprogramatica}} //NOMB: {{$catprogramatica->nombrecatprogramatica}}</option>
                    @else
                    <option disabled value="{{$catprogramatica->idcatprogramaticacomb}}">COD: {{$catprogramatica->codcatprogramatica}} //NOMB:  {{$catprogramatica->nombrecatprogramatica}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="idproveedor" class="d-inline font-verdana-bg">
                    <b>Proveedor</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select name="idproveedor" id="idproveedor" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($proveedordos as $proveedor)

                   
                    @if ($proveedor->idproveedor==$compras->idproveedor)
                    <option value="{{$proveedor->idproveedor}}" selected>COD: {{$proveedor->idproveedor}} //NOMB: {{$proveedor->nombreproveedor}} //DUEÑO: {{$proveedor->representanteproveedor}} //Dir: {{$proveedor->direccionproveedor}} //Tel: {{$proveedor->telefonoproveedor}}
                    </option>
                    @else
                    <option value="{{$proveedor->idproveedor}}">CODIGO: {{$proveedor->idproveedor}} //NOMBRE: {{$proveedor->nombreproveedor}} //DUEÑO: {{$proveedor->representanteproveedor}} //DIRECCION: {{$proveedor->direccionproveedor}} //TELEFONO: {{$proveedor->telefonoproveedor}}</option>
                    @endif

                    @endforeach
                </select>
            </div>
        </div>
        {{-- <div class="form-group row">
            <div class="col-md-12 text-right">
                <button class="btn color-icon-2 font-verdana-bg" type="button" onclick="save();">
                    <i class="fa-solid fa-paper-plane"></i>
                    &nbsp;Actualizar
                </button>
                <button class="btn btn-danger font-verdana-bg" type="button" >
                    
                    <a href="{{url('/pedidocomb/index')}}" style="color:white">Cancelar</a>
                </button>

                <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

            </div>
        </div> --}}
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
            window.location.href = "{{url('/pedidocomb/index')}}";
        }

        function validar_formulario(){
            if($("#idproveedor >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Proveedor]</b> es un dato obligatorio...");
                return false;
            }
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
            if($("#preventivo").val() <= 0){  
                $("#preventivo").val(''); 
                message_alert("El campo <b>[Preventivo]</b> es un dato incorrecto...");
                return false;
            }
                if ($("#preventivo2").val() == "preventivo") {
                $("#preventivo2").val('');
                $("#preventivo").val('');
          
                message_alert("El numero de <b>[PREVENTIVO]</b> ya existe en nuestros registros...");
                return false;
          
            }
            if($("#tipo").val() == ""){   
                message_alert("El campo de seleccion <b>[Tipo]</b> es un dato obligatorio...");
                return false;
            }
            if($("#numcompra").val() == ""){   
                message_alert("El campo <b>[Nro. Compra]</b> es un dato obligatorio...");
                return false;
            }
            if($("#numcompra").val() <= 0){ 
                $("#numcompra").val('');
                message_alert("El campo <b>[Nro. Compra]</b> es un dato incorrecto...");
                return false;
            }
            if ($("#numcompra2").val() == "numcomp") {
                $("#numcompra2").val('');
                $("#numcompra").val('');
          
                message_alert("El numero de <b>[COMPRA]</b> ya existe en nuestros registros...");
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
                message_alert("El campo de seleccion <b>[Ubicacion]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idcatprogramatica >option:selected").val() == ""){   
                message_alert("El campo de seleccion <b>[Proyecto]</b> es un dato obligatorio...");
                return false;
            }
         
            return true;
        }
        function myFunction() {
            respuesta();
        }
        function respuesta() {
            var ot_antigua = $("#preventivo").val();
            $.ajax({
                url: "{{ route('pedidocomb.pregunta5') }}",
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
                        $("#preventivo2").val('preventivo');
                    }
                }
            });
        }


        function myFunctiondos() {
            respuestados();
        }
        function respuestados() {
            var ot_antigua = $("#numcompra").val();
            $.ajax({
                url: "{{ route('pedidocomb.pregunta6') }}",
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
                        $("#numcompra2").val('numcomp');
                    }
                }
            });
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
    </script>
@endsection