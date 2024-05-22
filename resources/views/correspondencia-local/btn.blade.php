<td class="text-center p-1">
    <div class="d-flex justify-content-center">
        @canany(['correspondencia_local.gestionar', 'correspondencia_local.urlfile'])
            @can('correspondencia_local.gestionar')
                <span class="tts:left tts-slideIn tts-custom" aria-label="Gestionar correspondencia" style="cursor: pointer;">
                    <a href="{{ route('correspondencia.local.gestionar',$id_recepcion) }}" class="badge-with-padding badge badge-warning">
                        <i class="fas fa-cog fa-fw"></i>
                    </a>
                </span>
                &nbsp;
            @endcan
            @can('correspondencia_local.urlfile')
                @if ($estado_corresp == 0)
                    <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a digital" style="cursor: pointer;">
                        <span class="badge-with-padding badge badge-danger">
                            <i class="fas fa-times-circle fa-fw"></i>
                        </span>
                    </span>
                @else
                    <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a digital" style="cursor: pointer;">
                        <a href="{{ route('correspondencia.local.urlfile',$id_recepcion) }}" class="badge-with-padding badge badge-info" target="_blank">
                            <i class="fas fa-eye fa-fw"></i>
                        </a>
                    </span>
                @endif
                &nbsp;
            @endcan
            @can('correspondencia_local.generar.qr')
                <span class="tts:left tts-slideIn tts-custom" aria-label="Qr" style="cursor: pointer;">
                    <a href="{{ route('correspondencia.local.generar.qr',$id_recepcion) }}" class="badge-with-padding badge badge-dark text-white" target="_blank">
                        <i class="fas fa-qrcode fa-fw"></i>
                    </a>
                </span>
            @endcan
        @endcanany
    </div>
</td>

