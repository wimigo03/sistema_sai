@extends('layouts.dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">

                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/compras/proveedores/index')}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>

                &nbsp;&nbsp;&nbsp;

                  
                   
                    <a href="{{ route('ProveedoresController.createdoc', $idproveedor) }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
                            <button class="btn btn-sm btn-info   font-verdana" type="button" >
                                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                            </button>
                        </a>
            
                        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
                   
                
            
                
            </div>


            <div class="col-md-8 text-right titulo">
                <b>DOCUMENTOS DEL PROVEEDOR</b>
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
                            <th>NOMBRE DEL DOCUMENTO</th>
                            <th>DOCUMENO</th>
                            <th style="color:black ;width:10px;"><i class="fa fa-bars" aria-hidden="true"></i></th>

                        </tr>
                        @forelse ($docproveedor as $docprov)
                        <tr>

                            <td >{{$docprov -> iddocproveedor}}</td>
                            <td>{{$docprov -> nombredocumento}}</td>
                            <td s>{{$docprov -> documento}}</td>


                            <td>
                               
                                <span class="tts:right tts-slideIn tts-custom" aria-label="Ver Documento">
                                <a href="/sai/public/Archivos/{{$docprov -> documento}}" target="blank_"
                                class="fa fa-eye fa-lg " ></a>
                                
                            </span>
                              

                            </td>
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