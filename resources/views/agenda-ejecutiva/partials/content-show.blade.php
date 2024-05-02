<div class="row abs-center">
    <div class="col-md-12 pr-1 pl-1">
        <div class="card card-body hover-effect">
            <div class="form-group row font-roboto-14">
                <div class="col-md-12 pr-1 pl-1 text-center">
                    <b><u>{{ $evento->titulo }}</u></b>
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-12 pr-1 pl-1">
                    <label for="descripcion" class="d-inline"><b>Descripcion:</b></label><br>
                    {{ $evento->descripcion }}
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-12 pr-1 pl-1">
                    <label for="hora" class="d-inline"><b>Hora:</b></label><br>
                    {{ Carbon\Carbon::parse($evento->horaini)->format('H:i') }}
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-4 pr-1 pl-1">
                    <label for="lugar" class="d-inline"><b>Lugar:</b></label><br>
                    {{ $evento->lugar }}
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-3 pr-1 pl-1 text-justify">
                    <label for="coordinar" class="d-inline"><b>Coordinar con:</b></label><br>
                    {{ $evento->coordinar }}
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-3 pr-1 pl-1 text-justify">
                    <label for="representante" class="d-inline"><b>Representante G.A.R.G.CH.:</b></label><br>
                    {{ $evento->representante }}
                </div>
            </div>
            @can('agenda.ejecutiva.editar')
                <div class="row font-roboto-12">
                    <div class="col-md-12 pr-1 pl-1 text-right">
                        <a href="{{ route('agenda.ejecutiva.editar',$evento->id) }}" class="btn btn-outline-secondary font-roboto-12">
                            <i class="fas fa-edit fa-fw"></i> Modificar
                        </a>
                    </div>
                </div>
            @endcan
        </div>
    </div>
</div>
