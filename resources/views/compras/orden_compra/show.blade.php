@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                ORDEN DE COMPRA - {{ $orden_compra->dea->descripcion }}
            </div>
        </div>
    </div>
    <div class="card-body body">
        <input type="hidden" value="{{ $orden_compra->id }}" id="orden_compra_id">
        @canany(['orden.compra.aprobar','orden.compra.pdf'])
            <div class="form-group row">
                <div class="col-md-12 pr-1 pl-1">
                    <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
                        <i class="fas fa-arrow-left fa-fw"></i>
                    </span>
                    @can('orden.compra.pdf')
                        <span class="btn btn-warning font-roboto-12 float-right" onclick="imprimir();">
                            <i class="fas fa-print fa-fw"></i>
                        </span>
                    @endcan
                    @can('orden.compra.aprobar')
                        @if ($orden_compra->estado == '1')
                            <span class="btn btn-danger font-roboto-12 float-right mr-1" onclick="rechazar();">
                                <i class="fas fa-times fa-fw"></i> Rechazar
                            </span>
                            <span class="btn btn-success font-roboto-12 float-right mr-1" id="btn-registro" onclick="procesar();">
                                <i class="fas fa-paper-plane fa-fw"></i> Aprobar
                            </span>
                        @endif
                    @endcan
                    <i class="fa fa-spinner fa-spin fa-lg fa-sm spinner-btn" style="display: none;"></i>
                </div>
            </div>
        @endcanany
        <div class="form-group row font-roboto-12">
            <div class="col-md-4 pr-1 pl-1">
                <label for="area_solicitante" class="d-inline"><b>Unidad Solicitante</b></label>
                <input type="text" value="{{ $orden_compra->area->nombrearea }}" id="area_solicitante" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="user" class="d-inline"><b>Solicitante</b></label>
                <input type="text" value="{{ strtoupper($orden_compra->solicitante->name) }}" id="user" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="fecha_registro" class="d-inline"><b>Registro</b></label>
                <input type="text" value="{{ \Carbon\Carbon::parse($orden_compra->fecha_registro)->format('d/m/Y') }}" id="fecha_registro" class="form-control font-roboto-11" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-2 pr-1 pl-1">
                <label for="nro_oc" class="d-inline"><b>Nro. O.C</b></label>
                <input type="text" value="{{ $orden_compra->codigo }}" id="nro_oc" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="nro_solicitud" class="d-inline"><b>Nro. Solicitud</b></label>
                <input type="text" value="{{ $orden_compra->solicitud_compra->codigo }}" id="nro_solicitud" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-4 pr-1 pl-1">
                <label for="almacen" class="d-inline"><b>Almacen</b></label>
                <input type="text" value="{{ $orden_compra->almacen != null ? $orden_compra->almacen->nombre : '' }}" id="almacen" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="tipo" class="d-inline"><b>Tipo</b></label>
                <input type="text" value="{{ $orden_compra->tipos }}" id="tipo" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="estado" class="d-inline"><b>Estado</b></label>
                <input type="text" value="{{ $orden_compra->status }}" id="estado" class="form-control font-roboto-11 {{ $orden_compra->colorInputStatus}}" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-2 pr-1 pl-1">
                <label for="c_interno" class="d-inline"><b>N° C. Interno</b></label>
                <input type="text" value="{{ $orden_compra->c_interno }}" id="c_interno" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="nro_preventivo" class="d-inline"><b>N° Preventivo</b></label>
                <input type="text" value="{{ $orden_compra->nro_preventivo }}" id="nro_preventivo" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-4 pr-1 pl-1">
                <label for="proveedor" class="d-inline"><b>Proveedor</b></label>
                <input type="text" value="{{ isset($orden_compra->proveedor) ? $orden_compra->proveedor->nombre : '' }}" id="proveedor" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="fecha_aprob" class="d-inline"><b>Aprobado el</b></label>
                {{$orden_compra->fecha_aprob}}
                <input type="text" value="{{ isset($orden_compra->fecha_aprob) ? \Carbon\Carbon::parse($orden_compra->fecha_aprob)->format('d/m/Y') : '' }}" id="fecha_aprob" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="aprobado_por" class="d-inline"><b>Aprobado por</b></label>
                <input type="text" value="{{ isset($orden_compra->aprobante) ? $orden_compra->aprobante->name : '' }}" id="aprobado_por" class="form-control font-roboto-11" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-6 pr-1 pl-1">
                <label for="objeto" class="d-inline"><b>Objeto</b></label>
                <textarea id="objeto" rows="2" class="form-control font-roboto-11" disabled>{{ $orden_compra->objeto }}</textarea>
            </div>
            <div class="col-md-6 pr-1 pl-1">
                <label for="justificacion" class="d-inline"><b>Justificacion</b></label>
                <textarea id="justificacion" rows="2" class="form-control font-roboto-11" disabled>{{ $orden_compra->justificacion }}</textarea>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-12 pr-1 pl-1">
                <div class="card">
                    <div class="card-header text-center">
                        <strong><u>DETALLE DE LA ORDEN DE COMPRA</u></strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12 pr-1 pl-1 table-responsive">
                                <table id="detalle_tabla" class="table display table-bordered responsive hover-orange" style="width:100%;">
                                    <thead>
                                        <tr class="font-roboto-11">
                                            <th class="text-left p-1">CATEGORIA PROGRAMATICA</th>
                                            <th class="text-left p-1">PARTIDA PRESUPUESTARIA</th>
                                            <th class="text-left p-1">ITEM</th>
                                            <th class="text-center p-1">MEDIDA</th>
                                            <th class="text-right p-1">CANTIDAD</th>
                                            <th class="text-right p-1">PRECIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orden_compra_detalles as $datos)
                                            <tr class="font-roboto-11">
                                                <td class="text-left p-1">{{ $datos->categoriaProgramatica->codigo . ' - ' . $datos->categoriaProgramatica->nombre }}</td>
                                                <td class="text-left p-1">{{ $datos->partidaPresupuestaria->numeracion . ' - ' . $datos->partidaPresupuestaria->nombre }}</td>
                                                <td class="text-left p-1">{{ $datos->item->nombre }}</td>
                                                <td class="text-center p-1">{{ $datos->unidad_medida->nombre }}</td>
                                                <td class="text-right p-1">{{ number_format($datos->cantidad,2,'.',',') }}</td>
                                                <td class="text-right p-1">{{ number_format($datos->precio,2,'.',',') }}</td>
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
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function procesar() {
            if(!validar()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validar(){
            if($("#dea").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR DEA</center>");
                return false;
            }
            if($("#area_solicitante").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR EL AREA SOLICITANTE</center>");
                return false;
            }
            if($("#user").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR EL SOLICITANTE</center>");
                return false;
            }
            if($("#fecha_registro").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR LA FECHA DE REGISTRO</center>");
                return false;
            }
            if($("#nro_oc").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR EL NUMERO DE LA ORDEN DE COMPRA</center>");
                return false;
            }
            if($("#nro_solicitud").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR EL NUMERO DE LA SOLICITUD DE COMPRA</center>");
                return false;
            }
            if($("#almacen").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR EL ALMACEN</center>");
                return false;
            }
            if($("#tipo").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR EL TIPO DE ORDEN DE COMPRA</center>");
                return false;
            }
            if($("#estado").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR EL ESTADO DE LA ORDEN DE COMPRA</center>");
                return false;
            }
            if($("#c_interno").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR EL NUMERO DE CONTROL INTERNO</center>");
                return false;
            }
            if($("#nro_preventivo").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR EL NUMERO DE PREVENTIVO</center>");
                return false;
            }
            if($("#proveedor").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR EL PROVEEDOR</center>");
                return false;
            }
            if($("#objeto").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR EL OBJETO DE LA ORDEN DE COMPRA</center>");
                return false;
            }
            if($("#justificacion").val() == ""){
                Modal("<center><b>[ERROR. ]</b> AL VALIDAR LA JUSTIFICACION DE LA ORDEN DE COMPRA</center>");
                return false;
            }
            return true;
        }

        function confirmar(){
            var id = $("#orden_compra_id").val();
            var url = "{{ route('orden.compra.aprobar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function rechazar(){
            var id = $("#orden_compra_id").val();
            var url = "{{ route('orden.compra.rechazar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function imprimir(){
            var id = $("#orden_compra_id").val();
            var url = "{{ route('orden.compra.pdf',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function cancelar(){
            var url = "{{ route('orden.compra.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
