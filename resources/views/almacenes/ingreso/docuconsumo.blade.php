@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">

                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/almacenes/ingreso/index')}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>

                &nbsp;&nbsp;&nbsp;

                    {{-- @can('proveedores_create') --}}
                   
                    <a href="{{ route('IngresoController.createdoc', $idingreso) }}" 
                    class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
                            <button class="btn btn-sm btn-info   font-verdana" type="button" >
                                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                            </button>
                        </a>
            
                        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" 
                        style="display: none;"></i>
                   
                    {{-- @endcan --}}
            
                
            </div>


            <div class="col-md-8 text-right titulo">
                <b>NOTA DE INGRESO</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>

        
        <div class="body-border">
            <font size="2" face="Courier New" >
                    <table class="table table-bordered table-hover">
                        <tr class="bg-info text-light">

                            <th>ID</th>
                            <th>N COMPRA</th>
                            <th>N SOLICITUD</th>
                 
                            <th style="color:black ;width:10px;"><i 
                                class="fa fa-bars" aria-hidden="true">
                                </i></th>

                        </tr>
                        @forelse ($notaingreso as $docprov)
                        <tr>

                         <td >{{$docprov ->idnotaingreso}}</td>  
                            <td>{{$docprov ->numcompra}}</td>
                            <td s>{{$docprov ->numsolicitud}}</td>
                    


                            {{-- <td>
                                 @can('proveedores_edit') 
                                <span class="tts:right tts-slideIn tts-custom" aria-label="Editar Nota">
                                <a href="/1.- Almacen/sistema_sai_s_j_query_builder_almacen/public/Archivos/
                                {{$docprov -> idnotaingreso}}" target="blank_"
                                class="fa fa-eye fa-lg " ></a>
                                
                            </span>
                                 @endcan 

                            </td> --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
                        </tr>
                        @endforelse
                    </table>

                </font>

            </div>
           
        </div>
    </div>
@endsection