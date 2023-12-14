@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card rounded">
            <div class="card-header bg-gradient-secondary text-white rounded">
                <div class="card-title"><b class="font-verdana-bg">LISTA DE SOLICITUDES DE COMPRAS</b></div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-12 text-right">
                        <a href="{{ route('pedido.create') }}"
                            class="btn btn-color-success font-verdana text-white font-weight-bold">
                            <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Agregar
                        </a>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-md-10 font-verdana">
                        <table id="example" class="table hoverTable table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Objeto</th>
                                    <th>Area</th>
                                    <th>Proveedor</th>
                                    <th>Preventivo</th>
                                    <th>Num. Compra</th>
                                    <th>Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($compras as $comp)
                                <tr>
                                    <td class="text-center">{{$comp->idcompra}}</td>
                                    <td>{{ $comp -> nombrearea}}</td>
                                    <td>{{ $comp -> objeto}}</td>
                                    <td>{{ $comp -> nombreproveedor}}</td>
                                    <td>{{ $comp -> preventivo}}</td>
                                    <td>{{ $comp -> numcompra}}</td>


                                    <td>
                                        <a href="pedido/{{$comp->idcompra}}/editar" class="btn btn-xs btn-info" title="Editar Solicitud">
                                            <i class="fas fa-pencil-alt text-white" aria-hidden="true"></i>
                                        </a>


                                        <a href="pedido/{{$comp->idcompra}}/edit" style="color:white;"
                                            class="btn btn-xs btn-warning" title="Acceder al detalle">
                                            <i class="fas fa-file-alt fa-lg" aria-hidden="true"></i>
                                        </a>




                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>



                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@section('scripts')


<script>
$(document).ready(function() {
    $('#example').DataTable({

        //para cambiar el lenguaje a español
        language: {
            url: '/sai/public/spain.json'
        }
,
    });
});
</script>

@endsection
@endsection