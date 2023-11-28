<td style="padding: 0;" class="text-center p-1">
    @can('combustibles_access')
    <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
        <a href="{{route('transportes.pedido.aprovar',$idsoluconsumo)}}"
            onclick="return confirm('Se va a Aprovar la solicitud...')">
            <span class="text-success">
                <i class="fa-solid fa-xl fa-cart-plus" aria-hidden="true"></i>
            </span>
        </a>
    </span>
    @endcan
</td>


