<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="barrio_id" value="{{ $barrio->id }}">
    <input type="hidden" name="dea_id" value="{{ $dea_id }}">
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="tipo" class="d-inline"><b>Tipo: </b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="tipo" id="tipo" class="form-control select2">
                @foreach ($tipos as $tipo => $value)
                    <option value="{{ $tipo }}"
                        @if($tipo == request('tipo') || (isset($barrio) && $barrio->tipo == $tipo))
                            selected
                        @endif>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="nombre" class="d-inline"><b>Nombre: </b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="text" name="nombre" id="nombre" value="{{ $barrio->nombre}}" oninput="this.value = this.value.toUpperCase()" class="form-control font-verdana-12 intro {{ $errors->has('nombre') ? ' is-invalid' : '' }}">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="distrito" class="d-inline"><b>Distrito: </b></label>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="distrito" id="distrito" class="form-control select2">
                @foreach ($distritos as $distrito)
                    <option value="{{ $distrito->id }}"
                        @if($distrito->id == request('distrito') || (isset($barrio) && $barrio->distrito_id == $distrito->id))
                            selected
                        @endif>
                        {{ $distrito->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1 text-right">
            <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="procesar();">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar
            </button>
            <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                &nbsp;<i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
