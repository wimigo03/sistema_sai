<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('dashboard/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome_6.0/css/all.css') }}" rel="stylesheet">
    <title>Login</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 80vh;
            margin: 0;
        }

        .font-roboto-14 {font-size: 14px; font-family: "Roboto", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";}
        .font-roboto-12 {font-size: 12px; font-family: "Roboto", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";}

        .imagen-central {
            width: 100px;
            height: auto;
            overflow: hidden;
            opacity: 0.8;
        }

        .card-custom {
            margin-top: 20px;
        }

        .abs-center {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="row abs-center">
            <div class="col-md-4">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="card card-custom">
                        <div class="card-header font-roboto-14 text-center">
                            <b>
                                INGRESO AL SISTEMA
                            </b>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-roboto-14 bg-success text-white" id="basic-addon1">
                                                <i class="fa-solid fa-user"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="name" class="form-control font-roboto-14" value="{{ old('name') }}" placeholder="Usuario" aria-label="Usuario" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-roboto-14 bg-success text-white" id="basic-addon2">
                                                <i class="fa-solid fa-lock"></i>
                                                </span>
                                            </div>
                                            <input type="password" name="password" class="form-control font-roboto-14" placeholder="Contraseña" aria-label="password" aria-describedby="basic-addon2">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type=submit class="btn btn-block btn-outline-primary font-roboto-14">
                                        <span class="fas fa-sign-in-alt"></span>&nbsp;Iniciar sesion
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <span class="font-roboto-12">© 2023 Gobierno Autonomo Regional del Gran Chaco</span>
                <br>
                <img src="/logos/logoderecha.png" alt="img" class="imagen-central">
            </div>
        </div>
    </div>
    <script src="{{ asset('dataTable_1.10.22/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-1.13.2/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/bootstrap.min.js') }}"></script>
</body>
</html>
