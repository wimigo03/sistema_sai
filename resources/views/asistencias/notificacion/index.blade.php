@extends('layouts.admin')

@section('content')
    <div class="row mt-5 ">
        <div class=" col-md-4 m-4 m-md-4 ">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-left mini-stat-img mr-4">
                            <span class="fa fa-users" style="font-size: 30px"></span>
                        </div>
                        <h6 class="font-16 text-uppercase mt-0 text-white-50">Total <br>Natalicio</h6>

                    </div>
                    <span class="fa fa-user float-left " style="font-size: 80px; color:cadetblue "></span>

                    <div class="text-right">
                        @if ($cumplenAnioshoy > 0)
                            <h1 class="font-500 text-right"> {{ $cumplenAnioshoy }}</h1>
                        @else
                            <h1>0</h1>
                        @endif
                    </div>
                    <div class="text-right ml-5 ">

                        <a href="#hoy" data-toggle="modal" class="text-white-50"><i class=" mdi-arrow-right h6">HOY
                                </i></a>
                        </a>
                    
                    </div>
                    <div class="text-right ml-5 ">

                        <a href="#mes" data-toggle="modal" class="text-white-50"><i class=" mdi-arrow-right h6">MES
                                </i></a>
                        </a>
                    
                    </div>
    
                   


                    <!-- Log on to codeastro.com for more projects! -->
                </div>


            </div>
        </div>
         
    </div>

    @include('asistencias.notificacion.mostrar_emp')
    @section('scripts')
<script>
$(document).ready(function() {
    $('#empleados-fecha').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5' // Agrega el botón de exportación a Excel
        ]
    });
});
</script>
@endsection
  @endsection
