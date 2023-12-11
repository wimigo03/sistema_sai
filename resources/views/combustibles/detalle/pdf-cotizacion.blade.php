<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>

    <div class="page-header" align="center">
        <img src="{{ asset('logos/header.jpg') }}" width="700px" height="70px" />
    </div>

    <div class="page-footer" align="center">

        <img src="{{ asset('logos/footer.jpg') }}" width="700px" height="50px" />

    </div>
    <table  border="0" cellspacing="0" cellpadding="0">

        <thead>
          <tr>
            <td>
              <!--place holder for the fixed-position header-->
              <div class="page-header-space"></div>
            </td>
          </tr>
          <tr>
            <td>
              <!--place holder for the fixed-position header-->
              <div class="page-header-space"></div>
            </td>
          </tr>
          <tr>
            <td>
              <!--place holder for the fixed-position header-->
              <div class="page-header-space"></div>
            </td>
          </tr>
          <tr>
            <td>
              <!--place holder for the fixed-position header-->
              <div class="page-header-space"></div>
            </td>
          </tr>
        </thead>


      </table>


    <div>
        <p align="center">
            <strong>INFORME DE EVALUACIÓN Y RECOMENDACIÓN DE ADJUDICACIÓN</strong>
        </p>
        <p align="center">
            <strong>{{$ordencompra->informe1}}</strong>
        </p>
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="34" valign="top">
                        <p>
                            <strong>A:</strong>
                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$responsables->nombrerespcontrat}}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="34" valign="top">
                    </td>
                    <td width="500" valign="top">
                        <p>
                            <strong>
                                RESPONSABLE DE PROCESO DE CONTRATACIÓN (R.P.A)
                            </strong>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p>
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="37" valign="top">
                        <p>
                            <strong>DE:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$ordencompra->autoridadsolicitante}}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="37" valign="top">
                    </td>
                    <td width="500" valign="top">
                        <p>
                            <strong>RESPONSABLE DE EVALUACIÓN</strong>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div>
        <p>
            <strong>REF.</strong>
        </p>

        <p>
            <strong>INFORME DE EVALUACIÓN Y RECOMENDACIÓN DE ADJUDICACIÓN</strong>
        </p>
    </div>

    <div>
        <p>
            <strong>Fecha: </strong>
            Yacuiba, {{$fechaInvitacion}}
        </p>
        <p>
            De mi mayor consideración:
        </p>
        <p>
            En cumplimiento al memorándum de designación {{$ordencompra->memorandum1}} 
            y el artículo 38 inciso e) del D.S.
        </p>
        <p>
            0181 (SABS) se procedió a la Evaluación para la recomendación de
            adjudicación del proceso de contratación denominado: {{$ordencompra->nombrecompra}}.
        </p>
        <p>
            <strong>1</strong>
            <strong>. ANTECEDENTES:</strong>
        </p>
        <table border="1" cellspacing="0" cellpadding="0" width="100%" 
        style="font-size: 12px; border: 1px solid black;border-collapse: collapse;">
            <tbody>
                <tr>
                    <td width="142" valign="top">
                        <p>
                            <strong>1.1 Entidad Convocante:</strong>
                        </p>
                    </td>
                    <td width="371" colspan="2" valign="top">
                        <p>
                            GOBIERNO AUTÓNOMO REGIONAL DEL GRAN CHACO
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="142" valign="top">
                        <p>
                            <strong>1.2 Objeto de la Contratación:</strong>
                        </p>
                    </td>
                    <td width="371" colspan="2" valign="top">
                        <p>
                            {{$ordencompra->nombrecompra}}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="142" valign="top">
                        <p>
                            <strong>1.3 Precio Referencial:</strong>
                        </p>
                    </td>
                    <td width="67" valign="top">
                        <p>
                            {{$valor_total3}}
                        </p>
                    </td>
                    <td width="304" valign="top">
                        <p>
                            SON: {{$valor_total2}}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="142" valign="top">
                        <p>
                            <strong>1.4 Unidad Solicitante:</strong>
                        </p>
                    </td>
                    <td width="371" colspan="2" valign="top">
                        <p>
                            {{$ordencompra->solicitante}}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="142" valign="top">
                        <p>
                            <strong>1.5 Solicitud de Inicio del Proceso:</strong>
                        </p>
                    </td>
                    <td width="371" colspan="2" valign="top">
                        <p>
                            Yacuiba, {{$fechaInvitacion}}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="142" valign="top">
                        <p>
                            <strong>1.6 Responsable de Evaluación:</strong>
                        </p>
                    </td>
                    <td width="371" colspan="2" valign="top">
                        <p>
                            Memorándum de Designación {{$ordencompra->memorandum1}}
                            de fecha {{$fechaInvitacion}}
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p>
            <strong>2</strong>
            <strong>. PROPONENTES EN EL MERCADO VIRTUAL:</strong>
        </p>
        <p>
            No se registran proponentes en el mercado virtual según reporte de no
            existencia obtenido.
        </p>
        <p>
            <strong>3</strong>
            <strong>. INVITACIÓN PARA LA PRESENTACIÓN DE DOCUMENTOS</strong>
        </p>
        <p>
            <strong>
                Invitado: Sr(a) {{$ordencompra->representante}} (Proponente
                Identificado)
            </strong>
        </p>
    </div>

    <div>
        <p>
            <strong>Fecha de Invitación:</strong>

            {{$dateinvitacion}}





        </p>

        <p>

        </p>
    </div>

    <div>
        <p>
            <strong>Fecha de Aceptación de la Invitación </strong>
            {{$dateaceptacion}}
        </p>
        <p>
            El responsable de evaluación en cumplimiento a lo dispuesto en el
            artículo 38 del D.S. Nº 0181, se procede a la verificación de los
            documentos solicitados al Invitado Sr(a) {{$ordencompra->representante}}
            a lo dispuesto en las especificaciones técnicas y en la Invitación
            realizada.
        </p>
    </div>

    <div>
        <table border="1" cellspacing="0" cellpadding="0" width="100%" style=" border: 1px solid black;border-collapse: collapse;">
            <tbody>
                <tr style="font-size: 12px;">
                    <td width="154" rowspan="2" valign="top">
                        <p>
                            <strong>DOCUMENTOS SOLICITADOS</strong>
                        <p>
                    </td>
                    <td width="367" colspan="2" valign="top">
                        <p>
                            <strong>
                                VERIFICACIÓN DE DOCUMENTOS CUMPLE/NO CUMPLE
                            </strong>
                        <p>
                    </td>
                </tr>
                <tr style="font-size: 12px;">
                    <td width="137" valign="top">
                        <p>
                            <strong>ORIGINAL Y/O FOTOCOPIA LEGALIZADA</strong>
                        <p>
                    </td>
                    <td width="230" valign="top">
                        <p>

                            <strong>FOTOCOPIA SIMPLE</strong>
                        <p>
                    </td>
                </tr>
                <tr>

                        @forelse ($ordendoc as $key => $value)
                        <tr >

                            <td style="font-size: 12px;">{{$key+1 . '.- ' . $value -> nombredoc}}</td>
                            <td style="font-size: 12px;">{{ $value -> original}}</td>
                            <td style="font-size: 12px;">{{$value -> fotocopia}}</td>

                        </tr>
                        @empty

                        @endforelse
                </tr>
            </tbody>
        </table>
        <p>
            Verificado la presentación de los documentos exigidos en las
            especificaciones técnicas, en calidad de responsable de
        </p>
        <p>
            Evaluación, indicamos que el proponente cumple a cabalidad con lo
            solicitado.
        </p>
        <p>
            <strong>4</strong>
            <strong>. CONCLUSIONES.</strong>
        </p>
        <p>
            Por lo que el responsable de evaluación en el marco de sus atribuciones
            RECOMIENDA al Responsable del Proceso de Contratación – RPA, adjudicar
            al Proponente Sr (a). {{$ordencompra->representante}} para el Proceso de
            Contratación: {{$ordencompra->nombrecompra}}.
        </p>
        <p>
            Por cumplir con las especificaciones técnicas solicitadas por la unidad
            solicitante monto total propuesto Bs. {{$valor_total3}}  plazo de entrega de 3 DÍAS
            CALENDARIOS, A PARTIR DEL SIGUIENTE DÍA HÁBIL DE LA SUSCRIPCIÓN DE LA
            ORDEN DE COMPRA.
        </p>
        <p>
            Es todo, cuanto informamos para los fines consiguientes.
        </p>
        <p>
            Atentamente.
        </p>

    </div>

    <div align='center'>
        <p>
            {{$ordencompra->autoridadsolicitante}}
        </p>
        <p>
            <strong>RESPONSABLE DE EVALUACIÓN</strong>
        </p>
        </div>

    <p>
        C.c./Arch.
    </p>
    <p>
        Adj. Documentación respaldatoria
    </p>
    <p>
        Documentos del Proponente
    </p>




    </body>

</html>
