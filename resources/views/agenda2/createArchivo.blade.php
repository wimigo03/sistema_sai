@extends('layouts.dashboard')

@section('content')
@include('layouts.message_alert')
@if(Session::has('message'))
    <div class="alert alert-success">
        <em> {!! session('message') !!}</em>
    </div>
@endif
<br>
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row font-verdana-12">
                <div class="col-md-4 titulo">

                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('/agenda/index') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>

                </div>

                <div class="col-md-8 text-right titulo">
                    <b>CARGAR AGENDA</b>
                </div>

                <div class="col-md-12">
                    <hr color="red">
                </div>
            </div>


            <div class="body-border">
                <font size="2" face="Courier New">
                    <form method="POST" action="{{ route('agenda.insertar') }}" enctype="multipart/form-data"
                        id="form">
                        @csrf

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Dia:</label>

                            <div class="col-md-3">

                                <input type="text" name="fecha" placeholder="dd/mm/aaaa"
                                    class="form-control form-control-sm font-verdana-12" id="fecha" data-language="es"
                                    autocomplete="off">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Hora Inicio:</label>
                            <div class="col-md-2">
                                <input type="time" name="horaini"  class="form-control form-control-sm font-verdana-12" id="horaini" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Hora Final:</label>
                            <div class="col-md-2">
                                <input type="time" name="horafin"  class="form-control form-control-sm font-verdana-12" id="horafin">
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Evento:</label>

                            <div class="col-md-7">
                                <textarea type="text" name="evento" class="form-control" placeholder="Evento..." required id="evento"
                                onchange="javascript:this.value=this.value.toUpperCase();" cols="50" rows="3"></textarea>
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Detalles:</label>

                            <div class="col-md-7">
                                <textarea type="text" name="descripcion" class="form-control" placeholder="Detalles..." required id="descripcion"
                                onchange="javascript:this.value=this.value.toUpperCase();" cols="50" rows="5"></textarea>
                            </div>
                        </div>


                        <div align='center'>


                            <button class="btn btn-success font-verdana-12" type="button" id="cancelar">
                                Cancelar
                            </button>

                            &nbsp;&nbsp;&nbsp;&nbsp;

                            <button class="btn color-icon-2 font-verdana-12" type="button" id="insertar_item_material">
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


        $("#cancelar").click(function() {

            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ url('agenda/index') }}";

        });



        function validar_detalle_material() {



            if ($("#fecha").val() == "") {
                alert('---EL CAMPO FECHA ES OBLIGATORIO---');
                return false;
            }
            if ($("#horaini").val() == "") {
                alert('---EL CAMPO HORA INICIO ES OBLIGATORIO---');
                return false;
            }
            if ($("#horafin").val() == "") {
                alert('---EL CAMPO HORA FIN ES OBLIGATORIO---');
                return false;
            }



            if ($("#evento").val() == "") {
                alert('---EL CAMPO EVENTO NO PUEDE ESTAR VACIO---');
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
