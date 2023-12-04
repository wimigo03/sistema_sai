@extends('layouts.admin')
@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>SOLICITUDES PENDIENTES</b>
    </div>
    <div class="col-md-4 text-right">
        @can('comprascomb_aprovadas')

            <a href="{{ route('combustibles.pedido.index2') }}" class="tts:left tts-slideIn tts-custom" aria-label="ir a solicitudes aprobadas">
                <button class="btn btn-sm btn-success font-verdana" type="button" >SOLICITUDES APROBADAS
                    &nbsp;<i class="fa-solid fa-thumbs-up" style="font-size:14px"></i>&nbsp;
                </button>
            </a>

            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

        @endcan
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <center>
                        <table id="horarios-table" class="table-bordered yajra-datatable hoverTable responsive font-verdana" style="width:100%;">
                            <thead class="font-courier">
                                <tr>
                                    <td class="text-justify p-1"><b>OBJETO</b></td>
                                    <td class="text-justify p-1"><b>AREA</b></td>
                                    <td class="text-justify p-1"><b>PROVEEDOR</b></td>
                                    <td class="text-justify p-1"><b>PREVENTIVO</b></td>
                                    <td class="text-justify p-1"><b>NRO.COMPRA</b></td>
                                    <td class="text-justify p-1"><b>ESTADO</b></td>
                                    <td class="text-justify p-1"><b>Acciones</b></td>
                                
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
        </center>
    </div>
</div>
@section('scripts')

<script>
 $(document).ready(function() {
        $('#horarios-table').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('combustibles.pedido.index') }}",

            columns: [{
                    className: 'text-center',
                    data: 'objeto',
                    name: 'objeto'
                },
                {
                    className: 'text-center',
                    data: 'nombrearea',
                    name: 'nombrearea'
                },
                {
                    className: 'text-center',
                    data: 'nombreproveedor',
                    name: 'nombreproveedor'
                },
                {
                    className: 'text-center',
                    data: 'preventivo',
                    name: 'preventivo'
                },
                {
                    className: 'text-center',
                    data: 'numcompra',
                    name: 'numcompra'
                },
                {
                    className: 'text-center',
                    data: 'estadocompracomb',
                    name: 'estadocompracomb'
                },
                
                 {
                     className: 'text-center',
                     data: 'actions',
                     name: 'actions',
                     orderable: false,
                     searchable: false
                 }
            ]
        });
    });
</script>
@endsection
@endsection
