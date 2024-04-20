<form action="{{ route('entregas.store_paquete') }}"  method="post" id="form">
    @csrf
    <div class="form-group row font-roboto-12">
        <div class="col-md-3 pr-1 pl-1">
            <label for="distrito" class="d-inline"><b>Gestion</b></label>
            <select name="gestion" id="gestion" placeholder="--Seleccionar--" class="form-control select2" required>
                <option value="">-</option>
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
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-9 pr-1 pl-1">
            <label for="nombre" class="d-inline"><b>Items</b></label>
            <textarea type="text" rows="10" class="form-control font-roboto-12" id="items" name="items" required></textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="save();">
                <i class="fa-solid fa-paper-plane fa-fw" aria-hidden="true"></i>&nbsp;Procesar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
