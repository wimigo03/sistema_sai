@extends('layouts.admin')

@section('content')
@if(Session::has('message'))

<div class="alert alert-success">
    <em> {!! session('message') !!}</em>
</div>
@endif
<div class="card">
    <div class="card-header">{{ __('Detalle de la Compra') }}</div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <a href="{{ url('/compras/detalle') }}" class="btn blue darken-4 text-black "><i
                        class="fa fa-plus-square"></i> Volver atras</a>
            </div>
            <a href="{{route('compras.detalle.principal.invitacion',$id)}}" target="_blank">
                <button class="btn btn-outline-info">Invitacion</button>
            </a>
            <a href="{{route('compras.detalle.principal.aceptacion',$id)}}" target="_blank">
                <button class="btn btn-outline-info">Aceptacion</button>
            </a>
            <a href="{{route('compras.detalle.principal.cotizacion',$id)}}" target="_blank">
                <button class="btn btn-outline-info">Cotizacion</button>
            </a>
            <a href="{{route('compras.detalle.principal.adjudicacion',$id)}}" target="_blank">
                <button class="btn btn-outline-info">Adjudicacion</button>
            </a>
            <a href="{{route('compras.detalle.principal.orden',$id)}}" target="_blank">
                <button class="btn btn-outline-info">Orden</button>
            </a>
        </div>
    </div>
    <div class="card-body table-responsive">




        <table class="table table-borderless table-hover">
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



                <td>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
            </tr>
            @endforelse

        </table>

        <div class="card-body table-responsive">

            <form action="{{ route('DetalleCompraController.crearOrdendoc') }}" method="POST">
                @csrf

                <input name="idcompra" type="hidden" value="{{$id}}">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group" id="permissions-select">
                            <label for="producto" style="color:red;font-weight: bold;">Documentos:</label>
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
                            <button class="btn btn-outline-primary" type="submit">adicionar</button>
                        </div>
                    </div>









                </div>
            </form>




            <table class="table table-borderless table-hover">
                <tr>

                    <th>.... Documentos Requeridos ...</th>



                </tr>
                @forelse ($ordendoc as $orden)
                <tr>

                    <td>{{ $orden -> nombredoc}}</td>

                    <td>
                    <form action="{{ route('DetalleCompraController.eliminar2', $orden -> idordendoc) }}" class="d-inline-block"
                        method="get">
                        @csrf

                        <button type="submit" onclick="return confirm('Esta Ud. Seguro..?')"
                            class="btn btn-outline-danger">Eliminar</button>
                    </form>


                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
                </tr>
                @endforelse

            </table>




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
})
</script>
@endsection
