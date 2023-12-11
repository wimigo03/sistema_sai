@can('codcont_edit')
<center>
    <td style="padding: 0;" class="text-center p-1">
        <a class="tts:left tts-slideIn tts-custom" aria-label="Ver Auxiliares" href="{{ route('activo.auxiliar.index', ['id' => $codcont])}}">
            <button class="btn btn-sm btn-success font-verdana" type="button"><i class="fa fa-eye" aria-hidden="true"></i>
            </button>
        </a>

        @can('codcont_create')

        <a href="{{route('activo.auxiliar.create', ['id' => $codcont])}}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
            <button class="btn btn-sm btn-primary font-verdana" type="button">
                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </a>

        @endcan
    </td>
</center>
@endcan