<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="barrio_id" value="{{ $barrio->id }}">
    <div class="form-group row font-verdana-bg">
        <div class="col-md-3 pr-1">
            <label for="tipo" class="d-inline">Tipo</label>
            <select name="tipo" id="tipo" class="form-control form-control-sm select2">
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
        <div class="col-md-5 pl-1">
            <label for="nombre" class="d-inline">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ $barrio->nombre}}" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm font-verdana-bg intro {{ $errors->has('nombre') ? ' is-invalid' : '' }}">
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-3 pr-1">
            <label for="dea" class="d-inline">DEA</label>
            <input type="text" value="{{ Auth::user()->dea->nombre }}" class="form-control form-control-sm font-verdana-bg" disabled>
        </div>
        <div class="col-md-5 pl-1">
            <label for="distrito" class="d-inline">Distrito</label>
            <select name="distrito" id="distrito" class="form-control form-control-sm select2">
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
        <div class="col-md-12 text-right">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="cancelar();">
                &nbsp;<i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
