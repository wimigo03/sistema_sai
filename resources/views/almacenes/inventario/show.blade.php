@extends('layouts.dashboard')
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>ALMACEN {{ $almacen->nombre }}</strong>
            </div>
        </div>
        <form action="#" method="get" id="form">
            <input type="hidden" value="{{ $almacen->id }}" name="almacen_id" id="almacen_id">
            <div class="form-group row font-roboto-11 abs-center">
                <div class="col-md-6 pr-1 pl-1">
                    <select name="partida_presupuestaria_id" id="partida_presupuestaria_id" class="form-control">
                        <option value="">-</option>
                        @foreach ($partidas_presupuestarias as $index => $value)
                            <option value="{{ $index }}" @if(request('partida_presupuestaria_id') == $index) selected @endif >{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 pr-1 pl-1">
                    <input type="text" name="item" value="{{ request('item') }}" id="item" placeholder="--Item--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
                </div>
            </div>
        </form>
        <div class="form-group row abs-center">
            <div class="col-md-10 pr-1 pl-1">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder" style="cursor: pointer;">
                    <span class="btn btn-outline-primary font-roboto-12" onclick="retroceder();">
                        <i class="fas fa-angle-double-left fa-fw"></i>
                    </span>
                </span>
                <span class="btn btn-outline-danger font-roboto-12 float-right" onclick="limpiar();">
                    <i class="fas fa-eraser fa-fw"></i> Limpiar
                </span>
                <span class="btn btn-outline-primary font-roboto-12 float-right mr-1" onclick="search();">
                    <i class="fas fa-search fa-fw"></i> Buscar
                </span>
            </div>
        </div>
        <div class="form-group row abs-center">
            <div class="col-md-10 pr-1 pl-1 table-responsive">
                <table class="table display table-bordered table-striped responsive hover-orange" style="width:100%;">
                    <thead>
                        <tr class="font-roboto-11">
                            <td class="text-left p-1"><b>PARTIDA PRESUPUESTARIA</b></td>
                            <td class="text-left p-1"><b>ITEM</b></td>
                            <td class="text-right p-1"><b>SALDO</b></td>
                            <td class="text-center p-1"><b>MEDIDA</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ingreso_compra_detalles as $datos)
                            <tr class="font-roboto-11">
                                <td class="text-left p-1">{{ $datos->partida->codigo . ' - ' . $datos->partida->nombre }}</td>
                                <td class="text-left p-1">{{ $datos->item->nombre }}</td>
                                <td class="text-right p-1">{{ $datos->saldo_total }}</td>
                                <td class="text-center p-1">{{ $datos->unidad_medida->nombre }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-roboto-11">
                            <td colspan="12">
                                {{ $ingreso_compra_detalles->appends(Request::all())->links() }}
                                <p class="text- muted">Mostrando
                                    <strong>{{$ingreso_compra_detalles->count()}}</strong> registros de
                                    <strong>{{$ingreso_compra_detalles->total()}}</strong> totales
                                </p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#partida_presupuestaria_id').select2({
                theme: "bootstrap4",
                placeholder: "--Partida Presupuestaria--",
                width: '100%'
            });
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

        $('#partida_presupuestaria_id').change(function() {
            var id = $(this).val();
            search();
        });

        function search(){
            var id = $("#almacen_id").val();
            var url = "{{ route('almacen.show.search',':id') }}";
            url = url.replace(':id',id);
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var id = $("#almacen_id").val();
            var url = "{{ route('almacen.show',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function retroceder(){
            var url = "{{ route('almacen.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
