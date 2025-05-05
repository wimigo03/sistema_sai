@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row font-verdana-12">
                <div class="col-md-4 titulo">

                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ route('correspondencia.local.gestionar', $recepcion->id_recepcion) }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>

                </div>

                <div class="col-md-8 text-right titulo">
                    <b>EDITAR CORRESPONDENCIA</b>
                </div>

                <div class="col-md-12">
                    <hr color="red">
                </div>
            </div>


            <div class="body-border">
                <font size="2" face="Courier New">
                    <form method="POST" action="{{ route('correspondencia.local.update', $recepcion->id_recepcion) }}"
                        enctype="multipart/form-data">
                        @csrf


                        <div class="form-group row">
                            <label for="fecha" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Fecha Recepcion:</label>

                            <div class="col-md-3">

                                <input type="text" name="fecha" placeholder="dd/mm/aaaa"
                                    class="form-control form-control-sm font-verdana-12" id="fecha" data-language="es"
                                     value="{{ $fecha_d_m_y }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="required  col-md-4 col-form-label text-md-right"
                                style="color:black;font-weight: bold;">{{ __('Remintente') }}</label>
                            <div class="col-md-8">
                                <select name="emp" id="emp" class="col-md-10 form-control select2">

                                    @foreach ($remitentes as $remitente)
                                        @if ($recepcion->id_remitente == $remitente->id_remitente)
                                            <option value="{{ $remitente->id_remitente }}" selected>
                                                {{ $remitente->nombres_remitente }}
                                                {{ $remitente->apellidos_remitente }}
                                                --
                                                {{ $remitente->nombre_unidad }}
                                            </option>
                                        @else
                                            <option value="{{ $remitente->id_remitente }}">
                                                {{ $remitente->nombres_remitente }}
                                                {{ $remitente->apellidos_remitente }}
                                                --
                                                {{ $remitente->nombre_unidad }}
                                            </option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Asunto:</label>

                            <div class="col-md-6">
                                <textarea type="text" name="asunto" class="form-control" placeholder="Asunto..." required id="asunto"
                                onchange="javascript:this.value=this.value.toUpperCase();" cols="50" rows="2">{{ $recepcion->asunto }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Codigo:</label>

                            <div class="col-md-2">
                                <input type="text" name="codigo" class="form-control" required
                                    value="{{ $recepcion->n_oficio }}">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Hoja de ruta:</label>

                            <div class="col-md-2">
                                <input type="text" name="hojaruta" class="form-control" required
                                    value="{{ $recepcion->observaciones }}">
                            </div>
                        </div>






                        <div align='center'>

                            <button class="btn color-icon-2 font-verdana-12" type="submit">
                                <i class="fa-solid fa-paper-plane"></i>

                                &nbsp;
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
        $("#fecha").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });
    </script>
@endsection
