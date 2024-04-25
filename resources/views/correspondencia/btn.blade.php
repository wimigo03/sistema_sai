<td class="text-center p-1">
    <div class="d-flex justify-content-center">
        @can('correspondencia.index')
            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Codigo" style="cursor: pointer;">
                <a href="{{ route('correspondencia.edit',$id_recepcion) }}" class="badge-with-padding badge badge-warning text-white">
                    <i class="fas fa-edit fa-fw"></i>
                </a>
            </span>
        @endcan
    </div>
</td>

