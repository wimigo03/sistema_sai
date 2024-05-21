<div class="form-group row">
    <div class="col-md-6 pr-1 pl-1">
        <a href="{{ route('archivos.index') }}" class="btn btn-outline-primary font-roboto-12">
            <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
        </a>
    </div>
    <div class="col-md-6 pr-1 pl-1 text-right">
        @can('tipos.archivos.create')
            <span class="tts:left tts-slideIn tts-custom" aria-label="Registrar tipo" style="cursor: pointer;">
                <a href="{{ route('tipos.archivos.create') }}" class="btn btn-outline-info font-roboto-12">
                    <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                </a>
            </span>
        @endcan
    </div>
</div>
@can('tipos.archivos.cargar')
    <form action="{{ route('tipos.archivos.store.cargar') }}" method="post" id="form">
        @csrf
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-6 pr-1 pl-1">
                <label for="tipo" class="d-inline"><b>Tipo de archivo</b></label>
                <select name="tipo" id="tipo" class="form-control select2 font-roboto-12">
                    <option value="">-</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->idtipo }}">{{ $tipo->idtipo }}--{{ $tipo->nombretipo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <br>
                <span class="btn btn-sm btn-success font-roboto-12" onclick="save();">
                    <i class="fa-solid fa-plus fa-fw"></i>Registrar
                </span>
            </div>
        </div>
    </form>
@endcan
