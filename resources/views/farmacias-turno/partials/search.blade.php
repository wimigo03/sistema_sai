<form action="#" method="get" id="form">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-2">
        <div class="col mb-2">
            <input type="text" name="fecha_i" value="{{ request('fecha_i') }}" id="fecha_i" placeholder="--Inicio--" class="form-control font-roboto-14 intro">
        </div>
        <div class="col mb-2">
            <input type="text" name="fecha_f" value="{{ request('fecha_f') }}" id="fecha_f" placeholder="--Final--" class="form-control font-roboto-14 intro">
        </div>
        <div class="col mb-2">
            <input type="text" name="farmacia" value="{{ request('farmacia') }}" id="farmacia" placeholder="--Farmacia--" class="form-control font-roboto-14 intro">
        </div>
        <div class="col mb-2">
            <button class="btn btn-primary w-100 w-md-auto py-2 btn-size font-roboto-14" type="button" onclick="search();">
                <i class="fas fa-search fa-fw"></i> Buscar
            </button>
        </div>
        <div class="col mb-2">
            <button class="btn btn-danger w-100 w-md-auto py-2 btn-size font-roboto-14" type="button" onclick="limpiar();">
                <i class="fas fa-eraser fa-fw"></i> Limpiar
            </button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-center justify-content-md-end">
        @can('farmacias.index')
            <button class="btn btn-outline-dark w-100 w-md-auto py-2 btn-size mr-2 font-roboto-14" type="button" onclick="farmacias();">
                <i class="fa-solid fa-notes-medical fa-fw"></i> Farmacias
            </button>

            <button class="btn btn-outline-success w-100 w-md-auto py-2 btn-size font-roboto-14" type="button" onclick="create();">
                <i class="fas fa-plus fa-fw"></i> Generar Turnos
            </button>
        @endcan
    </div>
    <div class="col-12 text-center mt-2">
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
