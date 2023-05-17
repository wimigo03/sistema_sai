<center>

    <td style="padding: 0;" class="text-center p-1">
        @can('agenda_edit')
            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Fecha y Hora">
                <a href="{{route('agenda.edit2',$idagenda)}}">
                    <span class="text-warning">
                        <i class="fas fa-xl fa-calendar" style="color:rgb(35, 13, 232)"></i>
                    </span>
                </a>
            </span>
        @endcan
    </td>


</center>
