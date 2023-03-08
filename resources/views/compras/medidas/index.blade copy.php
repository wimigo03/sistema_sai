@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">


    <div class="col-md-10">
    </br>
    <div style="color:black;font-weight: bold;font-size: 18px;">Modulo Medidas
        &nbsp;&nbsp;

        @can('medidas_create')
        <a href="{{ route('medidas.create') }}" class="btn btn-outline-info btn-sm">Agregar</a>
        @endcan
    </div>
    </br>
        <div class="card">

            <div class="card-body">
            <font size="2" face="Courier New" >
                <table class="table table-bordered yajra-datatable hoverTable">
                    <thead>
                        <tr>
                            <th style="color:black;width:30px;">N°</th>
                            <th style="color:black">Nombre</th>
                            <th style="color:black;width:50px;">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
</font>
            </div>
        </div>
    </div>
</div>

@section('scripts')

<script type="text/javascript">
$(function() {

    var table = $('.yajra-datatable').DataTable({


        "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
}      ,

        processing: true,
        serverSide: true,
        ajax: "{{ route('medidas.list') }}",
        columns: [

            {data: 'DT_RowIndex',name: 'DT_RowIndex' },

            {data: 'nombreumedida',name: 'nombreumedida'},

            {data: 'btn',name: 'btn',orderable: true,searchable: true},
                 ]

    });

});
</script>

@endsection
@endsection
