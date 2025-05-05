@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="row font-verdana-12">
                <div class="col-md-4 titulo">
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('/correspondencia/index') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                </div>

                <div class="col-md-8 text-right titulo">
                    <b>REGISTRAR RECEPCION</b>
                </div>

                <div class="col-md-12">
                    <hr color="red">
                </div>

            </div>


            <div class="body-border">
                <font size="2" face="Courier New">
                    <form method="POST" action="{{ route('correspondencia.guardar.recepcion') }}" id="form">
                        @csrf

                        <div class="form-group row">
                            <label for="fecha" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Fecha Recepcion:</label>

                            <div class="col-md-3">

                                <input type="text" name="fecha" placeholder="dd/mm/aaaa"
                                    class="form-control form-control-sm font-verdana-12" id="fecha" data-language="es"
                                    autocomplete="off">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="required  col-md-4 col-form-label text-md-right"
                                style="color:black;font-weight: bold;">{{ __('Remintente') }}</label>
                            <div class="col-md-8">
                                <select name="emp" id="emp" class="col-md-10 form-control select2">
                                    @foreach ($empleados as $empleado)
                                        <option value="{{ $empleado->id_emp }}">
                                            {{ $empleado->nombres}}
                                            {{ $empleado->ap_pat}}
                                            {{ $empleado->ap_mat}}
                                            {{ $empleado->nombre_unidad}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Asunto:</label>

                            <div class="col-md-6">
                                <textarea type="text" name="asunto" class="form-control" placeholder="Asunto..." required id="referencia"
                                onchange="javascript:this.value=this.value.toUpperCase();" cols="50" rows="2"></textarea>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Codigo:</label>

                            <div class="col-md-2">
                                <input type="text" required name="codigo" class="form-control" placeholder="Codigo..."
                                onchange="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">N° Oficio    :</label>

                            <div class="col-md-2">
                                <input type="text" required name="oficio" class="form-control"
                                    placeholder="NOficio..."
                                    onchange="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="required  col-md-4 col-form-label text-md-right"
                                style="color:black;font-weight: bold;">{{ __('Tipo Correspondencia') }}</label>
                            <div class="col-md-8">
                                <select name="tipo" id="tipo" class="col-md-10 form-control select2">
                                    @foreach ($tipos as $tipo)
                                        <option value="{{$tipo->id_tipo_corresp}}">
                                            {{ $tipo->nombre_tipo}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>




                        <br>

                        <div align='center'>
                            <a href="{{ route('correspondencia.crear.remitente') }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar Remitente">
                                <button class="btn btn-sm btn-success font-verdana" type="button">
                                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                                </button>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-danger font-verdana-12" type="button" id="cancelar">
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


            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();

        });

        $("#cancelar    ").click(function() {

            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ url('correspondencia/index') }}";

        });

        $("#fecha").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });
    </script>
@endsection
