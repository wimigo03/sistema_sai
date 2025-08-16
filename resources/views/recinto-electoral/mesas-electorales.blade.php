<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    .div_detalle, .div_cabecera {
        padding: 15px;
        border-radius: 8px;
        background-color: #f1f1f1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .div_cabecera {
        margin-bottom: 20px;
    }

    .div_detalle {
        margin-top: 20px;
    }
</style>
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Mesas Electorales</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-file-lines fa-fw"></i>&nbsp;<b class="title-size">MESAS ELECTORALES</b>
            </div>
        </div>

        <div class="card-body">
            <div class="div_detalle mb-4">
                <div class="row" style="display: flex; justify-content: space-between;">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                            <a href="{{ route('recintos.index') }}" class="btn btn-outline-secondary w-100 w-md-auto py-2 font-roboto-14 font-weight-bold">
                                <i class="fas fa-exchange-alt fa-fw"></i> Cambiar de Reciento Electoral
                            </a>
                        </div>
                        <div class="text-center mt-3">
                            <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 abs-center">
                    <div class="col-12 text-center">
                        @foreach ($mesasElectorales as $datos)
                        <div class="row">
                            <div class="col-11">
                                @if ($datos->estado == 1)
                                    <a href="{{ route('recintos.show.detalle.mesas.electorales',$datos->id) }}" class="btn btn-outline-primary d-block mb-2">
                                        <i class="fas fa-vote-yea me-2"></i> Mesa {{ $datos->numero }}
                                    </a>
                                @else
                                    <a href="#" class="btn btn-outline-secondary d-block mb-2">
                                        <i class="fas fa-vote-yea me-2"></i> Mesa {{ $datos->numero }}
                                    </a>
                                @endif
                            </div>
                            <div class="col-1">
                                @if (Auth::user()->id == 102)
                                    @if ($datos->estado == 1)
                                        <a href="{{ route('recintos.mesas.deshabilitar',$datos->id) }}" class="btn btn-outline-danger text-dark d-block mb-2">
                                            <i class="fas fa-ban fa-fw"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('recintos.mesas.habilitar',$datos->id) }}" class="btn btn-outline-success text-dark d-block mb-2">
                                            <i class="fas fa-check fa-fw"></i>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {

            });

            var Modal = function(mensaje){
                $("#modal-alert .modal-body").html(mensaje);
                $('#modal-alert').modal({keyboard: false});
            }

            function procesar() {
                if(!validar()){
                    return false;
                }

                confirmar();
            }

            function confirmar(){
                var url = "{{ route('recintos.store') }}";
                $("#form").attr('action', url);
                $(".btn").hide();
                $(".spinner-btn").show();
                $("#form").submit();
            }
        </script>
    @endsection
@endsection
