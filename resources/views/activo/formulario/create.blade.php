@extends('layouts.dashboard')

@section('content')
<div class="row ">
    <div class="col-md-12">
        <div class="row font-verdana-sm">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('Activo/formulario/index') }}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>
            <div class="col-md-8 text-right titulo">
                <b>REGISTRO NUEVO FORMULARIO FISICO</b>
            </div>

            <div class="col-md-12">
                <hr color="red">
                <b>ENTIDAD:</b> {{ $entidad->entidad }}-{{ $entidad->desc_ent }}<span></span>
            </div>

        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="body-border ">
            <form method="POST" action="{{ route('activo.formulario.store') }}">
                @csrf
                <div class="form-group row font-verdana-sm">
                    <div class="col-md-4 form-group">
                        <label class="font-label">FECHA:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"></span>
                            </div>
                            <input type="date" name="fecha" class="form-control"
                            value="{{ old('fecha') }}">
                        </div>
                        @error('fecha')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="font-label">CI:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"></span>
                            </div>
                            <input type="text" name="ci" id="ci" class="form-control"
                            value="{{ old('ci') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm" onclick="buscarPorCi()"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>

                            @error('empleado_id')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <input type="hidden" name="empleado_id" id="empleado_id" value="{{ old('empleado_id') }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="col-md-4">
                            <label class="font-label">Responsable:</label>
                            <div class="mr-4" id="nombres"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="font-label">Cargo:</label>
                            <div id="cargo"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="font-label">Oficina:</label>
                            <div id="oficina"></div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn color-icon-2 font-verdana-bg" type="submit">
                            <i class="fa-solid fa-paper-plane"></i>
                            &nbsp;REGISTRAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
    <script>
    function buscarPorCi(){
        var ci = $('#ci').val();
        event.preventDefault();
        $.ajax({
            url: '/Activo/formulario/getCi',
            method: 'GET',
            data: {
                ci: ci
            },
            success: function(res) {
                if (res.response && res.response.ci) {
                    $('#nombres').text(res.response.nombres + ' ' + res.response.ap_pat + ' ' + res
                    .response.ap_mat);
                    $('#empleado_id').val(res.response.idemp);
                    $('#cargo').text(res.response.file.nombrecargo);
                    $('#oficina').text(res.response.empleadosareas.nombrearea);
                } else {
                    $('#nombres').text("No se ha encontrado ese ci");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    </script>
    @endsection
