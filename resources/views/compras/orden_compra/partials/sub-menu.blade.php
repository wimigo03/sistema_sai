<div class="form-group row">
    @can('orden.compra.index')
        <div class="col-md-3 pr-1 pl-1">
            <a href="{{ route('orden.compra.index') }}" id="menu-orden-compra" class="btn btn-lg btn-block btn-outline-dark font-roboto-12">
                <i class="fas fa-shopping-cart fa-fw"></i>&nbsp;<u>Ordenes de Compra</u>
            </a>
        </div>
    @endcan
    @can('proveedor.index')
        <div class="col-md-3 pr-1 pl-1">
            <a href="{{ route('proveedor.index') }}" id="menu-proveedor" class="btn btn-lg btn-block btn-outline-dark font-roboto-12">
                <i class="fa fa-users fa-fw"></i>&nbsp;<u>Proveedores</u>
            </a>
        </div>
    @endcan
    @can('programa.index')
        <div class="col-md-3 pr-1 pl-1">
            <a href="{{ route('programa.index') }}" id="menu-programa" class="btn btn-lg btn-block btn-outline-dark font-roboto-12">
                <i class="fa-solid fa-list fa-fw"></i>&nbsp;<u>Programas</u>
            </a>
        </div>
    @endcan
    @can('categoria.programatica.index')
        <div class="col-md-3 pr-1 pl-1">
            <a href="{{ route('categoria.programatica.index') }}" id="menu-categoria-programatica" class="btn btn-lg btn-block btn-outline-dark font-roboto-12">
                <i class="fa-solid fa-list fa-fw"></i>&nbsp;<u>Categorias Programaticas</u>
            </a>
        </div>
    @endcan
</div>
