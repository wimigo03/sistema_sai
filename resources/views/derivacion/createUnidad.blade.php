@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row font-verdana-12">
                <div class="col-md-4 titulo">
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('/correspondencia2/indexUnidad') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                </div>
                <div class="col-md-8 text-right titulo">
                    <b>CREAR AREA-UNIDAD</b>
                </div>
                <div class="col-md-12">
                    <hr color="red">
                </div>
            </div>


            <div class="body-border">
                <font size="2" face="Courier New">

                    <form method="POST" action="{{ route('correspondencia.local.lugar.guardar') }}" id="form">
                        @csrf

                        <div class="form-group row">
                            <label for="role_id" style="color:black;font-weight: bold;"
                                class="required col-md-2 col-form-label text-md-right">{{ __('Area-Unidad:') }}</label>

                            <div class="col-md-9">
                                <input type="text" name="nombre" required class="form-control " id="unidad"
                                    placeholder="Escriba el Area-Unidad-Comunidad.."
                                    onchange="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <br>

                        <div align='center'>
                            <button class="btn btn-danger font-verdana-12" type="button" id="cancelar">
                                Cancelar
                            </button>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn color-icon-2 font-verdana-12" type="button" id="insertar_item_material">
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

        $("#cancelar").click(function() {

            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ url('correspondencia2/indexUnidad') }}";

        });

        function validar_detalle_material() {



            if ($("#unidad").val() == "") {
                alert('---EL CAMPO UNIDAD-COMUNIDAD ES OBLIGATORIO--');
                return false;
            }




            return true;
        };
    </script>
@endsection
