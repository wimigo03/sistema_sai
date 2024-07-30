<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="solicitud_compra_id" value="{{ $solicitud_compra->id }}" id="solicitud_compra_id">
    <div class="form-group row font-roboto-12">
        <div class="col-md-2 pr-1 pl-1">
            <label for="codigo" class="d-inline"><b>Codigo</b></label>
            <input type="text" value="{{ $solicitud_compra->codigo }}" class="form-control font-roboto-12" disabled>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <label for="area_solicitante" class="d-inline"><b>Unidad Solicitante</b></label>
            <input type="text" value="{{ $empleado->area_asignada }}" class="form-control font-roboto-12" disabled>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="user" class="d-inline"><b>Solicitante</b></label>
            <input type="text" value="{{ $user->name }}" class="form-control font-roboto-12" disabled>
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="c_interno" class="d-inline"><b>N° Control Interno</b></label>
            <input type="text" name="c_interno" value="{{ $solicitud_compra->c_interno }}" id="c_interno" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1">
            <label for="detalle" class="d-inline"><b>Detalle</b></label>
            <textarea name="detalle" class="form-control font-roboto-12" id="detalle" oninput="this.value = this.value.toUpperCase();">{{ $solicitud_compra->detalle }}</textarea>
        </div>
    </div>
    <div class="row abs-center">
        <div class="col-md-12 pr-1 pl-1">
            <div class="card card-body bg-light">
                <div class="form-group row font-roboto-12">
                    <div class="col-md-5 pr-1 pl-1">
                        <label for="categoria_programatica" class="d-inline"><b>Categoria Programatica :</b></label>
                        <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control font-roboto-12 select2" disabled>
                            <option value="">--Seleccionar--</option>
                            @foreach ($categorias_programaticas as $categoria_programatica)
                                <option value="{{ $categoria_programatica->id }}"
                                    @if($categoria_programatica->id == old('categoria_programatica_id') || (isset($old_categoria_programatica_id) && $old_categoria_programatica_id == $categoria_programatica->id))
                                        selected
                                    @endif>
                                    {{ $categoria_programatica->categoria_programatica }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 pr-1 pl-1">
                        <label for="partida_presupuestaria" class="d-inline"><b>Partida Presupuestaria :</b></label>
                        <select name="partida_presupuestaria_id" id="partida_presupuestaria_id" class="form-control select2">
                        </select>
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-9 pr-1 pl-1">
                        <label for="item" class="d-inline"><b>Material</b></label>
                        <select id="item_id" name="item_id" class="form-control select2">
                            <option value="">--Seleccionar--</option>
                        </select>
                    </div>
                    <div class="col-md-2 pr-1 pl-1">
                        <label for="cantidad" class="d-inline"><b>Cantidad</b></label>
                        <input type="text" id="cantidad" class="form-control font-roboto-12">
                    </div>
                    <div class="col-md-1 pr-1 pl-1 text-right">
                        <br>
                        <span class="tts:left tts-slideIn tts-custom" aria-label="Agregar detalle">
                            <button type="button" class="btn btn-outline-success font-roboto-12" onclick="agregarMaterial();">
                                <i class="fa fa-plus fa-fw"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pr-1 pl-1 table-responsive">
                        <table id="detalle_tabla" class="table display table-striped responsive hover-orange" style="width:100%;">
                            <thead>
                                <tr class="font-roboto-11">
                                    <td class="text-left p-1"><b>CATEGORIA PROGRAMATICA</b></td>
                                    <td class="text-left p-1"><b>PARTIDA PRESUPUESTARIA</b></td>
                                    <td class="text-left p-1"><b>MATERIAL</b></td>
                                    <td class="text-left p-1"><b>MEDIDA</b></td>
                                    <td class="text-right p-1"><b>CANTIDAD</b></td>
                                    <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($solicitud_compra_detalles as $datos)
                                    <tr class="detalle-{{ $datos->id }} font-roboto-11">
                                        <td class="text-left p-1" style="vertical-align: middle;">
                                            {{ $datos->categoriaProgramatica->codigo . ' - ' . $datos->categoriaProgramatica->nombre }}
                                        </td>
                                        <td class="text-left p-1" style="vertical-align: middle;">
                                            {{ $datos->partidaPresupuestaria->numeracion . ' - ' . $datos->partidaPresupuestaria->nombre }}
                                        </td>
                                        <td class="text-left p-1" style="vertical-align: middle;">
                                            {{ $datos->item->nombre }}
                                            <input type="hidden" value="{{ $datos->id }}" name="solicitud_compra_detalle_id[]">
                                            <input type="hidden" value="{{ $datos->item_id }}" class="item_id">
                                        </td>
                                        <td class="text-left p-1" style="vertical-align: middle;">
                                            {{ $datos->unidad_medida->nombre }}
                                        </td>
                                        <td class="text-right p-1" width="80px">
                                            <input type="text" name="old_cantidad[]" value="{{ $datos->cantidad }}" class="form-control form-control-sm font-roboto-12 text-right input-cantidad-old">
                                        </td>
                                        <td class="text-center p-1" style="vertical-align: middle;">
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar" style="cursor: pointer;">
                                                <span class='badge-with-padding badge badge-danger' onclick='eliminarItem(this,{{ $datos->id }});'>
                                                    <i class='fas fa-trash fa-fw'></i>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
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
