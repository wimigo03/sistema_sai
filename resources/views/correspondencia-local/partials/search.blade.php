@canany(['correspondencia_local.crear', 'correspondencia_local.remitente.index', 'correspondencia_local.unidad.index'])
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1 text-right">
            @can('correspondencia_local.crear')
                <a href="{{ route('correspondencia.local.crear') }}" class="tts:left tts-slideIn tts-custom" aria-label="Registrar">
                    <button class="btn btn-sm btn-outline-success font-roboto-12" type="button">
                        <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                    </button>
                </a>
            @endcan
            @can('correspondencia_local.remitente.index')
                <a href="{{ route('correspondencia.local.remitente.index') }}" class="tts:left tts-slideIn tts-custom" aria-label="Ir a remitentes">
                    <button class="btn btn-sm btn-outline-warning font-roboto-12" type="button">
                        <i class="fas fa-users fa-fw"></i>
                    </button>
                </a>
            @endcan
            @can('correspondencia_local.unidad.index')
                <a href="{{ route('correspondencia.local.unidadIndex') }}" class="tts:left tts-slideIn tts-custom" aria-label="Ir a areas">
                    <button class="btn btn-sm btn-outline-info font-roboto-12" type="button">
                        <i class="fas fa-house-damage fa-fw"></i>
                    </button>
                </a>
            @endcan
        </div>
    </div>
@endcanany
