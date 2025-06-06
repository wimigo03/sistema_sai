<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="item_id" id="item_id" value="{{ $producto->id }}">
    <div class="row mb-2 font-roboto-14">
        <div class="col-12 col-md-6 col-lg-6 mb-2">
            <label for="" class="form-label d-inline">Partida Presupuestaria</label>
            <select name="partida_presupuestaria_id" id="partida_presupuestaria_id" class="form-control select2" disabled>
                <option value="">-</option>
                @foreach ($partidas_presupuestarias as $index => $value)
                    <option value="{{ $index }}" @if($producto->partida_presupuestaria_id == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-2 font-roboto-14">
        <div class="col-12 col-md-6 col-lg-5 mb-2">
            <label for="" class="form-label d-inline">Nombre</label>
            <input type="text" name="nombre" value="{{ $producto->nombre }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="row mb-2 font-roboto-14">
        <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="" class="form-label d-inline">Codigo</label>
                <input type="text" name="codigo" id="codigo" value="{{ $producto->codigo }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();" disabled>
        </div>
    </div>
    <div class="row mb-2 font-roboto-14">
        <div class="col-12 col-md-6 col-lg-3 mb-2">
            <label for="" class="form-label d-inline">Unidad de Medida</label>
            <select name="unidad_id" id="unidad_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($unidades as $unidad)
                    <option value="{{ $unidad->id }}"
                        @if($unidad->id == old('unidad_id') || (isset($producto) && $producto->unidad_id == $unidad->id))
                            selected
                        @endif>
                        {{ $unidad->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-2 font-roboto-14">
        <div class="col-12 col-md-6 col-lg-2 mb-2">
            <label for="" class="form-label d-inline">Precio Referencial</label>
            <input type="text" name="precio" value="{{ $producto->precio }}" id="precio" class="form-control font-roboto-12 input-numero-cleave">
        </div>
    </div>
    {{--<div class="row mb-2 font-roboto-14">
        <div class="col-12 col-md-6 col-lg-10 mb-2">
            <label for="" class="form-label d-inline">Tipo</label>
            <select name="tipo" id="tipo" class="form-control select2">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if($producto->tipo == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>--}}
    <div class="row mb-2 font-roboto-14">
        <div class="col-12 col-md-6 col-lg-10 mb-2">
            <label for="" class="form-label d-inline">Descripcion</label>
            <textarea name="detalle" id="detalle" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">{{ $producto->detalle }}</textarea>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-12 col-md-6 col-lg-12 mb-2">
        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
            @can('producto.habilitar')
                @if($producto->estado == '1')
                    <button class="btn btn-outline-danger w-100 w-md-auto btn-size mr-2 mb-2 mb-md-0" type="button" onclick="inhabilitar();">
                        <i class="fas fa-paper-plane fa-fw"></i> Inhabilitar
                    </button>
                @else
                    <button class="btn btn-outline-success w-100 w-md-auto btn-size mr-2 mb-2 mb-md-0" type="button" onclick="habilitar();">
                        <i class="fas fa-paper-plane fa-fw"></i> Habilitar
                    </button>
                @endif
            @endcan
            @if($producto->estado == '1')
                <button class="btn btn-primary w-100 w-md-auto btn-size mr-2 mb-2 mb-md-0" type="button" onclick="procesar();">
                    <i class="fas fa-paper-plane fa-fw"></i> Procesar
                </button>
            @endif
            <button class="btn btn-danger w-100 w-md-auto btn-size" type="button" onclick="cancelar();">
                <i class="fas fa-times fa-fw"></i> Cancelar
            </button>
        </div>
        <div class="text-center mt-3">
            <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
        </div>
    </div>
</div>
