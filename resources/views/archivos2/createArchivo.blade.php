@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row font-verdana-bg">
                <div class="col-md-4 titulo">

                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('/archivos2/index') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>

                </div>

                <div class="col-md-8 text-right titulo">
                    <b>CARGAR ARCHIVO</b>
                </div>

                <div class="col-md-12">
                    <hr color="red">
                </div>
            </div>


            <div class="body-border">
                <font size="2" face="Courier New">
                    <form method="POST" action="{{ route('archivos2.insertar') }}" enctype="multipart/form-data"
                        id="form">
                        @csrf






                        <div class="form-group row">
                            <label class="required  col-md-4 col-form-label text-md-right"
                                style="color:black;font-weight: bold;">Tipo Documento:</label>
                            <div class="col-md-8">
                                <select name="tipodocumento" required id="permissions2"
                                    class="col-md-6 form-control select2">
                                    <option value=""></option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->idtipo }}">{{ $tipo->nombretipo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Fecha Recepcion/Envio:</label>

                            <div class="col-md-3">

                                <input type="text" name="fecha" placeholder="dd/mm/aaaa"
                                    class="form-control form-control-sm font-verdana-bg" id="fecha" data-language="es"
                                    autocomplete="off">
                            </div>
                        </div>





                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">N°:</label>

                            <div class="col-md-2">
                                <input type="text" id="nombredocumento" name="nombredocumento" class="form-control"
                                    placeholder="N°. doc..." required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Referencia:</label>

                            <div class="col-md-6">
                                <textarea type="text" name="referencia" class="form-control" placeholder="Ref. doc..." required id="referencia"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" cols="50" rows="2"></textarea>
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="documento" style="color:black;font-weight: bold;"
                                class=" required col-md-4 col-form-label text-md-right"><b style="color: red">El tamaño del
                                    archivo no debe superar los 10 mb. Archivos(solo.pdf):</b></label>

                            <div class="col-md-6">
                                <input type="file" required name="documento" id="file">
                            </div>
                        </div>


                        <div align='center'>


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

            $('.select2').select2({
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
            window.location.href = "{{url('archivos2/index')}}";

        });



        function validar_detalle_material() {

            if ($("#permissions2 >option:selected").val() == "") {
                alert('---SELECCIONA EL TIPO DE DOCUMENTO---');
                return false;
            }

            if ($("#fecha").val() == "") {
                alert('---EL CAMPO FECHA ES OBLIGATORIO---');
                return false;
            }

            if ($("#nombredocumento").val() == "") {
                alert('---EL CAMPO N° DE DOCUMENTO NO PUEDE ESTAR VACIO---');
                return false;
            }

            if ($("#referencia").val() == "") {
                alert('---EL CAMPO REFERENCIA NO PUEDE ESTAR VACIO---');
                return false;
            }

            if ($("#file").val() == "") {
                alert('---SE DEBE CARGAR OBLIGATORIAMENTE UN ARCHIVO---');
                return false;
            }





            return true;
        };

        $("#fecha").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });
    </script>
@endsection
