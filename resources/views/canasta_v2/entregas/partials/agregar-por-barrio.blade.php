<div class="collapse" id="collapseExample2">
    <form action="{{ route('entregas.agregarporbarrio', $idpaquete) }}" method="post" id="form2">
        @csrf
        <input type="hidden" value="{{ $idpaquete }}" id="idcompra" name="idpaquete">
        <div class="form-group row font-roboto-12">
            <div class="col-md-10">
                <select name="barrio" id="barrio" class="form-control">
                    <option value="">-</option>
                    @foreach ($barrios as $barrio)
                        <option value="{{ $barrio->id }}">{{ $barrio->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 text-right">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Agregar">
                    <span class="btn btn-info font-roboto-12" onclick="save2();">
                        <i class="fa-solid fa-plus fa-fw"></i>
                    </span>
                </span>
            </div>
        </div>
    </form>
</div>
