<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-3 pr-1">
            <input type="text" name="nombre" value="{{request('nombre')}}" placeholder="--Nombres--" class="form-control form-control-sm font-verdana-bg intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="ap_pat" value="{{request('ap_pat')}}" placeholder="--Ap. Paterno--" class="form-control form-control-sm font-verdana-bg intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="ap_mat" value="{{request('ap_mat')}}" placeholder="--Ap. Materno--" class="form-control form-control-sm font-verdana-bg intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="username" value="{{request('username')}}" placeholder="--Usuario--" class="form-control form-control-sm font-verdana-bg intro">
        </div>
        <div class="col-md-3 pl-1">
            <input type="text" name="email" value="{{request('email')}}" placeholder="--Email--" class="form-control form-control-sm font-verdana-bg intro">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-2 pr-1">
            <input type="text" name="role" value="{{request('role')}}" placeholder="--Role--" class="form-control form-control-sm font-verdana-bg intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control form-control-sm font-verdana-bg">
                <option value="">-</option>
                <option value="1" @if(request('estado') == '1') selected @endif >HABILITADOS</option>
                <option value="0" @if(request('estado') == '0') selected @endif >NO HABILITADOS</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            @can('users.create')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Crear Nuevo Usuario">
                    <button class="btn btn-sm btn-outline-success font-verdana" type="button" onclick="create();">
                        &nbsp;<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
                    </button>
                </span>
            @endcan
            @can('users.excel')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Exportar a Excel">
                    <button class="btn btn-sm btn-outline-success font-verdana" type="button" onclick="excel();">
                        &nbsp;<i class="fa fa-file-excel" aria-hidden="true"></i>&nbsp;
                    </button>
                </span>
            @endcan
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="limpiar();">
                &nbsp;<i class="fa fa-eraser"></i>&nbsp;Limpiar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
