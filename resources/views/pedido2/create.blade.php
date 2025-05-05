@extends('layouts.dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
        <div class="card-header bg-gradient-secondary text-white rounded d-flex flex-row-reverse" style="color:black;font-weight: bold;font-size: 16px;"><font >AGREGAR SOLICITUD</font></div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <a href="{{ url('/compras/pedido') }}" class="btn blue darken-4 text-black "><i
                        class="fa fa-plus-square"></i> Volver atras</a>
            </div>
        </div>
    </div>
    <div class="card-body">
    <form method="POST" action="{{ route('pedido.store') }}">
                @csrf

                <div class="form-group row">
                <label for="objeto" class="required col-md-4 col-form-label text-md-right">{{ __('Objeto') }}</label>
                    <div class="col-md-6">
                        <textarea  required id="objeto" type="text" name="objeto" cols="60" rows="3" placeholder="Objeto..."
                        onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                <label for="justificacion" class="required col-md-4 col-form-label text-md-right">{{ __('Justificacion') }}</label>
                    <div class="col-md-6">
                        <textarea  id="detalle" type="text" name="justificacion" cols="60" rows="8" placeholder="Detalle..."
                        onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                    </div>
                </div>
            <div class="form-group row">
                <label for="preventivo" class="required col-md-4 col-form-label text-md-right">{{ __('Preventivo') }}</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="preventivo" placeholder=""
                        >
                </div>
            </div>
            <div class="form-group row">
                <label for="tipo" class="required col-md-4 col-form-label text-md-right">{{ __('Tipo') }}</label>
                <div class="col-md-2">
                    <select name="tipo" class="form-control"  >



                        <option value="1" >Producto</option>
                        <option value="2">Servicio</option>

                    </select>

                </div>
            </div>

            <div class="form-group row">
                <label for="numcompra" class="required col-md-4 col-form-label text-md-right">{{ __('Num.Compra') }}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="numcompra" placeholder=""
                    onchange="javascript:this.value=this.value.toUpperCase();">
                </div>
            </div>
            <div class="form-group row">
                <label for="controlinterno" class="required col-md-4 col-form-label text-md-right">{{ __('Cont.Interno') }}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="controlinterno" placeholder="" >
                </div>
            </div>





            <div class="form-group row">
                <label class="required col-md-4 col-form-label text-md-right">{{ __('Area') }}</label>
                <div class="col-md-6" id="permissions-select">

                    <select name="idarea" id="permissions" class="col-md-8">
                        @foreach ($areas as $area)

                        <option value="{{$area->idarea}}" selected>{{$area->nombrearea}}</option>

                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="required col-md-4 col-form-label text-md-right">{{ __('Programa') }}</label>
                <div class="col-md-6" id="permissions-select2">

                    <select name="idprograma" id="permissions" class="col-md-10">
                        @foreach ($programas as $programa)

                        <option value="{{$programa->idprograma}}" selected>{{$programa->nombreprograma}}</option>

                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="required col-md-4 col-form-label text-md-right">{{ __('Cat.Programatica') }}</label>
                <div class="col-md-6" id="permissions-select3">

                    <select name="idcatprogramatica" id="permissions" class="col-md-8">
                        @foreach ($catprogramaticas as $catprogramatica)

                        <option value="{{$catprogramatica->idcatprogramatica}}" selected>{{$catprogramatica->nombrecatprogramatica}}</option>

                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="required col-md-4 col-form-label text-md-right">{{ __('Proveedor') }}</label>
                <div class="col-md-6" id="permissions-select4">

                    <select name="idproveedor" id="permissions" class="col-md-8">
                        @foreach ($proveedores as $proveedor)

                        <option value="{{$proveedor->idproveedor}}" selected>{{$proveedor->nombreproveedor}}</option>

                        @endforeach
                    </select>
                </div>
            </div>






            <div class="box-footer" align="center">
                <button type="submit" class="btn btn-success pull-right">Guardar</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>


@endsection
@section('scripts')
<script>
var permission_select = new SlimSelect({
    select: '#permissions-select select',
    //showSearch: false,
    placeholder: 'Select Permissions',
    deselectLabel: '<span>&times;</span>',
    hideSelectedOption: true,
});
var permission_select2 = new SlimSelect({
    select: '#permissions-select2 select',
    //showSearch: false,
    placeholder: 'Select Permissions',
    deselectLabel: '<span>&times;</span>',
    hideSelectedOption: true,
});
var permission_select = new SlimSelect({
    select: '#permissions-select3 select',
    //showSearch: false,
    placeholder: 'Select Permissions',
    deselectLabel: '<span>&times;</span>',
    hideSelectedOption: true,
});
var permission_select2 = new SlimSelect({
    select: '#permissions-select4 select',
    //showSearch: false,
    placeholder: 'Select Permissions',
    deselectLabel: '<span>&times;</span>',
    hideSelectedOption: true,
});
</script>
@endsection
