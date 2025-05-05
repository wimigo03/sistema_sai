@extends('layouts.dashboard')

@section('content')
    <style>
        .invalid-feedback {
            font-size: 13px;
        }

        .font-label {
            color: black;
            font-weight: bold;
        }

        .file-input__input {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .file-input__label {
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            font-size: 14px;
            padding: 10px 12px;
            background-color: #4245a8;
            box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.25);
        }

        .file-input__label svg {
            height: 16px;
            margin-right: 4px;
        }
    </style>
    <div class="row ">
        <div class="col-md-12">
            <div class="row font-verdana-sm">
                <div class="col-md-4 titulo">
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('Activo/adeudo/index') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                </div>
                <div class="col-md-8 text-right titulo">
                    <b>REGISTRO NUEVO NO ADEUDO</b>
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
                <form method="POST" action="{{ route('activo.adeudo.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row font-verdana-sm">
                        <div class="col-md-4 form-group">
                            <label class="font-label">CI:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="ci" id="ci" class="form-control"
                                    value="{{ old('ci') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" id="buscar-ci"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>

                            @error('ci')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="font-label">Responsable:</label>
                            <div class="mr-4" id="nombres"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="font-label">Cargo:</label>
                            <div id="cargo"></div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">FECHA DE INICIO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="date" name="fecha_inicio" class="form-control"
                                    value="{{ old('fecha_inicio') }}">
                            </div>
                            @error('fecha_inicio')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">FECHA DE FINALIZACION:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="date" name="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}">
                            </div>
                            @error('fecha_fin')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">NRO. CONTRATO O AGRADECIMIENTO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="number" name="nro_contrato" class="form-control"
                                    value="{{ old('nro_contrato') }}">
                            </div>
                            @error('nro_contrato')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">CANT. ACTIVOS:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="number" min="0" id="cantidad_activos" readonly name="cantidad_activos"
                                    class="form-control" value="{{ old('cantidad_activos') }}">
                            </div>
                            @error('cantidad_activos')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">Motivo Retiro:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <select name="motivo_retiro" class="form-control">
                                    @php
                                        $oldEstado = old('motivo_retiro');
                                    @endphp
                                    @foreach (['CONCLUSION DE CONTRATO', 'MEMORANDUM DE AGRADECIMIENTO', 'SOLICITUD PARTICULAR'] as $option)
                                        <option value="{{ $option }}"
                                            @if ($oldEstado == $option) selected @endif>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('motivo_retiro')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">RESPALDO ADJUNTO:</label>
                            <div class="file-input">
                                <input type="file" name="respaldo" id="respaldo" class="file-input__input"
                                    accept="application/pdf" />
                                <label class="file-input__label" for="respaldo">
                                    <i class="fa fa-file-pdf mr-3 fa-lg"></i>
                                    <span>Respaldo</span>
                                </label>
                                <span id="respaldo-filename" class="file-name d-block"></span>
                            </div>
                            @error('respaldo')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="empleado_id" value="{{ old('empleado_id') }}" id="empleado_id">
                    <div class="text-center">
                        <button class="btn color-icon-2 font-verdana-12" type="submit">
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
        $('#respaldo').on('change', function() {
            const numFiles = this.files.length;
            $('#respaldo-filename').text(numFiles > 0 ? `${numFiles} archivo seleccionado` :
                'Ningún archivo seleccionado');
        });

        $('#buscar-ci').click(function(event) {
            var ci = $('#ci').val();
            event.preventDefault();
            $.ajax({
                url: '/Activo/adeudo/getCi',
                method: 'GET',
                data: {
                    ci: ci
                },
                success: function(res) {
                    console.log(res.response);
                    if (res.response && res.response.ci) {
                        $('#nombres').text(res.response.nombres + ' ' + res.response.ap_pat + ' ' + res
                            .response.ap_mat);
                        $('#empleado_id').val(res.response.idemp);
                        $('#cargo').text(res.response.file.nombrecargo);
                        $('#cantidad_activos').val(res.response.actuals_count);
                    } else {
                        $('#nombres').text("No se ha encontrado ese ci");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
