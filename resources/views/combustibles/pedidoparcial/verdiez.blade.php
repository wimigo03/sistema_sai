@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<br>
<div class="row font-verdana-bg">
    <div class="col-md-4 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/pedidoparcialcomb/index') }}">
         
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left">atras</i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-8 text-right titulo">
        <b>FORMULARIO DE SOLICITUD </b><b style='color:red'>RECHAZADO </b>  estado 10
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
    <form method="post" action="{{ route('pedidoparcialcomb.update') }}" id="form">
        @csrf
        {{--@method('PUT')--}}
        <input type="hidden" name="controlinterno2" id="controlinterno2">

        <input type="text" hidden name="idcompracomb" value="{{$compras->idcompracomb}}">
        <input type="text" hidden name="idproveedor" id="idproveedor" value="{{$compras->idproveedor}}">
        <input type="text" hidden name="numcompra" id="numcompra" value="{{$compras->numcompra}}">
        <input type="text" hidden name="preventivo" id="preventivo" value="{{$compras->preventivo}}">
        
        <div class="form-group row">
            <div class="col-md-3">
                <label for="oficinade" class="d-inline font-verdana-bg">
                    <b>Oficina</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <textarea  name="oficinade" cols="1" rows="4" class="form-control form-control-sm font-verdana-bg" id="oficinade" onkeyup="convertirAMayusculas(this)" >{{$compras->oficinade}}</textarea>
            </div>

            <div class="col-md-2">
                <label for="objeto" class="d-inline font-verdana-bg">
                    <b>Objeto</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <textarea name="objeto" cols="1" rows="4" class="form-control form-control-sm font-verdana-bg" id="objeto" onkeyup="convertirAMayusculas(this)">{{$compras->objeto}}</textarea>
            </div>

            <div class="col-md-4">
                <label for="justificacion" class="d-inline font-verdana-bg">
                    <b>Justificacion</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <textarea name="justificacion" cols="1" rows="4" class="form-control form-control-sm font-verdana-bg" id="justificacion" onkeyup="convertirAMayusculas(this)">{{$compras->justificacion}}</textarea>
            </div>
            <div class="col-md-3">
                <label for="controlinterno" class="d-inline font-verdana-bg">
                    <b>N° Solicitud</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <input type="text"   name="controlinterno" id="controlinterno" onchange="myFunction()" value="{{$compras->controlinterno}}" class="form-control form-control-sm font-verdana-bg" id="controlinterno" onkeypress="return valideNumber(event);">
           
                <label for="tipo" class="d-inline font-verdana-bg">
                    <b>Tipo</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <input type="text"  name="tipo" value="{{$compras->tipo}}" onkeyup="convertirAMayusculas(this)"
                class="form-control form-control-sm font-verdana-bg" id="tipo">
           
            </div>
            <div class="col-md-5" >
                <label for="iddirigidoa" class="d-inline font-verdana-bg">
                    <b>Dirigido A:</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select name="iddirigidoa" id="iddirigidoa" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($encargadodos as $area)
                    @if ($area->idenc==$compras->iddirigidoa)
                    <option value="{{$area->idenc}}" selected>CODIGO: {{$area->idenc}} //NOMBRE: {{$area->abrev }} {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //AREA: {{$area->nombrearea }} //CARGO: {{$area->cargo }} </option>
                    @else
                    <option value="{{$area->idenc}}">CODIGO: {{$area->idenc}} //NOMBRE: {{$area->abrev }} {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //AREA: {{$area->nombrearea }} //CARGO: {{$area->cargo }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-5" >
                <label for="idviaa" class="d-inline font-verdana-bg">
                    <b>Via:</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select name="idviaa" id="idviaa" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($encargado as $area)
                    @if ($area->idenc==$compras->idviaa)
                    <option value="{{$area->idenc}}" selected>CODIGO: {{$area->idenc}} //NOMBRE: {{$area->abrev }} {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //AREA: {{$area->nombrearea }} //CARGO: {{$area->cargo }} </option>
                    @else
                    <option value="{{$area->idenc}}">CODIGO: {{$area->idenc}} //NOMBRE: {{$area->abrev }} {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //AREA: {{$area->nombrearea }} //CARGO: {{$area->cargo }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="fechasoli" class="d-inline font-verdana-bg">
                    <b> Fecha</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <input   type="text" name="fechasoli" id="fechasoli" placeholder="dd/mm/aaaa" data-language="es"
                class="form-control" value="{{date('d/m/Y', strtotime($compras->fechasoli))}}">
            </div>
            <div class="col-md-5" >
                <label for="iddepartede" class="d-inline font-verdana-bg">
                    <b>De:</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select name="iddepartede" id="iddepartede" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($departede as $area)
                    @if ($area->idemp==$compras->iddepartede)
                    <option value="{{$area->idemp}}" selected>CODIGO: {{$area->idemp}} //NOMBRE: {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //AREA: {{$area->nombrearea }} //CARGO: {{$area->cargo }} //CARGO: {{$area->nombrecargo }} </option>
                    @else
                    <option value="{{$area->idemp}}">CODIGO: {{$area->idemp}} //NOMBRE: {{$area->nombres }} {{$area->ap_pat }} {{$area->ap_mat }} //AREA: {{$area->nombrearea }} //CARGO: {{$area->cargo }} //CARGO: {{$area->nombrecargo }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

<div class="col-md-5">
    <label for="idarea" class="d-inline font-verdana-bg">
        <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
    </label>
    <select name="idarea" id="idarea" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
        <option value="">-</option>
        @foreach ($areas as $catprogramatica)

        @if ($catprogramatica->idarea==$compras->idarea)
        <option value="{{$catprogramatica->idarea}}" selected>CODIGO: {{$catprogramatica->idarea}} //NOMBRE: {{$catprogramatica->nombrearea}}</option>
        @else
        <option value="{{$catprogramatica->idarea}}">CODIGO: {{$catprogramatica->idarea}} //NOMBRE: {{$catprogramatica->nombrearea}}</option>
        @endif
        @endforeach
    </select>
</div>



<div class="col-md-5">
    <label for="idprograma" class="d-inline font-verdana-bg">
        <b>Ubicacion Fisica</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
    </label>
    <select name="idprograma" id="idprograma" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
        <option value="">-</option>
        @foreach ($programas as $catprogramatica)

        @if ($catprogramatica->idprogramacomb==$compras->idprogramacomb)
        <option value="{{$catprogramatica->idprogramacomb}}" selected>CODIGO: {{$catprogramatica->idprogramacomb}} //NOMBRE: {{$catprogramatica->nombreprograma}}</option>
        @else
        <option value="{{$catprogramatica->idprogramacomb}}">CODIGO: {{$catprogramatica->idprogramacomb}} //NOMBRE: {{$catprogramatica->nombreprograma}}</option>
        @endif
        @endforeach
    </select>
</div>
            <div class="col-md-5">
                <label for="idcatprogramatica" class="d-inline font-verdana-bg">
                    <b>Proyecto</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                </label>
                <select name="idcatprogramatica" id="idcatprogramatica" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($catprogramaticas as $catprogramatica)

                    @if ($catprogramatica->idcatprogramaticacomb==$compras->idcatprogramaticacomb)
                    <option value="{{$catprogramatica->idcatprogramaticacomb}}" selected> CODIGO: {{$catprogramatica->codcatprogramatica}} //NOMBRE: {{$catprogramatica->nombrecatprogramatica}}</option>
                    @else
                    <option value="{{$catprogramatica->idcatprogramaticacomb}}"> CODIGO: {{$catprogramatica->codcatprogramatica}} //NOMBRE: {{$catprogramatica->nombrecatprogramatica}}</option>
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

                    <a href="{{url()->previous()}}" style="color:white">Cancelar</a>
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
            window.location.href = "{{url('combustibles/pedidoparcial/index')}}";
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

            if($("#controlinterno").val() == ""){
                message_alert("El campo <b>[Control Interno]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#controlinterno2").val() == "comunicacion") {
                $("#controlinterno2").val('');
                $("#controlinterno").val('');
                $("#objeto").val('');
                message_alert("El numero de <b>[Control Interno]</b> ya existe en nuestros registros...");
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

            return true;
        }

        function myFunction() {
            respuesta();
        }
        function respuesta() {
            var ot_antigua = $("#controlinterno").val();
            $.ajax({
                url: "{{ route('pedidoparcialcomb.pregunta4') }}",
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
                        $("#controlinterno2").val('comunicacion');
                    }
                }
            });
        }

        function valideNumber(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if(code>=48 && code<=57){
                return true;
            }else{
                return false;
            }
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
    </script>
@endsection
