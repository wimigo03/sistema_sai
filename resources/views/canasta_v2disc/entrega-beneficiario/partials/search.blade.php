<form action="#" method="get" id="form">
    <div class="form-group row abs-center">
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="codigo" value="{{ request('codigo') }}" id="codigo" placeholder="--Codigo--" class="form-control font-roboto-12 intro text-center">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1 text-center">
            <span class="btn btn-outline-primary font-roboto-12" onclick="search();">
                <i class="fa fa-search fa-fw" aria-hidden="true"></i>&nbsp;Procesar
            </span>
        </div>
    </div>
</form>
