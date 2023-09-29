@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row font-verdana-bg">
                <div class="col-md-4 titulo">
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('/correspondencia2/createRecepcion') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                </div>
                <div class="col-md-8 text-right titulo">
                    <b>CREAR TIPO CORRESPONDENCIA</b>
                </div>
                <div class="col-md-12">
                    <hr color="red">
                </div>
            </div>


            <div class="body-border">
                <font size="2" face="Courier New">

                    <form method="POST" action="{{ route('guardar2.tipo') }}" id="form">
                        @csrf

                        <div class="form-group row">
                            <label for="role_id" style="color:black;font-weight: bold;"
                                class="required col-md-2 col-form-label text-md-right">{{ __('Tipo:') }}</label>

                            <div class="col-md-9">
                                <input type="text" name="nombre" required class="form-control " id="tipo"
                                    placeholder="Escriba el tipo de correspondencia.."
                                    onchange="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <br>

                        <div align='center'>

                            <button class="btn color-icon-2 font-verdana-bg" type="button" id="insertar_item_material">
                                <i class="fa-solid fa-paper-plane"></i>
                                Guardar
                            </button>
                        </div>
                    </form>

                </font>




            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $("#insertar_item_material").click(function() {
            if (validar_detalle_material() == true) {

                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        });

        $("#cancelar    ").click(function() {

            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ url('correspondencia2/index') }}";

        });

        function validar_detalle_material() {



            if ($("#tipo").val() == "") {
                alert('---EL CAMPO TIPO ES OBLIGATORIO--');
                return false;
            }




            return true;
        };
    </script>
@endsection
