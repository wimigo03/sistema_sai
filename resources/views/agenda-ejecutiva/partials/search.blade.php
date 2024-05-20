<form action="#" method="get" id="form">
    <input type="hidden" value="{{ $date }}" id="date">
    <div class="form-group row">
        <div class="col-md-4 pr-1 pl-1">
            <span class="btn btn-outline-primary font-roboto-12" onclick="limpiar();">
                <i class="fa-solid fa-angles-left fa-fw"></i> Ir atras
            </span>
        </div>
        <div class="col-md-4 pr-1 pl-1 text-center font-roboto-25">
            <b class="text-dark"><u>{{ $fechaliteral }}</u></b>
        </div>
        <div class="col-md-4 pr-1 pl-1 text-right">
            @can('agenda.ejecutiva.create')
                <span class="tts:left tts-slideIn tts-custom" aria-label="Crear Evento">
                    <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                        <i class="fa fa-plus"></i>
                    </span>
                    <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </span>
            @endcan
            @can('agenda.ejecutiva.pdf')
                <span class="tts:left tts-slideIn tts-custom" aria-label="Imprimir">
                    <span class="btn btn-outline-warning font-roboto-12" onclick="print();">
                        <i class="fa fa-print" aria-hidden="true"></i> Imprimir
                    </span>
                </span>
            @endcan
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
