<form action="#" method="post" id="form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="tipo_id" id="tipo_id" value="{{ $tipo->idtipo }}">
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="tipo_id" class="d-inline"><b>Nombre:</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="text" name="nombretipo" value="{{ $tipo->nombretipo }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase()">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="codigo" class="d-inline"><b>Codigo:</b></label>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="codigo" value="{{ $tipo->codigo }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase()">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="subtipo" class="d-inline"><b>Subtipo:</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="subtipo" id="subtipo" class="form-control font-roboto-12 select2">
                <option value="">-</option>
                @foreach ($subtipos as $index => $value)
                    <option value="{{ $index }}" @if($tipo->subtipo == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="estado" class="d-inline"><b>Estado:</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control font-roboto-12 select2">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if($tipo->estado == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 text-center">
            <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
