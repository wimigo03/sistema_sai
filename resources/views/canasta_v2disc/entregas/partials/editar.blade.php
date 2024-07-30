<form action="#"  method="post" id="form">
    @csrf
    <input type="hidden" name="entrega_id" value="{{ $entrega->id }}" id="entrega_id">
    <input type="hidden" name="paquete_id" value="{{ $entrega->id_paquete }}" id="paquete_id">
    <input type="hidden" name="paquete_barrio_id" value="{{ $entrega->paquete_barrio_id }}" id="paquete_barrio_id">
    <div class="form-group row abs-center">
        <div class="col-md-4 pr-1 pl-1">
            <select name="barrio_id"  id="barrio_id" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($barrios as $index => $value)
                    <option value="{{ $index }}" @if(old('barrio_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row abs-center">
        <div class="col-md-4 pr-1 pl-1 text-center">
            <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                <i class="fa fa-paper-plane fa-fw" aria-hidden="true"></i>&nbsp;Procesar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fa fa-times fa-fw" aria-hidden="true"></i>&nbsp;Cancelar
            </span>
        </div>
    </div>
</form>
