@extends('layouts.admin')

@section('content')
@include('layouts.message_alert')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/programa/index') }}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>
            <div class="col-md-8 text-right titulo">
                <b>MODIFICAR REGISTRO</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>

        
        <div class="body-border">
            <font size="2" face="Courier New" >
                <form method="POST" id="form" action="{{ route('programa.update', $programas->idprogramacomb) }}">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="codigoprogr2" id="codigoprogr2">
                    <div class="form-group row">
                        <label for="codigoprogr" style="color:black;font-weight: bold;"
                            class="required col-md-2 col-form-label text-md-right">CODIGO:</label>
                        <div class="col-md-2">
                            <input type="text" required class="form-control" name="codigoprogr" id="codigoprogr" placeholder=""
                                value="{{$programas->codigoprogr}}"
                                onchange="myFunction()" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nombre" style="color:black;font-weight: bold;"
                            class="required col-md-2 col-form-label text-md-right">Nombre:</label>
                        <div class="col-md-10">
                            <input type="text" required class="form-control" name="nombre" id="nombre" placeholder=""
                                value="{{$programas->nombreprograma}}"
                                onkeyup="convertirAMayusculas(this)">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="direccion" style="color:black;font-weight: bold;"
                            class="required col-md-2 col-form-label text-md-right">direccion:</label>
                        <div class="col-md-10">
                            <input type="text" required class="form-control" name="direccion" id="direccion" placeholder=""
                                value="{{$programas->direccion}}"
                                onkeyup="convertirAMayusculas(this)">
                        </div>
                    </div>


                    <div align='center'>
                               
                        <div class="col-md-12 text-right">
                            <button class="btn color-icon-2 font-verdana-bg" type="button" onclick="save();">
                                <i class="fa-solid fa-paper-plane"></i>
                                &nbsp;Actualizar
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
            window.location.href = "{{url('combustibles/programa/index')}}";
        }

        function validar_formulario(){


            if($("#nombre").val() == ""){
                message_alert("El campo <b>[NOMBRE]</b> es un dato obligatorio...");
                return false;

            }
            if($("#codigoprogr").val() == ""){
                message_alert("El campo <b>[CODIGO]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#codigoprogr2").val() == "comunicacion") {
                $("#codigoprogr2").val('');
                $("#nombre").val('');
                $("#codigoprogr").val('');
                message_alert("El <b>[CODIGO ]</b> ya existe en nuestros registros...");
                return false;
            }
            if($("#direccion").val() == ""){
                message_alert("El campo <b>[DIRECCION]</b> es un dato obligatorio...");
                return false;

            }
            return true;
        }
        function myFunction() {
            respuesta();
        }
        function respuesta() {
            var ot_antigua = $("#codigoprogr").val();
            $.ajax({
                url: "{{ route('programa.pregunta10') }}",
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
                        $("#codigoprogr2").val('comunicacion');
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