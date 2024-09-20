<form action="#" method="post" id="form">
    @csrf
    <div class="card" style="border: 2px solid #17A2B8;">
        <div class="card-header" style="padding: 0.5rem 1rem;">
            <strong class="font-roboto-14"><u>DETALLE DE EQUIPOS</u></strong>
        </div>
        <div class="card-body">
            <div class="row font-roboto-12">
                <div class="col-md-12 pr-1 pl-1 mb-2">
                    <label for="problema" class="d-inline"><b>Problemas</b></label>
                    <textarea id="problema" class="form-control font-roboto-11 intro" oninput="this.value = this.value.toUpperCase()"></textarea>
                </div>
                <div class="col-md-3 pr-1 pl-1 mb-2">
                    <label for="codigo_serie" class="d-inline"><b>Codigo/Nro. Serie</b></label>
                    <input type="text" id="codigo_serie" oninput="this.value = this.value.toUpperCase()" class="form-control font-roboto-11 intro">
                </div>
                <div class="col-md-5 pr-1 pl-1 mb-2">
                    <label for="clasificacion" class="d-inline"><b>Clasificacion</b></label>
                    <select name="clasificacion" id="clasificacion" class="form-control form-control-sm select2">
                        <option value="">-</option>
                        @foreach ($clasificaciones as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <br>
                    <span class="btn btn-block btn-success font-roboto-12" onclick="insertar();">
                        <i class="fa fa-fw fa-plus-circle"></i> Insertar Equipo
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12 pr-1 pl-1">
                    <table id="tabla_detalle" class="table table-striped table-bordered hover-orange" style="width:100%;">
                        <thead>
                            <tr class="font-roboto-11">
                                <td class="text-justify p-1"><b>N°</b></td>
                                <td class="text-justify p-1"><b>CODIGO/SERIE</b></td>
                                <td class="text-justify p-1"><b>CLASIFICION</b></td>
                                <td class="text-justify p-1"><b>PROBLEMA</b></td>
                                <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        {{--<tfoot id="tfoot">
                            <tr class="font-roboto-11">
                                <input type="hidden" value="#" name="monto_total" id="monto_total">
                                <td class="text-center p-1" colspan="6"><b>TOTAL</b></td>
                                <td id="total_debe" class="text-right p-1"><b></b></td>
                                <td id="total_haber" class="text-right p-1"><b></b></td>
                                <td class="text-center p-1">&nbsp;</td>
                            </tr>
                        </tfoot>--}}
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
                            <option value="{{ $index }}" @if(old('area_id') == $index) selected @endif >{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 pr-1 pl-1 mb-2">
                    <label for="empleado" class="d-inline"><b>Empleado </b></label>
                    <select name="empleado_id" id="empleado_id" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($empleados as $index => $value)
                            <option value="{{ $index }}" @if(old('empleado_id') == $index) selected @endif >{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <label for="nro_comunicacion_interna" class="d-inline"><b>Nro Comunicacion Interna</b></label>
                    <input type="text" name="nro_comunicacion_interna" id="nro_comunicacion_interna" value="{{ old('nro_comunicacion_interna') }}" oninput="this.value = this.value.toUpperCase()" class="form-control font-roboto-11 intro">
                </div>
                <div class="col-md-12 pr-1 pl-1 mb-2">
                    <label for="observaciones" class="d-inline"><b>Observaciones</b></label>
                    <textarea name="observaciones" id="observaciones" class="form-control font-roboto-11 intro" oninput="this.value = this.value.toUpperCase()">{{ old('observaciones') }}</textarea>
                </div>
            </div>
            <div class="form-group row" id="btn-proceso">
                <div class="col-md-6 pr-1 pl-1">
                    <span class="btn btn-block btn-primary font-roboto-12" onclick="procesar();">
                        <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar
                    </span>
                    <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </div>
                <div class="col-md-6 pr-1 pl-1">
                    <span class="btn btn-block btn-danger font-roboto-12" onclick="cancelar();">
                        <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
                    </span>
                    <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </div>
            </div>
        </div>
    </div>
</form>
