<div class="form-group row">
    <div class="col-md-2">
        <input type="text" name="unidad" placeholder="--Unidad--" value="{{request('unidad')}}" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-3">
        <input type="text" name="codigo" placeholder="--Codigo--" value="{{request('codigo')}}" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-5">
        <input type="text" name="descripcion" placeholder="--Descripcion--" value="{{request('descripcion')}}" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2 text-right">
        {{--<button class="btn btn-danger font-verdana" type="button" onclick="searchdetallepdf();">
            &nbsp;<i class="fa fa-file-pdf" aria-hidden="true"></i>&nbsp;
        </button>--}}
        <button class="btn btn-primary font-verdana" type="button" onclick="search();">
            <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
        </button>
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
    </div>
</div>