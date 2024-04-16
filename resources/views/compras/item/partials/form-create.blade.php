<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-5 pr-1 pl-1">
                <label for="partida_id" class="d-inline"><b>Partida Presupuestaria</b></label>
                <select name="partida_id" id="partida_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($partidas_presupuestarias as $index => $value)
                        <option value="{{ $index }}" @if(old('partida_id') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5 pr-1 pl-1">
                <label for="nombre" class="d-inline"><b>Nombre</b></label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-3 pr-1 pl-1">
                <label for="unidad_id" class="d-inline"><b>Unidad de Medida</b></label>
                <select name="unidad_id" id="unidad_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($unidades as $index => $value)
                        <option value="{{ $index }}" @if(old('unidad_id') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="precio" class="d-inline"><b>Precio</b></label>
                <input type="text" name="precio" value="{{ old('precio') }}" id="precio" class="form-control font-roboto-12 input-numero-cleave">
            </div>
            <div class="col-md-4 pr-1 pl-1">
                <label for="tipo" class="d-inline"><b>Tipo</b></label>
                <select name="tipo" id="tipo" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($tipos as $index => $value)
                        <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-10 pr-1 pl-1">
                <label for="detalle" class="d-inline"><b>Descripcion</b></label>
                <textarea name="detalle" id="detalle" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">{{ old('detalle') }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 text-right">
                <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="procesar();">
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
