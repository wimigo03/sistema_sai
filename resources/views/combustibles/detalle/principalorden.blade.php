@extends('layouts.dashboard')

@section('content')
@if(Session::has('message'))

<div class="alert alert-success">
    <em> {!! session('message') !!}</em>
</div>
@endif
<div class="row justify-content-center">
    <div class="col-md-2 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/compras/detalle/index')}}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-10 text-right titulo">
        <b>ORDEN COMPRA</b>
    </div>
    <div class="col-md-12"  >
        <hr class="hrr">
    </div>
    <div class="row">
        <div class="col-md-12">




            <a href="{{route('compras.detalle.principal.invitacion',$id)}}" target="_blank">
                <button class="btn btn-outline-info">Invitacion</button>
            </a>
            <a href="{{route('compras.detalle.principal.aceptacion',$id)}}" target="_blank">
                <button class="btn btn-outline-info">Aceptacion</button>
            </a>
            <a href="{{route('compras.detalle.principal.cotizacion',$id)}}" target="_blank">
                <button class="btn btn-outline-info">Informe 1</button>
            </a>
            <a href="{{route('compras.detalle.principal.adjudicacion',$id)}}" target="_blank">
                <button class="btn btn-outline-info">Adjudicacion</button>
            </a>

            <a href="{{route('compras.detalle.principal.orden',$id)}}" target="_blank">
                <button class="btn btn-outline-info">O.Compra</button>
            </a>

        </div>
    </div>


    <div class="col-md-12"  >
        <hr class="hrr">
    </div>



    <div >
        <table class="table display table-bordered responsive font-verdana">
            <tr>
                <th>Fecha Orden</th>
                <th>Nombre Compra</th>
                <th>Solicitante</th>
                <th>Proveedor</th>


            </tr>
            @forelse ($ordencompra as $ocompra)
            <tr>
                <td>{{ $ocompra -> fechaorden}}</td>
                <td>{{ $ocompra -> nombrecompra}}</td>
                <td>{{ $ocompra -> solicitante}}</td>
                <td>{{ $ocompra -> proveedor}}</td>




            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
            </tr>
            @endforelse

        </table>

        <div >



            <form action="{{ route('DetalleCompraController.crearOrdendoc') }}" method="POST">
                @csrf

                <input name="idcompra" type="hidden" value="{{$id}}">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group" id="permissions-select">
                            <label for="producto" style="color:red;font-weight: bold;">Documentos Requeridos del Proveedor:</label>
                            <select name="iddoc" id="permissions">
                                @foreach($docorden as $doc)
                                <option value="{{$doc -> iddoc}}">
                                    {{$doc -> nombredoc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>







                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label for="producto" style="color:red;font-weight: bold;"></label>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit">adicionar</button>
                        </div>
                    </div>









                </div>
            </form>




            <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:80%;" >
                <tr>

                    <td class="text-justify p-1"><b>Documentos</b></td>
                        <td class="text-justify p-1" style="width:10%;"><b>-----</b></td>



                </tr>
                @forelse ($ordendoc as $orden)
                <tr>

                    <td>{{ $orden -> nombredoc}}</td>

                    <td>
                    <form action="{{ route('DetalleCompraController.eliminar2', $orden -> idordendoc) }}"
                        method="get">
                        @csrf

                        <button class='btn btn-default' type='submit' value='submit' onclick="return confirm('Esta Ud. Seguro..?')"  >
                        <i class="fa-solid fa-trash-xmark" style="color: red"></i>
                        </button>


                    </form>


                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="100%" class="text-center text-muted py-3">No hay Documentos</td>
                </tr>
                @endforelse

            </table>




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
})
</script>
@endsection
