<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="distrito_id" value="{{ $distrito->id }}">
    <div class="form-group row font-verdana-12">
        <div class="col-md-4 pr-1">
            <label for="nombre" class="d-inline">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ $distrito->nombre }}" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm font-verdana-12 intro {{ $errors->has('nombre') ? ' is-invalid' : '' }}">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="dea" class="d-inline">DEA</label>
            <select name="dea" id="dea" class="form-control form-control-sm select2 {{ $errors->has('dea') ? ' is-invalid' : '' }}">
                @foreach ($deas as $dea)
                    <option value="{{ $dea->id }}"
                        @if($dea->id == request('dea') || (isset($distrito) && $distrito->dea_id == $dea->id))
                            selected
                        @endif>
                        {{$dea->nombre}}
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
