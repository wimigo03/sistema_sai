<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 text-right">
        @can('archivos.create')
            <span class="tts:left tts-slideIn tts-custom root" aria-label="Registrar archivo" style="cursor: pointer;">
                <a href="{{ route('archivos.create') }}" class="btn btn-sm btn-outline-success font-roboto-12">
                    <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                </a>
            </span>
        @endcan
    </div>
</div>
