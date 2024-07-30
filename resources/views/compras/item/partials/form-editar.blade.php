<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="item_id" id="item_id" value="{{ $item->id }}">
    <input type="hidden" id="old_partida_presupuestaria_id" value="{{ $item->partida_presupuestaria_id }}">
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="categoria_programatica_id" class="d-inline"><b>Partida Presupuestaria: </b></label>
        </div>
        <div class="col-md-7 pr-1 pl-1">
            <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control select2">
                @foreach ($categorias_programaticas as $old_categoria_programatica)
                    <option value="{{ $old_categoria_programatica->id }}"
                        @if($old_categoria_programatica->id == old('categoria_programatica_id') || (isset($item) && $item->categoria_programatica_id == $old_categoria_programatica->id))
                            selected
                        @endif>
                        {{ $old_categoria_programatica->categoria_programatica }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="partida_presupuestaria_id" class="d-inline"><b>Partida Presupuestaria: </b></label>
        </div>
        <div class="col-md-7 pr-1 pl-1">
            <select name="partida_presupuestaria_id" id="partida_presupuestaria_id" class="form-control select2">
                {{--@foreach ($partidas_presupuestarias as $old_partida_presupuestaria)
                    <option value="{{ $old_partida_presupuestaria->id }}"
                        @if($old_partida_presupuestaria->id == old('partida_presupuestaria_id') || (isset($item) && $item->partida_id == $old_partida_presupuestaria->id))
                            selected
                        @endif>
                        {{ $old_partida_presupuestaria->partida_presupuestaria }}
                    </option>
                @endforeach--}}
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="nombre" class="d-inline"><b>Nombre: </b></label>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="nombre" value="{{ $item->nombre }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="unidad_id" class="d-inline"><b>Unidad de Medida: </b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="unidad_id" id="unidad_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($unidades as $unidad)
                    <option value="{{ $unidad->id }}"
                        @if($unidad->id == old('unidad_id') || (isset($item) && $item->unidad_id == $unidad->id))
                            selected
                        @endif>
                        {{ $unidad->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="precio" class="d-inline"><b>Precio: </b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="precio" value="{{ $item->precio }}" id="precio" class="form-control font-roboto-12 input-numero-cleave">
        </div>
    </div>
    {{--<div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="tipo" class="d-inline"><b>Tipo: </b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="tipo" id="tipo" class="form-control select2">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if($item->tipo == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>--}}
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="detalle" class="d-inline"><b>Descripcion: </b></label>
        </div>
        <div class="col-md-7 pr-1 pl-1">
            <textarea name="detalle" id="detalle" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">{{ $item->detalle }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1">
            @can('item.habilitar')
                @if($item->estado == '1')
                    <span class="btn btn-outline-danger font-roboto-12" onclick="inhabilitar();">
                        <i class="fas fa-ban fa-fw"></i> Inhabilitar
                    </span>
                @else
                    <span class="btn btn-outline-success font-roboto-12" onclick="habilitar();">
                        <i class="far fa-check-circle fa-fw"></i> Habilitar
                    </span>
                @endif
            @endcan
            <span class="btn btn-outline-danger font-roboto-12 float-right" onclick="cancelar();">
                <i class="fas fa-times fa-fw"></i> Cancelar
            </span>
            @if($item->estado == '1')
                <span class="btn btn-outline-primary font-roboto-12 float-right mr-1" onclick="procesar();">
                    <i class="fas fa-paper-plane fa-fw"></i> Procesar
                </span>
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            @endif
        </div>
    </div>
</form>
