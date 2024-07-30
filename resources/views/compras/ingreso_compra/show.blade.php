@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                INGRESO
            </div>
        </div>
    </div>
    <div class="card-body body">
        @canany(['ingreso.compra.ingresar','ingreso.compra.pdf'])
            <div class="form-group row abs-center">
                <div class="col-md-12 pr-1 pl-1">
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Ir atras" style="cursor: pointer;">
                        <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
                            <i class="fas fa-arrow-left fa-fw"></i>
                        </span>
                    </span>
                    @can('ingreso.compra.pdf')
                        <span class="tts:left tts-slideIn tts-custom float-right" aria-label="Exportar a pdf" style="cursor: pointer;">
                            <span class="btn btn-outline-warning font-roboto-12" onclick="imprimir();">
                                <i class="fas fa-print fa-fw"></i>
                            </span>
                        </span>
                    @endcan
                    @can('ingreso.compra.ingresar')
                        @if ($ingreso_compra->estado == '1')
                            <span class="btn btn-primary font-roboto-12 float-right mr-1" onclick="procesar();">
                                <i class="fas fa-paper-plane fa-fw"></i> Ingresar
                            </span>
                        @endif
                    @endcan
                    <i class="fa fa-spinner fa-spin fa-lg fa-sm spinner-btn" style="display: none;"></i>
                </div>
            </div>
        @endcanany
        <form action="#" method="post" id="form">
            @csrf
            <input type="hidden" name="ingreso_compra_id" value="{{ $ingreso_compra->id }}" id="ingreso_compra_id">
            <div class="form-group row font-roboto-12">
                <div class="col-md-4 pr-1 pl-1">
                    <label for="almacen" class="d-inline"><b>Almacen</b></label>
                    <input type="text" value="{{ $ingreso_compra->almacen->nombre }}" class="form-control font-roboto-11" disabled>
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <label for="codigo" class="d-inline"><b>Codigo</b></label>
                    <input type="text" value="{{ $ingreso_compra->codigo }}" class="form-control font-roboto-11" disabled>
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-4 pr-1 pl-1">
                    <label for="area_solicitante" class="d-inline"><b>Unidad Solicitante</b></label>
                    <input type="text" value="{{ $ingreso_compra->area->nombrearea }}" class="form-control font-roboto-11" disabled>
                </div>
                <div class="col-md-4 pr-1 pl-1">
                    <label for="proveedor" class="d-inline"><b>Proveedor</b></label>
                    <input type="text" value="{{ $ingreso_compra->proveedor->nombre }}" class="form-control font-roboto-11" disabled>
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <label for="estado" class="d-inline"><b>Estado</b></label>
                    <input type="text" value="{{ $ingreso_compra->status }}" class="form-control font-roboto-11 {{ $ingreso_compra->colorInputStatus}}" disabled>
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-12 pr-1 pl-1">
                    <label for="obs" class="d-inline"><b>Observaciones</b></label>
                    <textarea name="obs" id="obs" class="form-control font-roboto-11"></textarea>
                </div>
                @if ($ingreso_compra->user_id != null)
                    <div class="col-md-2 pr-1 pl-1">
                        <label for="user" class="d-inline"><b>Ingresado por</b></label>
                        <input type="text" value="{{ strtoupper($ingreso_compra->user->name) }}" class="form-control font-roboto-11" disabled>
                    </div>
                @endif
                @if ($ingreso_compra->fecha_ingreso != null)
                    <div class="col-md-2 pr-1 pl-1">
                        <label for="fecha" class="d-inline"><b>Fecha de ingreso</b></label>
                        <input type="text" value="{{ \Carbon\Carbon::parse($ingreso_compra->fecha_ingreso)->format('d/m/Y') }}" class="form-control font-roboto-11" disabled>
                    </div>
                @endif
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-10 pr-1 pl-1">
                    <div class="card">
                        <div class="card-header text-center">
                            <strong><u>DETALLE DEL INGRESO</u></strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-12 pr-1 pl-1 table-responsive">
                                    <table id="detalle_tabla" class="table table-striped display table-bordered responsive hover-orange" style="width:100%;">
                                        <thead>
                                            <tr class="font-roboto-11">
                                                <th class="text-left p-1">PARTIDA PRESUPUESTARIA</th>
                                                <th class="text-left p-1">MATERIAL</th>
                                                <th class="text-center p-1">MEDIDA</th>
                                                <th class="text-right p-1">CANTIDAD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ingreso_compra_detalles as $datos)
                                                <tr class="font-roboto-11">
                                                    <td class="text-left p-1">{{ $datos->partidaPresupuestaria->numeracion . ' - ' . $datos->PartidaPresupuestaria->nombre }}</td>
                                                    <td class="text-left p-1">{{ $datos->item->nombre }}</td>
                                                    <td class="text-center p-1">{{ $datos->unidad_medida->nombre }}</td>
                                                    <td class="text-right p-1">{{ number_format($datos->cantidad,2,'.',',') }}</td>
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
        </form>
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
            var url = "{{ route('ingreso.compra.ingresar') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function imprimir(){
            var id = $("#ingreso_compra_id").val();
            var url = "{{ route('ingreso.compra.pdf',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function cancelar(){
            var url = "{{ route('ingreso.compra.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
