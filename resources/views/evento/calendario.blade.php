@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>CALENDARIO DE EVENTOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="row abs-center">
            <div class="col-md-3 bg-success p-2">
                <a href="{{ asset('/evento/index/') }}/<?= $data['last'] ?>" class="m-3">
                    <i class="fas fa-chevron-circle-left fa-2x text-white"></i>
                </a>
            </div>
            <div class="col-md-3 bg-success p-3 text-center font-roboto-25">
                <b class="text-white"><?= $mespanish ?> <?= $data['year'] ?></b>
            </div>
            <div class="col-md-3 bg-success p-2 text-right">
                <a href="{{ asset('/evento/index/') }}/<?= $data['next'] ?>" class="m-3">
                    <i class="fas fa-chevron-circle-right fa-2x text-white"></i>
                </a>
            </div>
        </div>
        <div class="row abs-center">
            <div class="col-md-9 bg-warning">
                <div class="row font-roboto-12">
                    <div class="col text-center border border-white"><b>L</b></div>
                    <div class="col text-center border border-white"><b>M</b></div>
                    <div class="col text-center border border-white"><b>X</b></div>
                    <div class="col text-center border border-white"><b>J</b></div>
                    <div class="col text-center border border-white"><b>V</b></div>
                    <div class="col text-center border border-white"><b>S</b></div>
                    <div class="col text-center border border-white"><b>D</b></div>
                </div>
            </div>
        </div>
        <div class="row abs-center">
            <div class="col-md-9">
                @foreach ($data['calendar'] as $weekdata)
                    <div class="row font-roboto-12">
                        @foreach ($weekdata['datos'] as $dayweek)
                            @if ($dayweek['mes'] == $mes)
                                <div class="col text-center border border-warning hover-effect">
                                    <a href="{{ route('agenda.ej.detalle',['id' => $dayweek['dia'],'id2' => $mespanish, 'id3' => $data['year']]) }}" class="text-dark">
                                        <div style="position: relative; display: inline-block;">
                                            <i class="far fa-calendar fa-3x text-success"></i>
                                            <span class="font-roboto-11" style="position: absolute; top: 60%; left: 50%; transform: translate(-50%, -50%);">
                                                <b>{{ $dayweek['dia'] }}</b>
                                            </span>
                                        </div>
                                    </a>
                                    <hr>
                                    @foreach ($dayweek['evento'] as $event)
                                        <span class="font-roboto-12">
                                            <i class="fa-solid fa-square-check fa-fw"></i>
                                            {{ Carbon\Carbon::parse($event->horaini)->format('H:i') }}<br>
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <div class="col text-center border border-warning">
                                    &nbsp;
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row abs-center">
            <div class="col-md-9 bg-warning">
                <div class="row font-roboto-12">
                    <div class="col text-center border border-white"><b>L</b></div>
                    <div class="col text-center border border-white"><b>M</b></div>
                    <div class="col text-center border border-white"><b>X</b></div>
                    <div class="col text-center border border-white"><b>J</b></div>
                    <div class="col text-center border border-white"><b>V</b></div>
                    <div class="col text-center border border-white"><b>S</b></div>
                    <div class="col text-center border border-white"><b>D</b></div>
                </div>
            </div>
        </div>
        <div class="row abs-center">
            <div class="col-md-3 bg-success p-2">
                <a href="{{ asset('/agenda-ej/index/') }}/<?= $data['last'] ?>" class="m-3">
                    <i class="fas fa-chevron-circle-left fa-2x text-white"></i>
                </a>
            </div>
            <div class="col-md-3 bg-success p-3 text-center font-roboto-25">
                <b class="text-white"><?= $mespanish ?> <?= $data['year'] ?></b>
            </div>
            <div class="col-md-3 bg-success p-2 text-right">
                <a href="{{ asset('/agenda-ej/index/') }}/<?= $data['next'] ?>" class="m-3">
                    <i class="fas fa-chevron-circle-right fa-2x text-white"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
