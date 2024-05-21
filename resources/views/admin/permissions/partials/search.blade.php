<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-3 pr-1 pl-1 font-roboto-12">
            <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
            <select name="titulo" id="titulo" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($titulos as $titulo)
                    <option value="{{ $titulo->title }}"
                        @if($titulo->title == request('titulo'))
                            selected
                        @endif>
                        {{ strtoupper($titulo->title) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="nombre" placeholder="--Nombre del permiso--" value="{{ request('nombre') }}" class="form-control font-roboto-12 intro">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6 pr-1 pl-1">
            @can('permissions.create')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Crear">
                    <button class="btn btn-outline-success font-roboto-12" type="button" onclick="create();">
                        <i class="fa fa-plus"></i>
                    </button>
                    <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </span>
            @endcan
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="procesar();">
                <i class="fa fa-search" aria-hidden="true"></i> Buscar
            </button>
            <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="limpiar();">
                <i class="fa fa-eraser"></i> Limpiar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
