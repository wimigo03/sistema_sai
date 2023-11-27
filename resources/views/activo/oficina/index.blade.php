@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">
  <div class="row">
    OFICINAS
  </div>
  <div class="col-md-12">
    <hr class="hrr">
  </div>
</div>

<div class="col-md-12">
  <table class="table table-bordered customers-table table-hover" id="customers-table">
    <thead>
      <tr>
        {{-- <th class="text-center"></th> --}}
        <th class="text-center">ID</th>
        <th class="text-center">OFICINA</th>
        <th class="text-center"><i class="fa fa-bars" aria-hidden="true"></i></th>
      </tr>
    </thead>
  </table>
</div>

@section('scripts')
<script id="details-template" type="text/x-handlebars-template">
  @verbatim
        <table class="table details-table" id="purchases-{{idarea}}">
          <thead>
            <tr>
              <th class="text-justify">NOMBRES</th>
              <th class="text-justify">AP. PATERNO</th>
              <th class="text-justify">AP.MATERNO</th>
              <th class="text-justify">N° CARNET</th>
              <th class="text-justify">INGRESO</th>               
            </tr>
          </thead>
        </table>
  @endverbatim
</script>
<script>
  var template = Handlebars.compile($("#details-template").html());
  var table = $('#customers-table').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    autoWidth: true,
    ajax: "{{ route('oficina.list') }}",
    columns: [
      // {
      //   "className": 'details-control',
      //   "orderable": false,
      //   "searchable": false,
      //   "data": null,
      //   "defaultContent": ''
      // },
      {
        data: 'idarea',
        name: 'idarea',
        class: 'text-center p-1 font-verdana-sm'
      },
      {
        data: 'nombrearea',
        name: 'nombrearea',
        class: 'text-justify p-1 font-verdana-sm'
      },
      {
        data: 'btn2',
        name: 'btn2',
        orderable: true,
        searchable: false,
        class: 'text-center p-1 font-verdana-sm'
      }
    ],
    order: [
      [0 , 'asc']
    ],
    "iDisplayLength": 15,
    "language": {
      "info": "<span class='font-verdana'>Mostrando _START_ al _END_ de _TOTAL_</span>",
      "search": '',
      "searchPlaceholder": "Buscar",
      "paginate": {
        "next": "<span class='font-verdana'><b>Siguiente</b></span>",
        "previous": "<span class='font-verdana'><b>Anterior</b></span>",
      },
      "lengthMenu": "<span class='font-verdana'>Mostrar </span>" +
        "<select class='form form-control-sm'>" +
        "<option value='15'>15</option>" +
        "<option value='50'>50</option>" +
        "<option value='100'>100</option>" +
        "<option value='-1'>Todos</option>" +
        "</select> <span class='font-verdana'>registros</span>",
      "loadingRecords": "<span class='font-verdana'>...Cargando...</span>",
      "processing": "<span class='font-verdana'>...Procesando...</span>",
      "emptyTable": "<span class='font-verdana'>No hay datos</span>",
      "zeroRecords": "<span class='font-verdana'>No hay resultados para mostrar</span>",
      "infoEmpty": "<span class='font-verdana'>Ningun registro encontrado</span>",
      "infoFiltered": "<span class='font-verdana'>(filtrados de un total de _MAX_ registros)</span>"
    }
  });

  $('#customers-table tbody').on('click', 'td.details-control', function() {
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
      ajax: data.url,
      columns: [{
          data: 'nombres',
          name: 'nombres',
          class: 'text-justify p-1 font-verdana-sm'
        },
        {
          data: 'ap_pat',
          name: 'ap_pat',
          class: 'text-justify p-1 font-verdana-sm'
        },
        {
          data: 'ap_mat',
          name: 'ap_mat',
          class: 'text-justify p-1 font-verdana-sm'
        },
        {
          data: 'ci',
          name: 'ci',
          class: 'text-justify p-1 font-verdana-sm'
        },
        {
          data: 'fechingreso',
          name: 'fechingreso',
          class: 'text-justify p-1 font-verdana-sm'
        }
      ],
      order: [
        [1, 'asc']
      ],
      "language": {
        "info": "<span class='font-verdana'>Mostrando _START_ al _END_ de _TOTAL_</span>",
        "search": '',
        "searchPlaceholder": "Buscar",
        "paginate": {
          "next": "<span class='font-verdana'><b>Siguiente</b></span>",
          "previous": "<span class='font-verdana'><b>Anterior</b></span>",
        },
        "lengthMenu": "<span class='font-verdana'>Mostrar </span>" +
          "<select class='form form-control-sm'>" +
          "<option value='10'>10</option>" +
          "<option value='50'>50</option>" +
          "<option value='100'>100</option>" +
          "<option value='-1'>Todos</option>" +
          "</select> <span class='font-verdana'>registros</span>",
        "loadingRecords": "<span class='font-verdana'>...Cargando...</span>",
        "processing": "<span class='font-verdana'>...Procesando...</span>",
        "emptyTable": "<span class='font-verdana'>No hay datos</span>",
        "zeroRecords": "<span class='font-verdana'>No hay resultados para mostrar</span>",
        "infoEmpty": "<span class='font-verdana'>Ningun registro encontrado</span>",
        "infoFiltered": "<span class='font-verdana'>(filtrados de un total de _MAX_ registros)</span>"
      }
    });
  }
</script>
@endsection
@endsection