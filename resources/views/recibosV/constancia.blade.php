@extends('recibos.master2')
@section('detalle')

   <style type="text/css">
        .siguiente{
             page-break-after: always; 
        }
    </style>
  <div style="width:100%; display: block; padding: 2% 0% 0% 0%">
    <table class="tg2">
            <tr>
              <td class="borderBottomBlank" colspan="25" valign="middle" style="border-right-width:0px; border-bottom: 0px; font-size:13px; padding: 2% 0% 0% 0%; text-align:center;"><strong>
                 CONSTANCIA DE SUELDOS, SALARIOS, CONCEPTOS ASIMILADOS,</strong>
          <br><strong>CREDITO AL SALARIO Y SUBSIDIO PARA EL EMPLEO</strong></br>
              </td>
            </tr>
            <tr>
              <td colspan="12" valign="middle" style="border-right-width:0px; font-size:8px; padding:2px; text-align:left; padding: 0% 1% 0% 0%">&nbsp;</td>
              <td colspan="3" valign="middle" style="border-right-width:0px; font-size:8px; padding:2px; text-align:left; padding: 0% 1% 0% 0%">&nbsp;</td>
              <td width="1%" valign="middle" style="border-right-width:0px; font-size:8px; padding:2px; text-align:left; padding: 0% 1% 0% 0%">&nbsp;</td>
              <td width="1%" valign="middle" style="border-right-width:0px; font-size:8px; padding:2px; text-align:left; padding: 0% 1% 0% 0%">&nbsp;</td>
              <td width="3%" valign="middle" style="border-right-width:0px; font-size:8px; padding:2px; text-align:left; padding: 0% 1% 0% 0%">&nbsp;</td>
              <td width="1%" valign="middle" style="border-right-width:0px; font-size:8px; padding:2px; text-align:left; padding: 0% 1% 0% 0%">&nbsp;</td>
              <td width="3%" valign="middle" style="border-right-width:0px; font-size:8px; padding:2px; text-align:left; padding: 0% 1% 0% 0%">&nbsp;</td>
              <td width="8%" valign="middle" style="border-right-width:0px; font-size:8px; padding:2px; text-align:left; padding: 0% 1% 0% 0%">&nbsp;</td>
              <td width="7%" valign="middle" style="border-right-width:0px; font-size:8px; padding:2px; text-align:left; padding: 0% 1% 0% 0%">&nbsp;</td>
              <td width="3%" valign="middle" style="border-right-width:0px; font-size:8px; padding:2px; text-align:left; padding: 0% 1% 0% 0%">&nbsp;</td>
              <td width="3%" valign="middle" style="border-right-width:0px; font-size:10px; text-align:center; padding: 0% 1% 0% 0%;"><strong>37</strong></td>
              <td width="15%" valign="middle" style="border-right-width:0px; font-size:8px; padding:2px; text-align:left; padding: 0% 1% 0% 0%">&nbsp;</td>
            </tr>
            <tr>
              <td height="12" colspan="25" valign="middle" style="border-right-width:0px; border-top: 0px; font-size:8px; padding:2px; text-align:left; padding: 0% 0% 0% 2%"><strong>ESTA CONSTANCIA DEBER&Aacute; SER CONSERVADA POR EL TRABAJADOR</strong></td>
            </tr>
            <tr>
              <td height="35" colspan="25" valign="middle" style="border-right-width:0px; border-top-width:0px; text-align:center; padding: 1% 0% 0% 2%;"><table width="551" height="35" border="0" align="left">
                  <tr>
                    <td colspan="3" style="">&nbsp;</td>
                    <td width="58" style="border-left-width:0px; border-right-width:0px; font-size:10px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 0% 0% 0%; text-align: center">MES INICIAL</td>
                    <td width="15" style="">&nbsp;</td>
                    <td width="50" style="border-left-width:0px; border-right-width:0px; font-size:10px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 0% 0% 0%; text-align: center">MES FINAL</td>
                    <td width="15" style="">&nbsp;</td>
                    <td width="61" style="border-left-width:0px; border-right-width:0px; font-size:10px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px;padding: 0% 0% 0% 0%; text-align: center">EJERCICIO</td>
                  </tr>
                  <tr>
                    <td width="40" style="border-left-width:1px; border-right-width:1px; font-size:8px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;">FOLIO</td>
                    <?php //dd($datos);
                    ?>
                    <td width="65" style="border-left-width:1px; border-right-width:1px; font-size:10px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;">
                    @if($datos['folio']=='')
                       &nbsp;
                    @else
                     <strong> {{ $datos['folio']}} </strong>
                    @endif
                    </td>
                    <td width="154" style="border-left-width:0px; border-right-width:0px; font-size:8px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 3% 0% 0%; text-align: right;">PERIODO QUE AMPARA LA CONSTANCIA</td>
                    <td style="border-left-width:1px; border-right-width:1px; font-size:10px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;">
                    @if($datos['mesInicial']=='')
                       &nbsp;
                    @else
                      <strong> {{ $datos['mesInicial']}} </strong>
                    @endif
                    </td>
                    <td width="15" style="">&nbsp;</td>
                    <td style="border-left-width:1px; border-right-width:1px; font-size:10px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;">
                    @if($datos['mesFinal']=='')
                       &nbsp;
                    @else
                     <strong> {{ $datos['mesFinal']}} </strong>
                    @endif
                    </td>
                    <td width="15" style="">&nbsp;</td>
                    <td style="border-left-width:1px; border-right-width:1px; font-size:10px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;">
                    @if($datos['ejercicio']=='')
                       &nbsp;
                    @else
                     <strong> {{ $datos['ejercicio']}} </strong>
                    @endif
                    </td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="3" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%"><strong>1</strong></td>
              <td colspan="22" valign="middle" style="border-right-width:0px; font-size:10px; border-bottom-width: 3px; border-top-width: 3px; text-align:center; padding: 0% 0% 0% 0%"><strong>DATOS DEL TRABAJADOR O ASIMILADO A SALARIOS</strong></td>
            </tr>
            <tr>
              <td height="12" colspan="7" valign="middle" style="border-right-width:1px; border-top-width: 0px; border-bottom-width: 1px; font-size:9px; text-align:left; padding: 0% 0% 0% 5%;">
              @if($datos['aPaterno']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['aPaterno']}} </strong>
              @endif
              </td>
              <td height="12" colspan="8" valign="middle" style="border-right-width:1px; font-size:9px; text-align:left; border-bottom-width: 1px; padding: 0% 0% 0% 5%">
              @if($datos['aMaterno']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['aMaterno']}} </strong>
              @endif
              </td>
              <td height="12" colspan="10" valign="middle" style="border-right-width:0px; font-size:9px; border-bottom-width: 1px; text-align:left; padding: 0% 0% 0% 5%">
                @if($datos['nombre']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['nombre']}} </strong>
              @endif
              </td>
            </tr>
            <tr>
              <td height="12" colspan="7" valign="middle" style="border-right-width:1px; font-size:8px; border-bottom-width: 1px; text-align:center; padding: 0% 0% 0% 2%">APELLIDO PATERNO</td>
              <td height="12" colspan="8" valign="middle" style="border-right-width:1px; font-size:8px; border-bottom-width: 1px; text-align:center; padding: 0% 0% 0% 2%">APELLIDO MATERNO</td>
              <td height="12" colspan="10" valign="middle" style="border-right-width:0px; font-size:8px; border-bottom-width: 1px; text-align:center; padding: 0% 0% 0% 2%">NOMBRE(S)</td>
            </tr>
            <tr>
              <td height="12" colspan="3" valign="middle" style="border-right-width:1px; font-size:8px; text-align:center; padding: 0% 5% 0% 5%;">R.F.C.</td>
              <td width="12%" height="12" valign="middle" style="border-right-width:1px; font-size:9px; text-align:center; padding: 0% 5% 0% 5%;">
              @if($datos['rfc']=='')
                       &nbsp;
                    @else
                    <strong> {{ $datos['rfc']}} </strong>
                    @endif
              </td>
              <td width="7%" valign="middle" style="border-right-width:1px; font-size:8px; text-align:center; padding: 0% 5% 0% 5%;">C.U.R.P.</td>
              <td height="12" colspan="7" valign="middle" style="border-right-width:1px; font-size:9px; text-align:center; padding: 0% 2% 0% 2%;">
              @if($datos['curp']=='')
                       &nbsp;
                    @else
                     <strong> {{ $datos['curp']}} </strong>
                    @endif
              </td>
              <td width="3%" height="12" valign="middle" style="border-right-width:1px; font-size:8px; text-align:center; padding: 0% 1% 0% 1%;">T.N.</td>
              <td width="4%" valign="middle" style="border-right-width:1px; font-size:9px; text-align:center; padding: 0% 1% 0% 1%;">
              @if($datos['idTipoNomina']=='')
                       &nbsp;
                    @else
                    <strong>  {{ $datos['idTipoNomina']}} </strong>
                    @endif
              </td>
              <td width="3%" valign="middle" style="border-right-width:1px; font-size:8px; text-align:center; padding: 0% 1% 0% 1%;">Z.P.</td>
              <td height="12" colspan="3" valign="middle" style="border-right-width:1px; font-size:9px; text-align:center; padding: 0% 1% 0% 1%;">
              @if($datos['idZonaPagadora']=='')
                       &nbsp;
                    @else
                     <strong> {{ $datos['idZonaPagadora']}} </strong>
                    @endif
              </td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; font-size:8px; text-align:center; padding: 0% 1% 0% 1%;">NO.EMPLEADO</td>
              <td height="12" colspan="3" valign="middle" style="border-right-width:0px; font-size:9px; text-align:center; padding: 0% 0% 0% 2%">
              @if($datos['idEmpleado']=='')
                       &nbsp;
                    @else
                     <strong> {{ $datos['idEmpleado']}} </strong>
                    @endif
              </td>
            </tr>
            <tr>
              <td height="12" colspan="6" valign="middle" style="border-right-width:1px; border-top-width:1px; font-size:8px; text-align:center; padding: 0% 2% 0% 5%;">UNIDAD ADMINISTRATIVA</td>
              <td height="12" colspan="19" valign="middle" style="border-right-width:1px; border-top-width:1px; font-size:9px; text-align:left; padding: 0% 2% 0% 2%;">
              @if($datos['unidadAdministrativa']=='')
                       &nbsp;
                    @else
                     <strong> {{ $datos['unidadAdministrativa']}} </strong>
                    @endif
              </td>
            </tr>
            <tr>
              <td height="12" colspan="25" valign="middle" style="border-right-width:1px; border-top-width:1px; font-size:8px; text-align:left; padding: 0% 0% 0% 5%;"><strong>MARQUE CON "X" EL RECUADRO QUE CORRESPONDE Y/O CONTESTE LO QUE SE SOLICITA</strong></td>
            </tr>
            <tr>
              <td colspan="25" valign="middle" style="border-right-width:1px; border-top-width:0px; text-align:center; padding: 0% 0% 0% 0%;"><table width="551" border="0" align="center">
                <tbody>
                  <tr>
                    <td width="33" style="border-left-width:0px; border-right-width:0px; font-size:7px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 1% 0% 2%; text-align:left;">SI EL PATRON REALIZO CALCULO ANUAL</td>
                    <td width="30" style="border-left-width:1px; border-right-width:1px; font-size:14px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;"> 
                    @if($datos['calculoAnual']=='')
                       &nbsp;
                    @else
                     <strong> {{ $datos['calculoAnual']}} </strong>
                    @endif
                    </td>
                    <td width="35" style="border-left-width:0px; border-right-width:0px; font-size:7px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 0% 0% 0%; text-align:left;"><p>TARIFA UTILIZADA</p></td>
                    <td width="52" style="border-left-width:0px; border-right-width:0px; font-size:7px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 1% 0% 2%; text-align:left;"><p>A. DEL EJERCICIO QUE DECLARA
                    B.1991 (ACTUALIZADA)</p></td>
                    <td width="30" style="border-left-width:1px; border-right-width:1px; font-size:14px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;">
                    @if($datos['ejercicioDeclara']=='')
                       &nbsp;
                    @else
                     <strong> {{ $datos['ejercicioDeclara']}} </strong>
                    @endif
                    </td>
                    <td width="53" style="border-left-width:0px; border-right-width:0px; font-size:7px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 1% 0% 2%; text-align:left;">MARQUE CON &quot;X&quot; SI EL TRABAJADOR ES SINDICALIZADO
                      </p></td>
                    <td width="30" style="border-left-width:1px; border-right-width:1px; font-size:14px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;">
                    @if($datos['sindicalizado']=='')
                       &nbsp;
                    @else
                      <strong> {{ $datos['sindicalizado']}} </strong>
                    @endif
                    </td>
                    <td width="48" style="border-left-width:0px; border-right-width:0px; font-size:7px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 1% 0% 2%; text-align:left;">AREA GEOGRAFICA DEL SALARIO MINIMO</span>
                      </p></td>
                    <td width="30" style="border-left-width:1px; border-right-width:1px; font-size:14px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;">
                    @if($datos['areaGeografica']=='')
                       &nbsp;
                    @else
                      <strong> {{ $datos['areaGeografica']}} </strong>
                    @endif
                    </td>
                    <td width="45" style="border-left-width:0px; border-right-width:0px; font-size:7px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 1% 0% 2%; text-align:left;">CLAVE DE LA ENTIDAD FEDERATIVA DONDE PRESTO SUS SERVICIOS</span>
                      </p></td>
                    <td width="30" style="border-left-width:1px; border-right-width:1px; font-size:14px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;">
                    @if($datos['entidadFederativa']=='')
                       &nbsp;
                    @else
                       <strong> {{ $datos['entidadFederativa']}} </strong>
                    @endif
                    </td>
                    <td width="64" style="border-left-width:0px; border-right-width:0px; font-size:7px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 1% 0% 2%; text-align:left;">SI ES ASIMILADO A SALARIOS SE&Ntilde;ALE LA CLAVE CORRESPONDIENTE</span>
                      </p></td>
                    <td width="30" style="border-left-width:1px; border-right-width:1px; font-size:14px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;">
                      @if($datos['esAsimilado']=='')
                       &nbsp;
                    @else
                      <strong> {{ $datos['esAsimilado']}} </strong>
                    @endif
                    </td>
                  </tr>
                </tbody>
              </table></td>
            </tr>
            <tr>
              <td height="12" colspan="25" valign="middle" style="border-right-width:1px; border-top-width:0px; font-size:8px; text-align:left; padding: 0% 0% 0% 1%;">R.F.C. DEL(LOS) OTRO(S) PATRON(ES).</td>
            </tr>
            <tr>
              <td colspan="25" valign="middle" style="border-right-width:1px; border-top-width:0px; font-size:8px; text-align:left; padding: 0% 0% 1% 0%;"><table width="551" border="0" align="center">
                <tbody>
                  <tr>
                    <td width="14" style="border-left-width:0px; border-right-width:0px; font-size:10px; border-right-width:0px; padding: 1% 1% 1% 1%; text-align:left;"></td>
                    <td width="50" style="border-left-width:1px; border-right-width:1px; font-size:8px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;"></td>
                    <td width="13" style="border-left-width:0px; border-right-width:0px; font-size:10px; border-right-width:0px; padding: 1% 1% 1% 1%; text-align:left;"></td>
                    <td width="50" style="border-left-width:1px; border-right-width:1px; font-size:8px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;"></td>
                    <td width="11" style="border-left-width:0px; border-right-width:0px; font-size:10px; border-right-width:0px; padding: 1% 1% 1% 1%; text-align:left;"></td>
                    <td width="50" style="border-left-width:1px; border-right-width:1px; font-size:8px; border-top-width:1px; border-bottom-width:1px; padding: 0% 0% 0% 0%; text-align:center;"></td>
                    <td width="19" style="border-left-width:0px; border-right-width:0px; font-size:10px; border-right-width:0px; padding: 1% 1% 1% 1%; text-align:left;"></td>
                  </tr>
                </tbody>
              </table></td>
            </tr>
            <tr>
              <td colspan="3" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%">&nbsp;</td>
              <td colspan="22" valign="middle" style="border-right-width:0px; font-size:10px; border-bottom-width: 3px; border-top-width: 3px; text-align:center; padding: 0% 0% 0% 0%"><strong>OTROS DATOS INFORMATIVOS</strong></td>
            </tr>
            <tr>
              <td height="12" colspan="6" valign="middle" style="border-right-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 3%;">MONTO DE LAS APORTACIONES VOLUNTARIAS EFECTUADAS</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;"> @if($datos['montoAportaciones']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['montoAportaciones']}} </strong>
              @endif</td>
              <td height="12" colspan="10" valign="middle" style="border-right-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 2%;">MONTO DE LAS APORTACIONES VOLUNTARIAS DEDUCIBLES PARA LOS TRABAJADORES QUE REALIZARAN SU DECLARACION</td>
              <td class="monospaceType"  height="12" colspan="3" valign="middle" style="border-right-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 4%;">@if($datos['montoAporvolTrab']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['montoAporvolTrab']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td height="12" colspan="11" valign="middle" style="border-right-width:1px; border-top-width:1px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 2%;">INDIQUE SI EL PATRON APLICO EL MONTO DE LAS APORTACIONES VOLUNTARIAS EN EL CALCULO DEL IMPUESTO</td>
              <td width="4%" height="12" valign="middle" style="border-right-width:1px; border-top-width:1px; font-size:8px; text-align:center; padding: 0% 0% 0% 0%;">
              @if($datos['indicadorAporvol']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['indicadorAporvol']}} </strong>
              @endif</td>
              <td height="12" colspan="10" valign="middle" style="border-right-width:1px; border-top-width:1px; font-size:7px; text-align:left; padding: 0% 1% 0% 2%;">MONTO DE LAS APORTACIONES VOLUNTARIAS DEDUCIBLES APLICADAS POR EL PATRON</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-top-width:1px; font-size:11px; text-align:center; padding: 0% 0% 0% 4%;"> @if($datos['montoAporvolPat']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['montoAporvolPat']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td colspan="3" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%"><strong>2</strong></td>
              <td colspan="22" valign="middle" style="border-right-width:0px; font-size:10px; border-bottom-width: 3px; border-top-width: 3px; text-align:center; padding: 0% 0% 0% 0%"><strong>IMPUESTO SOBRE LA RENTA</strong></td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:9px; text-align:center; padding: 0% 0% 0% 2%;">A.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 2%;">TOTAL DE SUELDOS, SALARIOS Y CONCEPTOS ASIMILADOS (L+M+V+d+j1)</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-top-width:0px; border-bottom-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoA']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoA']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">G.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">MONTO DEL SUBSIDIO PARA EL EMPLEO QUE LE CORRESPONDIO AL TRABAJADOR DURANTE EL EJERCICIO</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoG']}} <strong>
              @endif</td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">B.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 2%;">INGRESOS EXENTOS (Q+X+i)</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoB']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoB']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">H.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">IMPUESTO SOBRE INGRESOS ACUMULABLES</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 1% 0% 5%;">@if($datos['campoH']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoH']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">C.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 2%;">TOTAL DE APORTACIONES VOLUNTARIAS DEDUCIBLES</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoC']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoC']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;"><p>I.</p></td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">IMPUESTOS SOBRE INGRESOS NO ACUMULABLES</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoI']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoI']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">D.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 2%;">INGRESOS NO ACUMULABLES (T+b)</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoD']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoD']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">J.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">IMPUESTO SOBRE LA RENTA CAUSADO EN EL EJERCICIO QUE DECLARA(H+I)</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoJ']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoJ']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">E.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 2%;">INGRESOS ACUMULABLES (A-B-C-D)</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoE']=='')
                       &nbsp;
              @else
                    <strong>  {{ $datos['campoE']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">K.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">IMPUESTO RETENIDO AL CONTRIBUYENTE (U+c+e+k1+l1)</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoK']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoK']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">F.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 2%;">ISR CONFORME A LA TARIFA ANUAL</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoF']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoF']}} </strong>
              @endif<br></td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 2%;">&nbsp;</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:left; padding: 0% 1% 0% 3%;">&nbsp;</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoNull']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoNull']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td colspan="3" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%"><strong>3</strong></td>
              <td colspan="22" valign="middle" style="border-right-width:0px; font-size:10px; border-bottom-width: 3px; border-top-width: 3px; text-align:center; padding: 0% 0% 0% 0%"><strong>PAGOS POR SEPARACION, JUBILACIONES, PENSIONES O HABERES DE RETIRO</strong></td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">L.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 2%;">MONTO TOTAL DEL PAGO EN UNA SOLA EXHIBICION (No debera hacer anotacion alguna en M, N y O)</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoL']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoL']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">Q.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 0% 0% 3%;">INGRESOS EXENTOS</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoQ']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoQ']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td height="14" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">M.</td>
              <td height="14" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 2%;">INGRESOS TOTALES POR PAGOS EN PARCIALIDADES (No hacer anotacion alguna en L)</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoM']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoM']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">R.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">INGRESOS GRAVABLES</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoR']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoR']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td height="14" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">N.</td>
              <td height="14" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 2%;">MONTO DIARIO PERCIBIDO POR JUBILACIONES, PENSIONES O HABERES DE RETIRO EN PARCIALIDADES (No debera hacer anotacion alguna en L)</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoN']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoN']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">S.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">INGRESOS ACUMULABLES</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoS']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoS']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td height="16" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">O.</td>
              <td height="16" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 2%;">CANTIDAD QUE SE HUBIERA PERCIBIDO EN EL PERIODO DE NO HABER PAGO UNICO POR JUBILACIONES, PENSIONES O HABERES DE RETIRO EN UNA SOLA EXHIBICION (No hacer anotacion alguna en L)</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoO']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoO']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">T.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">INGRESOS NO ACUMULABLES</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoT']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoT']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">P.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 0% 0% 2%;">NUMERO DE DIAS</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoP']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoP']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">U.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">IMPUESTO RETENIDO</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoU']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoU']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td colspan="3" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%"><strong>4</strong></td>
              <td colspan="22" valign="middle" style="border-right-width:0px; font-size:10px; border-bottom-width: 3px; border-top-width: 3px; text-align:center; padding: 0% 0% 0% 0%"><strong>OTROS PAGOS POR SEPARACION</strong></td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">V.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 0% 0% 2%;">MONTO TOTAL PAGADO</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoV']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoV']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">Z.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">INGRESOS ACUMULABLES (ULTIMO SUELDO MENSUAL ORDINARIO)</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoZ']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoZ']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">W.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 0% 0% 2%;">NUMERO DE AÑOS DE SERVICIO DEL TRABAJADOR</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoW']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoW']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">a.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">IMPUESTO CORRESPONDIENTE AL ULTIMO SUELDO MENSUAL ORDINARIO</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoAA']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoAA']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">X.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 0% 0% 2%;">INGRESOS EXENTOS</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoX']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoX']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">b.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">INGRESOS NO ACUMULABLES</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoBB']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoBB']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">Y.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 0% 0% 2%;">INGRESOS GRAVADOS</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoY']=='')
                       &nbsp;
              @else
                     <strong>{{ $datos['campoY']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">c.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">IMPUESTO RETENIDO</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:1px; border-bottom-width:1px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoCC']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoCC']}} </strong>
              @endif</td>
            </tr>
            <tr>
              <td colspan="3" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%"><strong>5</strong></td>
              <td colspan="22" valign="middle" style="border-right-width:0px; font-size:10px; border-bottom-width: 3px; border-top-width: 3px; text-align:center; padding: 0% 0% 0% 0%"><strong>INGRESOS ASIMILADOS</strong></td>
            </tr>
            <tr>
              <td height="12" colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width:0px; border-left-width:0px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">d.</td>
              <td height="12" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width:0px; border-top-width:0px; font-size:7px; text-align:left; padding: 0.2% 1% 0.7% 2%;">INGRESOS ASIMILADOS A SALARIOS</td>
              <td class="monospaceType" height="12" colspan="6" valign="middle" style="border-right-width:1px; border-bottom-width:0px; border-top-width:0px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoDD']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoDD']}} </strong>
              @endif</td>
              <td height="12" colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width:0px; border-top-width:0px; font-size:8px; text-align:center; padding: 0% 0% 0% 2%;">e.</td>
              <td height="12" colspan="9" valign="middle" style="border-right-width:1px; border-bottom-width:0px; border-top-width:0px; font-size:7px; text-align:left; padding: 0% 1% 0% 3%;">IMPUESTO RETENIDO DURANTE EL EJERCICIO</td>
              <td class="monospaceType" height="12" colspan="3" valign="middle" style="border-right-width:0px; border-bottom-width:0px; border-top-width:0px; font-size:11px; text-align:center; padding: 0% 0% 0% 5%;">
              @if($datos['campoEE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoEE']}} </strong>
              @endif</td>
            </tr>
        </table>
  </div>
  
 <div style="width:100%; display: block; padding: 2% 0% 0% 0%">
   <div style="width:100%; display: block; padding: 2% 0% 0% 0%">
   <table class="tg2">
   <tr>
        <td colspan="4" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;"><strong> {{$datos['folio']}} </strong></td>
        <td colspan="13" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:left; padding: 0% 0% 0% 0%;">@if($datos['aPaterno']=='' && $datos['aMaterno']!='')
       <strong>  {{$datos['aMaterno']}} {{$datos['nombre']}} </strong>
       @else
       <strong> {{ $datos['aPaterno']}} {{$datos['aMaterno']}} {{$datos['nombre']}} </strong>
       @endif</td>
        <td colspan="2" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">
       @if($datos['idEmpleado']=='')
       &nbsp;
       @else <strong> {{ $datos['idEmpleado']}} @endif</strong></td>
        <td valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;"><strong>37</strong></td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;"><strong>6</strong></td>
         <td colspan="19" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;"><strong>PAGOS DEL PATRON EFECTUADOS A SUS TRABAJADORES</strong></td>
       </tr>
       <tr>
         <td colspan="16" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td width="10%" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 3px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">GRAVADO</td>
         <td width="19%" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 3px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 3px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">EXENTO</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">f.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%;">SUELDOS, SALARIOS, RAYAS Y JORNALES</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
                      @if($datos['campoFFG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoFFG']}} </strong>
         @endif</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoFFE']=='')
           &nbsp;
           @else
            <strong> {{ $datos['campoFFE']}} </strong>
         @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">g.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">GRATIFICACION ANUAL</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoGGG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoGGG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoGGE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoGGE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">h.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">VIATICOS Y GASTOS DE VIAJE</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoHHG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoHHG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoHHE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoHHE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">i.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">TIEMPO EXTRAORDINARIO</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoIIG']=='')
                       &nbsp;
              @else
                    <strong> {{ $datos['campoIIG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoIIE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoIIE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">j.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">PRIMA VACACIONAL</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoJJG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoJJG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoJJG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoJJE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">k.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">PRIMA DOMINICAL</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoKKG']=='')
                       &nbsp;
              @else
                    <strong>  {{ $datos['campoKKG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoKKE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoKKE']}} </strong>
              @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">l.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">PARTICIPACION DE LOS TRABAJADORES EN LAS UTILIDADES (PTU)</td>
         <td  valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoLLG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoLLG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoLLE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoLLE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">m.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">REEMBOLSO DE GASTOS MEDICOS, DENTALES Y HOSPITALARIOS</td>
         <td  valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoMMG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoMMG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoMME']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoMME']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">n.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">FONDO DE AHORRO</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoNNG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoNNG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoNNE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoNNE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">o.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">CAJA DE AHORRO</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoOOG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoOOG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
         @if($datos['campoOOE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoOOE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">p.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">VALES PARA DESPENSA</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoPPG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoPPG']}} </strong>
              @endif</td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoPPE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoPPE']}} </strong>
              @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">q.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">AYUDA PARA GASTOS DE FUNERAL</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
         @if($datos['campoQQG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoQQG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoQQE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoQQE']}} </strong>
              @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">r.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">CONTRIBUCIONES A CARGO DEL TRABAJADOR PAGADAS POR EL PATRON</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoRRG']=='')
                       &nbsp;
              @else
                    <strong>  {{ $datos['campoRRG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoRRE']=='')
                       &nbsp;
              @else
                    <strong>  {{ $datos['campoRRE']}} </strong>
              @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">s.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">PREMIOS POR PUNTUALIDAD</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoSSG']=='')
                       &nbsp;
              @else
                    <strong> {{ $datos['campoSSG']}} </strong>
              @endif</td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoSSE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoSSE']}} </strong>
              @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">t.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">PRIMA DE SEGURO DE VIDA</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoTTG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoTTG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoTTE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoTTE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">u.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">SEGURO DE GASTOS MEDICOS MAYORES</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoUUG']=='')
                       &nbsp;
              @else
                    <strong>  {{ $datos['campoUUG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoUUE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoUUE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">v.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">VALES PARA RESTAURANTE</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoVVG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoVVG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoVVE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoVVE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">w.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">VALES PARA GASOLINA</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoWWG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoWWG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoWWE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoWWE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">x.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">VALES PARA ROPA</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoXXG']=='')
                       &nbsp;
              @else
                    <strong>  {{ $datos['campoXXG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoXXE']=='')
                       &nbsp;
              @else
                    <strong> {{ $datos['campoXXE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">y.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">AYUDA PARA RENTA</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoYYG']=='')
                       &nbsp;
              @else
                    <strong> {{ $datos['campoYYG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoYYE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoYYE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">z.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">AYUDA PARA ARTICULOS ESCOLARES</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoZZG']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoZZG']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoZZE']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoZZE']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">a1.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">DOTACION O AYUDA PARA ANTEOJOS</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoA1G']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoA1G']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
          @if($datos['campoA1E']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoA1E']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">b1.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">AYUDA PARA TRANSPORTE</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoB1G']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoB1G']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoB1E']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoB1E']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">c1.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">CUOTAS SINDICALES PAGADAS POR EL PATRON</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoC1G']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoC1G']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoC1E']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoC1E']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">d1.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">SUBSIDIOS POR INCAPACIDAD</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoD1G']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoD1G']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoD1E']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoD1E']}} </strong>
              @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">e1.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">BECAS PARA TRABAJADORES Y/O SUS HIJOS</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoE1G']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoE1G']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoE1E']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoE1E']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">f1.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:8px; text-align:left; padding: 0% 0% 0% 1%">PAGOS EFECTUADOS POR OTROS EMPLEADORES <br>
           (SOLO SI EL PATRON QUE EXPIDE LA CONSTANCIA REALIZO CALCULO ANUAL)</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoF1G']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoF1G']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 1px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoF1E']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoF1E']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 0px; border-top-width: 0px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">g1.</td>
         <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 0px; border-top-width: 0px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%">OTROS INGRESOS POR SALARIOS</td>
         <td valign="middle" class="monospaceType" style="border-right-width:1px; font-size:10px; border-bottom-width: 0px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoG1G']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoG1G']}} </strong>
              @endif
         </td>
         <td valign="middle" style="border-right-width:1px; font-size:10px; border-bottom-width: 0px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
         <td colspan="2" valign="middle" class="monospaceType" style="border-right-width:0px; font-size:10px; border-bottom-width: 0px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 5%;">
           @if($datos['campoG1E']=='')
                       &nbsp;
              @else
                     <strong> {{ $datos['campoG1E']}} </strong>
              @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;"><strong>7</strong></td>
         <td colspan="19" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;"><strong>IMPUESTO SOBRE LA RENTA POR SUELDOS Y SALARIOS</strong></td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">h1.</td>
         <td colspan="17" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 3px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%;">SUMA DEL INGRESO GRAVADO POR SUELDOS Y SALARIOS</td>
         <td class="monospaceType" colspan="2" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">
          @if($datos['campoH1']=='') 
          @else <strong> {{ $datos['campoH1']}} </strong> @endif
         </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">i1.</td>
         <td colspan="17" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%;">SUMA DEL INGRESO EXENTO POR SUELDOS Y SALARIOS</td>
         <td class="monospaceType" colspan="2" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoI1']=='') @else <strong> {{ $datos['campoI1']}} </strong> @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">j1.</td>
         <td colspan="17" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%;">SUMA DE INGRESOS POR SUELDOS Y SALARIOS (h1+j1)</td>
         <td class="monospaceType" colspan="2" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoJ1']=='') @else <strong> {{ $datos['campoJ1']}} </strong> @endif </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">k1.</td>
         <td colspan="17" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%;">IMPUESTO RETENIDO DURANTE EL EJERCICIO</td>
         <td class="monospaceType" colspan="2" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoK1']=='') @else <strong> {{ $datos['campoK1']}} </strong> @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">l1.</td>
         <td colspan="17" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:8px; text-align:left; padding: 0% 0% 0% 1%;">IMPUESTO RETENIDO POR OTRO(S) PATRON(ES)DURANTE EL EJERCICIO (Solo si el patron que explide la constancia realizo calculo anual)</td>
         <td class="monospaceType" colspan="2" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoL1']=='') @else <strong> {{ $datos['campoL1']}} </strong> @endif </td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">m1.</td>
         <td colspan="17" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:8px; text-align:left; padding: 0% 0% 0% 1%;">SALDO A FAVOR DETERMINADO EN EL EJERCICIO QUE DECLARA, QUE EL PATRON COMPENSARA DURANTE EL SIGUIENTE EJERCICIO</td>
         <td class="monospaceType" colspan="2" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoM1']=='') @else <strong> {{ $datos['campoM1']}} </strong> @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">n1.</td>
         <td colspan="17" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%;">SALDO A FAVOR DEL EJERCICIO ANTERIOR NO COMPENSADO DURANTE EL EJERCICIO QUE AMPARA LA CONSTANCIA</td>
         <td class="monospaceType" colspan="2" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoN1']=='') @else <strong> {{ $datos['campoN1']}} </strong> @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">o1.</td>
         <td colspan="17" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%;">MONTO TOTAL DE INGRESOS OBTENIDOS POR CONCEPTO DE PRESTACIONES DE PREVISION SOCIAL</td>
         <td class="monospaceType" colspan="2" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoO1']=='') @else <strong> {{ $datos['campoO1']}} </strong> @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">p1.</td>
         <td colspan="17" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%;">SUMA DE INGRESOS EXENTOS POR CONCEPTO DE PRESTACIONES DE PREVISION SOCIAL</td>
         <td class="monospaceType" colspan="2" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoP1']=='') @else <strong> {{ $datos['campoP1']}} </strong> @endif</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;">q1.</td>
         <td colspan="17" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 1px; font-size:9px; text-align:left; padding: 0% 0% 0% 1%;">MONTO DEL SUBSIDIO PARA EL EMPLEO ENTREGADO EN EFECTIVO AL TRABAJADOR DURANTE EL EJERCICIO QUE DECLARA</td>
         <td class="monospaceType" colspan="2" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 1px; font-size:10px; text-align:center; padding: 0% 0% 0% 5%;">@if($datos['campoQ1']=='') @else <strong> {{ $datos['campoQ1']}} </strong> @endif</td>
       </tr>
       <tr>
         <td colspan="20" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 3px; font-size:8px; text-align:justify; padding: 2.5% 3% 4% 3%;">SE DECLARA, BAJO PROTESTA DE DECIR LA VERDAD, QUE LOS DATOS ASENTADOS EN LA PRESENTE CONSTANCIA, FUERON MANIFESTADOS EN LA RESPECTIVA DECLARACI&Oacute;N INFORMATIVA (M&Uacute;LTIPLE) DEL EJERCICIO, PRESENTADA ANTE EL SAT CON FECHA 10/04/2017 Y A LA QUE LE CORRESPONDI&Oacute; EL N&Uacute;MERO DE FOLIO DE OPERACI&Oacute;N 5CBCE, ASI MISMO, SI (@if($datos['calculoSi']=='')
                       &nbsp;
              @else
                      {{ $datos['calculoSi']}}
              @endif ) O NO (@if($datos['calculoNo']=='')
                       &nbsp;
              @else
                      {{ $datos['calculoNo']}}
              @endif ) SE REALIZ&Oacute; EL CALCULO ANUAL EN LOS T&Eacute;RMINOS QUE ESTABLECE LA LEY DEL ISR.</td>
       </tr>
       <tr>
         <td colspan="1" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%"><strong>8</strong></td>
         <td colspan="19" valign="middle" style="border-right-width:0px; border-bottom-width: 3px; border-top-width: 3px; font-size:10px; text-align:center; padding: 0% 0% 0% 0%;"><strong>DATOS DEL RETENEDOR</strong></td>
       </tr>
       <tr>
         <td height="13" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:8px; text-align:left; padding: 0% 0% 0% 3%;">REGISTRO FEDERAL DE CONTRIBUYENTES</td>
         <td colspan="2" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:8px; text-align:left; padding: 0% 0% 0% 6%;">GDF9712054NA</td>
         <td colspan="11" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:8px; text-align:left; padding: 0% 0% 0% 2%">CLAVE &Uacute;NICA DE REGISTRO DE POBLACI&Oacute;N</td>
         <td colspan="3" valign="middle" style="border-right-width:0px; font-size:14px; border-bottom-width: 1px; border-top-width: 0px; text-align:right; padding: 0% 1% 0% 1%;">&nbsp;</td>
       </tr>
       <tr>
         <td height="13" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:8px; text-align:left; padding: 0% 0% 0% 3%;">NOMBRE DENOMINACI&Oacute;N O RAZ&Oacute;N SOCIAL</td>
         <td height="13" colspan="16" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 0px; font-size:8px; text-align:left; padding: 0% 0% 0% 1%;">GOBIERNO DE LA CIUDAD DE M&Eacute;XICO</td>
       </tr>
       <tr>
         <td height="13" colspan="4" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:8px; text-align:center; padding: 0% 0% 0% 3%;">DOMICILIO FISCAL</td>
         <td height="13" colspan="16" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 0px; font-size:8px; text-align:left; padding: 0% 0% 0% 1%;">PLAZA DE LA CONSTITUCI&Oacute;N S/N, CENTRO DE LA CD. DE M&Eacute;XICO, AREA 1, DELEGACI&Oacute;N CUAUHTEMOC, C.P. 06000, CIUDAD DE M&Eacute;XICO</td>
       </tr>
       <tr>
         <td colspan="2" rowspan="2" valign="middle" style="border-right-width:1px; border-bottom-width: 0px; border-top-width: 0px; font-size:8px; text-align:center; padding: 0% 0% 0% 4%;"><p><strong>DATOS DEL
           
           REPRESENTANTE LEGAL</strong></p></td>
         <td colspan="5" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:8px; text-align:left; padding: 0% 0% 0% 3%;"><strong>APELLIDO PATERNO, MATERNO Y NOMBRE (S)</strong></td>
         <td colspan="13" valign="middle" style="border-right-width:0px; border-bottom-width: 1px; border-top-width: 0px; font-size:8px; text-align:left; padding: 0% 0% 0% 1%"><strong>VASQUEZ REYES MIGUEL ANGEL</strong></td>
       </tr>
       <tr>
         <td colspan="5" valign="middle" style="border-right-width:1px; border-bottom-width: 0px; border-top-width: 0px; font-size:8px; text-align:left; padding: 0% 0% 0% 3%;"><strong>REGISTRO FEDERAL DE CONTRIBUYENTES</strong></td>
         <td colspan="1" valign="middle" style="border-right-width:1px; border-bottom-width: 0px; border-top-width: 0px; font-size:8px; text-align:center; padding: 0% 0% 0% 3%"><strong>VARM700623M46</strong></td>
         <td colspan="10" valign="middle" style="border-right-width:1px; border-bottom-width: 0px; border-top-width: 0px; font-size:8px; text-align:left; padding: 0% 0% 0% 2%"><strong>CLAVE &Uacute;NICA DE REGISTRO DE POBLACI&Oacute;N</strong></td>
         <td colspan="2" valign="middle" style="border-right-width:0px; font-size:8px; border-bottom-width: 0px; border-top-width: 0px; text-align:center; padding: 0% 0% 0% 3%;"><strong>VARM700623HVZSYG06</strong></td>
       </tr>
       <tr>
         <td class="monospaceType" height="29" colspan="9" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 3px; padding:4px; font-size:8px; text-align:justify; padding: 0.5% 0% 1% 0.5%;">Cadena Original:<br>
            <?php 
            $cadenaD=$datos['cadenaOriginal'];
            $cadena=chunk_split($cadenaD,94, "<br>");
            echo $cadena;
            ?>
           </td>
         <td colspan="11" rowspan="3" valign="middle" style="border-right-width:0px; border-left-width:3px; border-bottom-width: 0px; border-top-width: 3px; font-size:8px; text-align:left; padding: 0% 0% 0% 1%;">&nbsp;</td>
       </tr>
       <tr>
         <td class="monospaceType" height="29" colspan="9" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:8px; text-align:justify; padding: 0% 15% 0% 0.5%;">Sello Digital:<br>
            <?php 
            $selloD=$datos['selloDigital'];
            $sello=chunk_split($selloD,94, "<br>");
            echo $sello;
            ?>
           </td>
       </tr>
       <tr>
         <td class="monospaceType" height="18" colspan="9" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:8px; text-align:justify; padding: 0% 0% 0% 0.5%;">Número de Serie de Certificado de Firma Electrónica Avanzada<br>
           @if($datos['numeroSerie']=='')
                       &nbsp;
              @else
                      {{ $datos['numeroSerie']}}
              @endif
           </td>
       </tr>
       <tr>
         <td class="monospaceType" height="12" colspan="9" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:8px; text-align:left; padding: 0% 0% 1% 0.5%;">Fecha y Hora de Expedición del Documento:<br>
           10/04/2017 19:15:06
           </td>
         <td colspan="11" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-left-width:3px; border-top-width: 0px; font-size:8px; text-align:center; padding: 0% 0% 1% 0.5%;">FIRMA DE RECIBIDO POR EL CONTRIBUYENTE</td>
       </tr>
     </table></td>
 </div></td>
 </div>
@endsection