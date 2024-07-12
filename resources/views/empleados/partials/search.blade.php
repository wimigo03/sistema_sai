<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-3 pr-1 pl-1">
            <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
            {{--<select name="area_id" id="area_id" class="form-control font-roboto-10">--}}
            <select name="area_id" id="area_id" class="form-control select2 font-roboto-10">
                <option value="">-</option>
                @foreach ($areas as $index => $value)
                    <option value="{{ $index }}" @if(request('area_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="area_asignada_id" id="area_asignada_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($areas as $index => $value)
                    <option value="{{ $index }}" @if(request('area_asignada_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="file_id" id="file_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($cargos as $index => $value)
                    <option value="{{ $index }}" @if(request('file_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="escala_salarial_id" id="escala_salarial_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($escalas_salariales as $index => $value)
                    <option value="{{ $index }}" @if(request('escala_salarial_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nombre" value="{{ request('nombre') }}" id="nombre" placeholder="--Nombre(s)--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="ap_paterno" value="{{ request('ap_paterno') }}" id="ap_paterno" placeholder="--Apellido Paterno--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="ap_materno" value="{{ request('ap_materno') }}" id="ap_materno" placeholder="--Apellido Materno--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nro_carnet" value="{{ request('nro_carnet') }}" id="nro_carnet" placeholder="--Nro carnet--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="sexo" id="sexo" class="form-control select2">
                <option value="">-</option>
                @foreach ($sexos as $index => $value)
                    <option value="{{ $index }}" @if(request('sexo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <select name="tipo" id="tipo" class="form-control select2">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha_ingreso" value="{{ request('fecha_ingreso') }}" id="fecha_ingreso" placeholder="--Ingreso--" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha_retiro" value="{{ request('fecha_retiro') }}" id="fecha_retiro" placeholder="--Retiro--" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha_conclusion_inicio" value="{{ request('fecha_conclusion_inicio') }}" id="fecha_conclusion_inicio" placeholder="--Conclusion Inicio--" class="form-control font-roboto-12 bg-light intro" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha_conclusion_final" value="{{ request('fecha_conclusion_final') }}" id="fecha_conclusion_final" placeholder="--Conclusion Final--" class="form-control font-roboto-12 bg-light intro" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control select2">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6 pr-1 pl-1">
            @can('empleados.create')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Registrar" style="cursor: pointer;">
                    <span class="btn btn-sm btn-outline-success font-verdana" onclick="create();">
                        <i class="fas fa-plus fa-fw"></i>
                    </span>
                </span>
            @endcan
            @can('empleados.show')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Imprimir credenciales" style="cursor: pointer;">
                    <span class="btn btn-sm btn-outline-info font-verdana" onclick="imprimir_credenciales();">
                        <i class="fas fa-address-card fa-fw"></i>
                    </span>
                </span>
            @endcan
            @can('empleados.index')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Exportar a excel" style="cursor: pointer;">
                    <span class="btn btn-sm btn-outline-success font-verdana" onclick="excel();">
                        <i class="fas fa-file-excel fa-fw"></i>
                    </span>
                </span>
            @endcan
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="search();">
                <i class="fas fa-search fa-fw"></i> Buscar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="limpiar();">
                <i class="fas fa-eraser fa-fw"></i> Limpiar
            </span>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
