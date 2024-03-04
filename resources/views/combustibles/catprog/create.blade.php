@extends('layouts.admin')

@section('content')
@include('layouts.message_alert')

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
                <b>CREAR REGISTRO</b>
            </div>

            <div class="col-md-12">
                <hr color="red">
            </div>

        </div>

        
        <div class="body-border">
            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('catprogcomb.store') }}" id="form">
                    @csrf

                    <div class="form-group row">
                        <label for="codigo" class="required col-md-4  col-form-label text-md-right" required
                            style="color:black;font-weight: bold;">Codigo:</label>

                        <div class="col-md-6">
                            <input type="text" required name="codigo" id="codigo" class="form-control"
                                placeholder="Escriba el Codigo..."
                                onkeypress="return valideNumber(event);">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nombre" class="required col-md-4 col-form-label text-md-right"
                            style="color:black;font-weight: bold;">Nombre:</label>

                        <div class="col-md-6">
                            <input type="text" required name="nombre" id="nombre" class="form-control"
                                placeholder="Escriba el Nombre..."
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