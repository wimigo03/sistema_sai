@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fas fa-warehouse fa-fw"></i>&nbsp;<b class="title-size">REGISTRO DE MOVIMIENTOS</b>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-center justify-content-md-end">
                    <button class="btn btn-outline-danger w-100 w-md-auto btn-size mr-2 font-roboto-14" type="button" onclick="window.history.back();">
                        <i class="fas fa-fast-backward fa-fw"></i> Volver al Inventario de Almacen
                    </button>
                </div>
                <div class="col-12 text-center mt-2">
                    <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 table-responsive">
                    <table class="table display table-bordered table-striped responsive hover-orange" style="width:100%;">
                        <thead class="bg-dark text-white">
                            <tr class="font-roboto-13">
                                <td class="text-center p-2 text-nowrap"><b>COD.</b></td>
                                <td class="text-center p-2 text-nowrap"><b>ALMACEN</b></td>
                                <td class="text-center p-2 text-nowrap"><b>CAT. PROG.</b></td>
                                <td class="text-left p-2 text-nowrap"><b>PARTIDA PRESUPUESTARIA</b></td>
                                <td class="text-left p-2 text-nowrap"><b>PRODUCTO</b></td>
                                <td class="text-center p-2 text-nowrap"><b>MEDIDA</b></td>
                                <td class="text-center p-2 text-nowrap">&nbsp;</td>
                                <td class="text-center p-2 text-nowrap"><b>MOVIMIENTO</b></td>
                                <td class="text-center p-2 text-nowrap"><b>FECHA</b></td>
                                <td class="text-center p-2 text-nowrap"><b>N° COMP.</b></td>
                                <td class="text-right p-2 text-nowrap"><b>CANTIDAD</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($movimientos_inventarios as $datos)
                                <tr class="font-roboto-13">
                                    <td class="text-center p-2 text-nowrap">{{ $datos->id }}</td>
                                    <td class="text-center p-2 text-nowrap">{{ $datos->almacen->nombre }}</td>
                                    <td class="text-center p-2 text-nowrap">
                                        <span class="tts:right tts-slideIn tts-custom mr-1" aria-label="{{ $datos->categoriaProgramatica->nombre }}" style="cursor: pointer;">
                                            {{ $datos->categoriaProgramatica->codigo }}
                                        </span>
                                    </td>
                                    <td class="text-left p-2 text-nowrap">
                                        {{ $datos->partidaPresupuestaria->codigo . ' - ' . $datos->partidaPresupuestaria->nombre }}
                                    </td>
                                    <td class="text-left p-2 text-nowrap">{{ $datos->producto->codigo . ' - ' . $datos->producto->nombre }}</td>
                                    <td class="text-center p-2 text-nowrap">{{ $datos->producto->unidad_medida->nombre }}</td>
                                    <td class="text-center p-2 text-nowrap">{!! $datos->movimiento_tipo_badge !!}</td>
                                    <td class="text-center p-2 text-nowrap">{{ $datos->movimiento_tipo }}</td>
                                    <td class="text-center p-2 text-nowrap">{{ \Carbon\Carbon::parse($datos->fecha)->format('d-m-Y') }}</td>
                                    <td class="text-center p-2 text-nowrap">{{ $datos->referencia->codigo }}</td>
                                    <td class="text-right p-2 text-nowrap">{{ $datos->cantidad }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });
    </script>
@endsection
