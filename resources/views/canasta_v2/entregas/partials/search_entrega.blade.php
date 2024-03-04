<form action="#" method="get" id="form">
    <div class="form-group row">

        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nombres" placeholder="-- Nombres --" value="{{request('nombres')}}" class="form-control form-control-sm font-verdana-12 intro">
        </div>

        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="ap" placeholder="-- Ap.Paterno --" value="{{request('ap')}}" class="form-control form-control-sm font-verdana-12 intro">
        </div>

        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="am" placeholder="-- Ap.Materno --" value="{{request('am')}}" class="form-control form-control-sm font-verdana-12 intro">
        </div>

        <div class="col-md-1 pr-1 pl-1">
            <input type="text" name="ci" placeholder="-- C.i. --" value="{{request('ci')}}" class="form-control form-control-sm font-verdana-12 intro">
        </div>



        <div class="col-md-3 pl-1">
            <select name="barrio"  id="barrio2" class="form-control form-control-sm">
                <option value="">-</option>
                @foreach ($barrios2 as $barrio)
                <option value="{{ $barrio->nombre }}">{{ $barrio->nombre }}</option>
            @endforeach
            </select>

        </div>

    </div>

    <div class="form-group row">
        <div class="col-md-6">

        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="limpiar();">
                &nbsp;<i class="fa fa-eraser"></i>&nbsp;Limpiar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
    </div>
</form>
