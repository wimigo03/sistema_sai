
@extends('layouts.admin')

@section('content')
@include('layouts.message_alert')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/medidacomb/index') }}">
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
                <form method="POST" action="{{ route('medidacomb.store') }}" id="form">
                    @csrf
                    @method('POST')
                 

                 
                    <div class="form-group row">
                        <label for="name" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                        <div class="col-md-7">
                            <input id="nombremedida"  required type="text" require name="nombremedida" placeholder="Nombre..."
                            class="form-control"  cols="50" rows="2" onkeyup="convertirAMayusculas(this)">
                        </div>
                    </div>
                  
                 

                   

                    

                   
            <div align='center'>
                               
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
            window.location.href = "{{url('combustibles/medida/index')}}";
        }

        function validar_formulario(){

            if($("#nombremedida").val() == ""){
                message_alert("El campo <b>[Nombre]</b> es un dato obligatorio...");
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
 
</script>
@endsection