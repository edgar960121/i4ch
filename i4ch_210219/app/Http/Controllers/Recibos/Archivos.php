<?php

namespace App\Http\Controllers\Recibos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mule;
use Carbon\Carbon;

class Archivos extends Controller
{
    public function notAllowed(){
        return \Redirect::to('/usuario/inicio');
    }

    public function obtieneReciboZIP(Request $request){
        $zipper = \Zipper::make(storage_path('tmpZip/'.$request->uuid.'.zip'));

        $recibo = $this->generarRecibo($request,'/recibo/obtenerReciboElectronicoXML');

        if($recibo['error']['code'] != 0){
            return \View::make('error.general')->with($recibo);
        }

        $zipper->addString($request->uuid.'.xml', $recibo['data']);
        $zipper->addString($request->uuid.'.pdf', $this->obtieneReciboPDF($request));

        $zipper->close();
        
        $zip = \File::get(storage_path('tmpZip/'.$request->uuid.'.zip'));
        \File::delete(storage_path('tmpZip/'.$request->uuid.'.zip'));
        
        return \Response::make($zip,'200',array(
            'Content-Type'=>'application/octet-stream',
            'Content-Disposition' => 'attachment;filename="'.$request->uuid.'.zip"'
        )); 

    }
    
    public function obtieneReciboXML(Request $request){
        $recibo = $this->generarRecibo($request,'/recibo/obtenerReciboElectronicoXML');

        if($recibo['error']['code'] != 0){
            return \View::make('error.general')->with($recibo);
        }

    	return \Response::make($recibo['data'],'200',array(
            'Content-Type'=>'application/octet-stream',
            'Content-Disposition'=>'attachment; filename="' . $request->uuid . '.xml"'
        ));
    }

    public function obtieneReciboPDF(Request $request){
    	$respuesta = $this->generarRecibo($request,'/recibo/obtenerReciboElectronico');
    	
        if($respuesta['error']['code'] != 0){
            return \View::make('error.general')->with($respuesta);
        }
        $recibo = $respuesta['data'];
    	$recibo['idcdmx'] = $this->obtieneFolioApertura(base64_encode(serialize($recibo)));
        //dd($recibo);
    	$sanitizedData['data'] = $this->sanatizeInfo($recibo);
    	$sanitizedData['qrCode'] = base64_encode(\QrCode::format('png')->size(150)->generate($sanitizedData['data']['liga_qr']));
        
        $switchColor = $sanitizedData['data']['fecha_hora_certificacion']; 
        $tiempoCambio = Carbon::createFromFormat('Y-m-d', '2018-12-01')->toDateTimeString();
	    
		//dd($sanitizedData );
		
		if($switchColor > $tiempoCambio){
			return \PDF::loadHTML(\View::make('recibosV.'.strtolower($sanitizedData['data']['tipoAddenda']))->with($sanitizedData))
    				->setPaper([0,0,612.00,792.00], 'portrait')
                    ->setWarnings(false)
                    ->stream($request->uuid . '.pdf');
		}else{
			return \PDF::loadHTML(\View::make('recibos.'.strtolower($sanitizedData['data']['tipoAddenda']))->with($sanitizedData))
    				->setPaper([0,0,612.00,792.00], 'portrait')
                    ->setWarnings(false)
                    ->stream($request->uuid . '.pdf');
		}
		
    	
    }
 
    private function obtieneFolioApertura($text){
    	$parametros = [
			'security' => [
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			],
			'data'     => [
				'text' => $text
			]
		];

		$folio = Mule::callApi('POST','/recibo/folioApertura','9001',$parametros);

		if($folio['error']['code'] != 0){
			return \View::make('error.general')->with($folio);
		}

		return $folio['data']['idcdmx'];
    }

    private function generarRecibo(Request $request, $servicio){
    	
    	$parametros = [
			'security' => [
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			],
			'data'     => [
				'anio' => $request->anio,
				'uuid' => $request->uuid
			]
		];
		
		$recibo = Mule::callApi('POST',$servicio,'9001',$parametros);

		return $recibo;

    }

    private function sanatizeInfo($data){
        //dd($data['cfdi:Comprobante']);
                $bandera = 0;
                $tipoAddenda = '';
                $re = $data['cfdi:Comprobante']['cfdi:Emisor']['rfc'];
                $rr = $data['cfdi:Comprobante']['cfdi:Receptor']['rfc'];
                $tt = $data['cfdi:Comprobante']['total'];
                $id = $data['cfdi:Comprobante']['cfdi:Complemento']['tfd:TimbreFiscalDigital']['UUID'];
                $retorno['liga_qr'] = "?re=".$re."&rr=".$rr."&tt=".$tt."&id=".$id;
                $retorno['rfc_emisor'] = (isset($data['cfdi:Comprobante']['cfdi:Emisor']['rfc']))?$data['cfdi:Comprobante']['cfdi:Emisor']['rfc']:"";
                $retorno['nombre_emisor'] = (isset($data['cfdi:Comprobante']['cfdi:Emisor']['nombre']))?$data['cfdi:Comprobante']['cfdi:Emisor']['nombre']:"";
                if(isset($data['cfdi:Comprobante']['cfdi:Emisor']['cfdi:DomicilioFiscal'])){
                    $retorno['direccion_emisor1']  = $data['cfdi:Comprobante']['cfdi:Emisor']['cfdi:DomicilioFiscal']['calle'].', '.$data['cfdi:Comprobante']['cfdi:Emisor']['cfdi:DomicilioFiscal']['noExterior'];
                    $retorno['direccion_emisor2']  = $data['cfdi:Comprobante']['cfdi:Emisor']['cfdi:DomicilioFiscal']['colonia'].', '.$data['cfdi:Comprobante']['cfdi:Emisor']['cfdi:DomicilioFiscal']['codigoPostal'].', '.$data['cfdi:Comprobante']['cfdi:Emisor']['cfdi:DomicilioFiscal']['localidad'];
                    $retorno['direccion_emisor3']  = $data['cfdi:Comprobante']['cfdi:Emisor']['cfdi:DomicilioFiscal']['municipio'].', '.$data['cfdi:Comprobante']['cfdi:Emisor']['cfdi:DomicilioFiscal']['estado'].', '.$data['cfdi:Comprobante']['cfdi:Emisor']['cfdi:DomicilioFiscal']['pais'];
                } else {
                    $retorno['direccion_emisor1'] = "";
                    $retorno['direccion_emisor2'] = "";
                    $retorno['direccion_emisor3'] = "";
                }               
                if(isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina'])){
                    $retorno['curp'] = (isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['CURP']))?$data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['CURP']:"";
                    $retorno['num_empleado'] =  (isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['NumEmpleado']))?$data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['NumEmpleado']:"";
                } else {
                    $retorno['curp'] = (isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Receptor']['Curp']))?$data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Receptor']['Curp']:"";
                    $retorno['num_empleado'] =  (isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Receptor']['NumEmpleado']))?$data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Receptor']['NumEmpleado']:"";
                }
                
                $retorno['nombre']  = (isset($data['cfdi:Comprobante']['cfdi:Receptor']['nombre']))?$data['cfdi:Comprobante']['cfdi:Receptor']['nombre']:"";
                $retorno['rfc'] = (isset($data['cfdi:Comprobante']['cfdi:Receptor']['rfc']))?$data['cfdi:Comprobante']['cfdi:Receptor']['rfc']:"";                
                $retorno['liquido_cobrar'] = number_format($data['cfdi:Comprobante']['total'], 2,'.',',');
                $retorno['idcdmx'] = (isset($data['idcdmx']))?$data['idcdmx']:"";
                $retorno['folio_fiscal'] =  (isset($data['cfdi:Comprobante']['cfdi:Complemento']['tfd:TimbreFiscalDigital']['UUID']))?$data['cfdi:Comprobante']['cfdi:Complemento']['tfd:TimbreFiscalDigital']['UUID']:"";
                $retorno['lugar_expedicion'] = (isset($data['cfdi:Comprobante']['LugarExpedicion']))?$data['cfdi:Comprobante']['LugarExpedicion']:"";
                $version = (isset($data['cfdi:Comprobante']['cfdi:Complemento']['tfd:TimbreFiscalDigital']['version']))?$data['cfdi:Comprobante']['cfdi:Complemento']['tfd:TimbreFiscalDigital']['version']:"";
                $retorno['fecha_hora_certificacion'] = (isset($data['cfdi:Comprobante']['cfdi:Complemento']['tfd:TimbreFiscalDigital']['FechaTimbrado']))?$data['cfdi:Comprobante']['cfdi:Complemento']['tfd:TimbreFiscalDigital']['FechaTimbrado']:"";
                $sello_digital_emisor = (isset($data['cfdi:Comprobante']['sello']))?$data['cfdi:Comprobante']['sello']:"";
                $retorno['num_serie_cer_sat'] = (isset($data['cfdi:Comprobante']['cfdi:Complemento']['tfd:TimbreFiscalDigital']['noCertificadoSAT']))?$data['cfdi:Comprobante']['cfdi:Complemento']['tfd:TimbreFiscalDigital']['noCertificadoSAT']:"";
                $cadena_complemento_sat = '||'.$version.'|'.$retorno['folio_fiscal'].'|'.$retorno['fecha_hora_certificacion'].'|'.$sello_digital_emisor.'|'.$retorno['num_serie_cer_sat'].'||';
                $retorno['cadena_complemento_sat_print'] = chunk_split($cadena_complemento_sat,210, "<br>");
                $sello_digital_sat = (isset($data['cfdi:Comprobante']['cfdi:Complemento']['tfd:TimbreFiscalDigital']['selloSAT']))?$data['cfdi:Comprobante']['cfdi:Complemento']['tfd:TimbreFiscalDigital']['selloSAT']:"";
                $retorno['sello_digital_sat_print'] = chunk_split($sello_digital_sat,210, "<br>");
                $retorno['sello_digital_emisor_print'] = chunk_split($sello_digital_emisor,210, "<br>");
                $retorno['num_serie_cer_emisor'] = (isset($data['cfdi:Comprobante']['noCertificado']))?$data['cfdi:Comprobante']['noCertificado']:"";
                $retorno['tipo_comprobante'] = (isset($data['cfdi:Comprobante']['tipoDeComprobante']))?$data['cfdi:Comprobante']['tipoDeComprobante']:"";
                $retorno['moneda'] = (isset($data['cfdi:Comprobante']['Moneda']))?$data['cfdi:Comprobante']['Moneda']:"";
                $retorno['forma_pago'] = (isset($data['cfdi:Comprobante']['formaDePago']))?$data['cfdi:Comprobante']['formaDePago']:"";
                $retorno['metodo_pago'] = (isset($data['cfdi:Comprobante']['metodoDePago']))?$data['cfdi:Comprobante']['metodoDePago']:"";
                //$retorno['regimen_fiscal'] = (isset($data['cfdi:Comprobante']['cfdi:Emisor']['cfdi:RegimenFiscal']['Regimen']))?$data['cfdi:Comprobante']['cfdi:Emisor']['cfdi:RegimenFiscal']['Regimen']:"";
                $retorno['regimen_fiscal'] = (isset($data['cfdi:Comprobante']['cfdi:Emisor']['regimen']))?$data['cfdi:Comprobante']['cfdi:Emisor']['regimen']['Regimen']:"";
          if(isset($data['cfdi:Comprobante']['cfdi:Addenda']['PBI'])){
            $retorno['tipoAddenda'] = 'pbi';
            $retorno['cve_adscripcion'] = (isset($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['ClaveAdscripcion']))?$data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['ClaveAdscripcion']:"";
            $retorno['sector']  = $data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Sector'];
            $retorno['cve_empresa'] = (isset($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['ClaveEmpresa']))?$data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['ClaveEmpresa']:"";
            $retorno['cve_plaza'] = (isset($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['ClavePlaza']))?$data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['ClavePlaza']:"";
            $retorno['NumeroRecibo'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['NumeroRecibo'];
            $retorno['grado'] = (isset($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Grado']))?$data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Grado']:"";
            if(isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina'])){
                $periodo_pago_inicial = date("d/m/Y", strtotime($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['FechaInicialPago']));
                $periodo_pago_final = date("d/m/Y", strtotime($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['FechaFinalPago']));
                $retorno['desc_puesto'] =  $data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['Puesto'];
            } else {
                $periodo_pago_inicial = date("d/m/Y", strtotime($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['FechaInicialPago']));
                $periodo_pago_final = date("d/m/Y", strtotime($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['FechaFinalPago']));
                $retorno['desc_puesto'] =  $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Receptor']['Puesto'];
            }            
            $retorno['SalarioDiarioIntegrado'] =  isset($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['SalarioDiario'])?number_format($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['SalarioDiario'], 2,'.',','):'';
            $retorno['dependenciaPBI'] = (isset($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Dependencia']))?$data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Dependencia']:"";
            $retorno['periodo_pago'] = $periodo_pago_inicial .' AL '. $periodo_pago_final;
            $retorno['mensaje2'] = (isset($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Aviso1']))?$data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Aviso1']:"";
            /*percepciones y deducciones*/
            $regresaConceptoPercepcion='';
            $regresaDescripcionPercepcion='';
            $regresaImportePercepcion='';
            
            if(isset($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Percepciones']['Percepcion']['Detalle']))
                $varArray1 = $data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Percepciones']['Percepcion'];
            if(isset($varArray1))
                $data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Percepciones']['Percepcion'] = array( 0 => $varArray1);

            foreach($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Percepciones']['Percepcion'] as $percepciones)
                {
                    if(isset($percepciones['Detalle']['Clave']))
                       $percepciones['Detalle'] = array( 0 => $percepciones['Detalle']);
                        //echo json_encode($percepciones['Detalle']);
                    foreach($percepciones['Detalle'] as $detallePercepcion){
                        if($detallePercepcion['Clave'] != '0000'){
                            $bandera++;
                          $regresaConceptoPercepcion .= $detallePercepcion['Clave'].'<br>';
                          $regresaDescripcionPercepcion .= $detallePercepcion['Descripcion'].'<br>';
                          $regresaImportePercepcion .= number_format($detallePercepcion['Importe'], 2,'.',',').'<br>';
                        }
                    }
                
                 }
            $retorno['conceptoPercepcion'] = $regresaConceptoPercepcion;
            $retorno['descripcionPercepcion'] =$regresaDescripcionPercepcion;
            $retorno['importePercepcion'] =$regresaImportePercepcion;
            /*DEDUCCIONES*/
            $regresaDescripcionDeduccion='';
            $regresaImporteDeduccion='';
           
            if(isset($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Deducciones']['Deduccion']['Detalle']))
                $varArray2 = $data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Deducciones']['Deduccion'];
            if(isset($varArray2))
                $data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Deducciones']['Deduccion'] = array( 0 => $varArray2);
            
            if(!empty($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Deducciones']) && isset($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Deducciones']['Deduccion'])){
                foreach($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Deducciones']['Deduccion'] as $deducciones)
                    {
                        
                        if(isset($deducciones['Detalle']['Clave']))
                           $deducciones['Detalle'] = array( 0 => $deducciones['Detalle']);
                        //echo json_encode($deducciones['Detalle']);
                       foreach($deducciones['Detalle'] as $detalleDeduccion){
                            $bandera++;
                              $regresaDescripcionDeduccion .= $detalleDeduccion['Descripcion'].'<br>';
                              $regresaImporteDeduccion .= number_format($detalleDeduccion['Importe'], 2,'.',',').'<br>';
                        }          
                     }
                $retorno['bandera'] = $bandera;
                $retorno['descripcionDeduccion'] =$regresaDescripcionDeduccion;
                $retorno['importeDeduccion'] = $regresaImporteDeduccion;
            } else {
                $retorno['bandera'] = $bandera;
                $retorno['descripcionDeduccion'] = "";
                $retorno['importeDeduccion'] = "";
            }

            $retorno['totalPercepcion'] = number_format($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Percepciones']['TotalPercepciones'], 2,'.',',');
            $retorno['totalDeduccion'] = number_format($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Deducciones']['TotalDeducciones'], 2,'.',',');
            $retorno['mensaje'] = (isset($data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Aviso2']))?$data['cfdi:Comprobante']['cfdi:Addenda']['PBI']['Aviso2']:"";
            //fin PBI
            } else if(isset($data['cfdi:Comprobante']['cfdi:Addenda']['RFC'])){
                $retorno['tipoAddenda'] = "Rfcs";
                $retorno['cumpleanios'] = '';
                if(isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina'])){
                    $retorno['departamento'] = (isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['Departamento']))?$data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['Departamento']:'';    
                    $retorno['registro_patronal'] = (isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['RegistroPatronal']))?$data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['RegistroPatronal']:'';    
                    $retorno['NSS'] = (isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['NumSeguridadSocial']))?$data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['NumSeguridadSocial']:'';    
                    $retorno['SalarioDiarioIntegrado'] =  number_format($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['SalarioDiarioIntegrado'], 2,'.',',');
                    $retorno['diasPagados'] =  number_format($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['NumDiasPagados']);
                } else{
                    $retorno['departamento'] = (isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Receptor']['Departamento']))?$data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Receptor']['Departamento']:'';    
                    $retorno['registro_patronal'] = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Emisor']['RegistroPatronal'];
                    $retorno['NSS'] = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Receptor']['NumSeguridadSocial'];   
                    $retorno['SalarioDiarioIntegrado'] = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Receptor']['SalarioDiarioIntegrado'];
                    $retorno['diasPagados'] = number_format($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['NumDiasPagados']);
                }
                
                $retorno['num_plaza'] = (isset($data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['NumeroPlaza']))?$data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['NumeroPlaza']:'';
                $retorno['tn'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['TipoNomina'];
                $retorno['universo'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['Universo'];
                $retorno['nivel'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['NivelSalarial'];
                $retorno['puesto_actividad'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['CodigoPuestoOClaveActividad'];
                $retorno['grado'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['Grado'];
                $retorno['desc_puesto'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['DescripcionPuesto'];
                $retorno['sec_sindical'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['Sindicato'];
                $retorno['com_sindical'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['ComisionSindical'];
                $retorno['tipo_contratacion'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['TipoContratacion'];
                $retorno['periodo_contratacion'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['TipoContratacion'];
                $retorno['periodo_pago'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['PeriodoPago'];
                $retorno['zona_pagadora'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['ZonaPagadora'];
                /*percepciones y deducciones*/
                $liga = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC'];
                $regresaImportePercepcion='';
                $fechaPercepcion='';
                $regresaClaveconDetalle='';
                $regresaDescripcionconDetalle='';
                $regresaImporteDetalle='';
                $regresaFechaFinDetalle='';

                    if(isset($liga['Percepciones']['Percepcion']['NumeroPercepcion']))
                            $liga['Percepciones']['Percepcion'] = array( 0 => $liga['Percepciones']['Percepcion'] );
                     foreach($liga['Percepciones']['Percepcion'] as $percepcion){
                        $bandera++;
                        $regresaDescripcionconDetalle .= $percepcion['Concepto'].'<br>';
                        $regresaClaveconDetalle .= $percepcion['Clave'].'<br>';
                        $regresaFechaFinDetalle .= '&nbsp;<br>';
                        $regresaImporteDetalle .= '&nbsp;<br>';
                        $regresaImportePercepcion .= number_format($percepcion['ImporteTotal'], 2,'.',',').'<br>';
                        if(isset($percepcion['Detalle']['Clave']))
                            $percepcion['Detalle'] = array( 0 => $percepcion['Detalle'] );
                        if(isset($percepcion['Detalle'])){
                            foreach($percepcion['Detalle'] as $percepcionDetalle){
                                $bandera++;
                                if(isset($percepcionDetalle['FechaInicio'])){
                                    if($percepcionDetalle['FechaInicio']==""){
                                        $fechaInicioRFCs = '&nbsp;'; 
                                        $guion = ''; 
                                    } else {
                                       $fechaInicioRFCs = $percepcionDetalle['FechaInicio'];
                                        $guion = ' - '; 
                                    }                        
                                } else {
                                    $fechaInicioRFCs = "";
                                    $guion = '';
                                }
                                if(isset($percepcionDetalle['FechaFin'])){                        
                                    if($percepcionDetalle['FechaFin']==""){
                                        $fechaFinRFCs = '&nbsp;'; 
                                    } else {
                                       $fechaFinRFCs = $percepcionDetalle['FechaFin']; 
                                    }
                                } else {
                                    $fechaFinRFCs = "";
                                }
                                if($percepcionDetalle['Clave']==""){
                                    $tipoClavePercepcion = '&nbsp;'; 
                                } else {
                                  $tipoClavePercepcion = $percepcionDetalle['Clave'];
                                } 
                                 if($percepcionDetalle['Descripcion']==""){
                                    $tipoDescripcionPercepcion = '&nbsp;'; 
                                } else {
                                  $tipoDescripcionPercepcion = '&nbsp;&nbsp;&nbsp;'.$percepcionDetalle['Descripcion'];
                                }
                                if($percepcionDetalle['Importe']==""){
                                    $tipoImporteDetallePercepcion = '&nbsp;'; 
                                } else {
                                  $tipoImporteDetallePercepcion = '&nbsp;&nbsp;&nbsp;'.number_format($percepcionDetalle['Importe'], 2,'.',',');
                                }  
                                $adendaPercepcion = substr($fechaInicioRFCs, 0, 10).$guion.substr($fechaFinRFCs, 0, 10);
                                $regresaFechaFinDetalle .= $adendaPercepcion.'<br>';
                                $regresaClaveconDetalle .= $tipoClavePercepcion.'<br>';                    
                                $regresaDescripcionconDetalle .= $tipoDescripcionPercepcion.'<br>';
                                $regresaImporteDetalle .= $tipoImporteDetallePercepcion.'<br>';
                                $regresaImportePercepcion .= '&nbsp;<br>';
                            }
                        } else{                
                            $regresaClaveconDetalle .= '';
                            $regresaDescripcionconDetalle .= '';
                            $regresaImporteDetalle .= '';
                            $regresaImportePercepcion .= '';
                            $regresaFechaFinDetalle .= '';
                        }
                     }
                     
                    $retorno['conceptoPercepcion']  = $regresaClaveconDetalle;
                    $retorno['descripcionPercepcion'] = $regresaDescripcionconDetalle;
                    $retorno['importeDetalle'] = $regresaImporteDetalle;
                    $retorno['importePercepcion'] = $regresaImportePercepcion;
                    $retorno['importePercepcionGravado'] = '';
                    $retorno['importePercepcionExento'] = '';
                    
                    $retorno['FechaFinDetalle']  = '';
                    //$retorno['tipoPrestamo'] = $regresaTipoPrestamo;
                    if(isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina'])){
                        if(!isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Percepciones']['nomina:Percepcion'][0])){
                        $datos = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Percepciones']['nomina:Percepcion'];
                        unset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Percepciones']['nomina:Percepcion']);
                        $data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Percepciones']['nomina:Percepcion'][0] = $datos;
                        }
                        
                         foreach($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Percepciones']['nomina:Percepcion'] as $percepciones)
                        {
                            $bandera++;
                            if($percepciones['TipoPercepcion'] != '0000'){
                                
                             $retorno['FechaFinDetalle'] .= $percepciones['TipoPercepcion'].'<br><br>';
                             $retorno['importePercepcionGravado'] .= $percepciones['ImporteGravado'].'<br><br>';
                             $retorno['importePercepcionExento'] .= $percepciones['ImporteExento'].'<br><br>';
                            }
                        
                         }
                        
                        $retorno['TotalGravado']=$data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Percepciones']['TotalGravado'];
                        $retorno['TotalExento']=$data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Percepciones']['TotalExento'];
                    } else{
                        if(!isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Percepciones']['nomina12:Percepcion'][0])){
                        $datos = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Percepciones']['nomina12:Percepcion'];
                        unset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Percepciones']['nomina12:Percepcion']);
                        $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Percepciones']['nomina12:Percepcion'][0] = $datos;
                        }
                        
                         foreach($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Percepciones']['nomina12:Percepcion'] as $percepciones)
                        {
                            $bandera++;
                            if($percepciones['TipoPercepcion'] != '0000'){
                                
                             $retorno['FechaFinDetalle'] .= $percepciones['TipoPercepcion'].'<br><br>';
                             $retorno['importePercepcionGravado'] .= $percepciones['ImporteGravado'].'<br><br>';
                             $retorno['importePercepcionExento'] .= $percepciones['ImporteExento'].'<br><br>';
                            }
                        
                         }
                        
                        $retorno['TotalGravado']=$data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Percepciones']['TotalGravado'];
                        $retorno['TotalExento']=$data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Percepciones']['TotalExento'];
                    }
                  

                /*DEDUCCIONES*/
                $regresaDescripcionDeduccion='';
                $regresaImporteDeduccion='';
                $regresaTipoPrestamo = '';
                $regresaConceptoDeduccion='';
                $regresaImporteDetalleDeduccion='';
                $regresaFechaFinDetalleDeduccion='';
                $prestamoDeduccion='';
                    if(isset($liga['Deducciones']['Deduccion']['NumeroDeduccion']))
                            $liga['Deducciones']['Deduccion'] = array( 0 => $liga['Deducciones']['Deduccion'] );
                     foreach($liga['Deducciones']['Deduccion'] as $deduccion){
                        $bandera++;
                        $regresaDescripcionDeduccion .= $deduccion['Concepto'].'<br>';
                        $regresaConceptoDeduccion .= $deduccion['Clave'].'<br>';
                        $regresaTipoPrestamo .= '&nbsp;<br>';
                        $regresaImporteDetalleDeduccion .= '&nbsp;<br>';
                        $regresaImporteDeduccion .= number_format($deduccion['ImporteTotal'], 2,'.',',').'<br>';
                        if(isset($deduccion['Detalle']['Clave']))
                            $deduccion['Detalle'] = array( 0 => $deduccion['Detalle'] );
                        if(isset($deduccion['Detalle'])){
                            foreach($deduccion['Detalle'] as $deduccionDetalle){
                                $bandera++;
                                if($deduccionDetalle['TipoPrestamo']==""){
                                $tipoPrestamos = '&nbsp;'; 
                                } else {
                                  $tipoPrestamos = $deduccionDetalle['TipoPrestamo'];
                                }    
                                if($deduccionDetalle['SubtipoPrestamo']==""){
                                  $subtipoPrestamos = '&nbsp;'; 
                                } else {
                                  $subtipoPrestamos = $deduccionDetalle['SubtipoPrestamo'];
                                }            
                                $regresaTipoPrestamo .= $tipoPrestamos.' '. $subtipoPrestamos.'<br>';
                                if($deduccionDetalle['Clave']==""){
                                    $tipoClave = '&nbsp;'; 
                                } else {
                                  $tipoClave = $deduccionDetalle['Clave'];
                                }  
                                if($deduccionDetalle['Descripcion']==""){
                                    $tipoDescripcion = '&nbsp;'; 
                                } else {
                                  $tipoDescripcion = '&nbsp;&nbsp;&nbsp;'.$deduccionDetalle['Descripcion'];
                                }  
                                if($deduccionDetalle['Importe']==""){
                                    $tipoImporteDetalleDeduccion = '&nbsp;'; 
                                } else {
                                  $tipoImporteDetalleDeduccion = '&nbsp;&nbsp;&nbsp;'.number_format($deduccionDetalle['Importe'], 2,'.',',');
                                }  
                                $regresaConceptoDeduccion .= $tipoClave.'<br>';
                                $regresaDescripcionDeduccion .= $tipoDescripcion.'<br>';
                                $regresaImporteDetalleDeduccion .= $tipoImporteDetalleDeduccion.'<br>';
                                $regresaImporteDeduccion .= '&nbsp;<br>';
                            }
                        } else{                
                            $regresaConceptoDeduccion .= '';
                            $regresaDescripcionDeduccion .= '';
                            $regresaImporteDetalleDeduccion .= '';
                            $regresaImporteDeduccion .= '';
                            $regresaTipoPrestamo .= '';
                        }
                     }
                    
                $retorno['tipoPrestamo'] = ''.'<br>';
                $retorno['conceptoDeduccion'] = $regresaConceptoDeduccion;
                $retorno['descripcionDeduccion'] = $regresaDescripcionDeduccion;
                $retorno['importeDeduccion'] = $regresaImporteDeduccion;
                $retorno['importeDetalleDeduccion'] = $regresaImporteDetalleDeduccion;

                if(isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina'])){
                     if(!isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Deducciones']['nomina:Deduccion'][0])){
                            $datos = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Deducciones']['nomina:Deduccion'];
                            unset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Deducciones']['nomina:Deduccion']);
                            $data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Deducciones']['nomina:Deduccion'][0] = $datos;
                        }
                     foreach($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Deducciones']['nomina:Deduccion'] as $deduccion)
                        {
                            $bandera++;
                            if($deduccion['Clave'] != '0000'){
                                
                             $retorno['tipoPrestamo'] .= $deduccion['TipoDeduccion'].'<br><br>';


                            }
                        
                         }
                } else{
                    if(!isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Deducciones']['nomina12:Deduccion'][0])){
                            $datos = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Deducciones']['nomina12:Deduccion'];
                            unset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Deducciones']['nomina12:Deduccion']);
                            $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Deducciones']['nomina12:Deduccion'][0] = $datos;
                        }
                     foreach($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Deducciones']['nomina12:Deduccion'] as $deduccion)
                        {
                            $bandera++;
                            if($deduccion['Clave'] != '0000'){
                                
                             $retorno['tipoPrestamo'] .= $deduccion['TipoDeduccion'].'<br><br>';


                            }
                        
                         }
                }

            /*fin percepciones y deducciones*/
            $retorno['bandera'] = $bandera;
            $retorno['totalPercepcion'] =  number_format($data['cfdi:Comprobante']['subTotal'], 2,'.',',');
            $retorno['totalDeduccion'] = number_format($data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['Deducciones']['TotalDeducciones'], 2,'.',',');
            $retorno['mensaje'] = $data['cfdi:Comprobante']['cfdi:Addenda']['RFC']['Avisos'];
            //fin RFC
          } else if(isset($data['cfdi:Comprobante']['cfdi:Addenda']['Estandar'])){
            $retorno['tipoAddenda'] = "Estandar";
            $retorno['cumpleanios'] = '';
            $retorno['u_admva'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['NumeroUnidadAdministrativa'].' '.$data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['UnidadAdministrativa'];    
            $retorno['ZonaPagadora'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['ZonaPagadora'];
            $retorno['num_plaza'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['NumeroPlaza'];
            $retorno['tn'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['TipoNomina'];
            $retorno['universo'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['Universo'];
            $retorno['nivel'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['NivelSalarial'];
            $retorno['puesto_actividad'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['CodigoPuestoOClaveActividad'];
            $retorno['grado'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['Grado'];
            $retorno['desc_puesto'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['DescripcionPuesto'];
            $retorno['sec_sindical'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['Sindicato'];
            $retorno['com_sindical'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['ComisionSindical'];
            $retorno['tipo_contratacion'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['TipoContratacion'];
            $retorno['periodo_contratacion'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['PeriodoContratacion'];

            $retorno['periodo_pago'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['PeriodoPago'];

            /*percepciones y deducciones*/
                $liga = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar'];
                $regresaImportePercepcion='';
                $fechaPercepcion='';
                $regresaClaveconDetalle='';
                $regresaDescripcionconDetalle='';
                $regresaImporteDetalle='';
                $regresaFechaFinDetalle='';
                    if(isset($liga['Percepciones']['Percepcion']['NumeroPercepcion']))
                            $liga['Percepciones']['Percepcion'] = array( 0 => $liga['Percepciones']['Percepcion'] );
                     foreach($liga['Percepciones']['Percepcion'] as $percepcion){
                        $bandera++;
                        $regresaDescripcionconDetalle .= $percepcion['Concepto'].'<br>';
                        $regresaClaveconDetalle .= $percepcion['Clave'].'<br>';
                        $regresaFechaFinDetalle .= '&nbsp;<br>';
                        $regresaImporteDetalle .= '&nbsp;<br>';
                        $regresaImportePercepcion .= number_format($percepcion['ImporteTotal'], 2,'.',',').'<br>';
                        if(isset($percepcion['Detalle']['Clave']))
                            $percepcion['Detalle'] = array( 0 => $percepcion['Detalle'] );
                        if(isset($percepcion['Detalle'])){
                            foreach($percepcion['Detalle'] as $percepcionDetalle){
                                $bandera++;
                                if(isset($percepcionDetalle['FechaInicio'])){
                                    if($percepcionDetalle['FechaInicio']==""){
                                        $fechaInicioRFCs = '&nbsp;'; 
                                        $guion = ''; 
                                    } else {
                                       $fechaInicioRFCs = $percepcionDetalle['FechaInicio'];
                                        $guion = ' - '; 
                                    }                        
                                } else {
                                    $fechaInicioRFCs = "";
                                    $guion = '';
                                }
                                if(isset($percepcionDetalle['FechaFin'])){                        
                                    if($percepcionDetalle['FechaFin']==""){
                                        $fechaFinRFCs = '&nbsp;'; 
                                    } else {
                                       $fechaFinRFCs = $percepcionDetalle['FechaFin']; 
                                    }
                                } else {
                                    $fechaFinRFCs = "";
                                }
                                if($percepcionDetalle['Clave']==""){
                                    $tipoClavePercepcion = '&nbsp;'; 
                                } else {
                                  $tipoClavePercepcion = $percepcionDetalle['Clave'];
                                } 
                                 if($percepcionDetalle['Descripcion']==""){
                                    $tipoDescripcionPercepcion = '&nbsp;'; 
                                } else {
                                  $tipoDescripcionPercepcion = '&nbsp;&nbsp;&nbsp;'.$percepcionDetalle['Descripcion'];
                                }
                                if($percepcionDetalle['Importe']==""){
                                    $tipoImporteDetallePercepcion = '&nbsp;'; 
                                } else {
                                  $tipoImporteDetallePercepcion = '&nbsp;&nbsp;&nbsp;'.number_format($percepcionDetalle['Importe'], 2,'.',',');
                                }  
                                $adendaPercepcion = substr($fechaInicioRFCs, 0, 10).$guion.substr($fechaFinRFCs, 0, 10);
                                $regresaFechaFinDetalle .= $adendaPercepcion.'<br>';
                                $regresaClaveconDetalle .= $tipoClavePercepcion.'<br>';                    
                                $regresaDescripcionconDetalle .= $tipoDescripcionPercepcion.'<br>';
                                $regresaImporteDetalle .= $tipoImporteDetallePercepcion.'<br>';
                                $regresaImportePercepcion .= '&nbsp;<br>';
                            }
                        } else{                
                            $regresaClaveconDetalle .= '';
                            $regresaDescripcionconDetalle .= '';
                            $regresaImporteDetalle .= '';
                            $regresaImportePercepcion .= '';
                            $regresaFechaFinDetalle .= '';
                        }
                     }
                    $retorno['conceptoPercepcion'] = $regresaClaveconDetalle;
                    $retorno['descripcionPercepcion']=$regresaDescripcionconDetalle;
                    $retorno['importeDetalle']=$regresaImporteDetalle;
                    $retorno['importePercepcion']=$regresaImportePercepcion;
                    $retorno['FechaFinDetalle'] = $regresaFechaFinDetalle;
                
                /*DEDUCCIONES*/
                $regresaDescripcionDeduccion='';
                $regresaImporteDeduccion='';
                $regresaTipoPrestamo = '';
                $regresaConceptoDeduccion='';
                $regresaImporteDetalleDeduccion='';
                $regresaFechaFinDetalleDeduccion='';
                $prestamoDeduccion='';
                    if(isset($liga['Deducciones']['Deduccion']['NumeroDeduccion']))
                            $liga['Deducciones']['Deduccion'] = array( 0 => $liga['Deducciones']['Deduccion'] );
                     foreach($liga['Deducciones']['Deduccion'] as $deduccion){
                        $bandera++;
                        $regresaDescripcionDeduccion .= $deduccion['Concepto'].'<br>';
                        $regresaConceptoDeduccion .= $deduccion['Clave'].'<br>';
                        $regresaTipoPrestamo .= '&nbsp;<br>';
                        $regresaImporteDetalleDeduccion .= '&nbsp;<br>';
                        $regresaImporteDeduccion .= number_format($deduccion['ImporteTotal'], 2,'.',',').'<br>';
                        if(isset($deduccion['Detalle']['Clave']))
                            $deduccion['Detalle'] = array( 0 => $deduccion['Detalle'] );
                        if(isset($deduccion['Detalle'])){
                            foreach($deduccion['Detalle'] as $deduccionDetalle){
                                $bandera++;
                                if($deduccionDetalle['TipoPrestamo']==""){
                                $tipoPrestamos = '&nbsp;'; 
                                } else {
                                  $tipoPrestamos = $deduccionDetalle['TipoPrestamo'];
                                }    
                                if($deduccionDetalle['SubtipoPrestamo']==""){
                                  $subtipoPrestamos = '&nbsp;'; 
                                } else {
                                  $subtipoPrestamos = $deduccionDetalle['SubtipoPrestamo'];
                                }            
                                $regresaTipoPrestamo .= $tipoPrestamos.' '. $subtipoPrestamos.'<br>';
                                if($deduccionDetalle['Clave']==""){
                                    $tipoClave = '&nbsp;'; 
                                } else {
                                  $tipoClave = $deduccionDetalle['Clave'];
                                }  
                                if($deduccionDetalle['Descripcion']==""){
                                    $tipoDescripcion = '&nbsp;'; 
                                } else {
                                  $tipoDescripcion = '&nbsp;&nbsp;&nbsp;'.$deduccionDetalle['Descripcion'];
                                } 
                                if($deduccionDetalle['Importe']==""){
                                    $tipoImporteDetalleDeduccion = '&nbsp;'; 
                                } else {
                                  $tipoImporteDetalleDeduccion = '&nbsp;&nbsp;&nbsp;'.number_format($deduccionDetalle['Importe'], 2,'.',',');
                                }  
                                $regresaConceptoDeduccion .= $tipoClave.'<br>';
                                $regresaDescripcionDeduccion .= $tipoDescripcion.'<br>';
                                $regresaImporteDetalleDeduccion .= $tipoImporteDetalleDeduccion.'<br>';
                                $regresaImporteDeduccion .= '&nbsp;<br>';
                            }
                        } else{                
                            $regresaConceptoDeduccion .= '';
                            $regresaDescripcionDeduccion .= '';
                            $regresaImporteDetalleDeduccion .= '';
                            $regresaImporteDeduccion .= '';
                            $regresaTipoPrestamo .= '';
                        }
                     }
                    
                $retorno['tipoPrestamo']=$regresaTipoPrestamo;
                $retorno['conceptoDeduccion']=$regresaConceptoDeduccion;
                $retorno['descripcionDeduccion']=$regresaDescripcionDeduccion;
                $retorno['importeDeduccion']=$regresaImporteDeduccion;
                $retorno['importeDetalleDeduccion']=$regresaImporteDetalleDeduccion;
            /*fin percepciones y deducciones*/
            $retorno['bandera'] = $bandera;
            $retorno['totalPercepcion']= number_format($data['cfdi:Comprobante']['subTotal'], 2,'.',',');
            $retorno['totalDeduccion']=number_format($data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['Deducciones']['TotalDeducciones'], 2,'.',',');
            $retorno['mensaje'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Estandar']['Avisos'];
          } else if(isset($data['cfdi:Comprobante']['cfdi:Addenda']['Metro'])){
            $retorno['tipoAddenda'] = "Metro";
            $retorno['cumpleanios'] = '';
            $retorno['u_admva'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['NumeroUnidadAdministrativa'].' '.$data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['UnidadAdministrativa'];    
            $retorno['ZonaPagadora'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['ZonaPagadora'];
            $retorno['num_plaza'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['NumeroPlaza'];
            $retorno['tn'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['TipoNomina'];
            $retorno['universo'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['Universo'];
            $retorno['nivel'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['NivelSalarial'];
            $retorno['puesto_actividad'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['CodigoPuestoOClaveActividad'];
            $retorno['desc_puesto'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['DescripcionPuesto'];
            $retorno['sec_sindical'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['Sindicato'];
            $retorno['tipo_contratacion'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['TipoContratacion'];
            $retorno['periodo_pago'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['PeriodoPago'];
            /*percepciones y deducciones*/
                $liga = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro'];
                $regresaImportePercepcion='';
                $fechaPercepcion='';
                $regresaClaveconDetalle='';
                $regresaDescripcionconDetalle='';
                $regresaImporteDetalle='';
                $regresaFechaFinDetalle='';
                if(isset($liga['Percepciones']['Percepcion']['NumeroPercepcion'])){
                    $percepcion = $liga['Percepciones']['Percepcion'];
                    unset($liga['Percepciones']['Percepcion']);
                    $liga['Percepciones']['Percepcion'][0] = $percepcion;

                }
                     foreach($liga['Percepciones']['Percepcion'] as $percepcion){
                        //$regresaDescripcionconDetalle .= $percepcion['Concepto'].'<br>';
                        //$regresaClaveconDetalle .= $percepcion['Clave'].'<br>';
                        //$regresaFechaFinDetalle .= '&nbsp;<br>';
                        //$regresaImporteDetalle .= '&nbsp;<br>';
                        //$regresaImportePercepcion .= number_format($percepcion['ImporteTotal'], 2,'.',',').'<br>';
                        if(isset($percepcion['Detalle']['Clave']))
                            $percepcion['Detalle'] = array( 0 => $percepcion['Detalle'] );
                        if(isset($percepcion['Detalle'])){
                            foreach($percepcion['Detalle'] as $percepcionDetalle){
                                $bandera++;
                                if(isset($percepcionDetalle['FechaInicio'])){
                                    $fechaInicioRFCs = $percepcionDetalle['FechaInicio'];
                                    $guion = ' - ';
                                } else {
                                    $fechaInicioRFCs = "";
                                    $guion = '';
                                }
                                if(isset($percepcionDetalle['FechaFin'])){
                                    $fechaFinRFCs = $percepcionDetalle['FechaFin'];
                                } else {
                                    $fechaFinRFCs = "";
                                }
                                $adendaPercepcion = substr($fechaInicioRFCs, 0, 10).$guion.substr($fechaFinRFCs, 0, 10);
                                $regresaFechaFinDetalle .= $adendaPercepcion.'<br>';
                                $regresaClaveconDetalle .= $percepcionDetalle['Clave'].'<br>';                    
                                $regresaDescripcionconDetalle .= $percepcionDetalle['Descripcion'].'<br>';
                                $regresaImporteDetalle .= number_format($percepcionDetalle['Importe'], 2,'.',',').'<br>';
                                $regresaImportePercepcion .= '&nbsp;<br>';
                            }
                        } else{                
                            $regresaClaveconDetalle .= '';
                            $regresaDescripcionconDetalle .= '';
                            $regresaImporteDetalle .= '';
                            $regresaImportePercepcion .= '';
                            $regresaFechaFinDetalle .= '';
                        }
                     }
                    $retorno['conceptoPercepcion']  = $regresaClaveconDetalle;
                    $retorno['descripcionPercepcion'] =$regresaDescripcionconDetalle;
                    $retorno['importeDetalle'] = $regresaImporteDetalle;
                    $retorno['importePercepcion'] = $regresaImportePercepcion;
                    $retorno['FechaFinDetalle']  = $regresaFechaFinDetalle;
                
                /*DEDUCCIONES*/
                $regresaDescripcionDeduccion='';
                $regresaImporteDeduccion='';
                $regresaTipoPrestamo = '';
                $regresaConceptoDeduccion='';
                $regresaImporteDetalleDeduccion='';
                $regresaFechaFinDetalleDeduccion='';
                $prestamoDeduccion='';

                if(isset($liga['Deducciones']['Deduccion'])){
                     foreach($liga['Deducciones']['Deduccion'] as $deduccion){
                        //$regresaDescripcionDeduccion .= $deduccion['Concepto'].'<br>';
                        //$regresaConceptoDeduccion .= $deduccion['Clave'].'<br>';
                        //$regresaTipoPrestamo .= '&nbsp;<br>';
                        //$regresaImporteDetalleDeduccion .= '&nbsp;<br>';
                        //$regresaImporteDeduccion .= number_format($deduccion['ImporteTotal'], 2,'.',',').'<br>';
                        if(isset($deduccion['Detalle']['Clave']))
                            $deduccion['Detalle'] = array( 0 => $deduccion['Detalle'] );
                        if(isset($deduccion['Detalle'])){
                            foreach($deduccion['Detalle'] as $deduccionDetalle){
                                $bandera++;
                                if($deduccionDetalle['TipoPrestamo']==""){
                                $tipoPrestamos = '&nbsp;'; 
                                } else {
                                  $tipoPrestamos = $deduccionDetalle['TipoPrestamo'];
                                }    
                                if($deduccionDetalle['SubtipoPrestamo']==""){
                                  $subtipoPrestamos = '&nbsp;'; 
                                } else {
                                  $subtipoPrestamos = $deduccionDetalle['SubtipoPrestamo'];
                                }            
                                $regresaTipoPrestamo .= $tipoPrestamos.' '. $subtipoPrestamos.'<br>';
                                $regresaConceptoDeduccion .= $deduccionDetalle['Clave'].'<br>';
                                $regresaDescripcionDeduccion .= $deduccionDetalle['Descripcion'].'<br>';
                                $regresaImporteDetalleDeduccion .= number_format($deduccionDetalle['Importe'], 2,'.',',').'<br>';
                                $regresaImporteDeduccion .= '&nbsp;<br>';
                            }
                        } else{                
                            $regresaConceptoDeduccion .= '';
                            $regresaDescripcionDeduccion .= '';
                            $regresaImporteDetalleDeduccion .= '';
                            $regresaImporteDeduccion .= '';
                            $regresaTipoPrestamo .= '';
                        }
                     }
                }  
                $retorno['tipoPrestamo'] = $regresaTipoPrestamo;
                $retorno['conceptoDeduccion'] = $regresaConceptoDeduccion;
                $retorno['descripcionDeduccion'] = $regresaDescripcionDeduccion;
                $retorno['importeDeduccion'] = $regresaImporteDeduccion;
                $retorno['importeDetalleDeduccion'] = $regresaImporteDetalleDeduccion;
            /*fin percepciones y deducciones*/
            $retorno['bandera'] = $bandera;
            $retorno['totalPercepcion'] =  number_format($data['cfdi:Comprobante']['subTotal'], 2,'.',',');
            $retorno['totalDeduccion'] = number_format($data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['Deducciones']['TotalDeducciones'], 2,'.',',');
            $retorno['mensaje'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Metro']['Avisos'];
          } else if(isset($data['cfdi:Comprobante']['cfdi:Addenda']['Addenda'])){
            $retorno['tipoAddenda'] = "SIDEN";
            $retorno['cumpleanios'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['CUMPLEANIOS'];
            $retorno['id_u_admva'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['IDUNIDADADMINISTRATIVA'];
            $retorno['u_admva'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['UNIDADADMINISTRATIVA'];
            $retorno['zona_pagadora'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['ZONAPAGADORA'];
            $retorno['num_plaza'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['NUMPLAZA'];
            $retorno['tn'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['TIPONOMINA'];
            $retorno['universo'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['UNIVERSO'];
            $retorno['nivel'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['NIVELSALARIAL'];
            $retorno['puesto_actividad'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['CLAVEACTIVIDAD'];
            $retorno['grado'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['GRADO'];
            $retorno['desc_puesto'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['PUESTO'];
            $retorno['sec_sindical'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['SINDICATO'];
            $retorno['com_sindical'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['COMISIONSINDICAL'];
            $retorno['tipo_contratacion'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['TIPOCONTRATACION'];
            $retorno['periodo_contratacion'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['CONTRATACION'];
            $retorno['periodo_pago'] = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['PERIODOPAGO'];
            /*percepciones y deducciones*/

                $regresaConceptoPercepcion='';
                $regresaDescripcionPercepcion='';
                $regresaImportePercepcion='';
                $regresaFechaFinPercepcion='';

                if(isset($data['cfdi:Comprobante']['cfdi:Addenda']['AddendaPercepciones']['AddendaPercepcion']['Clave']))
                    $varArray1 = $data['cfdi:Comprobante']['cfdi:Addenda']['AddendaPercepciones']['AddendaPercepcion'];
                if(isset($varArray1))
                    $data['cfdi:Comprobante']['cfdi:Addenda']['AddendaPercepciones']['AddendaPercepcion'] = array( 0 => $varArray1);
            
                foreach($data['cfdi:Comprobante']['cfdi:Addenda']['AddendaPercepciones']['AddendaPercepcion'] as $percepciones)
                    {
                        $bandera++;
                        if($percepciones['Clave'] != '0000'){
                            
                          $regresaConceptoPercepcion .= $percepciones['Clave'].'<br>';
                          $regresaDescripcionPercepcion .= $percepciones['Concepto'].'<br>';
                          if($percepciones['FechaInicioP']==""){
                            $guion = '';
                          } else {
                            $guion = ' - ';
                          }             
                          $adendaPercepcion = substr($percepciones['FechaInicioP'], 0, 10).$guion.substr($percepciones['FechaFinP'], 0, 10);
                          $regresaFechaFinPercepcion .= $adendaPercepcion.'<br>';

                          $regresaImportePercepcion .= number_format($percepciones['ImporteTotal'], 2,'.',',').'<br>';
                        }
                    
                     }
                $retorno['FechaFinPercepcion']  = $regresaFechaFinPercepcion;
                $retorno['conceptoPercepcion']  = $regresaConceptoPercepcion;
                $retorno['descripcionPercepcion'] =$regresaDescripcionPercepcion;
                $retorno['importePercepcion'] =$regresaImportePercepcion;
                if(isset($data['cfdi:Comprobante']['cfdi:Addenda']['AddendaDeducciones']['AddendaDeduccion']['Clave']))
                    $varArray = $data['cfdi:Comprobante']['cfdi:Addenda']['AddendaDeducciones']['AddendaDeduccion'];
                if(isset($varArray))
                    $data['cfdi:Comprobante']['cfdi:Addenda']['AddendaDeducciones']['AddendaDeduccion'] = array( 0 => $varArray );
                if(!isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina'])){
                 $retorno['totalPercepcion'] = number_format($data['cfdi:Comprobante']['subTotal'], 2,'.',',');
                } else {
                   
                    $retorno['totalPercepcion'] =number_format($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['TotalPercepciones'], 2,'.',',');

                    if(isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:OtrosPagos'])){ 
                        if(isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:OtrosPagos']['nomina12:OtroPago']['Importe'])){
                            $otroPago = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:OtrosPagos'];
                        }else{
                            $otroPago = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:OtrosPagos']['nomina12:OtroPago'];
                        }
                        //dd($otroPago);
                        foreach($otroPago as $otrosPagos){
                            $data['cfdi:Comprobante']['cfdi:Addenda']['AddendaDeducciones']['AddendaDeduccion'][] = [
                                'Clave'=>$otrosPagos['Clave'],
                                'Importe'=> $otrosPagos['Importe']*-1,
                                "ImporteTotal" => $otrosPagos['Importe']*-1,
                                "SubtipoPrestamo" =>  '',
                                "FechaPago" =>  '',
                                "Concepto" =>  $otrosPagos['Concepto'],
                                "FechaImputacion" =>  '',
                                "TipoPrestamo" =>  '',
                                "TipoDeduccion" =>  ''
                            ];       
                        }
                    }
                }       //dd(json_encode($data)); 
                
                /*DEDUCCIONES*/
                $regresaTipoPrestamo = '';
                $regresaConceptoDeduccion='';
                $regresaDescripcionDeduccion='';
                $regresaImporteDeduccion='';
                $tipoPrestamos='';
                $subtipoPrestamos='';

                
                if(!empty($data['cfdi:Comprobante']['cfdi:Addenda']['AddendaDeducciones'])){
                        foreach($data['cfdi:Comprobante']['cfdi:Addenda']['AddendaDeducciones']['AddendaDeduccion'] as $deducciones)
                            {
                                $bandera++;
                                    if($deducciones['TipoPrestamo']==""){
                                      $tipoPrestamos = '&nbsp;'; 

                                    } else {
                                      $tipoPrestamos = $deducciones['TipoPrestamo'];

                                    }    
                                    if($deducciones['SubtipoPrestamo']==""){
                                      $subtipoPrestamos = '&nbsp;'; 

                                    } else {
                                      $subtipoPrestamos = $deducciones['SubtipoPrestamo'];

                                    }            
                                    $regresaTipoPrestamo .=$tipoPrestamos.' '. $subtipoPrestamos.'<br>';
                                    $regresaConceptoDeduccion .= $deducciones['Clave'].'<br>';
                                    $regresaDescripcionDeduccion .= $deducciones['Concepto'].'<br>';
                                    $regresaImporteDeduccion .= number_format($deducciones['ImporteTotal'], 2,'.',',').'<br>';            

                             }
                        $retorno['tipoPrestamo'] = $regresaTipoPrestamo;
                        $retorno['conceptoDeduccion'] = $regresaConceptoDeduccion;
                        $retorno['descripcionDeduccion'] = $regresaDescripcionDeduccion;
                        $retorno['importeDeduccion'] = $regresaImporteDeduccion;
                } else {
                    $retorno['tipoPrestamo'] = "";
                    $retorno['conceptoDeduccion'] = "";
                    $retorno['descripcionDeduccion'] = "";
                    $retorno['importeDeduccion'] = "";
                }
                //dd($regresaImporteDeduccion);
            /*fin percepciones y deducciones*/
            $retorno['bandera'] = $bandera;
            
            
            $retorno['totalDeduccion'] =number_format($data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['TOTALDEDUCCIONES'], 2,'.',',');
            $retorno['mensaje']  = $data['cfdi:Comprobante']['cfdi:Addenda']['Addenda']['AVISOS'];
          } else if(isset($data['cfdi:Comprobante']['cfdi:Addenda']['PA'])){
            $retorno['tipoAddenda'] = "pa";
            $retorno['cumpleanios'] = "&nbsp;";
            $retorno['uAdmva'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['UnidadAdministrativa'];   
            $retorno['nivel'] = (isset($data['cfdi:Comprobante']['cfdi:Addenda']['PA']['NivelSalarial'] ))?$data['cfdi:Comprobante']['cfdi:Addenda']['PA']['NivelSalarial']:'';
            $retorno['grado'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['Grado']; 
            $retorno['Sector'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['Sector']; 
            $retorno['destacamento'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['Destacamento']; 
            $retorno['numRecibo'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['NumeroRecibo'];
            $retorno['numPlaca'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['NumeroPlaca'];
            $retorno['usuario'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['Usuario'];
            $retorno['puesto_actividad'] = (isset($data['cfdi:Comprobante']['cfdi:Addenda']['PA']['DescripcionPuesto']))?$data['cfdi:Comprobante']['cfdi:Addenda']['PA']['DescripcionPuesto']:'';
            $retorno['tipo_contratacion'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['TipoContratacion'];
            $retorno['conceptoPago'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['ConceptoPago'];
            $retorno['periodo_pago'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['PeriodoPago'];
            $retorno['TN'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['TN'];
            $retorno['TF'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['TF'];
            $retorno['TA'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['TA'];
            $retorno['TE'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['TE'];
            $retorno['TV'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['TV'];
            $retorno['TP'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['TP'];
            $retorno['TD'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['TD'];
            $retorno['TAJUS'] = $data['cfdi:Comprobante']['cfdi:Addenda']['PA']['TAJUS'];
            /*percepciones y deducciones*/
                $liga = $data['cfdi:Comprobante']['cfdi:Addenda']['PA'];
                $regresaImportePercepcion='';
                $regresaClaveconDetalle='';
                $regresaDescripcionconDetalle='';
                    if(isset($liga['Percepciones']['Percepcion']['NumeroPercepcion']))
                            $liga['Percepciones']['Percepcion'] = array( 0 => $liga['Percepciones']['Percepcion'] );
                     foreach($liga['Percepciones']['Percepcion'] as $percepcion){
                         $bandera++;
                         $regresaDescripcionconDetalle .= $percepcion['Concepto'].'<br>';
                         $regresaClaveconDetalle .= $percepcion['Clave'].'<br>';
                         $regresaImportePercepcion .= number_format($percepcion['ImporteTotal'], 2,'.',',').'<br>';
                     }
                    $retorno['conceptoPercepcion'] = $regresaClaveconDetalle;
                    $retorno['descripcionPercepcion'] = $regresaDescripcionconDetalle;
                    $retorno['importePercepcion'] = $regresaImportePercepcion;
                
                /*DEDUCCIONES*/

                
                 $regresaDescripcionDeduccion='';
                 $regresaImporteDeduccion='';
                 $regresaConceptoDeduccion='';
                $prestamoDeduccion='';
                    if(isset($liga['Deducciones']['Deduccion']['NumeroDeduccion']))
                            $liga['Deducciones']['Deduccion'] = array( 0 => $liga['Deducciones']['Deduccion'] );
            if(isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:OtrosPagos'])){ 
                    if(isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:OtrosPagos']['nomina12:OtroPago']['Importe'])){
                        $otroPago[] = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:OtrosPagos']['nomina12:OtroPago'];
                    }else{
                        $otroPago = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:OtrosPagos']['nomina12:OtroPago'];
                    } 
                    
                    foreach($otroPago as $otrosPagos){
                        $liga['Deducciones']['Deduccion'][] = [
                            'Clave'=>$otrosPagos['Clave'],
                            'Importe'=> $otrosPagos['Importe']*-1,
                            "ImporteTotal" => $otrosPagos['Importe']*-1,
                            "SubtipoPrestamo" =>  '',
                            "FechaPago" =>  '',
                            "Concepto" =>  $otrosPagos['Concepto'],
                            "FechaImputacion" =>  '',
                            "TipoPrestamo" =>  '',
                            "TipoDeduccion" =>  ''
                        ];       
                    }
                }
                if(!empty($liga['Deducciones']['Deduccion'])){
                     foreach($liga['Deducciones']['Deduccion'] as $deduccion){
                        $bandera++;
                        $regresaDescripcionDeduccion .= $deduccion['Concepto'].'<br>';
                        $regresaConceptoDeduccion .= $deduccion['Clave'].'<br>';
                        $regresaImporteDeduccion .= number_format($deduccion['ImporteTotal'], 2,'.',',').'<br>';
                     }
                    
                
                  $retorno['conceptoDeduccion'] = $regresaConceptoDeduccion;
                  $retorno['descripcionDeduccion'] = $regresaDescripcionDeduccion;
                  $retorno['importeDeduccion'] = $regresaImporteDeduccion;
                } else {
                    $retorno['conceptoDeduccion'] = "";
                    $retorno['descripcionDeduccion'] = "";
                    $retorno['importeDeduccion'] = "";
                }
            /*fin percepciones y deducciones*/
            $retorno['bandera'] = $bandera;
            //dd($data);
            if(isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina'])){
                $retorno['totalPercepcion'] = number_format($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['TotalPercepciones'], 2,'.',',');
            }else{
                $retorno['totalPercepcion'] = number_format($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['nomina:Percepciones']['TotalGravado'], 2,'.',',');
            }
            


            $retorno['totalDeduccion'] =number_format($data['cfdi:Comprobante']['cfdi:Addenda']['PA']['Deducciones']['TotalDeducciones'], 2,'.',',');
            $retorno['mensaje'] = "";
           
          } else if(isset($data['cfdi:Comprobante']['cfdi:Addenda']['DIF'])){
            $retorno['tipoAddenda'] = "dif";

            $retorno['u_admva']='';
            $retorno['universo']='';
            $retorno['nivel']='';
            $retorno['puesto_actividad'] = $data['cfdi:Comprobante']['cfdi:Addenda']['DIF']['CodigoPuestoClaveActividad'];
            $retorno['grado']='';
            $retorno['desc_puesto']='';
            $retorno['sec_sindical']='';
            $retorno['com_sindical']='';
            $retorno['tipo_contratacion']='';
            $retorno['periodo_contratacion']='';
            

             if(isset($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina'])){
                   $retorno['fechaPago'] = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['FechaPago'];
                   $retorno['nss'] = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['NumSeguridadSocial'];
                   $retorno['fechaInicialPago'] = date("d/m/Y", strtotime($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['FechaInicialPago']));
                   $retorno['fechaFinalPago'] = date("d/m/Y", strtotime($data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['FechaFinalPago']));
                   $retorno['diasPagados'] = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina:Nomina']['NumDiasPagados'];
                   $retorno['tn']='';
                   $retorno['periodo_pago']=$retorno['fechaInicialPago'].' AL '.$retorno['fechaFinalPago'];
                } else {
                    $retorno['fechaPago'] = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['FechaPago'];
                   $retorno['nss'] = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['nomina12:Receptor']['NumSeguridadSocial'];
                   $retorno['fechaInicialPago'] = date("d/m/Y", strtotime($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['FechaInicialPago']));
                   $retorno['fechaFinalPago'] = date("d/m/Y", strtotime($data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['FechaFinalPago']));
                   $retorno['diasPagados'] = $data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['NumDiasPagados'];
                   $retorno['tn']=$data['cfdi:Comprobante']['cfdi:Complemento']['nomina12:Nomina']['TipoNomina'];
                   $retorno['periodo_pago']=$retorno['fechaInicialPago'].' AL '.$retorno['fechaFinalPago'];
                }
            
            $retorno['horario'] = $data['cfdi:Comprobante']['cfdi:Addenda']['DIF']['Horario'];
            $retorno['nombramiento'] = $data['cfdi:Comprobante']['cfdi:Addenda']['DIF']['TipoNombramiento'];
            $retorno['codigoPuesto'] = $data['cfdi:Comprobante']['cfdi:Addenda']['DIF']['CodigoPuestoClaveActividad'];
            $retorno['categoria'] = $data['cfdi:Comprobante']['cfdi:Addenda']['DIF']['Categoria'];
            $retorno['categoriaAfin'] = $data['cfdi:Comprobante']['cfdi:Addenda']['DIF']['CategoriaAfin'];
            $retorno['num_plaza'] = $data['cfdi:Comprobante']['cfdi:Addenda']['DIF']['NumeroPlaza'];
            $retorno['tipoPago'] = $data['cfdi:Comprobante']['cfdi:Addenda']['DIF']['TipoPago'];
            $retorno['ZonaPagadora'] = $data['cfdi:Comprobante']['cfdi:Addenda']['DIF']['ZonaPagadora'];
            $retorno['quincena'] = $data['cfdi:Comprobante']['cfdi:Addenda']['DIF']['Quincena'];
            
            /*percepciones y deducciones*/
                $liga = $data['cfdi:Comprobante']['cfdi:Addenda']['DIF'];
                $regresaImportePercepcion='';
                $fechaPercepcion='';
                $regresaClaveconDetalle='';
                $regresaDescripcionconDetalle='';
                $regresaImporteDetalle='';
                $regresaFechaFinDetalle='';
                $regresaNumeroPercepcion='';
                     foreach($liga['Percepciones']['Percepcion'] as $percepcion){
                        $bandera++;
                        $regresaDescripcionconDetalle .= $percepcion['Concepto'].'<br>';
                        $regresaClaveconDetalle .= $percepcion['Clave'].'<br>';
                        $regresaFechaFinDetalle .= '&nbsp;';
                        $regresaImporteDetalle .= '&nbsp';
                        $regresaNumeroPercepcion .= $percepcion['NumeroPercepcion'].'<br>';
                        $regresaImportePercepcion .= number_format($percepcion['ImporteTotal'], 2,'.',',').'<br>';
                        if(isset($percepcion['Detalle']['Clave']))
                            $percepcion['Detalle'] = array( 0 => $percepcion['Detalle'] );
                        if(isset($percepcion['Detalle']) || $percepcion['Detalle'][0]['Importe']!=''){
                            foreach($percepcion['Detalle'] as $percepcionDetalle){
                                $bandera++;
                                if(isset($percepcionDetalle['FechaInicio'])){
                                    if($percepcionDetalle['FechaInicio']==""){
                                        $fechaInicioRFCs = '&nbsp;'; 
                                        $guion = ''; 
                                    } else {
                                       $fechaInicioRFCs = $percepcionDetalle['FechaInicio'];
                                        $guion = ' - '; 
                                    }                        
                                } else {
                                    $fechaInicioRFCs = "";
                                    $guion = '';
                                }
                                if(isset($percepcionDetalle['FechaFin'])){                        
                                    if($percepcionDetalle['FechaFin']==""){
                                        $fechaFinRFCs = '&nbsp;'; 
                                    } else {
                                       $fechaFinRFCs = $percepcionDetalle['FechaFin']; 
                                    }
                                } else {
                                    $fechaFinRFCs = "";
                                }
                                
                                if($percepcionDetalle['Clave']==""){
                                    $tipoClavePercepcion = '&nbsp;'; 
                                } else {
                                  $tipoClavePercepcion = $percepcionDetalle['Clave'].'<br>';
                                } 
                                 if($percepcionDetalle['Descripcion']==""){
                                    $tipoDescripcionPercepcion = '&nbsp;'; 
                                } else {
                                  $tipoDescripcionPercepcion = '&nbsp;&nbsp;&nbsp;'.$percepcionDetalle['Descripcion'].'<br>';
                                }
                                if($percepcionDetalle['Importe']==""){
                                    $tipoImporteDetallePercepcion = '&nbsp;'; 
                                } else {
                                  $tipoImporteDetallePercepcion = '&nbsp;&nbsp;&nbsp;'.number_format($percepcionDetalle['Importe'], 2,'.',',').'<br>';
                                }  
                                if($fechaInicioRFCs!='' && $fechaFinRFCs!=''){
                                        $adendaPercepcion = substr($fechaInicioRFCs, 0, 10).$guion.substr($fechaFinRFCs, 0, 10).'<br>';
                                }else{
                                    $adendaPercepcion = substr($fechaInicioRFCs, 0, 10).$guion.substr($fechaFinRFCs, 0, 10);
                                }
                                $regresaFechaFinDetalle .= $adendaPercepcion;
                                $regresaClaveconDetalle .= $tipoClavePercepcion;                    
                                $regresaDescripcionconDetalle .= $tipoDescripcionPercepcion;
                                $regresaImporteDetalle .= $tipoImporteDetallePercepcion;
                                $regresaImportePercepcion .= '&nbsp;';

                            }
                        } else{                
                            $regresaClaveconDetalle .= '';
                            $regresaDescripcionconDetalle .= '';
                            $regresaImporteDetalle .= '';
                            $regresaImportePercepcion .= '';
                            $regresaFechaFinDetalle .= '';
                        }
                     }
                    $retorno['conceptoPercepcion'] = $regresaClaveconDetalle;
                    $retorno['descripcionPercepcion']=$regresaDescripcionconDetalle;
                    $retorno['importeDetalle']=$regresaImporteDetalle;
                    $retorno['importePercepcion']=$regresaImportePercepcion;
                    $retorno['FechaFinDetalle'] = $regresaFechaFinDetalle;
                
                /*DEDUCCIONES*/
                $regresaDescripcionDeduccion='';
                $regresaImporteDeduccion='';
                $regresaTipoPrestamo = '';
                $regresaConceptoDeduccion='';
                $regresaImporteDetalleDeduccion='';
                $regresaFechaFinDetalleDeduccion='';
                $prestamoDeduccion='';
                $regresaNumeroDeduccion='';
                     foreach($liga['Deducciones']['Deduccion'] as $deduccion){
                        $bandera++;
                        $regresaDescripcionDeduccion .= $deduccion['Concepto'].'<br>';
                        $regresaConceptoDeduccion .= $deduccion['Clave'].'<br>';
                        $regresaTipoPrestamo .= '';
                        $regresaImporteDetalleDeduccion .= '';
                        $regresaNumeroDeduccion .= $deduccion['NumeroDeduccion'].'<br>';
                        $regresaImporteDeduccion .= number_format($deduccion['ImporteTotal'], 2,'.',',').'<br>';
                        if(isset($deduccion['Detalle']['Clave']))
                            $deduccion['Detalle'] = array( 0 => $deduccion['Detalle'] );
                        if(isset($deduccion['Detalle']) || $deduccion['Detalle'][0]['Importe']!=''){
                            foreach($deduccion['Detalle'] as $deduccionDetalle){
                                $bandera++;
                                if($deduccionDetalle['TipoPrestamo']==""){
                                $tipoPrestamos = '&nbsp;'; 
                                } else {
                                  $tipoPrestamos = $deduccionDetalle['TipoPrestamo'];
                                }    
                                if($deduccionDetalle['SubtipoPrestamo']==""){
                                  $subtipoPrestamos = '&nbsp;'; 
                                } else {
                                  $subtipoPrestamos = $deduccionDetalle['SubtipoPrestamo'];
                                }            
                                $regresaTipoPrestamo .= $tipoPrestamos.' '. $subtipoPrestamos.'<br>';
                                if($deduccionDetalle['Clave']==""){
                                    $tipoClave = '&nbsp;'; 
                                } else {
                                  $tipoClave = $deduccionDetalle['Clave'].'<br>';
                                }  
                                if($deduccionDetalle['Descripcion']==""){
                                    $tipoDescripcion = '&nbsp;'; 
                                } else {
                                  $tipoDescripcion = '&nbsp;&nbsp;&nbsp;'.$deduccionDetalle['Descripcion'].'<br>';
                                } 
                                if($deduccionDetalle['Importe']==""){
                                    $tipoImporteDetalleDeduccion = '&nbsp;'; 
                                } else {
                                  $tipoImporteDetalleDeduccion = '&nbsp;&nbsp;&nbsp;'.number_format($deduccionDetalle['Importe'], 2,'.',',').'<br>';
                                }  
                                $regresaConceptoDeduccion .= $tipoClave;
                                $regresaDescripcionDeduccion .= $tipoDescripcion;
                                $regresaImporteDetalleDeduccion .= $tipoImporteDetalleDeduccion;
                                $regresaImporteDeduccion .= '&nbsp;';

                            }
                        } else{                
                            $regresaConceptoDeduccion .= '';
                            $regresaDescripcionDeduccion .= '';
                            $regresaImporteDetalleDeduccion .= '';
                            $regresaImporteDeduccion .= '';
                            $regresaTipoPrestamo .= '';
                        }
                     }
                    
                $tipoPrestamo=$regresaTipoPrestamo;
                $conceptoDeduccion=$regresaConceptoDeduccion;
                $descripcionDeduccion=$regresaDescripcionDeduccion;
                $importeDeduccion=$regresaImporteDeduccion;
                $importeDetalleDeduccion=$regresaImporteDetalleDeduccion;
                $numeroDeduccion = $regresaNumeroDeduccion;

                $retorno['tipoPrestamo']=$regresaTipoPrestamo;
                $retorno['conceptoDeduccion']=$regresaConceptoDeduccion;
                $retorno['descripcionDeduccion']=$regresaDescripcionDeduccion;
                $retorno['importeDeduccion']=$regresaImporteDeduccion;
                $retorno['importeDetalleDeduccion']=$regresaImporteDetalleDeduccion;
            /*fin percepciones y deducciones*/
            $retorno['bandera'] = $bandera;
            $retorno['totalPercepcion'] = number_format($data['cfdi:Comprobante']['subTotal'], 2,'.',',');
            $retorno['totalDeduccion'] =number_format($data['cfdi:Comprobante']['cfdi:Addenda']['DIF']['Deducciones']['TotalDeducciones'], 2,'.',',');
            $retorno['mensaje'] = $data['cfdi:Comprobante']['cfdi:Addenda']['DIF']['Observaciones'];
          } else {
            $retorno['tipoAddenda'] = "noAddenda";
            $retorno['bandera'] = $bandera;
            $retorno['cumpleanios'] = '';
          }
       return $retorno;
   	}

}
