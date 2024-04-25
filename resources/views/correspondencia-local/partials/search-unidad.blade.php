<div class="form-group row font-roboto-12">
    <div class="col-md-6 pr-1 pl-1">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Ir atras" style="cursor: pointer;">
            <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="cancelar();">
                <i class="fas fa-arrow-left fa-fw"></i>
            </button>
        </span>
    </div>
    <div class="col-md-6 pr-1 pl-1 text-right">
        <a href="{{ route('correspondencia.local.lugar.crear') }}" class="tts:left tts-slideIn tts-custom" aria-label="Registrar">
            <button class="btn btn-outline-success font-roboto-12" type="button">
                <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
            </button>
        </a>
    </div>
</div>
