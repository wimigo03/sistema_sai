<td style="padding: 0;" class="text-center p-1">
    <span class="tts:left tts-slideIn tts-custom" aria-label="Enviar a Almacen">



        <a href="{{route('compras.pedido.enviar', $compras->idcompra) }}" onclick="return confirm('Se va a enviar la compra a almacen, esta ud. seguro ?...')">
            <span class="text-info">
                <i class="fa-solid fa-2xl fa-cart-plus"></i>
            </span>
        </a>
    </span>
</td>
