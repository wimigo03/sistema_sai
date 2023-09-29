@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="row font-verdana-bg">
                <div class="col-md-4 titulo">
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('/correspondencia2/indexRemitente') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                </div>

                <div class="col-md-8 text-right titulo">
                    <b>CREAR REMITENTE</b>
                </div>

                <div class="col-md-12">
                    <hr color="red">
                </div>

            </div>


            <div class="body-border">
                <font size="2" face="Courier New">
                    <form method="POST" action="{{ route('guardar2.remitente') }}" id="form">
                        @csrf

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Nombres:</label>

                            <div class="col-md-6">
                                <input type="text" required name="nombres" id="nombres" class="form-control"
                                    placeholder="Nombres..." onchange="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right"
                                onchange="javascript:this.value=this.value.toUpperCase();">Apellidos:</label>

                            <div class="col-md-6">
                                <input type="text" required name="apellidos" id="apellidos" class="form-control"
                                    placeholder="Apellidos..." onchange="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Ci:</label>

                            <div class="col-md-2">
                                <input type="text" required name="ci" id="ci" class="form-control"
                                    placeholder="Ci...">
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="required  col-md-4 col-form-label text-md-right"
                                style="color:black;font-weight: bold;">{{ __('Unidad/Area') }}</label>
                            <div class="col-md-8">
                                <select name="lugar" id="lugar" class="col-md-10 form-control select3">
                                    @foreach ($unidades as $unidad)
                                        <option value="{{ $unidad->id_unidad }}">{{ $unidad->nombre_unidad }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <br>

                        <div align='center'>
                            <a href="{{ route('crear2.lugar') }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar area-unidad">
                                <button class="btn btn-sm btn-warning font-verdana" type="button">
                                    &nbsp;<i class="fa fa-lg fa-address-book" aria-hidden="true"></i>&nbsp;
                                </button>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;

                            <button class="btn btn-danger font-verdana-bg" type="button" id="cancelar">
                                Cancelar
                            </button>

                            &nbsp;&nbsp;&nbsp;&nbsp;

                            <button class="btn color-icon-2 font-verdana-bg" type="button" id="insertar_item_material">
                                <i class="fa-solid fa-paper-plane"></i>
                                Guardar
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
            $('.select3').select2({
                placeholder: "--Seleccionar--"
            });
        });

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
            window.location.href = "{{ url('correspondencia2/indexRemitente') }}";

        });

        function validar_detalle_material() {



            if ($("#nombres").val() == "") {
                alert('---EL CAMPO NOMBRES ES OBLIGATORIO---');
                return false;
            }

            if ($("#apellidos").val() == "") {
                alert('---EL CAMPO APELLIDOS NO PUEDE ESTAR VACIO---');
                return false;
            }



            return true;
        };
    </script>
@endsection
