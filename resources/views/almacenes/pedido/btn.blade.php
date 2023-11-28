
<td style="padding: 0;" class="text-center p-1">
     @can('combustibles_access') 
        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
            <a href="{{route('almacenes.pedido.editar',$idvale)}}">
                <span class="text-warning">
                    <i class="fa-solid fa-2xl fa-square-pen"></i>
                </span>
            </a>
        </span>
     @endcan 
</td>

