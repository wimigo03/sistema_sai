<form action="{{ route('entregas.update_paquete') }}"  method="post" id="form">
    @csrf
    <input type="hidden" name="id_paquete" id="id_paquete" value="{{$paquetes->id}}" >

    <div class="form-group row font-verdana-bg">
        <div class="col-md-2 pr-1">
            <label for="distrito" class="d-inline">Gestion</label>
            <select name="gestion" id="gestion" placeholder="--Seleccionar--"
                                    class="form-control form-control-sm select" required>
                                    <option value="2023"  @if ($paquetes->gestion == '2023') selected @endif>2023</option>
                                    <option value="2024" @if ($paquetes->gestion == '2024') selected @endif>2024</option>
                                    <option value="2025" @if ($paquetes->gestion == '2025') selected @endif>2025</option>
                                    <option value="2026" @if ($paquetes->gestion == '2026') selected @endif>2026</option>
                                    <option value="2027" @if ($paquetes->gestion == '2027') selected @endif>2027</option>
                                    <option value="2028" @if ($paquetes->gestion == '2028') selected @endif>2028</option>
                                    <option value="2029" @if ($paquetes->gestion == '2029') selected @endif>2029</option>
                                    <option value="2030" @if ($paquetes->gestion == '2030') selected @endif>2030</option>
            </select>
        </div>
        <div class="col-md-2 pr-1">
            <label for="numero" class="d-inline">Gestion</label>
            <select name="numero" id="numero" placeholder="--Seleccionar--"
                                    class="form-control form-control-sm select" required>
                                    <option value="1RA."  @if ($paquetes->numero == '1RA.') selected @endif>1RA.</option>
                                    <option value="2DA."  @if ($paquetes->numero == '2DA.') selected @endif>2DA.</option>
                                    <option value="3RA."  @if ($paquetes->numero == '3RA.') selected @endif>3RA.</option>
                                    <option value="4TA."  @if ($paquetes->numero == '4TA.') selected @endif>4TA.</option>
                                    <option value="5TA."  @if ($paquetes->numero == '5TA.') selected @endif>5TA.</option>
                                    <option value="6TA."  @if ($paquetes->numero == '6TA.') selected @endif>6TA.</option>
                                    <option value="7MA."  @if ($paquetes->numero == '7MA.') selected @endif>7MA.</option>
                                    <option value="8VA."  @if ($paquetes->numero == '8VA.') selected @endif>8VA.</option>
                                    <option value="9NA."  @if ($paquetes->numero == '9NA.') selected @endif>9NA.</option>
                                    <option value="10MA."  @if ($paquetes->numero == '10MA.') selected @endif>10MA.</option>
                                    <option value="10MA.1RA."  @if ($paquetes->numero == '10MA.1RA.') selected @endif>10MA.1RA.</option>
                                    <option value="10MA.2DA."  @if ($paquetes->numero == '10MA.2DA.') selected @endif>10MA.2DA.</option>

            </select>
        </div>
        <div class="col-md-8 pl-1">
            <label for="nombre" class="d-inline">Items</label>
            <textarea type="text" rows="10" class="form-control form-control-sm font-verdana-bg" id="items" name="items" required>{{ $paquetes->items }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="save();">
                <i class="fa-solid fa-paper-plane fa-fw" aria-hidden="true"></i>&nbsp;Procesar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fa-solid fa-xmarkfa-fw"></i>&nbsp;Cancelar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
