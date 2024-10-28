<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="robots" content="noindex,nofollow">
    <title>G.A.R.G.CH. | S.A.I.</title>
    {{--<link rel="canonical" href="https://www.wrappixel.com/templates/monster-admin-lite/" />--}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/slim-select/slimselect.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dataTable/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dataTable/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard/css/select2-bootstrap4.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard/css/fonts/roboto.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard/css/fonts/poppins.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard/css/fonts/sourceserif.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('font-awesome_6.0/css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/treeview/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('datepicker/datepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard/css/tooltips.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/notificaciones/Lobibox.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/notificaciones/notifications.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('js/jquery-ui-1.13.2/jquery-ui.min.css') }}" rel="stylesheet">
    <style>
        #customers-table tbody td.details-control {
            background-image: url('{{ asset('admin_assets/images/details_open.png') }}');
            cursor: pointer;
            background-repeat: no-repeat;
            background-position: center;
            background-origin: content-box;
            background-size: 20px;
            padding: 7px;
        }
        #customers-table tbody tr.shown td.details-control {
            background-image: url('{{ asset('admin_assets/images/details_close.png') }}');
            cursor: pointer;
            background-repeat: no-repeat;
            background-position: center;
            background-origin: content-box;
            background-size: 20px;
            padding: 7px;
        }
        .imagen-header {
            width: 150px;
            height: auto;
            overflow: hidden;
            opacity: 0.8;
        }
    </style>
    @include('layouts.modal.alerta')
    @include('layouts.modal.confirmar')
    @include('layouts.modal.no-confirmar')
    @include('layouts.modal.confirmar_compra')
    @yield('styles')
</head>
<body style="background-color: #ffffff;">
    @include('partial.admin.dashboard')
    <main>
        <div class="container-xl">
            <br>
            {{--@include('components.flash_alerts')--}}
            @yield('content')
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
            </form>
        </div>
    </main>
    <script src="{{ asset('dataTable/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('dataTable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dataTable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dataTable/js/datatable-language.js') }}"></script>
    <script src="{{ asset('dashboard/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/slim-select/slimselect.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/handlebars.js') }}"></script>
    <script src="{{ asset('dashboard/js/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/main.js') }}"></script>
    <script src="{{ asset('js/notificaciones/Lobibox.js') }}"></script>
    <script src="{{ asset('js/notificaciones/notification-active.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-1.13.2/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('datepicker/datepicker.es.js') }}"></script>
    <script src="{{ asset('js/treeview/jstree.min.js') }}"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"
        integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    ></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/addons/cleave-phone.us.js"
        integrity="sha512-sYKXH+IAMtg7mVursFAH+Xu1mIvmSqTd8LTEhKdRmvJhtX2IKUFpkZBZ9pigORvIR6Nt5klEF/P+psiJRa6crQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    ></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.5/proj4.js"></script>
    <script>
        /* function obtenerMontoCleave(montoString) {
            if(montoString == ""){
                return 0;
            }else{
                var re = /,/g;
                var resultado = montoString.replace(re, '');
                monto = parseFloat(resultado);
            }
            return monto;
        } */
    </script>

    @include('layouts.modal.notificaciones')

    <script>
        var id = 2;



        function fetchdata() {

            $.ajax({
                url: "{{ route('correspondencia.derivada.pregunta') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                dataType: 'JSON',
                success: function(data) {
                   // console.log(data); //Try to log the data and check the response
                    if (data.success == true) {
                        //alert('success :  user logged in');
                        notifyMe();
                    } else {
                        //alert('Erreur login');
                    }
                }



            });

        }

        $(document).ready(function() {
            setInterval(fetchdata, 8000);
        });

        function notifyMe2() {
            if (!("Notification" in window)) {
                alert("Este navegador no soporta notificaciones de escritorio");
            } else if (Notification.permission === "granted") {
                var options = {
                    body: "Usted Tiene Una Correspondencia sin responder",
                    icon: href="{{ asset('logos/logo2.png') }}",
                    dir: "ltr"
                };
                var notification = new Notification("!! ATENCION !!", options);
            } else if (Notification.permission !== 'denied') {
                Notification.requestPermission(function(permission) {
                    if (!('permission' in Notification)) {
                        Notification.permission = permission;
                    }
                    if (permission === "granted") {
                        var options = {
                            body: "Usted Tiene Una Correspondencia sin responder",
                            icon: href="{{ asset('logos/logo2.png') }}",
                            dir: "ltr"
                        };
                        var notification = new Notification("Hola :)", options);
                    }
                });
            }
        }
    </script>
@yield('scripts')
</body>
{{--<footer class="text-center">
    © 2022 Gobierno Autonomo Regional del Gran Chaco <a href="https://granchaco.gob.bo/">Pagina Web</a>
</footer>--}}
</html>
