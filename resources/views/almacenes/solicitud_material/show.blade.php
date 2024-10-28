@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="row abs-center">
            <div class="col-md-10">
                <div class="form-group row font-roboto-18">
                    <div class="col-md-12 text-center linea-completa">
                        <strong>SOLICITUD DE MATERIAL</strong>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 pr-1 pl-1">
                        <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
                            <i class="fas fa-arrow-left fa-fw"></i>
                        </span>
                        @can('solicitud.material.editar')
                            @if ($data->estado == '1')
                                <span class="btn btn-secondary font-roboto-12" onclick="editar();">
                                    <i class="fas fa-edit fa-fw"></i> Modificar
                                </span>
                            @endif
                        @endcan
                        {{-- @can('solicitud.material.pdf')
                            <span class="btn btn-warning font-roboto-12 float-right" onclick="imprimir();">
                                <i class="fas fa-print fa-fw"></i>
                            </span>
                        @endcan --}}
                        @can('solicitud.material.aprobar')
                            @if ($data->estado == '1')
                                <span class="btn btn-danger font-roboto-12 float-right mr-1" onclick="rechazar();">
                                    <i class="fas fa-times fa-fw"></i> Rechazar
                                </span>
                                <span class="btn btn-success font-roboto-12 float-right mr-1" onclick="procesar();">
                                    <i class="fas fa-paper-plane fa-fw"></i> Aprobar
                                </span>
                            @endif
                        @endcan
                        @can('solicitud.material.pendiente')
                            @if ($data->estado == '3')
                                <span class="btn btn-secondary font-roboto-12 float-right mr-1" onclick="pendiente();">
                                    <i class="fas fa-paper-plane fa-fw"></i> Volver a Pendiente
                                </span>
                            @endif
                        @endcan
                        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    </div>
                </div>
                <hr>
                <div class="row font-roboto-12">
                    <div class="col-md-2 pr-1 pl-1 mb-2">
                        <label for="codigo" class="d-inline"><b>N° SOL.</b></label>
                        <input type="text" value="{{ strtoupper($data->cod_solicitud) }}" class="form-control font-roboto-12" disabled>
                    </div>
                    <div class="col-md-2 pr-1 pl-1 mb-2">
                        <label for="fecha" class="d-inline"><b>Fecha</b></label>
                        <input type="text" value="{{ \Carbon\Carbon::parse($data->fsolicitud)->format('d/m/Y') }}" class="form-control font-roboto-12" disabled>
                    </div>
                    <div class="col-md-6 pr-1 pl-1 mb-2">
                        <label for="solicitante" class="d-inline"><b>Solicitante</b></label>
                        <input type="text" value="{{ strtoupper($data->solicitante->nombre_completo) }}" class="form-control font-roboto-12" disabled>
                    </div>
                    <div class="col-md-2 pr-1 pl-1 mb-2">
                        <label for="estado" class="d-inline"><b>Estado</b></label>
                        <input type="text" value="{{ $data->status }}" class="form-control font-roboto-12 {{ $data->input_status }}" disabled>
                    </div>
                    <div class="col-md-5 pr-1 pl-1 mb-2">
                        <label for="solicitante" class="d-inline"><b>Almacen</b></label>
                        <input type="text" value="{{ strtoupper($data->area->almacen->nombre) }}" class="form-control font-roboto-12" disabled>
                    </div>
                    <div class="col-md-7 pr-1 pl-1 mb-2">
                        <label for="solicitante" class="d-inline"><b>Unidad Solicitante</b></label>
                        <input type="text" value="{{ strtoupper($data->area->alias) }}" class="form-control font-roboto-12" disabled>
                    </div>
                    <div class="col-md-12 pr-1 pl-1 mb-2">
                        <label for="programa" class="d-inline"><b>Programa</b></label>
                        <input type="text" value="{{ $data->cprogramatica->codigo . ' - ' . $data->cprogramatica->nombre }}" class="form-control font-roboto-12" disabled>
                    </div>
                    <div class="col-md-12 pr-1 pl-1 mb-2">
                        <label for="obs" class="d-inline"><b>Observaciones</b></label>
                        <textarea class="form-control font-roboto-12" disabled>{{ $data->obs }}</textarea>
                    </div>
                    @if ($data->user_aprobado_id != null)
                        <div class="col-md-6 pr-1 pl-1 mb-2">
                            <label for="solicitante" class="d-inline"><b>Autorizado por</b></label>
                            <input type="text" value="{{ strtoupper($data->aprobante->nombre_completo) }}" class="form-control font-roboto-12" disabled>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12 pr-1 pl-1 table-responsive">
                        <form action="#" method="post" id="form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data->id }}" id="solicitud_material_id">
                            <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;">
                                <thead>
                                    <tr class="font-roboto-11">
                                        <td class="text-center p-1"><b>N°</b></td>
                                        <td class="text-center p-1"><b>DESCRIPCION DEL MATERIAL</b></td>
                                        <td class="text-center p-1"><b>U. MEDIDA</b></td>
                                        <td class="text-center p-1"><b>CANT. SOL.</b></td>
                                        @can('solicitud.material.aprobar')
                                            <td class="text-center p-1"><b>CANT. AUT.</b></td>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detalles as $datos)
                                        <tr class="font-roboto-11">
                                            <td class="text-center p-1" style="vertical-align: middle;">{{ $cont++ }}</td>
                                            <td class="text-justify p-1" style="vertical-align: middle;">{{ $datos->item->codigo . ' - ' . $datos->item->nombre }}</td>
                                            <td class="text-center p-1" style="vertical-align: middle;">{{ $datos->medida->nombre }}</td>
                                            <td class="text-right p-1" width="80px" style="vertical-align: middle;">
                                                <input type="text" value="{{ number_format($datos->cant_solicitada,2,'.',',') }}" class="form-control form-control-sm font-roboto-12 text-right input-cant-solicitada bg-secondary text-white" readonly>
                                            </td>
                                            @can('solicitud.material.aprobar')
                                                <td class="text-right p-1" width="80px" style="vertical-align: middle;">
                                                    <input type="hidden" name="detalle_id[]" value="{{ $datos->id }}">
                                                    <input type="text" name="cant_autorizada[]" value="{{ number_format($datos->cant_solicitada,2,'.',',') }}" class="form-control form-control-sm font-roboto-12 text-right input-cant-autorizada @if($data->estado != '1') bg-secondary text-white @endif">
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
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
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        /* function confirmar(){
            var id = $("#solicitud_material_id").val();
            var url = "{{ route('solicitud.material.aprobar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        } */

        function confirmar(){
            var url = "{{ route('solicitud.material.aprobar') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function rechazar(){
            var id = $("#solicitud_material_id").val();
            var url = "{{ route('solicitud.material.rechazar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function pendiente(){
            var id = $("#solicitud_material_id").val();
            var url = "{{ route('solicitud.material.pendiente',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function imprimir(){
            var id = $("#solicitud_material_id").val();
            var url = "{{ route('solicitud.material.pdf',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function editar(){
            var id = $("#solicitud_material_id").val();
            var url = "{{ route('solicitud.material.editar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function cancelar(){
            var url = "{{ route('solicitud.material.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
