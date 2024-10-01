<form action="#" method="post" id="form">
    @csrf
    @if (isset($mantenimiento))
        <input type="hidden" name="mantenimiento_id" value="{{ $mantenimiento->id }}">
    @endif
    <div class="card" style="border: 2px solid #17A2B8;">
        {{-- <div class="card-header" style="padding: 0.5rem 1rem;">
            <strong class="font-roboto-14"><u>DETALLE DE LOS EQUIPOS</u></strong>
        </div> --}}
        <div class="card-body">
            <div class="row font-roboto-12">
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="codigo_serie" class="d-inline"><b>Codigo/Nro. Serie</b></label>
                    <input type="text" id="codigo_serie" oninput="this.value = this.value.toUpperCase().replace(/\s+/g, '')" class="form-control font-roboto-11 intro">
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="clasificacion" class="d-inline"><b>Clasificacion</b></label>
                    <select id="clasificacion" class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($clasificaciones as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-7 pr-1 pl-1 mb-2">
                    <label for="problema" class="d-inline"><b>Estado del Equipo</b></label>
                    <input type="text" id="problema" class="form-control font-roboto-11 intro" oninput="this.value = this.value.toUpperCase()">
                </div>
                <div class="col-md-1 pr-1 pl-1 mb-2">
                    <br>
                    <span class="btn btn-success font-roboto-11 float-right" onclick="insertar();">
                        <i class="fa fa-fw fa-plus-circle"></i>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 pr-1 pl-1">
                    <table id="tabla_detalle" class="table table-striped table-bordered hover-orange" style="width:100%;">
                        <thead>
                            <tr class="font-roboto-11">
                                <td class="text-justify p-1"><b>N°</b></td>
                                <td class="text-justify p-1"><b>CODIGO/SERIE</b></td>
                                <td class="text-justify p-1"><b>CLASIFICION</b></td>
                                <td class="text-justify p-1"><b>ESTADO DEL EQUIPO</b></td>
                                <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($mantenimiento_detalles))
                                @php
                                    $cont = 1;
                                @endphp
                                @foreach($mantenimiento_detalles as $datos)
                                    <tr data-codigo-serie="{{ $datos->codigo_serie }}" class="detalle-{{ $datos->id }} font-roboto-11">
                                        <td class="text-justify p-1">{{ $cont++ }}</td>
                                        <td class="text-justify p-1">{{ $datos->codigo_serie }}</td>
                                        <td class="text-justify p-1">{{ $datos->clasificacion_equipo }}</td>
                                        <td class="text-justify p-1">{{ $datos->problema_equipo }}</td>
                                        <td class="text-center p-1">
                                            <div class="d-flex justify-content-center">
                                                <span class='badge-with-padding badge badge-danger tts:left tts-slideIn tts-custom mr-1'
                                                    style="cursor: pointer;"
                                                    aria-label="Eliminar"
                                                    onclick="if(confirm('¿Estás seguro de que quieres eliminar este ítem?')) { eliminarItem(this, {{ $datos->id }}); }">
                                                    <i class='fas fa-trash fa-fw'></i>
                                                </span>
                                                <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Modificar">
                                                    <a href="{{ route('mantenimientos.editarDetalle', $datos->id) }}" class="badge-with-padding badge badge-warning">
                                                        <i class="fa fa-edit fa-fw"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card" style="border: 2px solid #17A2B8;">
        <div class="card-body">
            <div class="row font-roboto-12">
                <div class="col-md-6 pr-1 pl-1 mb-2">
                    <label for="procedencia" class="d-inline"><b>Procedencia</b></label>
                    <select name="area_id" id="area_id" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($areas as $index => $value)
                            <option value="{{ $index }}"
                                @if(old('area_id') == $index || (isset($mantenimiento) && $mantenimiento->idarea == $index))
                                    selected
                                @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <label for="empleado" class="d-inline"><b>Funcionario Encargado</b></label>
                    <select name="empleado_id" id="empleado_id" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($empleados as $index => $value)
                            <option value="{{ $index }}"
                                @if(old('empleado_id') == $index || (isset($mantenimiento) && $mantenimiento->idemp == $index))
                                    selected
                                @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="nro_comunicacion_interna" class="d-inline"><b>Nro Comunicacion Interna</b></label>
                    <input type="text" name="nro_comunicacion_interna" id="nro_comunicacion_interna" value="{{ isset($mantenimiento) ? $mantenimiento->nro_comunicacion_interna : old('nro_comunicacion_interna') }}" oninput="this.value = this.value.toUpperCase()" class="form-control font-roboto-11 intro">
                </div>
                <div class="col-md-12 pr-1 pl-1 mb-2">
                    <label for="observaciones" class="d-inline"><b>Observaciones</b> (Si Corresponde)</label>
                    <input type="text" name="observaciones" value="{{ isset($mantenimiento) ? $mantenimiento->observaciones : old('observaciones') }}" id="observaciones" class="form-control font-roboto-11 intro" oninput="this.value = this.value.toUpperCase()">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 pr-1 pl-1 text-center">
                    @if (isset($mantenimiento))
                        <span class="btn btn-lg btn-primary font-roboto-12" onclick="update();" id="btn-proceso">
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar
                        </span>
                        <a href="{{ route('mantenimientos.show', $mantenimiento->id) }}" class="btn btn-lg btn-danger font-roboto-12">
                            <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
                        </a>
                    @else
                        <span class="btn btn-lg btn-primary font-roboto-12" onclick="procesar();" id="btn-proceso">
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar
                        </span>
                        <a href="{{ route('mantenimientos.index') }}" class="btn btn-lg btn-danger font-roboto-12">
                            <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
                        </a>
                    @endif
                    <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </div>
            </div>
        </div>
    </div>
</form>
