<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="nombre" value="{{request('nombre')}}" placeholder="--Nombres--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="ap_pat" value="{{request('ap_pat')}}" placeholder="--Ap. Paterno--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="ap_mat" value="{{request('ap_mat')}}" placeholder="--Ap. Materno--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="username" value="{{request('username')}}" placeholder="--Usuario--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="email" value="{{request('email')}}" placeholder="--Email--" class="form-control font-roboto-12 intro">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="role" value="{{request('role')}}" placeholder="--Role--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control font-roboto-12">
                <option value="">-</option>
                <option value="1" @if(request('estado') == '1') selected @endif >HABILITADOS</option>
                <option value="0" @if(request('estado') == '0') selected @endif >NO HABILITADOS</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6 pr-1 pl-1">
            @can('users.create')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Crear">
                    <span class="btn btn-outline-success font-roboto-12 float-left" onclick="create();">
                        <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                    </span>
                </span>
            @endcan
            @can('users.excel')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Exportar a Excel">
                    <span class="btn btn-outline-success font-roboto-12 float-left" onclick="excel();">
                        <i class="fa fa-file-excel fa-fw" aria-hidden="true"></i>
                    </span>
                </span>
            @endcan
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="search();">
                <i class="fa fa-search fa-fw" aria-hidden="true"></i> Buscar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="limpiar();">
                <i class="fa fa-eraser fa-fw"></i> Limpiar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
