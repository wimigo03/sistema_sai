@extends('layouts.dashboard')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/combustibles/catprog/index') }}">
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

                    <div class="form-group row">
                        <label for="codigo" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Codigo:</label>
                        <div class="col-md-6">
                            <input type="text" required class="form-control" name="codigo" id="codigo" placeholder=""
                                value="{{$catprogs->codcatprogramatica}}"
                                onkeypress="return valideNumber(event);">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nombre" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Nombre:</label>
                        <div class="col-md-6">
                            <input type="text" required class="form-control" name="nombre" id="nombre" placeholder=""
                                value="{{$catprogs->nombrecatprogramatica}}"
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>
                  

                    <div align='center'>
                               
                        <div class="col-md-12 text-right">
                            <button class="btn color-icon-2 font-verdana-12" type="button" onclick="save();">
                                <i class="fa-solid fa-paper-plane"></i>
                                &nbsp;Registrar
                            </button>
                            <button class="btn btn-danger font-verdana-12" type="button" >
            
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


            if($("#codigo").val() == ""){
                message_alert("El campo <b>[CODIGO]</b> es un dato obligatorio...");
                return false;
            }
            if($("#nombre").val() == ""){
                message_alert("El campo <b>[NOMBRE]</b> es un dato obligatorio...");
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
    </script>
@endsection