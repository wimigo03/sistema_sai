@extends('layouts.admin')
@section('content')
    @include('layouts.message_alert')
    @if (Session::has('message'))
        <div class="alert alert-success">
            <em> {!! session('message') !!}</em>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="row font-verdana-bg">
                <div class="col-md-4 titulo">
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('/correspondencia2/index') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                </div>
                <div class="col-md-8 text-right titulo">
                    <b>GESTIONAR CORRESPONDENCIA</b>
                </div>
                <div class="col-md-12">
                    <hr color="red">
                </div>

                <div class="col-md-12 text-right">

                    <a href="{{ route('correspondencia2.notificacion') }}">
                        <button class="btn btn-sm btn-light   font-verdana" type="button">
                            &nbsp;<i class="fa fa-lg fa-file-pdf" style="color: green "
                                aria-hidden="true"></i>&nbsp;Agreg.Digital
                        </button>
                    </a>

                    @if ($data->estado_corresp == 0)
                        <a href="{{ route('correspondencia2.cargarpdf', $data->id_recepcion) }}">
                            <button class="btn btn-sm btn-light   font-verdana" type="button">
                                &nbsp;<i class="fa fa-lg fa-file-pdf" style="color: green "
                                    aria-hidden="true"></i>&nbsp;Agreg.Digital
                            </button>
                        </a>
                    @elseif ($data->estado_corresp == 1)
                        <a href="{{ route('correspondencia2.urlfile', $data->id_recepcion) }}" target="blank_">
                            <button class="btn btn-sm btn-light   font-verdana" type="button">
                                &nbsp;<i class="fa fa-lg fa-eye" style="color: blue " aria-hidden="true"></i>&nbsp;Ver
                                Archivo
                            </button>
                        </a>

                        <a href="{{ route('correspondencia2.actualizarpdf', $data->id_recepcion) }}">
                            <button class="btn btn-sm btn-light   font-verdana" type="button">
                                &nbsp;<i class="fa fa-lg fa-file" style="color: orange" aria-hidden="true"></i>&nbsp;Cambiar
                                Digital
                            </button>

                        </a>
                    @endif

                    <a href="{{ route('correspondencia2.edit', $data->id_recepcion) }}">
                        <button class="btn btn-sm btn-light   font-verdana" type="button">
                            &nbsp;<i class="fa fa-lg fa-pencil" style="color: brown "
                                aria-hidden="true"></i>&nbsp;Edit.Corresp.
                        </button>
                    </a>

                    @if ($data->estado_corresp == 0)
                        <b style="color: red">--SIN DIGITAL--</b>
                    @elseif ($data->estado_corresp == 1)
                        <a href="{{ route('correspondencia2.derivar', $data->id_recepcion) }}">
                            <button class="btn btn-sm btn-light   font-verdana" type="button">
                                &nbsp;<i class="fa fa-lg fa-random" style="color: green "
                                    aria-hidden="true"></i>&nbsp;Deriv.Corresp
                            </button>
                        </a>
                    @endif




                </div>
            </div>
            <p id="demo"></p>

            <div class="body-border">
                <font size="2" face="Courier New">

                    <div class="form-group row">
                        <label for="detalle" style="color:red;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">FECHA RECEPCION:</label>
                        <div class="col-md-3">
                            <input id="detalle" required type="text" name="detalle" class="form-control" readonly
                                value="{{ $data->fecha_recepcion }}"></input>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="detalle" style="color:red;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">ASUNTO:</label>
                        <div class="col-md-7">
                            <textarea id="detalle" required type="text" name="detalle" cols="50" rows="2" class="form-control"
                                readonly>{{ $data->asunto }}</textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="detalle" style="color:red;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">REMITENTE:</label>
                        <div class="col-md-7">
                            <input id="detalle" required type="text" name="detalle" cols="50" rows="1"
                                class="form-control"
                                value="{{ $data->nombres_remitente }} {{ $data->apellidos_remitente }}" readonly></input>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="detalle" style="color:red;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">AREA-UNIDAD:</label>
                        <div class="col-md-7">
                            <textarea id="detalle" required type="text" name="detalle" cols="50" rows="2" class="form-control"
                                readonly>{{ $data->nombre_unidad }}</textarea>
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="detalle" style="color:red;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">CODIGO:</label>
                        <div class="col-md-2">
                            <input id="detalle" required type="text" name="detalle" class="form-control" readonly
                                value="{{ $data->n_oficio }}"></input>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="detalle" style="color:red;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">HOJA DE RUTA:</label>
                        <div class="col-md-2">
                            <input id="detalle" required type="text" name="detalle" class="form-control" readonly
                                value="{{ $data->observaciones }}"></input>
                        </div>
                    </div>





                </font>


            </div>

        </div>
    </div>
@endsection
@section('scripts')

@endsection
