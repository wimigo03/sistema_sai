<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 pl-1">
                <label for="tipo" class="d-inline"><b>Tipo</b></label>
                <select name="tipo" id="tipo" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($tipos as $index => $value)
                        <option value="{{ $index }}" @if(old('tipo') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="nombre" class="d-inline"><b>Nombre</b></label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="alias" class="d-inline"><b>Alias</b></label>
                <input type="text" name="alias" value="{{ old('alias') }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
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
