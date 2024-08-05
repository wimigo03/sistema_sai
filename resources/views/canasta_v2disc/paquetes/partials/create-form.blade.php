<form action="{{ route('paquetesdisc.store') }}"  method="post" id="form">
    @csrf
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-2 pr-1 pl-1">
            <label for="gestion" class="d-inline"><b>Gestion :</b></label>
            <select name="gestion" id="gestion" class="form-control select2">
                @foreach ($gestiones as $index => $value)
                    <option value="{{ $index }}" @if(request('gestion') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="numero" class="d-inline"><b>Nro. Entregasss :</b></label>
            <select  name="numero" id="numero" class="form-control font-roboto-12 select2">
                <option value="">-</option>
                @foreach ($numeros_entrega as $index => $value)
                    <option value="{{ $index }}" @if(request('numero') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-10 pr-1 pl-1">
            <label for="items" class="d-inline"><b>Items :</b></label>
            <textarea type="text" name="items" class="form-control font-roboto-12" id="items"></textarea>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-2 pr-1 pl-1">
            <label for="periodo" class="d-inline"><b>Periodo :</b></label>
            <select id="periodo_id" class="form-control font-roboto-12 select2">
                <option value="">-</option>
                @foreach ($periodos as $index => $value)
                    <option value="{{ $index }}" @if (request('periodo_id') == $index) selected @endif>
                        {{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-10 pr-1 pl-1">
            <br>
            <span class="btn btn-success font-roboto-12" onclick="registrar();">
                <i class="fa-solid fa-plus fa-fw" aria-hidden="true"></i>
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4 pr-1 pl-1 table-responsive">
            <table id="tabla_detalle" class="table display table-bordered responsive" style="width:100%;">
                <thead>
                    <tr class="font-roboto-11">
                        <td class="text-center p-1"><b>N°</b></td>
                        <td class="text-center p-1"><b>PERIODO</b></td>
                        <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-10 pr-1 pl-1">
            <span class="btn btn-outline-danger font-roboto-12 float-right" onclick="cancelar();">
                <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
            </span>
            <span class="btn btn-outline-primary font-roboto-12 float-right mr-1" onclick="procesar();" id="btn-proceso">
                <i class="fa-solid fa-paper-plane fa-fw" aria-hidden="true"></i>&nbsp;Procesar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
