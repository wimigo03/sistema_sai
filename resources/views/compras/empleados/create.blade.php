@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">{{ __('Nuevo Registro') }}</div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <a href="{{ url('/compras/empleados') }}" class="btn blue darken-4 text-black "><i
                        class="fa fa-plus-square"></i> Volver atras</a>
            </div>
        </div>
    </div>
    <div class="card-body">
    <form method="POST" action="{{ route('empleados.store') }}">
                @csrf

            <div class="form-group row">
                <label for="name" class="required col-md-4 col-form-label text-md-right">{{ __('Nombres') }}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nombres" placeholder=""
                         onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
            </div>
            <div class="form-group row">
                <label for="ap_pat"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Ap.Paterno') }}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ap_pat" placeholder="" 
                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
            </div>
            <div class="form-group row">
                <label for="ap_mat"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Ap.Materno') }}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ap_mat" placeholder=""
                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
            </div>
            <div class="form-group row">
                <label for="ci" class="required col-md-4 col-form-label text-md-right">{{ __('C.I.') }}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ci" placeholder="" 
                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
            </div>
            <div class="form-group row">
                <label for="correo" class="required col-md-4 col-form-label text-md-right">{{ __('Correo') }}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="correo" placeholder="" >
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="required col-md-4 col-form-label text-md-right">{{ __('F.-Nac.') }}</label>
                <div class="col-md-2 input-group date">
                    <input type="date" class="form-control" name="f_nac">

                </div>
            </div>

            <div class="form-group row">
                <label for="sexo" class="required col-md-4 col-form-label text-md-right">{{ __('Sexo') }}</label>
                <div class="col-md-2">
                    <select name="sexo" class="form-control"  >


                      
                        <option value="M" >MASCULINO</option>
                        <option value="F">FEMENINO</option>
                        
                    </select>

                </div>
            </div>
            <div class="form-group row">
                <label for="telefono"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>
                <div class="col-md-4">
                    <input type="text" maxlength="9" class="form-control" name="telefono" placeholder=""
                        >
                </div>
            </div>



            <div class="form-group row">
                <label class="required col-md-4 col-form-label text-md-right">{{ __('Area') }}</label>
                <div class="col-md-6" id="permissions-select2">

                    <select name="idarea" id="permissions" class="col-md-6">
                        @foreach ($areas as $area)
                      
                        <option value="{{$area->idarea}}" selected>{{$area->nombrearea}}</option>
                      


                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-group row">
                <label for="cargo"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Cargo') }}</label>
                <div class="col-md-4">
                    <input type="text"  class="form-control" name="cargo" placeholder=""
                    onkeyup="javascript:this.value=this.value.toUpperCase();" >
                </div>
            </div>



            <div class="box-footer" align="center">
                <button type="submit" class="btn btn-success pull-right">Guardar</button>
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
<script>
var permission_select2 = new SlimSelect({
    select: '#permissions-select2 select',
    //showSearch: false,
    placeholder: 'Select Permissions',
    deselectLabel: '<span>&times;</span>',
    hideSelectedOption: true,
})
$(document).ready(function() {
    $('.input-group.date').datepicker({
        format: "yyyy-mm-dd"
    });

});
</script>
@endsection