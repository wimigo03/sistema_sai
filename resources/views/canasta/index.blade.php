@extends('layouts.admin')
@section('content')
<style>
    table tbody tr:hover{background:rgba(143, 217, 240, 0.497)!important;}
</style>

<div class="header">
    <div class="row font-verdana-bg">
        <div class="col-md-10 titulo">
            <b>CANASTA</b>
        </div>
        <div class="col-md-2 text-right titulo">
            <button class="btn btn-primary font-verdana" type="button" onclick="search();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

            &nbsp;&nbsp;&nbsp;

            <span class="tts:left tts-slideIn tts-custom" aria-label="Limpiar">
                <a href="{{route('canasta.index')}}">
                    &nbsp;<i class="fa-duotone fa-eraser fa-xl"></i>&nbsp;
                </a>
            </span>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>

    <form action="{{ route('canasta.search') }}" method="get" id="form">
        @csrf
        @include('canasta.partials.search')
    </form>
</div>
<hr>


    <div class="body">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <center>
                    <table class="table display table-bordered responsive font-verdana" style="width:100%;">
                        <thead>
                            <tr>
                                <td class="text-center p-1"><b>ESTADO</b></td>
                                <td class="text-center p-1"><b>NOMBRES</b></td>
                                <td class="text-center p-1"><b>AP.PAT</b></td>
                                <td class="text-center p-1"><b>AP.MAT</b></td>
                                <td class="text-center p-1"><b>DISTRITO</b></td>
                                <td class="text-center p-1"><b>BARRIO</b></td>
                                <td class="text-center p-1"><b>DIRECCION</b></td>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $datos)
                                <tr>
                                    <td class="text-center p-1">{{$datos->estado}}</td>
                                    <td class="text-center p-1">{{$datos->nombres}}</td>
                                    <td class="text-center p-1">{{$datos->ap}}</td>
                                    <td class="text-center p-1">{{$datos->am}}</td>
                                    <td class="text-center p-1">{{$datos->barrios->distrito}}</td>
                                    <td class="text-center p-1">{{$datos->barrios->barrio}}</td>
                                    <td class="text-center p-1">{{$datos->direccion}}</td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    {{ $data->appends(Request::all())->links() }}
                                    <p class="text-muted">Mostrando
                                        <strong>{{$data->count()}}</strong> registros de
                                        <strong>{{$data->total()}}</strong> totales
                                    </p>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </center>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "--Seleccionar--"
        });
    });

    function search(){
        $(".btn").hide();
        $(".spinner-btn-send").show();
        $("#form").submit();
    }


</script>
@endsection
