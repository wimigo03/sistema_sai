@can('correspondencia_local.gestionar')
    <td class="text-center p-1">
        <div class="d-flex justify-content-center">
            <span class="tts:left tts-slideIn tts-custom" aria-label="Gestionar correspondencia" style="cursor: pointer;">
                <a href="{{ route('correspondencia.local.gestionar',$id_recepcion) }}" class="badge-with-padding badge badge-warning">
                    <i class="fas fa-cog fa-fw"></i>
                </a>
            </span>
        </div>
    </td>
@endcan

