<div class="row mb-3">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr class="font-roboto-13">
                    @can('farmacias.index')
                        <td class="text-center p-2 text-nowrap">
                            <b><i class="fa-solid fa-trash fa-fw"></i></b>
                        </td>
                    @endcan
                    <td class="text-center p-2 text-nowrap"><b>FECHA TURNO</b></td>
                    <td class="p-2 text-nowrap"><b>FARMACIA</b></td>
                    <td class="p-2 text-nowrap"><b>DIRECCION</b></td>
                    <td class="text-center p-2 text-nowrap"><b>MAPS</b></td>
                    @can('farmacias.index')
                        <td class="text-center p-2 text-nowrap">
                            <b><i class="fa-solid fa-bars fa-fw"></i></b>
                        </td>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($farmaciasTurnos as $datos)
                    <tr class="font-roboto-13">
                        @can('farmacias.index')
                            <td class="text-center p-2 text-nowrap">
                                <span class="tts:right tts-slideIn tts-custom" aria-label="Eliminar" style="cursor: pointer;">
                                    <a href="{{ route('farmacias.turnos.delete',$datos->id) }}" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash fa-fw"></i>
                                    </a>
                                </span>
                            </td>
                        @endcan
                        <td class="text-center p-2 text-nowrap">{{ \Carbon\Carbon::parse($datos->fecha_i)->format('d-m-Y') }}</td>
                        @if (isset($datos->farmacia))
                            <td class="p-2 text-nowrap">{{ strtoupper($datos->farmacia->nombre) }}</td>
                            <td class="p-2 text-nowrap" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                {{ strtoupper($datos->farmacia->direccion) }}
                            </td>
                            <td class="text-center p-2 text-nowrap">
                                @if ($datos->farmacia->lat != null && $datos->farmacia->lng != null)
                                    <a href="https://google.com/maps/place/{{ $datos->farmacia->lat }},{{ $datos->farmacia->lng }}" target="_blank">
                                        <i class="fa-solid fa-location-dot fa-lg text-danger"></i>
                                    </a>
                                @else
                                    <i class="fa-solid fa-location-dot fa-lg text-secondary"></i>
                                @endif
                            </td>
                        @else
                            <td class="p-2 text-nowrap">&nbsp;</td>
                            <td class="p-2 text-nowrap">&nbsp;</td>
                            <td class="p-2 text-nowrap">&nbsp;</td>
                        @endif
                        @can('farmacias.index')
                            <td class="text-center p-2 text-nowrap">
                                {{-- BOTON DE MODIFICAR--}}
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                    <a href="#"
                                    class="btn btn-sm btn-warning btn-edit"
                                    data-toggle="modal"
                                    data-target="#modalModificar"
                                    data-id="{{ $datos->id }}">
                                        <i class="fas fa-edit fa-fw"></i>
                                    </a>
                                </span>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="font-roboto-14">
                        {{ $farmaciasTurnos->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$farmaciasTurnos->count()}}</strong> registros de
                            <strong>{{$farmaciasTurnos->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


{{-- MODAL: MODIFICAR TURNO --}}
<div class="modal fade font-verdana-bg" id="modalModificar" tabindex="-1" role="dialog" aria-labelledby="modalModificarLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formModificar" action="{{ route('farmacias.turnos.update') }}" method="POST" class="modal-content">
      @csrf
      {{-- Si prefieres PUT/PATCH, agrega @method('PUT') o @method('PATCH') --}}
      <div class="modal-header">
        <h5 class="modal-title" id="modalModificarLabel">
          <i class="fa fa-lg fa-pen text-warning" aria-hidden="true"></i>&nbsp;Modificar
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        {{-- ID del turno (hidden) --}}
        <input type="hidden" name="farmacia_turno_id" id="farmacia_turno_id">

        {{-- Ejemplo de campos opcionales (agrega lo que realmente edites) --}}
        <div class="form-group mb-2">
          <label class="font-roboto-14 mb-1">Farmacia de turno</label>
            <select name="farmacia_id" id="farmacia_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($farmacias as $index => $value)
                    <option value="{{ $index }}"
                        @if (isset($farmacia) && $farmacia->id == $index)
                            selected
                        @elseif (old('farmacia_id') == $index)
                            selected
                        @endif>
                        {{ strtoupper($value) }}
                    </option>
                @endforeach
            </select>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fa fa-times fa-fw"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-primary btn-submit">
          <i class="fa fa-pencil-alt fa-fw"></i> Guardar cambios
        </button>
      </div>
    </form>
  </div>
</div>
