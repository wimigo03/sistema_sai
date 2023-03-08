@extends('layouts.admin')

@section('content')
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>FILES-(Planta)</b>
        </div>
        <div class="col-md-4 text-right">
            @can('file_create_access')
                <a href="{{ route('areas.crearFile', $id) }}" >
                    <button class="btn btn-sm btn-primary font-verdana" type="button" >
                        &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                    </button>
                </a>
            @endcan
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <center>
                <table class="table table-bordered hoverTable text-justify p-1 font-verdana">
                    <tr>

                        <th>Num.File</th>
                        <th>Cargo</th>
                        <th>Nombre Cargo</th>
                        <th>Hab.Basico</th>
                        <th>Categoria</th>
                        <th>Niv.Adm.</th>
                        <th>Clase</th>
                        <th>Niv.Sal.</th>
                        <th>Area</th>
                        <th>Estado</th>
                        <th style="color:black;"><i class="fa fa-bars" aria-hidden="true"></i></th>

                    </tr>
                    @forelse ($file as $files)
                        <tr>

                            <td>{{ $files->numfile }}</td>
                            <td>{{ $files->cargo }}</td>
                            <td>{{ $files->nombrecargo }}</td>
                            <td>{{ $files->habbasico }}</td>
                            <td>{{ $files->categoria }}</td>
                            <td>{{ $files->niveladm }}</td>
                            <td>{{ $files->clase }}</td>
                            <td>{{ $files->nivelsal }}</td>
                            <td>{{ $files->nombrearea }}</td>

                            @if ($files->estadofile == 1)
                                <td style="color:green;font-weight: bold;">Disponible</td>
                            @else
                                <td style="color:red;font-weight: bold;">Ocupado</td>
                            @endif

                            <td>
                                @can('file_edit_access')
                                    <a href="{{ route('file.edit', $files->idfile) }}" style="color:#017EBE;"
                                        class="fas fa-lg fa-edit" title="Editar"></a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
                        </tr>
                    @endforelse
                </table>



                @if ($file->total() > $file->perPage())
                    <br><br>
                    {{ $file->links() }}
                @endif
            </center>
        </div>
    </div>
@endsection
