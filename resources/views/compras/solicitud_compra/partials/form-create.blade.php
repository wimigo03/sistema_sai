<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
        <input type="hidden" name="area_id" value="{{ $empleado->idarea }}">
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <div class="form-group row font-roboto-12">
            <div class="col-md-5 pr-1 pl-1">
                <label for="area_solicitante" class="d-inline"><b>Unidad Solicitante</b></label>
                <input type="text" value="{{ $empleado->empleadosareas->nombrearea }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="user" class="d-inline"><b>Solicitante</b></label>
                <input type="text" value="{{ $user->name }}" class="form-control font-roboto-12" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-2 pr-1 pl-1">
                <label for="tipo" class="d-inline"><b>Tipo</b></label>
                <select name="tipo" id="tipo" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($tipos as $index => $value)
                        <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="c_interno" class="d-inline"><b>N° Control Interno</b></label>
                <input type="text" name="c_interno" value="{{ old('c_interno') }}" id="c_interno" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-8 pr-1 pl-1">
                <label for="detalle" class="d-inline"><b>Justificacion</b></label>
                <textarea name="detalle" class="form-control font-roboto-12" id="detalle" oninput="this.value = this.value.toUpperCase();">{{ old('detalle') }}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 pr-1 pl-1">
                <div class="card card-body bg-light">
                    <div class="form-group row font-roboto-12">
                        <div class="col-md-8 pr-1 pl-1">
                            <label for="item" class="d-inline"><b>Item Producto / Servicio</b></label>
                            <select id="item_id" name="item_id" class="form-control select2">
                                <option value="">--Seleccionar--</option>
                            </select>
                        </div>
                        <div class="col-md-3 pr-1 pl-1">
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
                    <div class="form-group row">
                        <div class="col-md-12 pr-1 pl-1 table-responsive">
                            <table id="detalle_tabla" class="table display table-striped table-bordered responsive hover-orange" style="width:100%;">
                                <thead>
                                    <tr class="font-roboto-11">
                                        <td class="text-left p-1"><b>ITEM</b></td>
                                        <td class="text-left p-1"><b>MEDIDA</b></td>
                                        <td class="text-right p-1"><b>CANTIDAD</b></td>
                                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                                    </tr>
                                </thead>
                                <tbody>
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
                <button class="btn btn-outline-primary font-roboto-12" id="btn-registro" type="button" onclick="procesar();">
                    <i class="fas fa-paper-plane fa-fw"></i> Procesar
                </button>
                <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                    <i class="fas fa-times fa-fw"></i> Cancelar
                </button>
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div>
    </form>
</div>
