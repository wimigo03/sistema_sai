
@extends('layouts.admin')
@section('content')
@if(Session::has('message'))
<div class="alert alert-success">
    <em> {!! session('message') !!}</em>
</div>
@endif

<script type="text/javascript">

          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

           <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/export-data.js"></script>
            <script src="https://code.highcharts.com/modules/accessibility.js"></script>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
            <script src="https://code.highcharts.com/highcharts.js"></script>
            

</script>

    <h1>Grafica de ingreso almacen</h1>
    <center>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th >Programa</th>
                <th >iten</th>
                <th >cantidad</th>
                <th >Subtotal</th>
            
            
           
            </tr>
        </thead>
        <tbody>

          
                @foreach($ingresos as $item)
                    <tr>
                        <td>{{ $item->nombreprograma }}</td>
                        <td>{{ $item->nombreproducto }}</td>

                     
                        <td>{{ $item->cantidad }}</td>
                        <td>{{ $item->subtotal }}</td>
                       
                    
                    </tr>
                @endforeach
          

            
            <!-- Más filas aquí -->
        </tbody>
    </table>
</center>

<center>
    <div class="container" mt-5>
        <div class="row">
            <div class="col">
                <div id="container"></div>
                </div>
            
            </div>
        
        </div>
    </center>


            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
      
            

   


    <script >

$(document).ready(function() {
    var allSeriesData = [];
    var categories = [];

    var table = $('#myTable').DataTable( {

        
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
},


        initComplete: function(settings, json) {
            var api = new $.fn.dataTable.Api(settings);

            // Obtén las categorías del eje x de los encabezados de la tabla:
            var headers = api.columns().header().toArray();
            headers.forEach(function(heading, index) {
                if (index == 2) { // Solo toma en cuenta la columna de cantidad
                    categories.push($(heading).html());
                }
            });

            // Obtén los datos de la serie como un array de números de los datos de las filas de la tabla:
            var rows = api.rows().data().toArray();
            rows.forEach(function(row) {
                var group = {
                    name: '',
                    data: []
                };
                row.forEach(function(cell, idx) {
                    if (idx == 0) { // Considera la columna de nombreprograma como el nombre de la serie
                        group.name = cell;
                    } else if (idx == 2) { // Solo toma en cuenta la columna de cantidad
                        group.data.push(parseFloat(cell.replace(/,/g, '')));
                    }
                });
                allSeriesData.push(group);
            });
        }
    });

    var chart = Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Test Data'
        },
        xAxis: {
            categories: categories
        },
        series: allSeriesData
    });

    
});

</script>

</script>

@endsection


