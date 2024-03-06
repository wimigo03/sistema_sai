@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">

                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/proveedor/index') }}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>

                &nbsp;&nbsp;&nbsp;


                    <a href="{{ route('proveedor.createdoc', $idproveedor) }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
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
                            <th>DOCUMENTO</th>
                            <th style="color:black ;width:10px;"><i class="fa fa-bars" aria-hidden="true"></i></th>
                            <th style="color:black ;width:10px;"><i class="fa fa-bars" aria-hidden="true"></i></th>

                        </tr>
                        @forelse ($docproveedor as $docprov)
                        <tr>

                            <td >{{$docprov ->iddocproveedores}}</td>
                            <td>{{$docprov ->nombredocumento}}</td>
                            <td s>{{$docprov ->documento}}</td>


                            <td>
                             
                                <span class="tts:right tts-slideIn tts-custom" aria-label="Ver Documento">
                                <a href="/../Documentos/{{$docprov ->documento}}" target="blank_"
                                class="fa fa-eye fa-lg " ></a>

                            </span>

                           

                            </td>
                            <td>
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Archivo">
                                <a href="{{route('proveedor.editararchivo',$docprov ->iddocproveedores)}}">
                                    <span class="text-warning">
                                        <i class="fas fa-xl fa-edit" style="color:rgb(26, 162, 16)"></i>
                                    </span>
                                </a>
                            </span>

                                
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
