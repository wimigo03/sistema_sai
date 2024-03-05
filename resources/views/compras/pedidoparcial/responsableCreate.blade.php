@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="row font-verdana-12">

            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/compras/pedidoparcial/responsable') }}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>


            <div class="col-md-6 text-right titulo">
                <b>CREAR RESPONSABLE  </b>
            </div>

            <div class="col-md-12">
                <hr color="red">
            </div>

        </div>


        <div class="body-border">
            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('compras.pedidoparcial.storeEncargado') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="nombre" class="required col-md-4 col-form-label text-md-right"
                            style="color:black;font-weight: bold;"></label>

                        <div class="col-md-6">
                            <label  {{$personalArea->nombrearea}} ><b style='color:red'>{{$personalArea->nombrearea}} </b></label>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="codigo" class="required col-md-4  col-form-label text-md-right" required
                            style="color:black;font-weight: bold;">Abrev:</label>

                        <div class="col-md-2">
                            <input type="text" required name="abrev" class="form-control"
                                 >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nombre" class="required col-md-4 col-form-label text-md-right"
                            style="color:black;font-weight: bold;">Empleado:</label>

                        <div class="col-md-6">
                        <select name="idempleado" id="idempleado" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                            <option value="">--seleccione--</option>
                            @foreach ($empleados as $value)
                                <option value="{{ $value->idemp }}">{{ $value->nombres}} {{ $value->ap_pat}} {{ $value->ap_mat}}</option>
                            @endforeach
                        </select>
                   </div>
                    </div>


                    <div class="form-group row">
                        <label for="nombre" class="required col-md-4 col-form-label text-md-right"
                            style="color:black;font-weight: bold;">Cargo:</label>

                        <div class="col-md-6">
                            <input type="text" name="cargo" required class="form-control"
                            placeholder="--Cargo del responsable--"
                            onchange="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>



                    <div align='center'>

                        <button class="btn color-icon-2 font-verdana-12" type="submit">
                            <i class="fa-solid fa-paper-plane"></i>
                            &nbsp;Guardar
                        </button>
                    </div>

                </form>
            </font>

        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });

/*var permission_select = new SlimSelect({
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
});*/
</script>
@endsection
