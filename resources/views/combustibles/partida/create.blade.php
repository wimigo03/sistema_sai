@extends('layouts.admin')

@section('content')
@include('layouts.message_alert')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/partidacomb/index')}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>
            <div class="col-md-8 text-right titulo">
                <b>CREAR REGISTRO</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>

        
        <div class="body-border">
            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('partidacomb.store') }}" id="form">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="codigopartida2" id="codigopartida2">

              
                    <div class="form-group row">
                        <label for="codigopartida" style="color:black;font-weight: bold;"
                            class="required col-md-2 col-form-label text-md-right">
                            Codigo:
                        </label>
                        <div class="col-md-2">
                            <input type="text"  required name="codigopartida" id="codigopartida" class="form-control" 
                                placeholder="Codigo del Partida..."
                                onchange="myFunction()" >
                        </div>
                    </div>
                    

                    <div class="form-group row">
                        <label for="nombre" style="color:black;font-weight: bold;"
                            class="required col-md-2 col-form-label text-md-right">
                            Nombre:
                        </label>

                        <div class="col-md-8">
                            <textarea  type="text" required name="nombre" id="nombre" class="form-control"cols="50" rows="4"
                                placeholder="Nombre de la partida..."
                                onkeyup="convertirAMayusculas(this)"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="direccion" style="color:black;font-weight: bold;"
                            class="required col-md-2 col-form-label text-md-right">
                            Detalle:
                        </label>

                        <div class="col-md-8">
                            <textarea type="text" required name="direccion" id="direccion" class="form-control"cols="50" rows="4"
                                placeholder="Detalle..."
                                onkeyup="convertirAMayusculas(this)"></textarea>
                        </div>
                    </div>


                    </br>

                    <div align='center'>
                               
                      
            <div class="col-md-12 text-right">
                <button class="btn color-icon-2 font-verdana-bg" type="button" onclick="save();">
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
            </font>




        </div>
       
    </div>
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
            window.location.href = "{{url('combustibles/partida/index')}}";
        }

        function validar_formulario(){

            if($("#nombre").val() == ""){
                message_alert("El campo <b>[NOMBRE]</b> es un dato obligatorio...");
                return false;

            }
            if($("#codigopartida").val() == ""){
                message_alert("El campo <b>[CODIGO]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#codigopartida2").val() == "comunicacion") {
                $("#codigopartida2").val('');
                $("#nombre").val('');
                $("#codigopartida").val('');
                message_alert("El <b>[CODIGO ]</b> ya existe en nuestros registros...");
                return false;
            }
            if($("#direccion").val() == ""){
                message_alert("El campo <b>[DETALLE]</b> es un dato obligatorio...");
                return false;

            }
            return true;
        }
   
        function myFunction() {
            respuesta();
        }
        function respuesta() {
            var ot_antigua = $("#codigopartida").val();
            $.ajax({
                url: "{{ route('partidacomb.pregunta11') }}",
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
                        $("#codigopartida2").val('comunicacion');
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