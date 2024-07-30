<div class="form-group row">
    <div class="col-md-12 text-center">
        <div class="row abs-center">
            <div class="col-md-4 pr-1 pl-1">
                @can('item.index')
                    <span class="btn btn-block btn-outline-dark font-roboto-13" id="btn-item" onclick="get_items();">
                        <i class="fas fa-tags fa-fw"></i> Productos
                    </span>
                @endcan
            </div>
            <div class="col-md-4 pr-1 pl-1">
                @can('unidad.medida.index')
                    <span class="btn btn-block btn-outline-dark font-roboto-13" id="btn-unidad-medida" onclick="get_unidades();">
                        <i class="fas fa-balance-scale fa-fw"></i> Unidades de Medida
                    </span>
                @endcan
            </div>
            <div class="col-md-4 pr-1 pl-1">
                @can('partida.presupuestaria.index')
                    <span class="btn btn-block btn-outline-dark font-roboto-13" id="btn-partida-prespuestaria" onclick="get_partidas_presupuestarias();">
                        <i class="fas fa-file-invoice fa-fw"></i> Partidas Prespuestarias
                    </span>
                @endcan
            </div>
        </div>
    </div>
</div>
