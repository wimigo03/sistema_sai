<td style="padding: 0;" class="text-center p-1">
    @can('combustibles_access')
    <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
        <a href="{{route('transportes.pedido.edit',$idsoluconsumo)}}">
            <span class="text-primary">
                <i class="fa-solid fa-2xl fa-square-info"></i>
            </span>
        </a>
    </span>
    @endcan
</td>