<form action="#" method="get" id="form">
    <div class="form-group row">


        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nombre" placeholder="-- Nombres --" value="{{ request('nombre') }}"
                class="form-control form-control-sm font-verdana-bg intro">
        </div>

        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="ap" placeholder="-- Ap.Paterno --" value="{{ request('ap') }}"
                class="form-control form-control-sm font-verdana-bg intro">
        </div>

        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="am" placeholder="-- Ap.Materno --" value="{{ request('am') }}"
                class="form-control form-control-sm font-verdana-bg intro">
        </div>

        <div class="col-md-3 pl-1">
            <select name="area" id="area" class="form-control form-control-sm">
                <option value="">-</option>
                @foreach ($areas as $index => $value)
                    <option value="{{ $index }}" @if (request('area') == $index) selected @endif>
                        {{ $value }}</option>
                @endforeach
            </select>

        </div>
         {{-- COMPRAS combustible
        <div class="col-md-3 pl-1">
            <select name="nivell" id="nivell" class="form-control form-control-sm">
                <option value="">-</option>
                @foreach ($niveles as $index => $value)
                    <option value="{{ $index }}" @if (request('nivell') == $index) selected @endif>
                        {{ $value }}</option>
                @endforeach
            </select>

        </div>
        --}}
    </div>

    <div class="form-group row">
        <div class="col-md-6">

        </div>


        <div class="col-md-6 text-right">

            @if ($estado1 == 1)
                <button class="btn btn-outline-info font-verdana" type="button" onclick="procesar2();">
                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Cargar
                </button>
                </button>
            @else
            @endif

            <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="limpiar();">
                &nbsp;<i class="fa fa-eraser"></i>&nbsp;Limpiar
            </button>
        </div>
    </div>
</form>
