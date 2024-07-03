<div class="collapse" id="collapseExample6">
    <form action="{{ route('entregas.confirmar_entrega') }}" method="get" id="form6" >
        @csrf
        <input type="hidden" value="{{ $idpaquete }}" id="idcompra" name="idpaquete">
        <div class="form-group row font-roboto-12">
            <div class="col-md-6">
                <select name="barrio6" id="barrio6" class="form-control form-control-sm">
                    <option value="">-</option>
                    @foreach ($barrios4 as $barrio4)
                        <option value="{{ $barrio4->id }}">{{ $barrio4->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 text-right">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Confirmar">
                    <span class="btn btn-info font-roboto-12" onclick="save6();" >
                        <i class="fa fa-check fa-fw" aria-hidden="true"></i>
                    </span>
                </span>
            </div>
        </div>
    </form>
</div>
