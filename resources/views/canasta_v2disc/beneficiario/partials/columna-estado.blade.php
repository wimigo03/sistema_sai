<td class="text-center p-1">
    @switch($estado)
        @case('A')
            <span class="badge-with-padding badge badge-success">
                HABILITADO
            </span>
        @break
        @case('F')
            <span class="badge-with-padding badge badge-danger">
                FALLECIDO
            </span>
        @break
        @case('B')
            <span class="badge-with-padding badge badge-warning">
                BAJA
            </span>
        @break
        @case('X')
            <span class="badge-with-padding badge badge-secondary">
                PENDIENTE
            </span>
        @break
    @endswitch
</td>
