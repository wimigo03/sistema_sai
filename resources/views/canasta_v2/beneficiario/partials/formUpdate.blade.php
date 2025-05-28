<form action="{{ isset($beneficiario) ? route('beneficiarios.update') : route('beneficiarios.store') }}" method="post" id="form" {{--enctype="multipart/form-data"--}}>
    @csrf
    @if ($brigadista == true)
        <input type="hidden" name="censado" value="censo">
    @endif
    <input type="hidden" name="idBeneficiario" id="idBeneficiario" value="{{ isset($beneficiario) ? $beneficiario->id : '' }}">
    <div class="card bg-dark">
        <div class="card-header font-roboto-14 bg-white">
            <b>I. DATOS PERSONALES</b>
        </div>
        <div class="card-body bg-white">
            <div class="form-group row font-roboto-12">
                <div class="col-md-5 pr-1 pl-1">
                    <label for="barrio" class="d-inline"><b>Barrio</b></label>
                    <select name="barrio" id="barrio" class=" form-control select2">
                        @foreach ($barrios as $barrio)
                            <option value="">-</option>
                            <option value="{{ $barrio->id }}"
                                    @if (isset($beneficiario) ? $beneficiario->id_barrio == $barrio->id : old('barrio')) selected @endif
                                >
                                {{ $barrio->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <label for="estado" class="d-inline"><b>Estado</b></label>
                    <select name="estado" id="estado" class="form-control select2 font-roboto-12">
                        <option value="">-</option>
                        <option value="A" @if (isset($beneficiario) ? $beneficiario->estado == 'A' : old('estado')) selected @endif>HABILITADO</option>
                        <option value="X" @if (isset($beneficiario) ? $beneficiario->estado == 'X' : old('estado')) selected @endif>PENDIENTE</option>
                        <option value="F" @if (isset($beneficiario) ? $beneficiario->estado == 'F' : old('estado')) selected @endif>FALLECIDO</option>
                        <option value="B" @if (isset($beneficiario) ? $beneficiario->estado == 'B' : old('estado')) selected @endif>BAJA</option>
                        <option value="E" @if (isset($beneficiario) ? $beneficiario->estado == 'E' : old('estado')) selected @endif>ELIMINAR</option>
                        <option value="O" @if (isset($beneficiario) ? $beneficiario->estado == 'O' : old('estado')) selected @endif>OBSERVADO</option>
                    </select>
                </div>
                @isset($beneficiario)
                    {{--
                    <div class="col-md-2 pr-1 pl-1">
                        <br>
                        <span class="{{ $beneficiario->status == 'PENDIENTE' ? 'btn btn-block btn-secondary' : 'btn btn-block btn-success' }} font-roboto-12">
                            {{ $beneficiario->status }}
                        </span>
                    </div>
                    --}}
                    @if ($beneficiario->censado == '2')
                        <div class="col-md-5 pr-1 pl-1 text-right">
                            <br>
                            <span class="btn btn-block btn-warning font-roboto-12">
                                <i class="fa-solid fa-user fa-fw"></i>&nbsp;CENSADO POR {{ $beneficiario->user_censo->nombre_completo }}
                            </span>
                        </div>
                    @endif
                @endisset
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <label for="nombres" class="d-inline"><b>Nombres</b></label>
                    <input type="text" name="nombres" id="nombres" value="{{ isset($beneficiario) ? $beneficiario->nombres : old('nombres') }}" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <label for="ap" class="d-inline"><b>Apellido Paterno</b></label>
                    <input type="text" name="ap" id="ap" value="{{ isset($beneficiario) ? $beneficiario->ap : old('ap') }}" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <label for="ap" class="d-inline"><b>Apellido Paterno</b></label>
                    <input type="text" name="am" id="am" value="{{ isset($beneficiario) ? $beneficiario->am : old('am') }}" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="ci" class="d-inline"><b>Nro. de Carnet</b></label>
                    <input type="text" name="ci" id="ci" value="{{ isset($beneficiario) ? $beneficiario->ci : old('ci') }}" class="form-control font-roboto-12">
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="expedido" class="d-inline"><b>Expedido</b></label>
                    <select name="expedido" id="expedido" class="form-control select2 font-roboto-12">
                        <option value="">-</option>
                        <option value="BN" @if (isset($beneficiario) ? $beneficiario->expedido == 'BN' : old('expedido')) selected @endif>BENI</option>
                        <option value="CBBA" @if (isset($beneficiario) ? $beneficiario->expedido == 'CBBA' : old('expedido')) selected @endif>COCHABAMBA</option>
                        <option value="LPZ" @if (isset($beneficiario) ? $beneficiario->expedido == 'LPZ' : old('expedido')) selected @endif>LA PAZ</option>
                        <option value="ORU" @if (isset($beneficiario) ? $beneficiario->expedido == 'ORU' : old('expedido')) selected @endif>ORURO</option>
                        <option value="PND" @if (isset($beneficiario) ? $beneficiario->expedido == 'PND' : old('expedido')) selected @endif>PANDO</option>
                        <option value="PTS" @if (isset($beneficiario) ? $beneficiario->expedido == 'PTS' : old('expedido')) selected @endif>POTOSI</option>
                        <option value="SC" @if (isset($beneficiario) ? $beneficiario->expedido == 'SC' : old('expedido')) selected @endif>SUCRE</option>
                        <option value="SCZ" @if (isset($beneficiario) ? $beneficiario->expedido == 'SCZ' : old('expedido')) selected @endif>SANTA CRUZ</option>
                        <option value="TJA" @if (isset($beneficiario) ? $beneficiario->expedido == 'TJA' : old('expedido')) selected @endif>TARIJA</option>
                    </select>
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="estado_civil" class="d-inline"><b>Estado Civil</b></label>
                    <select name="estado_civil" id="estado_civil" class="form-control select2 font-roboto-12">
                        <option value="">-</option>
                        <option value="Soltero(a)" @if (isset($beneficiario) ? $beneficiario->estado_civil == 'Soltero(a)' : old('estado_civil')) selected @endif>SOLTERO(A)</option>
                        <option value="Casado(a)" @if (isset($beneficiario) ? $beneficiario->estado_civil == 'Casado(a)' : old('estado_civil')) selected @endif>CASADO(A)</option>
                        <option value="Viudo(a)" @if (isset($beneficiario) ? $beneficiario->estado_civil == 'Viudo(a)' : old('estado_civil')) selected @endif>VIUDO(A)</option>
                        <option value="Divorciado(a)" @if (isset($beneficiario) ? $beneficiario->estado_civil == 'Divorciado(a)' : old('estado_civil')) selected @endif>DIVORCIADO(A)</option>
                        <option value="Concubino(a)" @if (isset($beneficiario) ? $beneficiario->estado_civil == 'Concubino(a)' : old('estado_civil')) selected @endif>CONCUBINO(A)</option>
                        <option value="Observado(a)" @if (isset($beneficiario) ? $beneficiario->estado_civil == 'Observado(a)' : old('estado_civil')) selected @endif>OBSERVADO(A)</option>
                        <option value="Ninguno" @if (isset($beneficiario) ? $beneficiario->estado_civil == 'Ninguno' : old('estado_civil')) selected @endif>NINGUNO</option>
                    </select>
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2" id="form_ci_pareja" style="display: none;">
                    <label for="ci" class="d-inline"><b>Nro. de Carnet (Pareja)</b></label>
                    <input type="text" name="ci_pareja" id="ci_pareja" value="{{ isset($beneficiario) ? $beneficiario->ci_pareja : old('ci_pareja') }}" class="form-control font-roboto-12">
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="celular" class="d-inline"><b>Nro. de Celular</b></label>
                    <input type="text" name="celular" value="{{ isset($beneficiario) ? $beneficiario->celular :old('celular') }}" id="celular" class="form-control font-roboto-12">
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="fnac" class="d-inline"><b>Nacido el</b></label>
                    @if (isset($beneficiario))
                        <input type="text" name="fnac" value="{{ $beneficiario->fecha_nac != null ? \Carbon\Carbon::parse($beneficiario->fecha_nac)->format('d/m/Y') : '' }}" id="fnac" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" data-language="es">
                    @else
                        <input type="text" name="fnac" value="{{ old('fnac') }}" id="fnac" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" data-language="es">
                    @endif
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="sexo" class="d-inline"><b>Sexo</b></label>
                    <select name="sexo" id="sexo" class="form-control select2 font-roboto-12">
                        <option value="">-</option>
                        <option value="H" @if (isset($beneficiario) ? $beneficiario->sexo == 'H' : old('sexo')) selected @endif>MASCULINO</option>
                        <option value="M" @if (isset($beneficiario) ? $beneficiario->sexo == 'M' : old('sexo')) selected @endif>FEMENINO</option>
                    </select>
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <label for="profesion" class="d-inline"><b>Profesion</b></label>
                    <select name="profesion" id="profesion" class=" form-control select2">
                        @foreach ($profesiones as $profesion)
                            <option value="">-</option>
                            <option value="{{ $profesion->id }}"
                                    @if (isset($beneficiario) ? $beneficiario->profesion_id == $profesion->id : old('profesion')) selected @endif
                                >
                                {{ $profesion->ocupacion }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <label for="ocupacion" class="d-inline"><b>Ocupacion</b></label>
                    <select name="ocupacion" id="ocupacion" class=" form-control select2">
                        @foreach ($ocupaciones as $ocupacion)
                            <option value="">-</option>
                            <option value="{{ $ocupacion->id }}"
                                    @if (isset($beneficiario) ? $beneficiario->id_ocupacion == $ocupacion->id : old('ocupacion')) selected @endif
                                >
                                {{ $ocupacion->ocupacion }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="categoria" class="d-inline"><b>Categoria</b></label>
                    <select name="categoria" id="categoria" class="form-control select2 font-roboto-12">
                        <option value="">-</option>
                        <option value="1" @if (isset($beneficiario) ? $beneficiario->categoria == '1' : old('categoria')) selected @endif>A</option>
                        <option value="2" @if (isset($beneficiario) ? $beneficiario->categoria == '2' : old('categoria')) selected @endif>B</option>
                        <option value="3" @if (isset($beneficiario) ? $beneficiario->categoria == '3' : old('categoria')) selected @endif>C</option>
                    </select>
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <label for="estado_salud" class="d-inline"><b>Estado de Salud</b></label>
                    <select name="estado_salud" id="estado_salud" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($estados_salud as $index => $value)
                            <option value="{{ $index }}"
                                @if( (isset($beneficiario) && $beneficiario->estado_salud == $index) || (old('estado_salud') == $index) ) selected @endif>
                                {{ $value }}
                            </option>

                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    @if (isset($beneficiario))
                        <input type="checkbox" name="check_seguro_medico" id="check_seguro_medico" {{ $beneficiario->seguro_medico != null ? 'checked' : '' }} onclick="CheckSeguroMedico()">
                    @else
                        <input type="checkbox" name="check_seguro_medico" id="check_seguro_medico" {{ old('seguro_medico') ? 'checked' : '' }} onclick="CheckSeguroMedico()">
                    @endif
                    <label for="seguro_medico" class="d-inline"><b>Seguro Medico</b></label>

                    <label for="titular" class="d-inline float-right ml-1"><b>Titular</b></label>
                    @if (isset($beneficiario))
                        <input type="checkbox" class="float-right" name="check_titular" id="check_titular" {{ $beneficiario->titular_seguro_medico == '2' ? 'checked' : '' }}>
                    @else
                        <input type="checkbox" class="float-right" name="check_titular" id="check_titular" {{ old('check_titular') == 'on' ? 'checked' : '' }}>
                    @endif
                    <select name="seguro_medico" id="seguro_medico" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($_seguros as $index => $value)
                            <option value="{{ $index }}" @if(isset($beneficiario) ? $beneficiario->seguro_medico == $index : old('seguro_medico')) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="firma" class="d-inline"><b>¿El beneficiario firma?</b></label>
                    <select name="firma" id="firma" class="form-control select2 font-roboto-12">
                        <option value="">-</option>
                        <option value="SI" @if (isset($beneficiario) ? $beneficiario->firma == 'SI' : old('firma')) selected @endif>SI</option>
                        <option value="NO" @if (isset($beneficiario) ? $beneficiario->firma == 'NO' : old('firma')) selected @endif>NO</option>
                    </select>
                </div>
                <div class="col-md-10 pr-1 pl-1 mb-2">
                    <label for="direccion" class="d-inline"><b>Direccion</b></label>
                    <input type="text" name="direccion" id="direccion" value="{{ isset($beneficiario) ? $beneficiario->direccion : old('direccion') }}" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card bg-dark">
        <div class="card-header font-roboto-14 bg-white">
            <b>II. UBICACION Y DETALLE DE SU VIVIENDA</b>
        </div>
        <div class="card-body bg-white">
            <div class="form-group row font-roboto-12">
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="latitud" class="d-inline"><b>Latitud</b></label>
                    <input type="text" name="latitud" id="latitud" class="form-control font-roboto-12">
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="longitud" class="d-inline"><b>Longitud</b></label>
                    <input type="text" name="longitud" id="longitud" class="form-control font-roboto-12">
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="utmx" class="d-inline"><b>UTM Y</b></label>
                    <input type="text" name="utmy" id="utmy" class="form-control font-roboto-12">
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="utmy" class="d-inline"><b>UTM X</b></label>
                    <input type="text" name="utmx" id="utmx" class="form-control font-roboto-12">
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <br>
                    <span class="btn btn-dark btn-block font-roboto-12" id="toggleButton">
                        <i class="fa-solid fa-map-location-dot fa-fw"></i> Mostrar u Ocultar Mapa
                    </span>
                </div>
            </div>
            <div class="row font-roboto-12" id="form-map">
                <div class="col-md-12 pr-1 pl-1">
                    <div id="map"></div>
                    <p id="coordinates"></p>
                    <span class="locate-btn"><i class="fa-solid fa-location-crosshairs fa-2x"></i></span>
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-12 pr-1 pl-1 mb-2">
                    <label for="detalle_vivienda" class="d-inline"><b>Descripcion de la Vivienda</b></label>
                    <textarea name="detalle_vivienda" id="detalle_vivienda" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">{{ isset($beneficiario) ? $beneficiario->detalle_vivienda : old('detalle_vivienda'); }}</textarea>
                </div>
                <div class="col-md-3 pr-1 pl-1 mb-2">
                    <label for="tipo_vivienda" class="d-inline"><b>Tipo de Vivienda</b></label>
                    <select name="tipo_vivienda" id="tipo_vivienda" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($tipos_viviendas as $index => $value)
                            <option value="{{ $index }}" @if(isset($beneficiario) ? $beneficiario->tipo_vivienda : old('tipo_vivienda') == $index) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 pr-1 pl-1 mb-2">
                    <label for="material_vivienda" class="d-inline"><b>Material de la Vivienda</b></label>
                    <select name="material_vivienda" id="material_vivienda" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($materiales_viviendas as $index => $value)
                            <option value="{{ $index }}" @if(isset($beneficiario) ? $beneficiario->material_vivienda : old('material_vivienda') == $index) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 pr-1 pl-1 mb-2 text-center">
                   <b><u>VECINOS QUE LO IDENTIFICAN COMO VIVIENTE DEL BARRIO</u></b>
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <label for="vecino_1" class="d-inline"><b>(1) Vecino</b></label>
                    <input type="text" name="vecino_1" id="vecino_1" value="{{ isset($beneficiario) ? $beneficiario->vecino_1 : old('vecino_1') }}" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <label for="vecino_2" class="d-inline"><b>(2) Vecino</b></label>
                    <input type="text" name="vecino_2" id="vecino_2" value="{{ isset($beneficiario) ? $beneficiario->vecino_2 : old('vecino_2') }}" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <label for="vecino_3" class="d-inline"><b>(3) Vecino</b></label>
                    <input type="text" name="vecino_3" id="vecino_3" value="{{ isset($beneficiario) ? $beneficiario->vecino_3 : old('vecino_3') }}" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card bg-dark">
        <div class="card-header font-roboto-14 bg-white">
            <b>III. IMAGENES</b>
        </div>
        @isset($beneficiario)
        <div class="card-body bg-white">
            <div class="form-group row font-roboto-12">
                <div class="col-md-4 pr-1 pl-1 text-center">
                    @isset($beneficiario)
                        <img src="{{ asset(substr($beneficiario->dir_foto, 2)) }}" width="150" />
                    @endisset
                    <input type="hidden" name="_file_documento" value="{{ isset($beneficiario) ? $beneficiario->dir_foto : '' }}" id="_file_documento">
                </div>
                <div class="col-md-4 pr-1 pl-1 text-center">
                    @isset($beneficiario)
                        <img src="{{ asset($beneficiario->file_ci_anverso) }}" width="150" />
                    @endisset
                    <input type="hidden" name="_file_ci_anverso" value="{{ isset($beneficiario) ? $beneficiario->file_ci_anverso : '' }}" id="_file_ci_anverso">
                </div>
                <div class="col-md-4 pr-1 pl-1 text-center">
                    @isset($beneficiario)
                        <img src="{{ asset($beneficiario->file_ci_reverso) }}" width="150" />
                    @endisset
                    <input type="hidden" name="_file_ci_reverso" value="{{ isset($beneficiario) ? $beneficiario->file_ci_reverso : '' }}" id="_file_ci_reverso">
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-4 pr-1 pl-1 text-center">
                    <label for="fregistro" class="d-inline"><b>Foto Beneficiario</b></label>
                    <input type="file" name="file_documento" id="file_documento" class="form-control font-roboto-12">
                </div>
                <div class="col-md-4 pr-1 pl-1 text-center">
                    <label for="ci_anverso" class="d-inline"><b>Foto Carnet Anverso</b></label>
                    <input type="file" name="file_ci_anverso" id="file_ci_anverso" class="form-control font-roboto-12">
                </div>
                <div class="col-md-4 pr-1 pl-1 text-center">
                    <label for="ci_reverso" class="d-inline"><b>Foto Carnet Reverso</b></label>
                    <input type="file" name="file_ci_reverso" id="file_ci_reverso" class="form-control font-roboto-12">
                </div>
            </div>
        </div>
        @endisset
    </div>
    <br>
    <div class="card bg-dark">
        <div class="card-header font-roboto-14 bg-white">
            <div class="row">
                <div class="col-md-6 pr-1 pl-1">
                    <b>IV. OBSERVACIONES</b>
                </div>
                <div class="col-md-6 pr-1 pl-1 text-right font-roboto-12">
                    @if (isset($beneficiario))
                        <input type="checkbox" name="informacion" id="informacion" onclick="toggleCheckboxes(this)" {{ $beneficiario->informacion == '2' ? 'checked' : '' }}>
                    @else
                        <input type="checkbox" name="informacion" id="informacion" onclick="toggleCheckboxes(this)" {{ old('informacion') == '2' ? 'checked' : '' }}>
                    @endif
                    <b><u>Seleccionar esta opcion si el Beneficiario se niega a dar Información</u></b>
                </div>
            </div>
        </div>
        <div class="card-body bg-white">
            <div class="form-group row font-roboto-12">
                <div class="col-md-12 pr-1 pl-1">
                    <textarea name="observacion" id="observacion" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">{{ isset($beneficiario) ? 'ACTUALIZACION DE DATOS' : old('observacion') }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="form-group row">
        <div class="col-md-6">
            <span class="btn btn-primary btn-block font-roboto-14" onclick="procesar();">
                <i class="fa-solid fa-paper-plane fa-fw" aria-hidden="true"></i>&nbsp;Procesar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
        <div class="col-md-6">
            @if ($brigadista == true)
                @can('canasta.beneficiarios.brigadista.index')
                    <span class="btn btn-danger btn-block font-roboto-14" onclick="brigadista_cancelar();">
                        <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
                    </span>
                @endcan
            @else
                @can('canasta.beneficiarios.index')
                    <span class="btn btn-danger btn-block font-roboto-14" onclick="cancelar();">
                        <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
                    </span>
                @endcan
            @endif
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
