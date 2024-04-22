<div class="collapse" id="collapseExample5">
    <form action="{{ route('entregas.detalleBarrio2') }}" method="get" id="form5" target="_blank">
        @csrf
        <input type="hidden" value="{{ $idpaquete }}" id="idcompra" name="idpaquete">
        <div class="form-group row font-roboto-12">
            <div class="col-md-6">
                <select name="barrio5" id="barrio5" class="form-control form-control-sm">
                    <option value="">-</option>
                    @foreach ($barrios3 as $barrio3)
                        <option value="{{ $barrio3->id }}">{{ $barrio3->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 text-right">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Imprimir">
                    <span class="btn btn-secondary font-roboto-12" onclick="save5();" >
                        <i class="fa fa-print fa-fw" aria-hidden="true"></i>
                    </span>
                </span>
            </div>
        </div>
    </form>
</div>
