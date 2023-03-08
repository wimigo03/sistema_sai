@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div style="color:black;font-weight: bold;font-size: 18px;">Modulo Empleados Contrato </div>
           
        </div>
        </div>
    <div class="panel-body">
      <font size="2" face="Courier New" >
        <table class="table table-bordered customers-table table-hover" id="customers-table">
            <thead>
            <tr>
                <th></th>
                <th>Id</th>
                <th>nombre area</th>
                <th>Opciones</th>
              
            </tr>
            </thead>
        </table>
      </font>
    </div>


@section('scripts')

    <script id="details-template" type="text/x-handlebars-template">
        @verbatim
        <div class="label label-info">{{ nombrearea }}</div>
        <table class="table details-table" id="purchases-{{idarea}}">
            <thead>
            <tr>
           
                <th>Nombres</th>
                <th>Ap.Paterno</th>
                <th>Ap.Materno</th>
                <th>ci</th>
                <th>Fech.Ingreso</th>
                
         
                            
            </tr>
            </thead>
        </table>
        @endverbatim
    </script>

    <script>
      var template = Handlebars.compile($("#details-template").html());
      var table = $('#customers-table').DataTable({
      
        processing: true,
        serverSide: true,
       
        scrollY: true,
        ajax: '{{ route('contrato.list') }}',
        columns: [
          {
            "className":      'details-control',
            "orderable":      false,
            "searchable":     false,
            "data":           null,
            "defaultContent": ''
          },
          { data: 'idarea', name: 'idarea' },
          { data: 'nombrearea', name: 'nombrearea' },
          { data: 'btn2', name: 'btn2', orderable: true, searchable: false }
          
         
        ],
        order: [[1, 'asc']],


      // cambiar lenguaje a español

      "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
}      

      });

      // Add event listener for opening and closing details
      $('#customers-table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var tableId = 'purchases-' + row.data().idarea;

        if (row.child.isShown()) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
        } else {
          // Open this row
          row.child(template(row.data())).show();
          initTable(tableId, row.data());
          console.log(row.data());
          tr.addClass('shown');
          tr.next().find('td').addClass('no-padding bg-gray');
        }
      });

      function initTable(tableId, data) {
        $('#' + tableId).DataTable({
          processing: true,
          serverSide: true,
          ajax: data.details_url,
          columns: [
            
            { data: 'nombres', name: 'nombres' },
            { data: 'ap_pat', name: 'ap_pat'},
            { data: 'ap_mat', name: 'ap_mat'},
            { data: 'ci', name: 'ci'},
            { data: 'fechingreso', name: 'fechingreso'}
          
            
       
                      
          ],
          order: [[1, 'asc']],
           // cambiar lenguaje a español

           "language": {
           "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
}
        });
      }
    </script>
@endsection
@endsection