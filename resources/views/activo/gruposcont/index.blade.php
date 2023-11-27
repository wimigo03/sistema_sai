@extends('layouts.admin')

@section('content')

<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>GRUPO CONTABLE</b>
    </div>
    <div class="col-md-4 text-right">
        @can('gruposcont_create')
        <a href="{{route('activo.gruposcont.create')}}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
            <button class="btn btn-sm btn-primary font-verdana" type="button">
                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </a>
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        @endcan
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>

<div class="row font-verdana-sm">
    <div class="col-md-12">
        <center>
            <table class="table-bordered yajra-datatable hoverTable" style="width:100%;">
                <thead class="font-courier">
                    <tr>
                        <td class="text-center p-1 font-weight-bold"><b>N°</b></td>
                        <td class="text-center p-1 font-weight-bold"><b>NOMBRE GRUPO CONTABLE</b></td>
                        <td class="text-center p-1 font-weight-bold"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </center>
    </div>
</div>



@section('scripts')
<script type="text/javascript">
    $(function() {
        var table = $('.yajra-datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('activo.gruposcont.list') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'nombre',
                    name: 'nombre',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'btn',
                    name: 'btn',
                    orderable: true,
                    searchable: true
                },
            ],
            language: {
                // Agrega la configuración de idioma aquí si es necesario
            }
        });
    });
</script>
@endsection
@endsection