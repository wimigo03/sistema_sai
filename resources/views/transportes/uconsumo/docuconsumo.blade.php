@extends('layouts.dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">

                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/transportes/uconsumo/index')}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>

                &nbsp;&nbsp;&nbsp;

               
                   
                    <a href="{{ route('UnidadConsumoController.createdoc', $idunidadconsumo) }}" 
                    class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
                            <button class="btn btn-sm btn-info   font-verdana" type="button" >
                                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                            </button>
                        </a>
            
                        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" 
                        style="display: none;"></i>
                   
            
                
            </div>


            <div class="col-md-8 text-right titulo">
                <b>DOCUMENTOS DE LA UNIDAD</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>

        
        <div class="row">
            <div class="col-md-12 table-responsive">
                <center>
                    <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:100%">
                        <thead>
                            <tr>

                            <th class="text-justify p-1">N</th>
                            <th class="text-justify p-1">NOMBRE DEL DOCUMENTO</th>
                            <th class="text-justify p-1">DOCUMENTO</th>
                            <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                    $num = 1;
                    @endphp

                        @forelse ($docuconsumo as $docprov)
                        <tr>

                           <td class="text-justify p-1" >{{$num++}}</td>  
                            <td class="text-justify p-1">{{$docprov ->nombredocumento}}</td>
                            <td class="text-justify p-1">{{$docprov ->documento}}</td>


                            <td style="padding: 0;" class="text-center p-1">
                             
                                <span class="tts:right tts-slideIn tts-custom" aria-label="Ver Documento">
                                <a href="../../../Archivos/{{$docprov -> documento}}" target="blank_"
                                class="fa fa-eye fa-lg " ></a>
                                
                            </span>
                             

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                    </table>

                </center>
            </div>
        </div>
        @section('scripts')
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({

                    order: [
                        [0, "desc"]
                    ],



                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                });
            });

            function agregar() {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                window.location.href = "{{ route('compras.pedido.create') }}";
            }
        </script>
    @endsection
@endsection
