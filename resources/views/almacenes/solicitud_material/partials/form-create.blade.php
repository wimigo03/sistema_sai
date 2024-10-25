<form action="#" method="post" id="form">
    @csrf
    @if(isset($detalles))
        <input type="hidden" name="id" value="{{ $data->id }}">
    @endif
    <input type="hidden" name="categoria_programatica_id" value="{{ $categoria_programatica_id }}">
    <div class="row font-roboto-12">
        <div class="col-md-3 pr-1 pl-1 mb-2">
            <label for="area_solicitante" class="d-inline"><b>ALMACEN</b></label>
            <input type="text" value="{{ $empleado->area_asignada_almacen }}" class="form-control font-roboto-12" disabled>
        </div>
        <div class="col-md-4 pr-1 pl-1 mb-2">
            <label for="area_solicitante" class="d-inline"><b>Unidad Solicitante</b></label>
            <input type="text" value="{{ $empleado->area_asignada }}" class="form-control font-roboto-11" disabled>
        </div>
        <div class="col-md-3 pr-1 pl-1 mb-2">
            <label for="user" class="d-inline"><b>Solicitante</b></label>
            <input type="text" value="{{ strtoupper($user->name) }}" class="form-control font-roboto-11" disabled>
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <label for="c_interno" class="d-inline"><b>N° Solicitud</b></label>
            <input type="text" name="cod_solicitud" value="{{ isset($data) ? $data->cod_solicitud : $codigo_solicitud }}" id="cod_solicitud" class="form-control font-roboto-11" disabled>
        </div>
        <div class="col-md-12 pr-1 pl-1 mb-2">
            <label for="detalle" class="d-inline"><b>Observaciones</b></label>
            <textarea name="obs" class="form-control font-roboto-11" id="obs" oninput="this.value = this.value.toUpperCase();">{{ isset($data) ? $data->obs : old('obs') }}</textarea>
        </div>
    </div>
    <div class="row abs-center">
        <div class="col-md-12 pr-1 pl-1">
            <div class="card card-body bg-light">
                <div class="form-group row font-roboto-12">
                    <div class="col-md-9 pr-1 pl-1 mb-2">
                        <label for="item_id" class="d-inline"><b>Material</b></label>
                        <select name="item_id" id="item_id" class="form-control select2">
                            <option value="">-</option>
                            @foreach ($items as $index => $value)
                                <option value="{{ $index }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 pr-1 pl-1 mb-2">
                        <label for="cantidad" class="d-inline"><b>Cantidad</b></label>
                        <input type="text" id="cantidad" class="form-control font-roboto-12 text-right">
                    </div>
                    <div class="col-md-1 pr-1 pl-1 text-right mb-2">
                        <br>
                        <span class="tts:left tts-slideIn tts-custom" aria-label="Agregar detalle">
                            <span class="btn btn-outline-success font-roboto-12" onclick="agregarMaterial();">
                                <i class="fa fa-plus fa-fw"></i>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pr-1 pl-1 table-responsive">
                        <table id="detalle_tabla" class="table display table-striped responsive hover-orange" style="width:100%;">
                            <thead>
                                <tr class="font-roboto-11">
                                    <td class="text-left p-1"><b>N°</b></td>
                                    <td class="text-left p-1"><b>DESCRIPCION DEL MATERIAL</b></td>
                                    <td class="text-center p-1"><b>MEDIDA</b></td>
                                    <td class="text-right p-1"><b>CANTIDAD</b></td>
                                    <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($detalles))
                                    @foreach ($detalles as $datos)
                                        <tr class="detalle-{{ $datos->id }} font-roboto-11">
                                            <td class="text-left p-1" style="vertical-align: middle;">
                                                {{ $cont++ }}
                                            </td>
                                            <td class="text-left p-1" style="vertical-align: middle;">
                                                <input type="hidden" name="detalle_id[]" value="{{ $datos->id }}">
                                                <input type="hidden" value="{{ $datos->item_id }}" class="item_id">
                                                {{ $datos->item->codigo . ' - ' . $datos->item->nombre }}
                                            </td>
                                            <td class="text-center p-1" style="vertical-align: middle;">
                                                {{ $datos->medida->nombre }}
                                            </td>
                                            <td class="text-right p-1" width="80px">
                                                <input type="text" name="old_cantidad[]" value="{{ number_format($datos->cant_solicitada,2,'.',',') }}" class="form-control form-control-sm font-roboto-12 text-right input-cantidad">
                                            </td>
                                            <td class="text-center p-1" style="vertical-align: middle;">
                                                <span class='badge-with-padding badge badge-danger tts:left tts-slideIn tts-custom'
                                                    style="cursor: pointer;"
                                                    aria-label="Eliminar"
                                                    onclick="if(confirm('¿Estás seguro de que quieres eliminar este ítem?')) { eliminarItem(this, {{ $datos->id }}); }">
                                                    <i class='fas fa-trash fa-fw'></i>
                                                </span>
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
    </div>
    <br>
    <div class="form-group row">
        <div class="col-md-12 pr-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" id="btn-registro" onclick="procesar();">
                <i class="fas fa-paper-plane fa-fw"></i> Procesar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fas fa-times fa-fw"></i> Cancelar
            </span>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
