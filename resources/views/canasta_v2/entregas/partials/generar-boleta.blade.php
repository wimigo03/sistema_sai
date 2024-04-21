<div class="collapse" id="collapseExample3">
    <form action="{{ route('entregas.generarboleta') }}" method="get" id="form3" target="_blank">
        @csrf
        <input type="hidden" value="{{ $idpaquete }}" id="idcompra" name="idpaquete">
        <div class="form-group row font-roboto-12">
            <div class="col-md-10">
                <select name="barrio3" id="barrio3" class="form-control form-control-sm">
                    <option value="">-</option>
                    @foreach ($barrios3 as $barrio3)
                        <option value="{{ $barrio3->id }}">{{ $barrio3->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 text-right">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Imprimir">
                    <span class="btn btn-secondary font-roboto-12" onclick="save3();" >
                        <i class="fa fa-print fa-fw" aria-hidden="true"></i>
                    </span>
                </span>
            </div>
        </div>
    </form>
</div>
