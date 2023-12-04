
<td style="padding: 0;" class="text-center p-1">
     @can('solunidadconsumo_ver') 
        <span class="tts:left tts-slideIn tts-custom" aria-label="Visualizar">
            <a href="{{route('transportes.pedido.editar',$idsoluconsumo)}}">
                <span class="text-primary" >
                    <i class="fa fa-eye fa-lg" style="color:rgb(87, 58, 231)"></i>
                </span>
            </a>
        </span>
     @endcan 
</td>

