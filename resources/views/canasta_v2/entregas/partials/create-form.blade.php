<form action="{{ route('entregas.store_paquete') }}"  method="post" id="form">
    @csrf
    <div class="form-group row font-verdana-bg">
        <div class="col-md-3 pr-1">
            <label for="distrito" class="d-inline">Gestion</label>
            <select name="gestion" id="gestion" placeholder="--Seleccionar--"
                                    class="form-control form-control-sm select" required>
                                    <option value="">-- Seleccione --</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                </select>
        </div>
        <div class="col-md-9 pl-1">
            <label for="nombre" class="d-inline">Items</label>
            <textarea type="text" rows="10" class="form-control form-control-sm font-verdana-bg" id="items" name="items" required></textarea>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 text-right">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="save();">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="cancelar();">
                &nbsp;<i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
