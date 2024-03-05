<div class="row font-verdana-bg flex justify-content-between align-items-center">
    <div class="col-md-8 titulo mb-4">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="javascript:void(0);" onclick="window.history.back()">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
        <b>LISTA DE ACTIVOS DE {{ $empleado->nombres }} {{ $empleado->ap_pat }} {{ $empleado->ap_mat }}</b>
    </div>
    <div class="">
        <span class="tts:left tts-slideIn tts-custom" aria-label="Asignacion Interna de Bienes">
            <button onclick="generarReporteAsignacion()" id="asignacion" class="btn btn-primary" disabled>
                <i class="fa-duotone fa-arrows-turn-right"></i>
            </button>
        </span>
        <span class="tts:left tts-slideIn tts-custom" aria-label="Devolucion Interna de Bienes">
            <button onclick="generarReporteDevolucion()" id="devolucion" class="btn btn-primary" disabled>
                <i class="fa-solid fa-left"></i>
            </button>
        </span>
        <span class="tts:left tts-slideIn tts-custom" aria-label="Kardex de Activos">
            <button onclick="generarReporteKardex()" id="kardex" class="btn btn-primary" disabled>
                <i class="fa-light fa-files"></i>
            </button>
        </span>
        <span class="tts:left tts-slideIn tts-custom" aria-label="Transferir Activos">
            <button id="abrirModal" class="btn btn-primary mb-0" data-toggle="modal" data-target="#miModal" disabled>
                <i class="fa-solid fa-right-left"></i>
            </button>
        </span>
    </div>
</div>
