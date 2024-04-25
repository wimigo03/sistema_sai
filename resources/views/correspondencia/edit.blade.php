@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>MODIFICAR CODIGO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <form method="POST" action="{{ route('correspondencia.update', $recepcion->id_recepcion) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-2 pr-1 pl-1">
                    <label for="nombre" class="d-inline"><b>Codigo</b></label>
                    <input type="text" name="codigo" class="form-control font-roboto-12" required value="{{ $recepcion->n_oficio }}">
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-8 text-right">
                    <button class="btn btn-outline-primary font-roboto-12" type="submit">
                        <i class="fa-solid fa-paper-plane fa-fw"></i>&nbsp;Guardar
                    </button>
                    <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                        <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
                    </span>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function cancelar(){
            var url = "{{ route('correspondencia.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
