@canany(['correspondencia_local.crear', 'correspondencia_local.remitente.index', 'correspondencia_local.unidad.index'])
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1">
            @can('correspondencia.index')
                <a href="{{ route('correspondencia.index') }}" class="btn btn-warning font-roboto-12">
                    <i class="fa fa-folder fa-fw"></i> Ir a correspondencia anterior
                </a>
            @endcan
            @can('correspondencia_local.unidad.index')
                <a href="{{ route('correspondencia.local.unidadIndex') }}" class="tts:left tts-slideIn tts-custom float-right" aria-label="Ir a areas">
                    <button class="btn btn-outline-info font-roboto-12" type="button">
                        <i class="fas fa-house-damage fa-fw"></i>
                    </button>
                </a>
            @endcan
            @can('correspondencia_local.remitente.index')
                <a href="{{ route('correspondencia.local.remitente.index') }}" class="tts:left tts-slideIn tts-custom float-right mr-1" aria-label="Ir a remitentes">
                    <button class="btn btn-outline-primary font-roboto-12" type="button">
                        <i class="fas fa-users fa-fw"></i>
                    </button>
                </a>
            @endcan
            @can('correspondencia_local.crear')
                <a href="{{ route('correspondencia.local.crear') }}" class="tts:left tts-slideIn tts-custom float-right mr-1" aria-label="Registrar">
                    <button class="btn btn-outline-success font-roboto-12" type="button">
                        <i class="fa fa-plus fa-fw"></i>
                    </button>
                </a>
            @endcan
        </div>
    </div>
@endcanany
