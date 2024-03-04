@extends('layouts.admin')
@section('content')
<style>
    table tbody tr:hover{background:rgba(143, 217, 240, 0.497)!important;}
</style>

<div class="header">
    <div class="row font-verdana-12">
        <div class="col-md-10 titulo">
            <b>CREDENCIALES</b>
        </div>

        &nbsp;&nbsp;&nbsp;



                    <a href="{{ route('credencial.create', $idsolicitud) }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
                            <button class="btn btn-sm btn-info   font-verdana" type="button" >
                                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                            </button>
                        </a>




        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>


</div>
<hr>

{{-- <input type="text" name="nombredocumento" value="{{$solicitud->idsolicitud}}"> --}}
    <div class="body">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <center>
                    <table class="table display table-bordered responsive font-verdana" style="width:100%;">
                        <thead>
                            <tr>
                                <td class="text-center p-1"><b>NOMBRES</b></td>
                                <td class="text-center p-1"><b>CI</b></td>
                                <td class="text-center p-1"><b>N° STAND</b></td>
                                <td class="text-center p-1"><b>FOTO</b></td>
                                <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($credenciales as $credencial)
                                <tr>
                                    <td class="text-center p-1">{{$credencial->nombres}}</td>
                                    <td class="text-center p-1">{{$credencial->ci}}</td>
                                    <td class="text-center p-1">{{$credencial->stand}}</td>
                                    <td class="text-center p-1">{{$credencial->foto}}</td>
                                    <td style="padding: 0;" class="text-center p-1">
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Credenciales">
                                            <a href="{{ route('expochaco.generarqr', $credencial->idcredencial) }}" target="blank_">
                                                <span class="text-info">
                                                    <i class="fa-solid fa-xl fa-qrcode" style="color:  black"></i>
                                                </span>
                                            </a>
                                        </span>
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    {{ $credenciales->appends(Request::all())->links() }}
                                    <p class="text-muted">Mostrando
                                        <strong>{{$credenciales->count()}}</strong> registros de
                                        <strong>{{$credenciales->total()}}</strong> totales
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



</script>
@endsection
