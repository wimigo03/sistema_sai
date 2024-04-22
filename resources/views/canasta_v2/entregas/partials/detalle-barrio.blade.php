<div class="collapse" id="collapseExample4">
    <form action="{{ route('entregas.detalleBarrio') }}" method="get" id="form4" target="_blank">
        @csrf
        <input type="hidden" value="{{ $idpaquete }}" id="idcompra" name="idpaquete">
        <div class="form-group row font-roboto-12">
            <div class="col-md-10">
                <select name="barrio4" id="barrio4" class="form-control form-control-sm">
                    <option value="">-</option>
                    @foreach ($barrios3 as $barrio3)
                        <option value="{{ $barrio3->id }}">{{ $barrio3->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 text-right">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Imprimir">
                    <span class="btn btn-secondary font-roboto-12" onclick="save4();" >
                        <i class="fa fa-print fa-fw" aria-hidden="true"></i>
                    </span>
                </span>
            </div>
        </div>
    </form>
</div>
