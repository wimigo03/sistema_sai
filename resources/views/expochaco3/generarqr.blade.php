@extends('layouts.admin3')
@section('content')
    @include('layouts.message_alert')



    <form method="post" id="form">
        @csrf

        <table style="width: 393.288px; background-color: white;" border="1">
            <tbody>
                <tr>
                    <td style="width: 178px;">

                        <img src="{{ asset($credencial->foto) }}" alt="Image" class="img-fluid" />

                    </td>
                    <td style="width: 202.288px;" align="center">
                        <p><strong>&nbsp;</strong></p>
                        <p style="color: black"><strong>CREDENCIAL</strong></p>
                        <p style="color: black"><strong>EXPOCHACO 2023</strong></p>
                        <p><strong>&nbsp;</strong></p>
                        <p><strong>&nbsp;</strong></p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 380.288px;" colspan="2" >
                        <p style="color: black"><strong>&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong><strong>NOMBRE:
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>{{ $credencial->nombres }}</p>
                        <p style="color: black"><strong>&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CI:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </strong>{{ $credencial->ci }}</p>
                        <p style="color: black"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;N&deg; DE
                                STAND:&nbsp;&nbsp;&nbsp;&nbsp; </strong>{{ $credencial->stand }}</p>

                                <div class="title m-b-md" align='center'>
                                    {!!QrCode::size(200)->generate($ruta) !!}
                                 </div>
                                 <p></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p>&nbsp;</p>


    </form>

@endsection
