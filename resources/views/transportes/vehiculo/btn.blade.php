<center>

      <td style="padding: 0;" class="text-center p-1">
        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
            <a href="{{ route('vehiculo.edit',$idvehiculo) }}">
                <span class="text-primary">
                    <i class="fas fa-xl fa-edit"></i>
                </span>
            </a>
        </span>
    </td>

    &nbsp;&nbsp;&nbsp;
    
    <td style="padding: 0;" class="text-center p-1">
        <span class="tts:left tts-slideIn tts-custom" aria-label="Documentos">
            <a href="{{route('Proveedores.editdoc', $idvehiculo)}}">
                <span class="text-primary">
                    <i class="fas fa-xl fa-file" style="color:orange"></i>
                </span>
            </a>
        </span>
    </td>

</center>