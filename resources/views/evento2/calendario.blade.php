@extends('layouts.dashboard')
@section('content')

    <meta content="">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Exo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Exo', sans-serif;
        }

        .header-col {
            background: #E3E9E5;
            color: #536170;
            text-align: center;
            font-size: 20px;
            font-weight: bold;

        }

        .header-calendar {
            background: rgb(20, 119, 219);
            color: white;

        }

        .box-day {
            border: 1px solid #c6ecd5;
            height: 150px;

        }

        .box-dayoff {
            border: 1px solid #E3E9E5;
            height: 150px;
            background-color: #ccd1ce;
        }
    </style>

    </head>

    <body>

        <div class="container col-md-6 table-responsive">

            <h4 style="text-align:center"><b style="color:rgb(20, 119, 219)">Calendario - Evento</b></h4>




            <div class="row header-calendar">

                <div class="col" style="display: flex; justify-content: space-between; padding: 10px;">
                    <a href="{{ asset('/Evento2/index/') }}/<?= $data['last'] ?>" style="margin:10px;">
                        <i class="fas fa-chevron-circle-left" style="font-size:25px;color:white;"></i>
                    </a>
                    <h4 style="font-weight:bold;margin:10px;"><?= $mespanish ?> <small><?= $data['year'] ?></small></h4>
                    <a href="{{ asset('/Evento2/index/') }}/<?= $data['next'] ?>" style="margin:10px;">
                        <i class="fas fa-chevron-circle-right" style="font-size:25px;color:white;"></i>
                    </a>
                </div>

            </div>

            <div class="row ">
                <div class="col header-col" style="font-size: 10px">L</div>
                <div class="col header-col" style="font-size: 10px">M</div>
                <div class="col header-col" style="font-size: 10px">X</div>
                <div class="col header-col" style="font-size: 10px">J</div>
                <div class="col header-col" style="font-size: 10px">V</div>
                <div class="col header-col" style="font-size: 10px">S</div>
                <div class="col header-col" style="font-size: 10px">D</div>
            </div>

            <!-- inicio de semana -->
            @foreach ($data['calendar'] as $weekdata)
                <div class="row" >
                    <!-- ciclo de dia por semana -->
                    @foreach ($weekdata['datos'] as $dayweek)
                        @if ($dayweek['mes'] == $mes)
                            <div class="col box-day  table-responsive"  style="font-size: 10px;color: rgb(26, 194, 11);text-align: center;font-weight: bold;">
                                {{ $dayweek['dia'] }}
                                <!-- evento -->
                                <p>

                                <span >
                                    <a href="{{ asset('/Evento2/details/') }}/{{$dayweek['dia']}},{{$mespanish}},{{$data['year']}}">
                                        <span class="text-primary" >
                                            <i class="fa fa-eye fa-2x" style="color:rgb(87, 58, 231)"></i>
                                        </span>
                                    </a>
                                </span>

                                <!-- <a href="{{ asset('/Evento2/details/') }}/{{$dayweek['dia']}},{{$mespanish}},{{$data['year']}}"><FONT size="1">Ver</FONT></a>-->
                                <p>

                                @foreach ($dayweek['evento'] as $event)

                                    <a class="badge badge-light" style="font-size: 8px;color: black;font-weight: bold;">
                                        {{Carbon\Carbon::parse($event->horaini)->format('H:i') }}

                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="col box-dayoff">
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach

        </div> <!-- /container -->



    @endsection
