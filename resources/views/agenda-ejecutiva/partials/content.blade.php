@foreach ($eventos as $datos)
    <div class="row abs-center">
        <div class="col-md-12 pr-1 pl-1">
            <div class="card card-body hover-effect">
                <div class="form-group row font-roboto-14">
                    <div class="col-md-12 pr-1 pl-1 text-center">
                        <b><u>{{ $datos->titulo }}</u></b>
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-12 pr-1 pl-1">
                        <label for="descripcion" class="d-inline"><b>Descripcion:</b></label><br>
                        {{ $datos->descripcion }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-2 pr-1 pl-1">
                        <label for="hora" class="d-inline"><b>Hora:</b></label><br>
                        {{ Carbon\Carbon::parse($datos->horaini)->format('H:i') }}
                    </div>
                    <div class="col-md-4 pr-1 pl-1">
                        <label for="lugar" class="d-inline"><b>Lugar:</b></label><br>
                        {{ $datos->lugar }}
                    </div>
                    <div class="col-md-3 pr-1 pl-1 text-justify">
                        <label for="coordinar" class="d-inline"><b>Coordinar con:</b></label><br>
                        {{ $datos->coordinar }}
                    </div>
                    <div class="col-md-3 pr-1 pl-1 text-justify">
                        <label for="representante" class="d-inline"><b>Representante G.A.R.G.CH.:</b></label><br>
                        {{ $datos->representante }}
                    </div>
                </div>
                @can('agenda.ejecutiva.editar')
                    <div class="row font-roboto-12">
                        <div class="col-md-12 pr-1 pl-1 text-right">
                            <a href="{{ route('agenda.ejecutiva.editar',$datos->id) }}" class="btn btn-outline-secondary font-roboto-12">
                                <i class="fas fa-edit fa-fw"></i> Modificar
                            </a>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
    <br>
@endforeach
