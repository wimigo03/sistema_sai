@can('correspondencia_local.urlfile')
    <td class="text-center p-1">
        <div class="d-flex justify-content-center">
            <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a digital" style="cursor: pointer;">
                <a href="{{ route('correspondencia.local.urlfile',$data->id_recepcion) }}" class="badge-with-padding badge badge-info" target="_blank">
                    <i class="fas fa-eye fa-fw"></i>
                </a>
            </span>
        </div>
    </td>
@endcan
