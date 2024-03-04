<form action="#" method="get" id="form">
    <div class="form-group row">


        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="gestion" placeholder="-- Gestion --" value="{{request('gestion')}}" class="form-control form-control-sm font-verdana-bg intro">
        </div>

        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="periodo" placeholder="-- Periodo --" value="{{request('periodo')}}" class="form-control form-control-sm font-verdana-bg intro">
        </div>






    </div>

    <div class="form-group row">
        <div class="col-md-6">


            <a href="#create" data-toggle="modal">
                <button class="btn btn-outline-primary font-verdana" type="button" >
                    &nbsp;<i class="fa fa-plus"></i>&nbsp;Crear Nuevo Paquete
                </button>
                <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
            </a>



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
