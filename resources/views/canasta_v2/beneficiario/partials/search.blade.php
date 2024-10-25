<form action="#" method="get" id="form">
    <div class="row">
        {{--<div class="col-md-2 pr-1 pl-1">
            <input type="text" name="codigo" placeholder="-- Codigo --" value="{{ request('codigo') }}" class="form-control font-roboto-12 intro" onkeypress="return valideNumberInteger(event);">
        </div>--}}
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <select name="distrito"  id="id_distrito" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($distritos as $index => $value)
                    <option value="{{ $index }}" @if(request('distrito') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1 mb-2">
            <input type="hidden" value="{{ request('_id_barrio') }}" id="_id_barrio">
            <select name="barrio" id="id_barrio" class="form-control font-roboto-12">
                <option value="">-</option>
                {{--@foreach ($barrios as $index => $value)
                    <option value="{{ $index }}" @if(request('barrio') == $index) selected @endif >{{ $value }}</option>
                @endforeach--}}
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1 mb-2">
            <input type="text" name="nombre_completo" id="nombre_completo" placeholder="-- Nombre Completo --" value="{{ request('nombre_completo') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <input type="text" name="ci" id="ci" placeholder="--N° de carnet--" value="{{ request('ci') }}" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-1 pr-1 pl-1 mb-2">
            <select name="sexo" id="sexo" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($sexos as $index => $value)
                    <option value="{{ $index }}" @if(request('sexo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1 pr-1 pl-1 mb-2">
            <input type="text" name="edad_inicial" id="edad_inicial" value="{{ request('edad_inicial') }}" id="edad_inicial" placeholder="--Edad (1)--" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-1 pr-1 pl-1 mb-2">
            <input type="text" name="edad_final" id="edad_final" value="{{ request('edad_final') }}" id="edad_final" placeholder="--Edad (2)--" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-3 pr-1 pl-1 mb-2">
            <select name="id_ocupacion"  id="id_ocupacion" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($ocupaciones as $index => $value)
                    <option value="{{ $index }}" @if(request('id_ocupacion') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <select name="estado" id="estado" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1 mb-2">
            <select name="usuario"  id="usuario" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($usuarios as $index => $value)
                    <option value="{{ $index }}" @if(request('usuario') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <select name="estado_censo" id="estado_censo" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($estados_censo as $index => $value)
                    <option value="{{ $index }}" @if(request('estado_censo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <input type="text" name="finicial" value="{{ request('finicial') }}" id="finicial" placeholder="(Inscritos) desde" class="form-control font-roboto-12" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <input type="text" name="ffinal" value="{{ request('ffinal') }}" id="ffinal" placeholder="(Inscritos) hasta" class="form-control font-roboto-12" data-language="es">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 pr-1 pl-1 mb-2">
            @can('canasta.beneficiarios.create')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Registrar" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                        <i class="fa fa-plus fa-fw"></i>
                    </span>
                </span>
            @endcan
            @can('canasta.beneficiarios.excel')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Exportar a excel" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="excel();">
                        <i class="fa-solid fa-file-excel fa-fw"></i>
                    </span>
                </span>
            @endcan
            @can('canasta.beneficiarios.pdf.listar')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Exportar a pdf" style="cursor: pointer;">
                    <span class="btn btn-outline-danger font-roboto-12" onclick="pdf();">
                        <i class="fa-solid fa-file-pdf fa-fw"></i>
                    </span>
                </span>
            @endcan
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
            <span class="btn btn-outline-danger font-roboto-12 float-right" onclick="limpiar();">
                <i class="fa fa-eraser fa-fw"></i>&nbsp;Limpiar
            </span>
            <span class="btn btn-outline-primary font-roboto-12 float-right mr-1" onclick="procesar();">
                <i class="fa fa-search fa-fw" aria-hidden="true"></i>&nbsp;Buscar
            </span>
        </div>
    </div>
</form>
