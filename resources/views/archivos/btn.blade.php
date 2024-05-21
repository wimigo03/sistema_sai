<td class="text-center p-1">
    @canany(['archivos.documentacion','archivos.editar','archivos.generar.qr'])
        <div class="d-flex justify-content-center">
            @can('archivos.documentacion')
                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a documento" style="cursor: pointer;">
                    <a href="{{ route('archivos.documentacion',$idarchivo) }}" class="badge-with-padding badge badge-primary" target="_blank">
                        <i class="fas fa-file fa-fw"></i>
                    </a>
                </span>
                &nbsp;
            @endcan
            @can('archivos.editar')
                <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                    <a href="{{ route('archivos.editar',$idarchivo) }}" class="badge-with-padding badge badge-warning">
                        <i class="fas fa-edit fa-fw"></i>
                    </a>
                </span>
                &nbsp;
            @endcan
            @can('archivos.generar.qr')
                <span class="tts:left tts-slideIn tts-custom" aria-label="Qr" style="cursor: pointer;">
                    <a href="{{ route('archivos.generar.qr',$idarchivo) }}" class="badge-with-padding badge badge-dark text-white" target="_blank">
                        <i class="fas fa-qrcode fa-fw"></i>
                    </a>
                </span>
            @endcan
        </div>
    @endcanany
</td>
