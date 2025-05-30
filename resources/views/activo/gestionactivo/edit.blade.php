@extends('layouts.dashboard')

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
                        <a href="javascript:void(0);" onclick="window.history.back()">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                </div>

                <div class="col-md-8 text-right titulo">
                    <b>ACTUALIZAR ACTIVO</b>
                </div>

                <div class="col-md-12">
                    <hr color="red">
                    <b>ENTIDAD:</b> {{ $entidad->entidad }}-{{ $entidad->desc_ent }}<span></span>
                </div>

            </div>


            <div class="body-border ">
                <form method="POST" action="{{ route('activo.gestionactivo.update', $actual->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row font-verdana-sm">
                        <div class="col-md-4">
                            <label style="color:black;font-weight: bold;">UNIDAD:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">

                                    {{-- <input type="hidden" name="unidad" value="{{ $actual->unidadadmin->unidad }}"
                                        readonly="true" class="form-control">
                                    <input type="hidden" name="idunidadadmin" value="{{ $actual->idunidadadmin }}"
                                        readonly="true" class="form-control">

                                    <input type="hidden" name="entidad" value="{{ $actual->entidad }}" readonly="true"
                                        class="form-control">
                                    <input type="hidden" name="identidades" value="{{ $actual->identidades }}"
                                        readonly="true" class="form-control"> --}}

                                    <span class="input-group-text">{{ $actual->unidad }}</span>
                                </div>
                                <input type="text" name="sigla" readonly="true" class="form-control"
                                    value="{{ $unidad->descrip }}">
                            </div>
                            <label style="color:black;font-weight: bold;">CODIGO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ $actual->codcont }}</span>
                                </div>
                                <input type="text" required name="codigo" value="{{ $actual->codigo }}"
                                    class="form-control" readonly required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="color:black;font-weight: bold;">VIDA UTIL :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AÑOS </span>
                                </div>
                                <input type="text" name="vidautil" id="vida" readonly class="form-control"
                                    value="{{ $actual->vidautil }} " required>
                            </div>
                            <label style="color:black;font-weight: bold;">FECHA INCORPORACIÓN :</label>
                            <div class="input-group">
                                <input type="date" required name="feul" id="feul" readonly="true"
                                    class="form-control" required>
                                <input type="hidden" value="{{ $actual->dia }}" id="dia">
                                <input type="hidden" value="{{ $actual->mes }}" id="mes">
                                <input type="hidden" value="{{ $actual->ano }}" id="ano">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="color:black;font-weight: bold;">ORGANISMO FINANCIERO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <select name="org_fin" id="organismofin" class="form-control" disabled>
                                    @foreach ($organismofins as $organismofin)
                                        <option value="{{ $organismofin->idorganismofin }}"
                                            @if ($organismofin->idorganismofin == $actual->org_fin) selected @endif>
                                            {{ optional($organismofin)->des }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label style="color:black;font-weight: bold;">AMBIENTE:</label>
                                <select class="form-control js-example-basic-multiple" id="ambiente" name="ambiente_id"
                                    >
                                    <option value="">Seleccione un ambiente</option>
                                    @foreach ($ambientes as $ambiente)
                                        <option value="{{ $ambiente->id }}"
                                            @if ($ambiente->id == $actual->ambiente_id) selected @endif>{{ $ambiente->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                {{ $actual->ambiente_id }}
                            </div>

                        </div>
                        <div class="col-md-7 mb-3">
                            <label for="observ" style="color:black;font-weight: bold;">DESCRIPCIÓN :</label>
                            <textarea type="text" required name="descrip" class="form-control" rows="1" placeholder="Descripción..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">{{ $actual->descrip }}</textarea>
                            @error('descrip')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label style="color:black;font-weight: bold;">GRUPO CONTABLE:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ $actual->codcont }}</span>
                                </div>
                                <select name="codaux" id="codcont" class="form-control" disabled>
                                    <option value="">Seleccione grupo contable</option>
                                    @foreach ($codcont as $grupo)
                                        <option value="{{ $grupo->codcont }}"
                                            @if ($grupo->codcont == $actual->codcont) selected @endif>
                                            <h1 style="color: blue;">{{ $grupo->nombre }}</h1>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('codaux')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label style="color:black;font-weight: bold;">AUXILIAR:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ $actual->codaux }}</span>
                                </div>
                                <select name="idaux" id="codaux" class="form-control" disabled>
                                    <option value="">Seleccione Auxiliar</option>
                                    @foreach ($auxiliars as $auxiliar)
                                        <option value="{{ $auxiliar->codaux }}"
                                            {{ $auxiliar->codaux == $actual->codaux ? 'selected' : '' }}>
                                            {{ $auxiliar->nomaux }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('idaux')
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
                                    <option value="">Seleccione el estado</option>
                                    <option value="1" {{ $actual->codestado == 1 ? 'selected' : '' }}>BUENO
                                    </option>
                                    <option value="2" {{ $actual->codestado == 2 ? 'selected' : '' }}>REGULAR
                                    </option>
                                    <option value="3" {{ $actual->codestado == 3 ? 'selected' : '' }}>MALO</option>
                                </select>
                            </div>
                            @error('codestado')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label for="observ" style="color:black;font-weight: bold;">OBSERVACIONES :</label>
                            <div class="input-group">
                                <textarea type="text" name="observaciones" class="form-control" rows="1" placeholder="observacion..."
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">{{ $actual->observaciones }}</textarea>
                            </div>
                            @error('observaciones')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <label for="cod_rube" style="color:black;font-weight: bold;">ID PREVENTIVO :</label>
                            <div class="input-group">
                                <input type="text" name="cod_rube" value="{{ old('cod_rube', $actual->cod_rube) }}" class="form-control" placeholder="Preventivo">
                            </div>
                            @error('cod_rube')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            {{-- <div class="form-check-inline">
                                <label for="depreciar" style="color:black;font-weight: bold;"
                                    class="required col-md-12 col-form-label text-md-right">DEPRECIAR</label>
                                <input type="checkbox" name="depreciar" value="1" class="form-control" checked>
                                <label for="actualizar" style="color:black;font-weight: bold;"
                                    class="required col-md-12 col-form-label text-md-right">ACTUALIZAR</label>
                                <input type="checkbox" name="actualizar" value="1" class="form-control" checked>

                            </div> --}}
                        </div>
                        <div class="col-md-5 mb-3">
                            <label style="color:black;font-weight: bold;">OFICINA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <select name="codarea" id="area" class="form-control" disabled>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->idarea }}"
                                            {{ $area->idarea == $actual->codarea ? 'selected' : '' }}>
                                            <h1 color:blue;>{{ $area->nombrearea }}</h1>
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
                                <select name="codemp" id="empleado" class="form-control" disabled>
                                    <option value="{{ $actual->codemp }}" selected>
                                        {{ optional($actual->empleados)->full_name }}
                                    </option>
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
                                <select name="idcargo" id="cargo" class="form-control" disabled>
                                    <option
                                        value="{{ optional($actual->empleados)->file ? $actual->empleados->file->idFile : null }}">
                                        {{ optional($actual->empleados)->file ? $actual->empleados->file->nombrecargo : null }}
                                    </option>
                                </select>
                            </div>
                            @error('idcargo')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-group">
                                @if ($actual->ultimaImagen)
                                    <img src="{{ asset('public/images/' . $actual->ultimaImagen->ruta) }}"
                                        alt="Imagen Actual" style="height: 150px;">
                                @endif
                            </div>
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
                                    <input type="file" name="fotografia" id="camera-input" class="file-input__input"
                                        accept="image/*" />
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
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label style="color:black;font-weight: bold;">COSTO INICIAL:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Bs </span>
                                        </div>
                                        <input type="text" name="costo" id="costoInicial" class="form-control"
                                            value="{{ $actual->costo }}">
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
                                        <input type="text" readonly id="factor_actual"
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
                                        <input type="text" readonly class="form-control"
                                            value="{{ $actual->vidautil }}" required>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">DEPRE ACUM INICIAL:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">BS</span>
                                        </div>
                                        <input type="text" id="depre_acumulada_inicial" readonly class="form-control"
                                            value="" required>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">% DEPRECIA:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <input type="text" readonly id="porcentaje_depreciacion" class="form-control"
                                            value="{{ $actual->vidautil != 0 ? number_format((1 / $actual->vidautil) * 100, 2) : 0 }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">DEPRE GESTION:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">BS</span>
                                        </div>
                                        <input type="text" id="depre_gestion" readonly class="form-control"
                                            value="" required>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">DEP. ACUMULADA:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Bs </span>
                                        </div>
                                        <input type="text" readonly name="depacu" id="depre_acumulada"
                                            class="form-control" value="00" required>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">VALOR NETO:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Bs </span>
                                        </div>
                                        <input type="text" readonly name="depacu" id="valor_actual"
                                            class="form-control" value="00" required>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label style="color:black;font-weight: bold;">VALOR ACTUAL:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Bs </span>
                                        </div>
                                        <input type="text" readonly id="valor_neto"
                                            class="form-control" value="00" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label style="color:black;font-weight: bold; ">CALCULADO A :</label>
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
                                            <label style="color:black;font-weight: bold;">Ufv Inicial:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Bs </span>
                                                </div>
                                                <input type="text" readonly class="form-control"
                                                    value="{{ $ufInicial }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label style="color:black;font-weight: bold;">Ufv Actual:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Bs </span>
                                                </div>
                                                <input type="text" readonly class="form-control"
                                                    value="{{ $ufActual }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
@section('styles')
    <style>
        .select2-search__field:focus {
            outline: none;
            border: none;
        }
    </style>
@endsection
@section('scripts')
<script>
    function initMap() {

        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD73WmrwkgvJi5CLHprURygkrcTJerWGIk&callback=initMap">
    </script>
    <script src="{{ asset('js/depreciar.js') }}"></script>
    <script>
        $(document).ready(function() {
            initMap()
            $('#ambiente').select2({
                tags: true,
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                }
            });
        });
        $(document).ready(function() {
            var vidaUtil = parseFloat($('#vida').val());
            var costoInicial = parseFloat($('#costoInicial').val());
            var fechaInicial = new Date(
                '{{ $actual->ano }}',
                '{{ $actual->mes - 1 }}',
                '{{ $actual->dia }}'
            );
            var ufInicial = '{{ $ufInicial }}';
            var ufActual = '{{ $ufActual }}';

            var formattedDate = fechaInicial.toISOString().split('T')[0];
            $('#feul').val(formattedDate);
            $('#factor_actual').val(
                getTwoDecimals(
                    factorActual(ufInicial, ufActual)
                )
            );
            $('#depre_acumulada').val(
                getTwoDecimals(
                    depreciacionAcumulada(costoInicial, vidaUtil, fechaInicial, ufInicial, ufActual)
                )
            );
            $('#valor_actual').val(
                valorNeto(costoInicial, vidaUtil, fechaInicial, ufInicial,ufActual).toFixed(2)
            );
            $('#valor_neto').val(
                valorActual(costoInicial, ufInicial,ufActual).toFixed(2)
            );
            $('#depre_gestion').val(
                getTwoDecimals(
                    depreciacionAcumuladaGestion(costoInicial, vidaUtil, ufInicial, ufActual)
                )
            );
            $('#depre_acumulada_inicial').val(
                getTwoDecimals(
                    depreciacionAcumuladaInicial(costoInicial, vidaUtil, fechaInicial, ufInicial, ufActual)
                )
            );
        });
        function getTwoDecimals(num) {
                return Math.floor(num * 100) / 100;
            }

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
