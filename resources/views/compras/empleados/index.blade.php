@extends('layouts.admin')

@section('content')
    <div class="panel-heading">Master details</div>
    <div class="panel-body">
        <table class="table table-bordered" id="customers-table">
            <thead>
            <tr>
                <th></th>
                <th>Id</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
            </thead>
        </table>
    </div>


@section('scripts')

    <script id="details-template" type="text/x-handlebars-template">
        @verbatim
        <div class="label label-info">Customer {{ first_name }}'s Purchases</div>
        <table class="table details-table" id="purchases-{{id}}">
            <thead>
            <tr>
                <th>Id</th>
                <th>Bank account number</th>
                <th>Company</th>
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
        ajax: '{{ route('empleados.list') }}',
        columns: [
          {
            "className":      'details-control',
            "orderable":      false,
            "searchable":     true,
            "data":           null,
            "defaultContent": ''
          },
          { data: 'id', name: 'id' },
          { data: 'first_name', name: 'first_name' },
          { data: 'last_name', name: 'last_name' },
          { data: 'email', name: 'email' },
          { data: 'created_at', name: 'created_at' },
          { data: 'updated_at', name: 'updated_at' },
        ],
        order: [[1, 'asc']],


      // cambiar lenguaje a español

      language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    }
      

      });

      // Add event listener for opening and closing details
      $('#customers-table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var tableId = 'purchases-' + row.data().id;

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
            { data: 'id', name: 'id' },
            { data: 'bank_acc_number', name: 'bank_acc_number' },
            { data: 'company', name: 'company'}
          ]
        })
      }
    </script>
@endsection
@endsection