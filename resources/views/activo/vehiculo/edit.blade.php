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
                        <a href="{{ url('Activo/vehiculo/index') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                </div>

                <div class="col-md-8 text-right titulo">
                    <b>REGISTRAR NUEVO VEHICULO</b>
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
                <form method="POST" action="{{ route('activo.vehiculo.update', $vehiculo->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row font-verdana-sm">
                        <div class="col-md-4 form-group">
                            <label class="font-label">CODIGO VSIAF:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="codigo" id="codigo" class="form-control"
                                    value="{{ old('codigo', $vehiculo->codigo) }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" id="buscar-codigo"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                                <input type="hidden" name="actual_id" id="actual_id" value="{{ $vehiculo->actual->id }}">
                            </div>

                            @error('codigo')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <label class="font-label">DESCRIPCION:</label>
                            <p id="descripcion">{{ $vehiculo->actual->descrip }}</p>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">COSTO HISTORICO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="number" id="costo_historico" min="0" class="form-control"
                                    value="{{ old('costo_historico', $vehiculo->actual->costo) }}" readonly>
                            </div>
                            @error('costo_historico')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">DOC. EFECTO DE ASIGNACION INDIVIDUAL:</label>
                            <div class="file-input">
                                <input type="file" name="documento" id="documento" class="file-input__input"
                                    accept="application/pdf" />
                                <label class="file-input__label" for="documento">
                                    <i class="fa fa-file-pdf mr-3 fa-lg"></i>
                                    <span>Documento</span>
                                </label>
                                <span id="documento-filename" class="file-name d-block"></span>
                            </div>
                            @error('documento')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">ESTADO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" class="form-control" id="estado" name="estado" readonly>
                            </div>
                            @error('estado')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">NOMBRE DEL PROPIETARIO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="nombre_propietario" class="form-control"
                                    value="{{ old('nombre_propietario',$vehiculo->nombre_propietario) }}">
                            </div>
                            @error('nombre_propietario')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">MUNICIPIO RADICATORIA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="municipio_radicatoria" class="form-control"
                                    value="{{ old('municipio_radicatoria',$vehiculo->municipio_radicatoria) }}">
                            </div>
                            @error('municipio_radicatoria')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">CLASE VEHICULO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="clase_vehiculo" class="form-control"
                                    value="{{ old('clase_vehiculo',$vehiculo->clase_vehiculo) }}">
                            </div>
                            @error('clase_vehiculo')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">TIPO COMBUSTIBLE:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="tipo_combustible" class="form-control"
                                    value="{{ old('tipo_combustible',$vehiculo->tipo_combustible) }}">
                            </div>
                            @error('tipo_combustible')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">GNV:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <select name="gnv" class="form-control @error('gnv') is-invalid @enderror">
                                    <option value="1" {{ old('gnv',$vehiculo->gnv) == '1' ? 'selected' : '' }}>Verdadero</option>
                                    <option value="0" {{ old('gnv',$vehiculo->gnv) == '0' ? 'selected' : '' }}>Falso</option>
                                </select>
                            </div>
                            @error('gnv')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">NUMERO DE PLACA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="nro_placa" class="form-control"
                                    value="{{ old('nro_placa',$vehiculo->nro_placa) }}">
                            </div>
                            @error('nro_placa')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">TIPO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="tipo" class="form-control" value="{{ old('tipo',$vehiculo->tipo) }}">
                            </div>
                            @error('tipo')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">MARCA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="marca" class="form-control" value="{{ old('marca',$vehiculo->marca) }}">
                            </div>
                            @error('marca')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">MODELO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="modelo" class="form-control" value="{{ old('modelo',$vehiculo->modelo) }}">
                            </div>
                            @error('modelo')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">COLOR:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="color" class="form-control" value="{{ old('color',$vehiculo->color) }}">
                            </div>
                            @error('color')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">PAIS PROCEDENCIA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="pais_procedencia" class="form-control"
                                    value="{{ old('pais_procedencia',$vehiculo->pais_procedencia) }}">
                            </div>
                            @error('pais_procedencia')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">USO DEL BIEN:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="uso_bien" class="form-control"
                                    value="{{ old('uso_bien',$vehiculo->uso_bien) }}">
                            </div>
                            @error('uso_bien')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">NRO. MOTOR:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="nro_motor" class="form-control"
                                    value="{{ old('nro_motor',$vehiculo->nro_motor) }}">
                            </div>
                            @error('nro_motor')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">NRO. CHASIS:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="nro_chasis" class="form-control"
                                    value="{{ old('nro_chasis',$vehiculo->nro_chasis) }}">
                            </div>
                            @error('nro_chasis')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">CILINDRADA Cc:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="number" min="0" name="cilindrada" class="form-control"
                                    value="{{ old('cilindrada',$vehiculo->cilindrada) }}">
                            </div>
                            @error('cilindrada')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">TRACCION:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="traccion" class="form-control"
                                    value="{{ old('traccion',$vehiculo->traccion) }}">
                            </div>
                            @error('traccion')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">NRO. PLAZAS:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="number" min="0" name="nro_plazas" class="form-control"
                                    value="{{ old('nro_plazas',$vehiculo->nro_plazas) }}">
                            </div>
                            @error('nro_plazas')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">NRO. PUERTAS:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="number" min="0" name="nro_puertas" class="form-control"
                                    value="{{ old('nro_puertas',$vehiculo->nro_puertas) }}">
                            </div>
                            @error('nro_puertas')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">CAPACIDAD DE CARGA KL:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="number" min="0" name="capacidad_carga" class="form-control"
                                    value="{{ old('capacidad_carga',$vehiculo->capacidad_carga) }}">
                            </div>
                            @error('capacidad_carga')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">NRO. POLIZA PROCEDENCIA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="nro_poliza_procedencia" class="form-control"
                                    value="{{ old('nro_poliza_procedencia',$vehiculo->nro_poliza_procedencia) }}">
                            </div>
                            @error('nro_poliza_procedencia')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">FECHA DE POLIZA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="date" name="fecha_poliza" class="form-control"
                                    value="{{ old('fecha_poliza',$vehiculo->fecha_poliza) }}">
                            </div>
                            @error('fecha_poliza')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">ULTIMO SOAT:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="number" min="1" name="ultimo_soat" class="form-control"
                                    value="{{ old('ultimo_soat',$vehiculo->ultimo_soat) }}">
                            </div>
                            @error('ultimo_soat')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">ULTIMO I.T.V.:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="number" min="1" name="ultima_itv" class="form-control"
                                    value="{{ old('ultima_itv',$vehiculo->ultima_itv) }}">
                            </div>
                            @error('ultima_itv')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">B-SISA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="b_sisa" class="form-control" value="{{ old('b_sisa',$vehiculo->b_sisa) }}">
                            </div>
                            @error('b_sisa')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">NRO. R.U.A.T.:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="nro_ruat" class="form-control"
                                    value="{{ old('nro_ruat',$vehiculo->nro_ruat) }}">
                            </div>
                            @error('nro_ruat')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">DOC. ADJ. R.U.A.T:</label>
                            <div class="d-flex justify-content-between">
                                <div class="file-input">
                                    <input type="file" name="documento_ruat" id="documento_ruat"
                                        class="file-input__input" accept="application/pdf" />
                                    <label class="file-input__label" for="documento_ruat">
                                        <i class="fa fa-file-pdf mr-3 fa-lg"></i>
                                        <span>Documento</span>
                                    </label>
                                    <span id="documento_ruat-filename" class="file-name d-block"></span>
                                </div>
                            </div>
                            @error('documento_ruat')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">NRO. (CRPVA):</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="nro_crpva" class="form-control"
                                    value="{{ old('nro_crpva',$vehiculo->nro_crpva) }}">
                            </div>
                            @error('nro_crpva')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">NRO. POLIZA SEGURO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="nro_poliza_seguro" class="form-control"
                                    value="{{ old('nro_poliza_seguro',$vehiculo->nro_poliza_seguro) }}">
                            </div>
                            @error('nro_poliza_seguro')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">VENC. POLIZA DEL SEGURO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="date" name="vencimiento_poliza_seguro" class="form-control"
                                    value="{{ old('vencimiento_poliza_seguro',$vehiculo->vencimiento_poliza_seguro) }}">
                            </div>
                            @error('vencimiento_poliza_seguro')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">DEPARTAMENTO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="departamento" class="form-control"
                                    value="{{ old('departamento',$vehiculo->departamento) }}">
                            </div>
                            @error('departamento')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">PROVINCIA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="provincia" class="form-control"
                                    value="{{ old('provincia',$vehiculo->provincia) }}">
                            </div>
                            @error('provincia')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">MUNICIPIO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="municipio" class="form-control"
                                    value="{{ old('municipio',$vehiculo->municipio) }}">
                            </div>
                            @error('municipio')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">LOCALIDAD:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="localidad" class="form-control"
                                    value="{{ old('localidad',$vehiculo->localidad) }}">
                            </div>
                            @error('localidad')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">DISTRITO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="number" min="1" name="distrito" class="form-control"
                                    value="{{ old('distrito',$vehiculo->distrito) }}">
                            </div>
                            @error('distrito')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">CANTON:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="canton" class="form-control" value="{{ old('canton',$vehiculo->canton) }}">
                            </div>
                            @error('canton')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">COMUNIDAD:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="comunidad" class="form-control"
                                    value="{{ old('comunidad',$vehiculo->comunidad) }}">
                            </div>
                            @error('comunidad')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">ZONA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="zona" class="form-control" value="{{ old('zona',$vehiculo->zona) }}">
                            </div>
                            @error('zona')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">DIRECCION:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="direccion" class="form-control"
                                    value="{{ old('direccion',$vehiculo->direccion) }}">
                            </div>
                            @error('direccion')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">KARDEX DE OBSERVACION:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" name="kardex_aclaracion" class="form-control"
                                    value="{{ old('kardex_aclaracion',$vehiculo->kardex_aclaracion) }}">
                            </div>
                            @error('kardex_aclaracion')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">DOCUMENTOS ADJUNTOS:</label>
                            <div class="file-input">
                                <input type="file" name="documentos[]" multiple id="documentos"
                                    class="file-input__input" accept="application/pdf" />
                                <label class="file-input__label" for="documentos">
                                    <i class="fa fa-file-pdf mr-3 fa-lg"></i>
                                    <span>Documento</span>
                                </label>
                                <span id="documentos-filename" class="file-name d-block"></span>
                            </div>
                            @error('documentos')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-label">IMAGEN:</label>
                            <div class="d-flex justify-content-between">
                                <div class="file-input">
                                    <input type="file" name="imagen" id="imagen" class="file-input__input"
                                        accept="image/*" />
                                    <label class="file-input__label" for="imagen">
                                        <i class="fa fa-image mr-3 fa-lg"></i>
                                        <span>Imagen</span>
                                    </label>
                                    <span id="imagen-filename" class="file-name d-block"></span>
                                </div>
                            </div>
                            @error('imagen')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn color-icon-2 font-verdana-12" type="submit">
                            <i class="fa-solid fa-paper-plane mr-2"></i>Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#documento').on('change', function() {
            const numFiles = this.files.length;
            $('#documento-filename').text(numFiles > 0 ? `${numFiles} archivo seleccionado` :
                'Ningún archivo seleccionado');
        });

        $('#documento_ruat').on('change', function() {
            const numFiles = this.files.length;
            $('#documento_ruat-filename').text(numFiles > 0 ? `${numFiles} archivo seleccionado` :
                'Ningún archivo seleccionado');
        });

        $('#documentos').on('change', function() {
            const numFiles = this.files.length;
            $('#documentos-filename').text(numFiles > 0 ? `${numFiles} archivo(s) seleccionado(s)` :
                'Ningún archivo seleccionado');
        });

        $('#imagen').on('change', function() {
            const numFiles = this.files.length;
            $('#imagen-filename').text(numFiles > 0 ? `${numFiles} imagen seleccionada` :
                'Ningún archivo seleccionado');
        });

        $('#buscar-codigo').click(function(event) {
            var codigo = $('#codigo').val();
            event.preventDefault();
            $.ajax({
                url: '/Activo/vehiculo/getCodigo',
                method: 'GET',
                data: {
                    codigo: codigo
                },
                success: function(res) {
                    if (res.response && res.response.descrip) {
                        $('#descripcion').text(res.response.descrip);
                        $('#actual_id').val(res.response.id);
                        $('#costo_historico').val(res.response.costo);
                        switch (res.response.codestado) {
                          case 1:
                            $('#estado').val('BUENO');
                            break;
                          case 2:
                            $('#estado').val('REGULAR');
                            break;
                          case 3:
                            $('#estado').val('MALO');
                            break;
                          default:
                            $('#estado').val('');
                            break;
                        }
                    } else {
                        $('#descripcion').text("No se ha encontrado ese codigo");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
