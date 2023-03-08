@extends('layouts.admin')
@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>AREAS</b>
    </div>
    <div class="col-md-4 text-right">
        @can('medidas_create')

        <a href="{{route('areas.create')}}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
                <button class="btn btn-sm btn-primary font-verdana" type="button" >
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

<div class="row">
    <div class="col-md-12">
        <center>
                        <table class="table-bordered yajra-datatable hoverTable" style="width:80%;">
                            <thead class="font-courier">
                                <tr>
                                    <td class="text-center p-1 font-weight-bold"><b>N°</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>NOMBRE</b></td>
                                    <td class="text-center p-1 font-weight-bold">
                                        <i class="fa fa-bars" aria-hidden="true"></i>
                                    </td>
                                    <td class="text-center p-1 font-weight-bold">
                                        <i class="fa fa-bars" aria-hidden="true"></i>
                                    </td>
                                    <td class="text-center p-1 font-weight-bold">
                                        <i class="fa fa-bars" aria-hidden="true"></i>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </center>
                    </div>
                </div>

@section('scripts')

<script type="text/javascript">
$(function() {

    var table = $('.yajra-datatable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        responsive: true,

        ajax: "{{ route('areas.list') }}",
        columns: [
                         {data: 'DT_RowIndex',name: 'DT_RowIndex',class:'text-justify p-1 font-verdana' },

                         {data: 'nombrearea',name: 'nombrearea',class:'text-justify p-1 font-verdana'},

                         {data: 'btn', name: 'btn',orderable: false},

                         {data: 'btn2', name: 'btn2',orderable: false},

                         {data: 'btn3', name: 'btn3',orderable: false},
                ]

    });

});
</script>

@endsection
@endsection
