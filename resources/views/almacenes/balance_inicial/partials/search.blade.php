<form action="#" method="get" id="form">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-12 g-2">
        <div class="col mb-2">
            <input type="text" name="sucursal" value="{{ request('sucursal') }}" id="sucursal" placeholder="--Sucursal--" class="form-control font-roboto-14 intro">
        </div>
        <div class="col mb-2">
            <input type="text" name="gestion" value="{{ request('gestion') }}" id="gestion" placeholder="--Gestion--" class="form-control font-roboto-14 intro">
        </div>
    </div>
</form>
<div class="row">
    <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-center justify-content-md-end">
        @can('balance.inicial.create')
            <button class="btn btn-success w-100 w-md-auto btn-size mr-2 font-roboto-14" type="button" onclick="create();">
                <i class="fas fa-plus fa-fw"></i> Nuevo Balance
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
