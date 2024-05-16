<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nombres" placeholder="-- Nombres --" value="{{ request('nombres') }}"
                class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="ap" placeholder="-- Ap. Paterno --" value="{{ request('ap') }}"
                class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="am" placeholder="-- Ap. Materno --" value="{{ request('am') }}"
                class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-1 pr-1 pl-1">
            <input type="text" name="ci" placeholder="-- C. I. --" value="{{ request('ci') }}"
                class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="barrio" id="barrio2" class="form-control">
                <option value="">-</option>
                @foreach ($barrios2 as $barrio)
                    <option value="{{ $barrio->nombre }}" @if (request('barrio') == $barrio->nombre) selected @endif>
                        {{ $barrio->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if (request('estado') == $index) selected @endif>
                        {{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-1 pr-1 pl-1">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir atras" style="cursor: pointer;">
                <span class="btn btn-primary font-roboto-12" onclick="cancelar();">
                    <i class="fas fa-angle-double-left fa-fw"></i>
                </span>
            </span>
        </div>
        <div class="col-md-9 pr-1">
            <label for="nombre" style="color: green">--- (Total: {{ $total }}) --</label>
            <label for="nombre" style="color: blue">(Entregados: {{ $entregados }}) --</label>
            <label for="nombre" style="color: orange">(Sin Entrega: {{ $sin_entrega }}) ---</label>

        </div>



        <div class="col-md-2 pr-2 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                <i class="fa fa-search fa-fw" aria-hidden="true"></i>&nbsp;Buscar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="limpiar();">
                <i class="fa fa-eraser fa-fw"></i>&nbsp;Limpiar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
    </div>
</form>
