@extends('layouts.dashboard')
@section('content')
<br>
<div class="row font-verdana-12">
    <div class="col-md-10 text-left titulo">
        <b>ROLES</b>
    </div>
    <div class="col-md-2 text-right">
        <span class="tts:left tts-slideIn tts-custom" aria-label="Agregar un nuevo rol">
            <button class="btn btn-success font-verdana-12" type="button" onclick="create();">
                &nbsp;<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </span>
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>
<div class="row">
    <div class="col-md-12 table-responsive">
        <center>
            <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:100%">
                <thead>
                    <tr>
                        <td class="text-justify p-1"><b>ID</b></td>
                        <td class="text-justify p-1"><b>TITULO</b></td>
                        <td class="text-right p-1"><b>CODIGO</b></td>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $datos)
                        <tr>
                            <td class="text-justify p-1">{{$datos->id}}</td>
                            <td class="text-justify p-1">{{$datos->title}}</td>
                            <td class="text-right p-1">{{$datos->short_code}}</td>
                            <td class="text-center p-1">
                                
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                        <a href="{{route('admin.roles.show',$datos->id)}}">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-2xl fa-square-info"></i>
                                            </span>
                                        </a>
                                    </span>
                              
                               
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                                        <a href="{{route('admin.roles.edit',$datos->id)}}">
                                            <span class="text-warning">
                                                <i class="fa-solid fa-2xl fa-pen-to-square"></i>
                                            </span>
                                        </a>
                                    </span>
                              
                               
                                    <form action="{{ route('admin.roles.destroy', $datos->id) }}" class="d-inline-block" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <span type="submit" onclick="return confirm('Esta Ud. seguro?')">
                                            <span class="text-danger">
                                                <i class="fa-solid fa-xl fa-trash" aria-hidden="true"></i>
                                            </span>
                                        </span>
                                    </form>
                               
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </center>
    </div>
    <div class="col-md-12 text-center">
        ---------------------------------------------------------------------------
    </div>
    <div class="col-md-12 table-responsive">
        <table id="tablaAjax" class="table display table-bordered responsive font-verdana" style="width:100%">
            <thead>
                <tr>
                    <td class="text-justify p-1"><b>ID</b></td>
                    <td class="text-justify p-1"><b>TITULO</b></td>
                    <td class="text-justify p-1"><b>CODIGO</b></td>
                    <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tablaAjax').DataTable({
                "processing":true,
                "ajax":"{{ route('admin.roles.index.ajax') }}",
                "serverSide":true,
                "columns": [
                    {data: 'id', name:'id', class:'text-justify p-1 font-verdana'},
                    {data: 'title',  name:'title', class:'text-justify p-1 font-verdana'},
                    {data: 'short_code', name:'short_code', class:'text-right p-1 font-verdana'},
                    {data: 'btnActions', class:'text-center font-verdana'}
                ],
                "iDisplayLength": 10,
                "order": [[ 0, "desc" ]],
                language: {
                    url: '/spain.json'
                },
            });

            $('#dataTable').DataTable({
                language: {
                    url: '/spain.json'
                },
                order: [[ 0, "desc" ]]
            });
        });

        function create(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            //var idcompra = $("#idcompra").val();
            var url = "{{ route('admin.roles.create') }}";
            //url = url.replace(':id',idcompra);
            window.location.href = url;
        }
    </script>
@endsection