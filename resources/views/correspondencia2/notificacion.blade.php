@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">




            <div class="body-border">

                        <div align='center'>




                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="button" value="Guardar" onclick="notifyMe()" id="insertar_item_material">
                            <input type="button" value="Alert" onclick="Function()" id="alx"/>

                        </div>




            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>

function Function() {
        setInterval(notifyMe, 5000);
    };

function  notifyMe()  {
    if  (!("Notification"  in  window))  {
        alert("Este navegador no soporta notificaciones de escritorio");
    }
    else  if  (Notification.permission  ===  "granted")  {
        var  options  =   {
            body:   "Descripción o cuerpo de la notificación",
            icon:   "url_del_icono.jpg",
            dir :   "ltr"
        };
        var  notification  =  new  Notification("Hola :D", options);
    }
    else  if  (Notification.permission  !==  'denied')  {
        Notification.requestPermission(function (permission)  {
            if  (!('permission'  in  Notification))  {
                Notification.permission  =  permission;
            }
            if  (permission  ===  "granted")  {
                var  options  =   {
                    body:   "Descripción o cuerpo de la notificación",
		            icon:   "url_del_icono.jpg",
		            dir :   "ltr"
                };
                var  notification  =  new  Notification("Hola :)", options);
            }
        });
    }
}
    </script>
@endsection
