@extends('layouts.admin')

@section('content')
    <style>
        .invalid-feedback {
            font-size: 13px;
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
                        <a href="{{ url('Activo/gestionactivo/index') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                </div>

                <div class="col-md-8 text-right titulo">
                    <b>REGISTRAR NUEVO ACTIVO</b>
                </div>

                <div class="col-md-12">
                    <hr color="red">
                    <b>ENTIDAD:</b> {{ $entidad->entidad }}-{{ $entidad->desc_ent }}<span></span>
                </div>

            </div>

            <div class="body-border ">
                <form method="POST" action="{{ route('activo.gestionactivo.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row font-verdana-sm">
                        <div class="col-md-4">
                            <label style="color:black;font-weight: bold;">UNIDAD:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <input type="hidden" name="unidad" value="{{ $unidad->unidad }}" readonly="true"
                                        class="form-control">
                                    <input type="hidden" name="idunidadadmin" value="{{ $unidad->idunidadadmin }}"
                                        readonly="true" class="form-control">

                                    <input type="hidden" name="entidad" value="{{ $entidad->entidad }}" readonly="true"
                                        class="form-control">
                                    <input type="hidden" name="identidades" value="{{ $entidad->identidades }}"
                                        readonly="true" class="form-control">

                                    <span class="input-group-text">{{ $unidad->unidad }}</span>
                                </div>
                                <input type="text" name="sigla" readonly="true" class="form-control"
                                    value="{{ $unidad->descrip }}">
                            </div>
                            <label style="color:black;font-weight: bold;">CODIGO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> </span>
                                </div>
                                <input type="text" required name="codigo" id="codigoAuxiliar" class="form-control"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="color:black;font-weight: bold;">VIDA UTIL :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AÑOS </span>
                                </div>
                                <input type="text" name="vidautil" id="vida" readonly class="form-control"
                                    value="" required>
                            </div>
                            <label style="color:black;font-weight: bold;">FECHA INCORPORACIÓN :</label>
                            <div class="input-group">
                                <input type="date" required name="feul" id="feul" readonly class="form-control"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="color:black;font-weight: bold;">ORGANISMO FINANCIERO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <select name="org_fin" id="organismofin" class="form-control">
                                    <option value=""> Seleccione un organismo financiero </option>
                                    @foreach ($organismofins as $organismofin)
                                        <option value="{{ $organismofin->idorganismofin }}"
                                            {{ old('org_fin') == $organismofin->idorganismofin ? 'selected' : '' }}>
                                            <h1 color:blue;>{{ $organismofin->des }}</h1>
                                        </option>
                                    @endforeach
                                </select>
                                @error('org_fin')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label style="color:black;font-weight: bold;">AMBIENTE:</label>
                            <select class="form-control" id="ambiente" name="ambiente_id">
                                @foreach ($ambientes as $ambiente)
                                    <option value="{{ $ambiente->id }}">{{ $ambiente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-7 mb-3">
                            <label for="observ" style="color:black;font-weight: bold;">DESCRIPCIÓN :</label>
                            <textarea type="text" name="descrip" class="form-control" rows="1" placeholder="Descripción..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">{{ old('descrip') }}</textarea>
                            @error('descrip')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label style="color:black;font-weight: bold;">GRUPO CONTABLE:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <select name="codcont" id="codcont" class="form-control">
                                    <option value="">Seleccione Grupo Contable</option>
                                    @foreach ($codcont as $item)
                                        <option value="{{ $item->codcont }}"
                                            {{ old('codcont') == $item->codcont ? 'selected' : '' }}>
                                            {{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('codcont')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label style="color:black;font-weight: bold;">AUXILIAR:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> </span>
                                </div>
                                <select name="codaux" id="codaux" class="form-control">
                                    <option value=""> Seleccione Auxiliar </option>
                                </select>
                            </div>
                            @error('codaux')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <label style="color:black;font-weight: bold;">ESTADO ACTIVO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> </span>
                                </div>
                                <select name="codestado" id="codestado" class="form-control">
                                    <option value="">Seleccione Estado</option>
                                    <option value="1" {{ old('codestado') == '1' ? 'selected' : '' }}>BUENO</option>
                                    <option value="2" {{ old('codestado') == '2' ? 'selected' : '' }}>REGULAR
                                    </option>
                                    <option value="3" {{ old('codestado') == '3' ? 'selected' : '' }}>MALO</option>
                                </select>
                            </div>
                            @error('codestado')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <label for="observaciones" style="color:black;font-weight: bold;">OBSERVACIONES :</label>
                            <div class="input-group">
                                <textarea type="text" name="observaciones" class="form-control" rows="1" placeholder="observacion..."
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">{{ old('observaciones') }}</textarea>
                            </div>
                            @error('observaciones')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                            <label for="cod_rube" style="color:black;font-weight: bold;">ID PREVENTIVO :</label>
                            <div class="input-group">
                                <input type="text" name="cod_rube" value="{{ old('cod_rube') }}" class="form-control" placeholder="Preventivo">
                            </div>
                            @error('cod_rube')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-5 mb-3">
                            <label style="color:black;font-weight: bold;">OFICINA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <select name="codarea" id="area" class="form-control">
                                    <option value="">Seleccione Oficina</option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->idarea }}"
                                            {{ old('codarea') == $area->idarea ? 'selected' : '' }}>
                                            {{ $area->nombrearea }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('codarea')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label style="color:black;font-weight: bold;">RESPONSABLE:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <select name="codemp" id="empleado" class="form-control">
                                    <option value=""> Seleccione Responsable</option>
                                </select>
                            </div>
                            @error('codemp')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label style="color:black;font-weight: bold;">CARGO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <select name="idcargo" id="cargo" class="form-control">

                                </select>
                            </div>
                            @error('idcargo')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label style="color:black;font-weight: bold;">C.I.:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input type="text" id="ci" value="" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label style="color:black;font-weight: bold;">FOTOGRAFIA:</label>
                                <div class="d-flex justify-content-between">
                                    <div class="file-input">
                                        <input type="file" name="imagenes[]" multiple id="gallery-input"
                                            class="file-input__input" accept="image/*" />
                                        <label class="file-input__label" for="gallery-input">
                                            <i class="fa fa-image mr-3 fa-lg"></i>
                                            <span>Galeria</span>
                                        </label>
                                        <span id="gallery-filename" class="file-name d-block"></span>
                                    </div>
                                    <div class="file-input">
                                        <input type="file" name="fotografia" id="camera-input"
                                            class="file-input__input" accept="image/*" />
                                        <label class="file-input__label" for="camera-input">
                                            <i class="fa fa-camera mr-3 fa-lg"></i>
                                            <span>Cámara</span>
                                        </label>
                                        <span id="camera-filename" class="file-name d-block"></span>
                                    </div>
                                </div>
                                @error('imagenes')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('fotografia')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label style="color:black;font-weight: bold;">UBICACION:</label>
                                <div class="input-group">
                                    <div id="mapa" style="height: 120px; width: 100%;"></div>
                                </div>
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" id="latitude" name="latitude">
                                <input type="hidden" id="longitude" name="longitude">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label style="color:black;font-weight: bold;">COSTO INICIAL:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Bs </span>
                                        </div>
                                        <input type="text" name="costo" id="costoInicial" class="form-control"
                                            value="{{ old('costo') }}">
                                    </div>
                                    @error('costo')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label style="color:black;font-weight: bold;">FACTOR. ACTUAL:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"></span>
                                        </div>
                                        <input type="text" readonly name="depacu" id="factorActual"
                                            class="form-control" value="00" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">VIDA:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">AÑOS</span>
                                        </div>
                                        <input type="text" readonly id="vidaForm" class="form-control"
                                            value="" required>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">DEPRE ACUM INICIAL:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">BS</span>
                                        </div>
                                        <input type="text" id="depre_acumulada_inicial" readonly class="form-control"
                                            value="00.00" required>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">% DEPRECIA:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <input type="text" readonly id="porcentaje_depreciacion" class="form-control"
                                            value="0" required>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">DEPRE GESTION:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">BS</span>
                                        </div>
                                        <input type="text" id="depre_gestion" readonly class="form-control"
                                            value="00.00" required>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">DEP. ACUMULADA:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Bs </span>
                                        </div>
                                        <input type="text" readonly name="depacu" id="depreAcumulada"
                                            class="form-control" value="00" required>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">VALOR NETO:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Bs </span>
                                        </div>
                                        <input type="text" readonly name="depacu" id="valorActual"
                                            class="form-control" value="00" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label style="color:black;font-weight: bold;">CALCULADO A :</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">DÍA </span>
                                        </div>
                                        <input type="text" name="dia" class="form-control"
                                            value="{{ date('d') }}" required>
                                        <input type="text" name="mes" class="form-control"
                                            value="{{ date('m') }}" required>
                                        <input type="text" name="año" class="form-control"
                                            value="{{ date('Y') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">UFV:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Bs </span>
                                        </div>
                                        <input type="text" readonly class="form-control" value="2.35998" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn color-icon-2 font-verdana-bg" type="submit">
                            <i class="fa-solid fa-paper-plane"></i>
                            &nbsp;REGISTRAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@section('styles')
    <style>
        .select2-search__field:focus {
            outline: none;
            border: none;
        }
    </style>
@endsection
@section('scripts')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD73WmrwkgvJi5CLHprURygkrcTJerWGIk&callback=initMap" async
        defer></script>
    </script>
    <script>
        $(document).ready(function() {
            $('#ambiente').select2({
                tags: true,
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                }
            });
            $('#organismofin').select2({
                tags: true,
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                }
            });
            $('#area').select2({
                tags: true,
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                }
            });
            $('#codcont').select2({
                tags: true,
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                }
            });
        });
        $(document).ready(function() {
            // $(window).on('beforeunload', function() {
            //     sessionStorage.clear();
            // });

            let errors = {{ count($errors) }}
            var auxiliares;
            var auxiliar_selected;
            var codigoAuxiliar;

            var responsables;
            var responsable_selected;
            var cargo;
            if (errors > 0) {
                var años = sessionStorage.getItem('años');
                var auxiliares = JSON.parse(sessionStorage.getItem('auxiliares'));
                var auxiliar_selected = sessionStorage.getItem('auxiliar_selected');
                var codigoAuxiliar = sessionStorage.getItem('codigoAuxiliar');
                var empleados = JSON.parse(sessionStorage.getItem('empleados'));
                var empleado_selected = sessionStorage.getItem('empleado_selected');
                var cargo_selected = JSON.parse(sessionStorage.getItem('cargo_selected'));
                $('#codigoAuxiliar').val(codigoAuxiliar)
                $('#vida').val(años);
                var $codauxselect = $('#codaux');

                $codauxselect.empty();
                $codauxselect.append('<option value="">Seleccione Auxiliar</option>'); // Opción inicial

                $.each(auxiliares, function(index, auxiliar) {
                    var selected = (auxiliar.codaux == auxiliar_selected) ? 'selected' : '';
                    $codauxselect.append('<option value="' + auxiliar.codaux + '" ' + selected + '>' +
                        auxiliar.nomaux + '</option>');
                });
                var $empleadosSelect = $('#empleado');
                $empleadosSelect.empty();
                $empleadosSelect.append(
                    '<option value="">Elige un responsable</option>');

                $.each(empleados, function(index, empleado) {
                    var selected = (empleado.idemp == empleado_selected) ? 'selected' : '';
                    $empleadosSelect.append('<option value="' + empleado.idemp + '" ' + selected + '>' +
                        empleado.nombres +
                        (empleado.ap_pat ? " " + empleado.ap_pat : "") +
                        (empleado.ap_mat ? " " + empleado.ap_mat : "") +
                        '</option>');
                });
                var $cargoSelect = $('#cargo');
                $cargoSelect.empty();
                $cargoSelect.append('<option value="' + cargo_selected.idfile +
                    '">' + cargo_selected.nombrecargo + '</option>');
            }

            $('#codcont').change(function() {
                var codigo = $(this).val();
                $.ajax({
                    url: '/gestionactivo/getAuxiliar',
                    type: 'GET',
                    data: {
                        codigo: codigo
                    },
                    success: function(data) {
                        $('#codigoAuxiliar').val('')
                        auxiliares = data.auxiliars;
                        var años = data.vidaUtil;

                        var $codauxselect = $('#codaux');
                        var porcentaje_depreciacion = (1 / años) * 100
                        $('#vida').val(años);
                        $('#vidaForm').val(años);
                        $('#porcentaje_depreciacion').val(porcentaje_depreciacion.toFixed(2));

                        $codauxselect.empty();
                        $codauxselect.append(
                            '<option value="">Seleccione Auxiliar</option>'); // Opción inicial

                        $.each(auxiliares, function(index, auxiliar) {
                            $codauxselect.append('<option value="' + auxiliar
                                .codaux + '">' + auxiliar.nomaux + '</option>');
                        });

                        sessionStorage.setItem('auxiliares', JSON.stringify(auxiliares));
                        sessionStorage.setItem('años', JSON.stringify(años));
                    }
                });
            });
            $('#codaux').change(function() {
                var codigoGrupo = $("#codcont").val();
                var codigoAux = $(this).val();
                $.ajax({
                    url: '/gestionactivo/getLastAuxiliar',
                    type: 'GET',
                    data: {
                        codigoGrupo: codigoGrupo,
                        codigoAux: codigoAux,
                    },
                    success: function(data) {
                        if (data.lastActual) {
                            var codigo_grupo = data.lastActual.codcont
                            var codigo_aux = data.lastActual.codaux
                            var codigo_correlativo = data.lastActual.codigo
                            var ultimosCincoDigitos = codigo_correlativo.slice(-5);
                            var ultimosCincoDigitosNumero = parseInt(ultimosCincoDigitos, 10);
                            ultimosCincoDigitosNumero += 1;
                            var resultadoFormateado = ultimosCincoDigitosNumero.toString()
                                .padStart(5, '0');
                        } else {
                            var codigo_grupo = codigoGrupo.toString().padStart(2, '0')
                            var codigo_aux = codigoAux.toString().padStart(4, '0')

                            ultimosCincoDigitosNumero = 1;
                            var resultadoFormateado = ultimosCincoDigitosNumero.toString()
                                .padStart(5, '0');
                        }
                        var unidad = "{{ $unidad->unidad }}";
                        codigoAuxiliar = unidad + codigo_grupo.toString().padStart(2, '0') +
                            codigo_aux.toString().padStart(4, '0') + resultadoFormateado;
                        $('#codigoAuxiliar').val(codigoAuxiliar)

                        sessionStorage.setItem('codigoAuxiliar', codigoAuxiliar);
                        sessionStorage.setItem('auxiliar_selected', codigoAux);
                        auxiliar_selected = codigoAux
                    }

                });
            });
            $('#area').change(function() {
                var areaId = $(this).val();
                $('#cargo').val('');
                $.ajax({
                    url: '/gestionactivo/getResponsables',
                    type: 'GET',
                    data: {
                        area_id: areaId,
                        emp_id: null
                    },
                    success: function(data) {
                        var empleados = data.empleados;
                        var $empleadosSelect = $('#empleado');
                        $empleadosSelect.empty();
                        $empleadosSelect.append(
                            '<option value="">Elige un responsable</option>'); // Opción inicial

                        $.each(empleados, function(index, empleado) {
                            $empleadosSelect.append('<option value="' + empleado.idemp +
                                '">' +
                                empleado.nombres +
                                (empleado.ap_pat ? " " + empleado.ap_pat : "") +
                                (empleado.ap_mat ? " " + empleado.ap_mat : "") +
                                '</option>');
                        });
                        sessionStorage.setItem('empleados', JSON.stringify(empleados));
                    }
                });
            });
            $('#empleado').change(function() {
                var empId = $(this).val();
                $.ajax({
                    url: '/gestionactivo/getCargo',
                    type: 'GET',
                    data: {
                        emp_id: empId
                    },
                    success: function(data) {
                        var cargo = data.files;
                        var $cargoSelect = $('#cargo');
                        $cargoSelect.empty();
                        $('#ci').val(data.empleado.ci);

                        $.each(cargo, function(index, cargo) {
                            $cargoSelect.append('<option value="' + cargo.idfile +
                                '">' + cargo.nombrecargo + '</option>');
                            sessionStorage.setItem('cargo_selected', JSON.stringify(
                                cargo));
                        });
                        sessionStorage.setItem('empleado_selected', empId);
                    }
                });
            });

            $('#costoInicial').on('input', function() {
                $('#valorActual').val($('#costoInicial').val());
            });

        });
        $('#gallery-input').on('change', function() {
            const numFiles = this.files.length;
            $('#gallery-filename').text(numFiles > 0 ? `${numFiles} archivo(s) seleccionado(s)` :
                'Ningún archivo seleccionado');
        });

        $('#camera-input').on('change', function() {
            const numFiles = this.files.length;
            $('#camera-filename').text(numFiles > 0 ? `${numFiles} archivo(s) seleccionado(s)` :
                'Ningún archivo seleccionado');
        });

        function initMap() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitud = position.coords.latitude;
                    var longitud = position.coords.longitude;

                    $("#latitude").val(latitud);
                    $("#longitude").val(longitud);

                    var ubicacion = {
                        lat: latitud,
                        lng: longitud
                    };
                    var opcionesMapa = {
                        center: ubicacion,
                        zoom: 17
                    };

                    mapa = new google.maps.Map(document.getElementById("mapa"), opcionesMapa);
                    var marker = new google.maps.Marker({
                        position: ubicacion,
                        map: mapa
                    })
                });
            } else {
                alert("La geolocalización no está disponible en este navegador.");
            }
        }
    </script>
@endsection
@endsection
