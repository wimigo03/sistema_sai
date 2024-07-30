@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                SOLICITUD DE COMPRA - {{ $solicitud_compra->dea->descripcion }}
            </div>
        </div>
    </div>
    <div class="card-body body">
        <input type="hidden" value="{{ $solicitud_compra->id }}" id="solicitud_compra_id">
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1">
                <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
                    <i class="fas fa-arrow-left fa-fw"></i>
                </span>
                @can('solicitud.compra.pdf')
                    <span class="btn btn-warning font-roboto-12 float-right" onclick="imprimir();">
                        <i class="fas fa-print fa-fw"></i>
                    </span>
                @endcan
                @can('solicitud.compra.aprobar')
                    @if ($solicitud_compra->estado == '1')
                        <span class="btn btn-danger font-roboto-12 float-right mr-1" onclick="rechazar();">
                            <i class="fas fa-times fa-fw"></i> Rechazar
                        </span>
                        <span class="btn btn-success font-roboto-12 float-right mr-1" id="btn-registro" onclick="procesar();">
                            <i class="fas fa-paper-plane fa-fw"></i> Aprobar
                        </span>
                    @endif
                @endcan
                @can('solicitud.compra.pendiente')
                    @if ($solicitud_compra->estado == '3')
                        <span class="btn btn-secondary font-roboto-12 float-right mr-1" onclick="pendiente();">
                            <i class="fas fa-paper-plane fa-fw"></i> Volver a Pendiente
                        </span>
                    @endif
                @endcan
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-4 pr-1 pl-1">
                <label for="area_solicitante" class="d-inline"><b>Unidad Solicitante</b></label>
                <input type="text" value="{{ $solicitud_compra->area->nombrearea }}" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="user" class="d-inline"><b>Solicitante</b></label>
                <input type="text" value="{{ strtoupper($solicitud_compra->solicitante->name) }}" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="codigo" class="d-inline"><b>Codigo</b></label>
                <input type="text" value="{{ $solicitud_compra->codigo }}" class="form-control font-roboto-11" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-2 pr-1 pl-1">
                <label for="tipo" class="d-inline"><b>Tipo</b></label>
                <input type="text" value="{{ $solicitud_compra->tipos }}" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="c_interno" class="d-inline"><b>N° C. Interno</b></label>
                <input type="text" value="{{ $solicitud_compra->c_interno }}" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="fecha_registro" class="d-inline"><b>F. Registro</b></label>
                <input type="text" value="{{ \Carbon\Carbon::parse($solicitud_compra->fecha_registro)->format('d/m/Y') }}" class="form-control font-roboto-11" disabled>
            </div>
            @if ($solicitud_compra->aprobante != null)
                <div class="col-md-3 pr-1 pl-1">
                    <label for="aprobado_por" class="d-inline"><b>Aprobado por</b></label>
                    <input type="text" value="{{ $solicitud_compra->aprobante->name }}" class="form-control font-roboto-11" disabled>
                </div>
            @endif
            <div class="col-md-2 pr-1 pl-1">
                <label for="estado" class="d-inline"><b>Estado</b></label>
                <input type="text" value="{{ $solicitud_compra->status }}" class="form-control font-roboto-11 {{ $solicitud_compra->colorInputStatus}}" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-12 pr-1 pl-1">
                <label for="detalle" class="d-inline"><b>Descripcion </b></label>
                <textarea rows="2" class="form-control font-roboto-11" disabled>{{ $solicitud_compra->detalle }}</textarea>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-12 pr-1 pl-1">
                <div class="card">
                    <div class="card-header text-center">
                        <strong><u>DETALLE DE LA SOLICITUD DE COMPRA</u></strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12 pr-1 pl-1 table-responsive">
                                <table id="detalle_tabla" class="table display table-bordered responsive hover-orange" style="width:100%;">
                                    <thead>
                                        <tr class="font-roboto-11">
                                            <td class="text-left p-1"><b>P. PRESUPUESTARIA</b></td>
                                            <td class="text-left p-1"><b>MATERIAL</b></td>
                                            <td class="text-left p-1"><b>DETALLE DEL MATERIAL</b></td>
                                            <td class="text-left p-1"><b>MEDIDA</b></td>
                                            <td class="text-right p-1"><b>CANTIDAD</b></td>
                                            {{--<td class="text-right p-1"><b>SALDO</b></td>--}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($solicitud_compra_detalles as $datos)
                                            <tr class="font-roboto-11">
                                                <td class="text-left p-1">{{ $datos->partidaPresupuestaria->numeracion . ' - ' . $datos->partidaPresupuestaria->nombre }}</td>
                                                <td class="text-left p-1">{{ $datos->item->nombre }}</td>
                                                <td class="text-left p-1">{{ $datos->item->detalle }}</td>
                                                <td class="text-left p-1">{{ $datos->unidad_medida->nombre }}</td>
                                                <td class="text-right p-1">{{ number_format($datos->cantidad,2,'.',',') }}</td>
                                                {{--<td class="text-right p-1">{{ number_format($datos->saldo,2,'.',',') }}</td>--}}
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
        @canany(['solicitud.compra.aprobar','solicitud.compra.pdf'])
            <div class="form-group row">
                {{--<div class="col-md-2 pr-1 pl-1">
                    <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
                        <i class="fas fa-arrow-left fa-fw"></i> Ir atras
                    </span>
                    <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </div>--}}
                {{--<div class="col-md-12 pr-1 pl-1 text-center">
                    @can('solicitud.compra.aprobar')
                        @if ($solicitud_compra->estado == '1')
                            <span class="btn btn-success font-roboto-12" id="btn-registro" onclick="procesar();">
                                <i class="fas fa-paper-plane fa-fw"></i> Aprobar
                            </span>
                            <span class="btn btn-danger font-roboto-12" onclick="rechazar();">
                                <i class="fas fa-times fa-fw"></i> Rechazar
                            </span>
                        @endif
                    @endcan
                    @can('solicitud.compra.pendiente')
                        @if ($solicitud_compra->estado == '3')
                            <span class="btn btn-outline-secondary font-roboto-12" onclick="pendiente();">
                                <i class="fas fa-paper-plane fa-fw"></i> Volver a Pendiente
                            </span>
                        @endif
                    @endcan
                </div>--}}
                {{--<div class="col-md-2 pr-1 pl-1 text-right">
                    @can('solicitud.compra.pdf')
                        <span class="btn btn-outline-warning font-roboto-12" onclick="imprimir();">
                            <i class="fas fa-file-pdf fa-fw"></i> Imprimir
                        </span>
                        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    @endcan
                </div>--}}
            </div>
        @endcanany
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
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            var id = $("#solicitud_compra_id").val();
            var url = "{{ route('solicitud.compra.aprobar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function rechazar(){
            var id = $("#solicitud_compra_id").val();
            var url = "{{ route('solicitud.compra.rechazar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function pendiente(){
            var id = $("#solicitud_compra_id").val();
            var url = "{{ route('solicitud.compra.pendiente',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function imprimir(){
            var id = $("#solicitud_compra_id").val();
            var url = "{{ route('solicitud.compra.pdf',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function cancelar(){
            var url = "{{ route('solicitud.compra.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
