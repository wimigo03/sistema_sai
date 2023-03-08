@extends('layouts.admin')
@section('content')
@section('styles')
@endsection
<div class="form-group row">
    <div class="col-md-12">
        <div class="card card-custom">
            <div class="card-header bg-secondary text-white">
                <div class="card-title"><b>MEDIDAS</b></div>
            </div>
            <div class="card-body">
                {{--<form method="POST" action="{{ route('compras.pedido.search') }}" accept-charset="UTF-8">--}}
                    {!! Form::model(Request::all(),['route'=> ['compras.pedido.search']]) !!}
                        @include('compras.pedido.search')
                    {!! Form::close()!!}
                {{--</form>--}}
                <hr>
                <div class="form-group row">
                    <div class="col-md-12 text-center">
                        <div class="table-responsive table-striped table-bordered">
                            <table class="display responsive" style="width:100%">
                                <thead>
                                    <tr class="font-verdana-bg">
                                        <td class="text-center p-1"><b>ID</b></td>
                                        <td class="text-center p-1"><b>OBJETO</b></td>
                                        <td class="text-center p-1"><b>AREA</b></td>
                                        <td class="text-center p-1"><b>PROVEEDOR</b></td>
                                        <td class="text-center p-1"><b>PREVENTIVO</b></td>
                                        <td class="text-center p-1"><b>N° COMPRA</b></td>
                                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($compras as $comp)
                                        <tr class="font-verdana-bg">
                                            <td class="text-center p-1">{{$comp->idcompra}}</td>
                                            <td class="text-justify p-1">{{$comp->objeto}}</td>
                                            <td class="text-center p-1">{{$comp->nombrearea}}</td>
                                            <td class="text-center p-1">{{$comp->nombreproveedor}}</td>
                                            <td class="text-center p-1">{{$comp->preventivo}}</td>
                                            <td class="text-center p-1">{{$comp->numcompra}}</td>
                                            <td class="text-center p-1">
                                            @can('medidas_access')
                                                <a href="pedido/{{$comp->idcompra}}/editar" class="btn btn-xs btn-outline-warning">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a>
                                            @endcan   
                                                <a href="pedido/{{$comp->idcompra}}/edit" class="btn btn-xs btn-outline-info">
                                                    <i class="fas fa-list" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--************************************************************************
<div class="card">
    <div class="card-header">{{ __('Lista de Medidas') }}</div>
 
    <div class="card-body table-responsive">
    
        <a href="{{ route('pedido.create') }}" class="btn btn-outline-primary">Agregar Registro</a>

        <br /><br />

        @include('compras.pedido.search')

        <table class="table table-borderless table-hover">
        <tr>
                    <th>Id</th>
                    <th>Objeto</th>
                    <th>Area</th>
                    <th >Proveedor</th>
                    <th>Preventivo</th>
                    <th>Num. Compra</th>
                    <th >Opciones</th>

                </tr>
            @forelse ($compras as $comp)
            <tr>
                <td class="text-center">{{$comp->idcompra}}</td>
                <td >{{ $comp -> nombrearea}}</td>
                <td >{{ $comp -> objeto}}</td>
                <td>{{ $comp -> nombreproveedor}}</td>
                <td>{{ $comp -> preventivo}}</td>
                <td>{{ $comp -> numcompra}}</td>


                <td>
                @can('medidas_access')
                <a href="pedido/{{$comp->idcompra}}/editar" class="btn btn-outline-warning">Editar</a>
                    @endcan
                    
                <a href="pedido/{{$comp->idcompra}}/edit" class="btn btn-outline-info">Items de la Compra</a>

               

                    
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
            </tr>
            @endforelse
        </table>


        @if($compras->total() > $compras->perPage())
        <br><br>
        {{$compras->links()}}
        @endif



    </div>
</div>--}}
@endsection
@section('scripts')
    <script type="text/javascript" src="/dataTable_1.10.22/js/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="/dataTable_1.10.22/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/dataTable_1.10.22/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "processing":true,
                "serverSide":true,
                "ajax":"{{ route('compras.pedido.indexAjax') }}",
                "columns": [
                    {data: 'idcompra', name:'c.idcompra', class:'text-center p-1 font-verdana'},
                    {data: 'objeto', name:'c.objeto', class:'text-justify p-1 font-verdana'},
                    {data: 'nombrearea', name:'a.nombrearea', class:'text-center p-1 font-verdana'},
                    {data: 'nombreproveedor', name:'p.nombreproveedor', class:'text-center p-1 font-verdana'},
                    {data: 'preventivo', name:'c.preventivo', class:'text-center p-1 font-verdana'},
                    {data: 'numcompra', name:'c.numcompra', class:'text-center p-1 font-verdana'},
                    /*{data: 'status_search', name:'status_search', class:'text-center p-1 font-verdana',render: function(data, type, row){
                        if(row.status_search === 'BORRADOR'){
                            return '<span class="btn btn-xs btn-secondary font-verdana-sm"><b>BORRADOR</b></span>';
                        }else if(row.status_search == 'APROBADO'){
                            return '<span class="btn btn-xs btn-success font-verdana-sm"><b>APROBADO</b></span>';
                        }else{
                            return '<span class="btn btn-xs btn-danger font-verdana-sm"><b>ANULADO</b></span>';       
                        }
                    }
                },
                    {data: 'copia', name:'a.copia', class:'text-center p-1 font-verdana',render: function(data, type, row){
                        if(row.copia === '1'){
                            return '<i class="fas fa-check"></i>';
                        }else{
                            return '<i class="fas fa-close"></i>';
                        }
                    }
                },*/
                    {data: 'btnActions', class:'text-justify p-1'}
                ],
                "iDisplayLength": 10,
                "order": [[ 0, "desc" ]],
                "language":{
                    "info": "Mostrando _START_ al _END_ de _TOTAL_","search": '',"searchPlaceholder": "Buscar",
                    "paginate": {"next": "<small><b>Siguiente</b></small>","previous": "<small><b>Anterior</b></small>",},
                    "lengthMenu": '<small>Mostrar</small> <select class="form form-control-sm">'+'<option value="10">10</option>'+'<option value="25">25</option>'+'<option value="50">50</option>'+'<option value="100">100</option>'+'<option value="-1">Todos</option>'+'</select> <small>registros</small>',
                    "loadingRecords": "...Cargando...","processing": "...Procesando...","emptyTable": "No hay datos","zeroRecords": "No hay resultados para mostrar","infoEmpty": "Ningun registro encontrado","infoFiltered": "(filtrados de un total de _MAX_ registros)"
                }
            });
        } );
    </script>
@endsection