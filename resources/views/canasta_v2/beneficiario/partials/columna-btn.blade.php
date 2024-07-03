<td class="text-center p-1">
    @canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.datos'])
        <div class="d-flex justify-content-center">
            @can('canasta.beneficiarios.editar')
                <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                    <a href="{{ route('beneficiarios.editar', $beneficiario_id) }}" class="badge-with-padding badge badge-warning">
                        <i class="fa-solid fa-pen-to-square fa-fw"></i>
                    </a>
                </span>
                &nbsp;
            @endcan
            @can('canasta.beneficiarios.show')
                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a kardex">
                    <a href="{{ route('beneficiarios.show', $beneficiario_id) }}" class="badge-with-padding badge badge-info" target="_blank">
                        <i class="fa fa-list fa-fw" aria-hidden="true"></i>
                    </a>
                </span>
                &nbsp;
            @endcan
        </div>
    @endcanany
</td>
