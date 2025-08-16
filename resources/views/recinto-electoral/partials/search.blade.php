<div class="div_cabecera mb-4">
    <form action="#" method="post" id="form">
        @csrf
        <div class="row abs-center">
            <div class="col-12">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
                    <div class="col mb-2">
                        <label for="nombre" class="form-label d-inline font-roboto-14">Nombre del Recinto Electoral</label>
                        <input type="text" name="nombre" value="{{ request('nombre') }}" id="nombre" class="form-control font-roboto-14 intro">
                    </div>
                    <div class="col mb-2">
                        <label for="zona" class="form-label d-inline font-roboto-14">Zona Electoral</label>
                        <select name="zona" id="zona" class="form-control">
                            @foreach ($zonas as $index => $value)
                                <option value="{{ $index }}" @if(request('zona') == $index) selected @endif >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col mb-2">
                        <label for="cantidad" class="form-label d-inline font-roboto-14">Cantidad Mesas</label>
                        <input type="number" name="cantidad" value="{{ request('cantidad') }}" id="cantidad" class="form-control font-roboto-14 intro numero-entero">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row abs-center">
        <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-center justify-content-md-end">
            @can('recintos.index')
                <button class="btn btn-outline-success w-100 w-md-auto py-2 btn-size font-roboto-14" type="button" onclick="procesar();">
                    <i class="fas fa-plus fa-fw"></i> Registrar Nuevo
                </button>
            @endcan
        </div>
        <div class="col-12 text-center mt-2">
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</div>
