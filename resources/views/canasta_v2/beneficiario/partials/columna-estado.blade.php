<td class="text-center p-1">
    @switch($estado)
        @case('A')
            <span class="badge-with-padding badge badge-success btn-block">
                HABILITADO
            </span>
        @break
        @case('F')
            <span class="badge-with-padding badge badge-danger btn-block">
                FALLECIDO
            </span>
        @break
        @case('B')
            <span class="badge-with-padding badge badge-warning btn-block">
                BAJA
            </span>
        @break
        @case('X')
            <span class="badge-with-padding badge badge-secondary btn-block">
                PENDIENTE
            </span>
        @break
        @case('E')
            <span class="badge-with-padding badge badge-danger btn-block">
                ELIMINADO
            </span>
        @break
    @endswitch
</td>
