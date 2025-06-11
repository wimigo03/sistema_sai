<form action="#" method="get" id="form">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-2">
        <div class="col mb-2">
            <input type="text" name="codigo" value="{{ request('codigo') }}" id="codigo" placeholder="--Codigo--" class="form-control font-roboto-14 intro">
        </div>
        <div class="col mb-2">
            <input type="text" name="sucursal" value="{{ request('sucursal') }}" id="sucursal" placeholder="--Sucursal--" class="form-control font-roboto-14 intro">
        </div>
        <div class="col mb-2">
            <input type="text" name="proveedor" value="{{ request('proveedor') }}" id="proveedor" placeholder="--Proveedor--" class="form-control font-roboto-14 intro">
        </div>
        <div class="col mb-2">
            <input type="text" name="solicitante" value="{{ request('solicitante') }}" id="solicitante" placeholder="--Solicitante--" class="form-control font-roboto-14 intro">
        </div>
        <div class="col mb-2">
            <input type="text" name="nro_solicitud" value="{{ request('nro_solicitud') }}" id="nro_solicitud" placeholder="--N° de Solicitud--" class="form-control font-roboto-14 intro">
        </div>
        <div class="col mb-2">
            <input type="text" name="fecha_registro" value="{{ request('fecha_registro') }}" id="fecha_registro" placeholder="--Registro--" class="form-control font-roboto-14 intro">
        </div>
        <div class="col mb-2">
            <input type="text" name="fecha_salida" value="{{ request('fecha_salida') }}" id="fecha_salida" placeholder="--Salida--" class="form-control font-roboto-14 intro">
        </div>
        <div class="col mb-2">
            <select name="estado" id="estado" class="form-control">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-center justify-content-md-end">
        @can('salida.sucursal.create')
            <button class="btn btn-success w-100 w-md-auto btn-size mr-2 font-roboto-14" type="button" onclick="create();">
                <i class="fas fa-plus fa-fw"></i> Nuevo Salida
            </button>
        @endcan

        <button class="btn btn-outline-danger w-100 w-md-auto btn-size mr-2 font-roboto-14" type="button" onclick="limpiar();">
            <i class="fas fa-eraser fa-fw"></i> Limpiar
        </button>

        <button class="btn btn-outline-primary w-100 w-md-auto btn-size font-roboto-14" type="button" onclick="search();">
            <i class="fas fa-search fa-fw"></i> Buscar
        </button>
    </div>
    <div class="col-12 text-center mt-2">
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
