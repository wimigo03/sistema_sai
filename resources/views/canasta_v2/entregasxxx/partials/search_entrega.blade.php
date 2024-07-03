<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="nombres" placeholder="--Nombres--" value="{{ request('nombres') }}" class="form-control  font-roboto-12 intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="ap" placeholder="--Apellido Paterno--" value="{{ request('ap') }}" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="am" placeholder="--Apellido Materno--" value="{{ request('am') }}" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="ci" placeholder="--Nro. de carnet--" value="{{ request('ci') }}" class="form-control font-roboto-12 intro">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4 pr-1 pl-1">
            <select name="barrio" id="barrio2" class=" form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($barrios2 as $barrio)
                    <option value="{{ $barrio->nombre }}" @if (request('barrio') == $barrio->nombre) selected @endif>
                        {{ $barrio->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if (request('estado') == $index) selected @endif>
                        {{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-8 pr-1 pl-1">
            <span class="tts:right tts-slideIn tts-custom root" aria-label="Ir atras" style="cursor: pointer;">
                <span class="btn btn-primary font-roboto-12" onclick="cancelar();">
                    <i class="fas fa-angle-double-left fa-fw"></i>
                </span>
            </span>
            <span class="tts:right tts-slideIn tts-custom root" aria-label="Registrar solo beneficiarios" style="cursor: pointer;">
                <a href="{{ route('entregas.entrega_index2', $idpaquete ) }}" class="btn btn-outline-success font-roboto-12">
                    <i class="fas fa-male fa-fw"></i>
                </a>
            </span>
            @can('canasta.entregas.agregar.porbarrio')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Registrar beneficiarios por barrio" style="cursor: pointer;">
                    <span class="btn btn-outline-info font-roboto-12" data-toggle="collapse" data-target="#collapseBeneficiariosPorBarrio" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa fa-address-book fa-fw" aria-hidden="true"></i>
                    </span>
                </span>
            @endcan
        </div>
        {{--<div class="col-md-4 pr-1 pl-1 text-center">
            <span style="color: green">Total: {{ $total }} |</span>
            <span style="color: blue">Entregados: {{ $entregados }} |</span>
            <span style="color: orange">Sin Entrega: {{ $sin_entrega }}</span>
        </div>--}}
        <div class="col-md-4 pr-1 pl-1 text-right">
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
