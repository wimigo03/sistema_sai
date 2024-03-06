@extends('layouts.admin')

@section('content')
@include('layouts.message_alert')
<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/catprogcomb/index') }}">
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
                <form method="POST" id="form" action="{{ route('catprogcomb.update', $catprogs->idcatprogramaticacomb) }}">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="codigo2" id="codigo2">
                    {{-- <input type="hidden" class="form-control" name="id4" placeholder="" value="{{$id4}}"> --}}
                    <input type="text" hidden name="id4" value="{{$catprogs->fechacat}}">

                    <div class="form-group row">
                        <label for="codigo" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Codigo:</label>
                        <div class="col-md-6">
                            <input type="text" required class="form-control" name="codigo" id="codigo" placeholder=""
                                value="{{$catprogs->codcatprogramatica}}"
                                onchange="myFunction()">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nombre" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Nombre:</label>
                        <div class="col-md-6">
                            <textarea type="text" required class="form-control" name="nombre" id="nombre" placeholder=""cols="51" rows="4"
                                onkeyup="convertirAMayusculas(this)">{{$catprogs->nombrecatprogramatica}}</textarea>
                        </div>
                    </div>
                  
                    <div class="form-group row">
                        <label for="estadocatprogramatica" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Estado:</label>
                        <div class="col-md-6">
                        <select name="estado" id="estadocatprogramatica" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
        
                            <option {{old('estadocatprogramatica',$catprogs->estadocatprogramatica)=="1"? 'selected':''}}  value="1">ACTIVO</option>
                            <option {{old('estadocatprogramatica',$catprogs->estadocatprogramatica)=="2"? 'selected':''}} value="2">INACTIVO</option>
        
                        </select>
                    </div>
                    </div>

                    <div class="form-group row">
                        <label for="fechasoli" class="required col-md-4 col-form-label text-md-right">
                            <b> Fecha</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <div class="col-md-4">
                        <input   type="text" name="fechasoli" id="fechasoli" placeholder="dd/mm/aaaa" data-language="es"
                        class="form-control" value="{{date('d/m/Y', strtotime($catprogs->fechacat))}}">
                    </div>
                </div>

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
            window.location.href = "{{url('combustibles/catprog/index')}}";
        }

        function validar_formulario(){


            if($("#nombre").val() == ""){
                message_alert("El campo <b>[NOMBRE]</b> es un dato obligatorio...");
                return false;
            }
            if($("#codigo").val() == ""){
                message_alert("El campo <b>[CODIGO]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#codigo2").val() == "comunicacion") {
                $("#codigo2").val('');
                $("#nombre").val('');
                $("#codigo").val('');
                message_alert("El <b>[CODIGO ]</b> ya existe en nuestros registros...");
                return false;
            }
            return true;
        }
        function myFunction() {
            respuesta();
        }
        function respuesta() {
            var ot_antigua = $("#codigo").val();
            $.ajax({
                url: "{{ route('catprogcomb.pregunta8') }}",
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
                        $("#codigo2").val('comunicacion');
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

        $("#fechasoli").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });
    </script>
@endsection