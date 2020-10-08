<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewRouting extends Controller
{
	public function index(){
		return view('sections/home');
	}

	public function inicio(){

		//Seguridad informática para Mule
        $parametros = [
			'security' => [
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			]
		];

		$respuesta = Mule::callApi('POST', '/encuesta/status','9007',$parametros);
		$respuesta2 = Mule::callApi('POST', '/recibo/obtieneIDCITIZEN','9005',$parametros);
		//dd(\Session::get('Session.id'));
		//dd($respuesta2);
		if($respuesta2['data']['status'] == 'PROCEDE'){
		return  \View::make('principal')->with(['user'=>$respuesta['Status'], 'prueba'=>$respuesta2['data']['citizen_id'],
		'validar'=>$respuesta2['data']['status']]);

		}else {
			return  \View::make('principal')->with(['user'=>$respuesta['Status'], 'validar'=>$respuesta2['data']['status']]);
			
		}
		
	}

	public function informacion(){
		\Session::forget('Current.informationForm');
		
		$campos = [
			['name'=> 'Nombres','type'=>'text','bdname' => 'nombre','sesname'=>'Session.nombres'],
			['name'=> 'Apellido paterno','type'=>'text','bdname' => 'apPaterno','sesname'=>'Session.paterno'],
			['name'=> 'Apellido materno','type'=>'text','bdname' => 'apMaterno','sesname'=>'Session.materno'],
			['name'=> 'Correo electrónico','type'=>'text','bdname' => 'correo','sesname'=>'Session.mail'],
			['name'=> 'Contraseña','type'=>'password','bdname' => 'contrasenia','sesname'=>''],
			['name'=> 'CURP','type'=>'text','bdname' => 'curp','sesname'=>'Session.curp'],
			['name'=> 'RFC','type'=>'text','bdname' => 'rfc','sesname'=>'Session.rfc'],
			['name'=> 'OCR','type'=>'text','bdname' => 'ocr','sesname'=>'Session.ocr'],
		];

		$form = collect($campos)->map(function($i){
			$campo = str_random(40);
			\Session::put('Current.informationForm.'.$campo,['bdname' => $i['bdname'],'sesname'=>$i['sesname']]);
			$i['bdname'] = $campo;
			$i['value']  = \Session::get($i['sesname']);
			return $i;
		});
		
		return \View::make('informacion')->with(['form'=>$form]);
	}

	public function login(){
		return view('login');
	}

	public function logout(){
		$parametros = [
			'security' => [
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			]
		];
		
		Mule::callApi('POST','/i4ch/logout','9000',$parametros);

		\Session::flush();
		return \Redirect::to(url('/'));
		//return \Redirect::to(url('/login'));
	}

	public function adminRoles(){

        $parametros = [
			'security' => [
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			]
		];
		
		$respuesta = Mule::callApi('POST','/foundation/admin/getModulos','9004',$parametros);
		
		if($respuesta['error']['code'] != 0){
			return \Redirect::to('/usuario/inicio');
		}

		$modulos = collect($respuesta['data'])->prepend(['group'=>'0','title'=>'Selecciona']);
		//dd($modulos);
		return \View::make('admin.roles')->with(compact('modulos'));
	}

	public function dataEncuesta(Request $request){
		

		/* Guardamos todas las entradas del Form */
		$request = $request->input();

		

		/* Saco de las entradas del form solo las respuestas */
		$respuestas = array_slice($request, 3);

		

		//guardo los datos de la encuesta, modulo y las respuestas en la variable data
		$data = array('tipo' => $request['tipo'],
						'modulo' => $request['modulo'],
						'respuesta' => $respuestas );	

		//Guardo el token y sessionId para la seguridad de la mula
		$parametros = array(
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			);

		//Enpaqueto todos los arreglos anteriores en un solo arreglo
		$arreglo = array('security' => $parametros,
							'data' => $data);

		//dd($arreglo);
		//envío el paquete y recibo la respuesta del servicio
		$callback = Mule::callApi('POST', '/encuesta/save', '9007', $arreglo);



		//nada interesante...
		//$nextQuiz = $callback['Mod'];

		//regreso a la encuesta...
		return \Redirect::to('/encuesta')->with(['parametros' => $parametros]);


	}


	public function encuesta(){

		/* obtengo los datos de seguridad para la mula*/
	    $parametros = [
			'security' => [
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			]
		];
		//dd($parametros);
		//
		/* Consulto el status de la encuesta; lugar donde se quedo el usuario al contestar sus encuestas*/
		$modulo = Mule::callApi('POST', '/encuesta/status','9007',$parametros);
		//dd($modulo);
		$posicionEncuesta = $modulo['Mod'];

		$userType=substr($modulo['Mod'], 0,1);
	
		#Dependiendo del tipo de usuario se lanza una o dos
		if ($userType == "1") {


			/*Discrimino su respuesta*/
			if ($posicionEncuesta == "1.0") {

				return \View::make('formulario.formulario1_8')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta === "1.1") {

				return \View::make('formulario.formulario1_9')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta == "1.2") {

				return \View::make('formulario.formulario1_10')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta == "1.3") {

				return \View::make('formulario.formulario1_11')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta == "1.4") {
				$larespuesta=Mule::callApi('POST', '/encuesta/answer','9007',$parametros);
				$P31=$larespuesta['answer']['1_1'];
				//dd($larespuesta);
				if (isset($larespuesta['answer']['1_5'])) {
					$P35=$larespuesta['answer']['1_5'];
				}else{
					$P35='no';
				}
				switch ($P31) {

					case 'Ninguno':

						$answer = 'la primaria';
						break;

					case 'Primaria':

						if ($P35=='si') {
							$answer = 'la secundaria';
						}else{
							$answer = 'la primaria';
						}
						
						break;

					case 'Secundaria':
						if ($P35=='si') {
							$answer = 'la preparatoria o bachillerato';
						}else{
							$answer = 'la secundaria'; 
						}
						break;

					case 'Preparatoria o bachillerato':
						if ($P35=='si') {
							$answer='la licenciatura';
						}else{
							$answer = 'la preparatoria o bachillerato';
						}
						
						break;

					case 'Estudios técnicos o comerciales con primaria terminada':

						$answer = 'la secundaria';
						break;

					case 'Estudios técnicos o comerciales con secundaria terminada':

						$answer = 'la preparatoria o bachillerato';
						break;

					case 'Estudios técnicos o comerciales con preparatoria terminada':
						$answer = 'la Licenciatura';
						break;

					case 'Licenciatura':

					if ($P35=='si') {
							$answer = 'otra licenciatura o posgrado';
						}else{
							$answer= 'licenciatura';
						}
						break;

					case 'Maestría':
						$answer='otra licenciatura o posgrado';

						break;

					case 'Doctorado':
						$answer='otra licenciatura o posgrado';
						break;		
									
					default:
						$answer='su ultimo grado de estudios';
						break;
				}

				return \View::make('formulario.formulario1_12')->with(['parametros' => $parametros])->with('answer',$answer);

			}elseif ($posicionEncuesta == "1.5") {

				$larespuesta=Mule::callApi('POST', '/encuesta/answer','9007',$parametros);
				//dd($larespuesta);
				$P31=$larespuesta['answer']['1_1'];

				if (isset($larespuesta['answer']['1_5'])) {
					$P35=$larespuesta['answer']['1_5'];
				}else{
					$P35='no';
				}

				switch ($P31) {

					case 'Ninguno':
						$answer = 'la primaria';
						break;

					case 'Primaria':
						if ($P35=='si') {
							$answer = 'la secundaria';
						}else{
							$answer = 'la primaria';
						}
						
						break;

					case 'Secundaria':
						if ($P35=='si') {
							$answer = 'la preparatoria o bachillerato';
						}else{
							$answer = 'la secundaria'; 
						}
						break;

					case 'Preparatoria o bachillerato':
						if ($P35=='si') {
							$answer='la licenciatura';
						}else{
							$answer = 'la preparatoria o bachillerato';
						}
						
						break;

					case 'Estudios técnicos o comerciales con primaria terminada':

						$answer = 'la secundaria';
						break;

					case 'Estudios técnicos o comerciales con secundaria terminada':
						$answer = 'la preparatoria o bachillerato';
						break;

					case 'Estudios técnicos o comerciales con preparatoria terminada':
						$answer = 'la Licenciatura';
						break;

					case 'Licenciatura':

					if ($P35=='si') {
							$answer = 'otra licenciatura o posgrado';
						}else{
							$answer= 'licenciatura';
						}
						break;

					case 'Maestría':
						$answer='otra licenciatura o posgrado';

						break;

					case 'Doctorado':
						$answer='otra licenciatura o posgrado';
						break;		
									
					default:
						$answer='su ultimo grado de estudios';
						break;
				}

				return \View::make('formulario.formulario1_13')->with(['parametros' => $parametros])->with('answer',$answer)->with('p3', $P31);

			}elseif ($posicionEncuesta == "1.6") {

				return \View::make('formulario.formulario1_1')->with(['parametros' => $parametros]);

			}elseif($posicionEncuesta=="1.7"){

				return \View::make('formulario.formulario1_2')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta == "1.8") {

				return \View::make('formulario.formulario1_3')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta == "1.9") {

				return \View::make('formulario.formulario1_4')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta === "1.10") {

				return \View::make('formulario.formulario1_5')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta == "1.11") {
				
				
				return \View::make('formulario.formulario1_6')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta == "1.12") {
				

				return \View::make('formulario.formulario1_7')->with(['parametros' => $parametros]);

			}elseif($modulo['Mod'] == 'Concluido'){

				return \View::make('formulario.formularioende')->with(['parametros' => $parametros]);
			}

		}else{

			if ($posicionEncuesta == "2.0") {

				return \View::make('formulario.formulario2_1')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta == "2.1") {

				return \View::make('formulario.formulario2_2')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta == "2.2") {

				return \View::make('formulario.formulario2_3')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta == "2.3") {

				return \View::make('formulario.formulario2_4')->with(['parametros' => $parametros]);

			}elseif ($posicionEncuesta == "2.4") {

				$larespuesta=Mule::callApi('POST', '/encuesta/answer','9007',$parametros);


				$P31=$larespuesta['answer']['1_1'];

				if (isset($larespuesta['answer']['1_5'])) {
					$P35=$larespuesta['answer']['1_5'];
				}else{
					$P35='no';
				}





				switch ($P31) {

					case 'Ninguno':
						$answer = 'la primaria';
						break;

					case 'Primaria':
						if ($P35=='si') {
							$answer = 'la secundaria';
						}else{
							$answer = 'la primaria';
						}
						
						break;

					case 'Secundaria':
						if ($P35=='si') {
							$answer = 'la preparatoria o bachillerato';
						}else{
							$answer = 'la secundaria'; 
						}
						break;

					case 'Preparatoria o bachillerato':
						if ($P35=='si') {
							$answer='la licenciatura';
						}else{
							$answer = 'la preparatoria o bachillerato';
						}
						
						break;

					case 'Estudios técnicos o comerciales con primaria terminada':

						$answer = 'la secundaria';
						break;

					case 'Estudios técnicos o comerciales con secundaria terminada':
						$answer = 'la preparatoria o bachillerato';
						break;

					case 'Estudios técnicos o comerciales con preparatoria terminada':
						$answer = 'la Licenciatura';
						break;

					case 'Licenciatura':

					if ($P35=='si') {
							$answer = 'otra licenciatura o posgrado';
						}else{
							$answer= 'licenciatura';
						}
						break;

					case 'Maestría':
						$answer='otra licenciatura o posgrado';

						break;

					case 'Doctorado':
						$answer='otra licenciatura o posgrado';
						break;		
									
					default:
						$answer='su ultimo grado de estudios';
						break;
				}



				return \View::make('formulario.formulario2_5')->with(['parametros' => $parametros])->with('answer', $answer);

			}elseif ($posicionEncuesta == "2.5") {

				$larespuesta=Mule::callApi('POST', '/encuesta/answer','9007',$parametros);


				$P31=$larespuesta['answer']['1_1'];

				if (isset($larespuesta['answer']['1_5'])) {
					$P35=$larespuesta['answer']['1_5'];
				}else{
					$P35='no';
				}





				switch ($P31) {

					case 'Ninguno':
						$answer = 'la primaria';
						break;

					case 'Primaria':
						if ($P35=='si') {
							$answer = 'la secundaria';
						}else{
							$answer = 'la primaria';
						}
						
						break;

					case 'Secundaria':
						if ($P35=='si') {
							$answer = 'la preparatoria o bachillerato';
						}else{
							$answer = 'la secundaria'; 
						}
						break;

					case 'Preparatoria o bachillerato':
						if ($P35=='si') {
							$answer='la licenciatura';
						}else{
							$answer = 'la preparatoria o bachillerato';
						}
						
						break;

					case 'Estudios técnicos o comerciales con primaria terminada':

						$answer = 'la secundaria';
						break;

					case 'Estudios técnicos o comerciales con secundaria terminada':
						$answer = 'la preparatoria o bachillerato';
						break;

					case 'Estudios técnicos o comerciales con preparatoria terminada':
						$answer = 'la Licenciatura';
						break;

					case 'Licenciatura':

					if ($P35=='si') {
							$answer = 'otra licenciatura o posgrado';
						}else{
							$answer= 'licenciatura';
						}
						break;

					case 'Maestría':
						$answer='otra licenciatura o maestría';

						break;

					case 'Doctorado':
						$answer='otra licenciatura o maestría';
						break;		
									
					default:
						$answer='su ultimo grado de estudios';
						break;
				}

				return \View::make('formulario.formulario2_6')->with(['parametros' => $parametros])->with('answer',$answer)->with('p3', $P31);

			}elseif ($modulo['Mod'] == 'Concluido') {

				return \View::make('formulario.formularioende')->with(['parametros' => $parametros]);
				# code...
			}

		}

		
		
	}

	public function scgcdmx(){

		return \Redirect::to('http://www.contraloria.cdmx.gob.mx');
	}

	public function cuestionario(){
		//dd('hola');
		return \View::make('formulario.formulario1_1');
		
	}

	public function cuestionarioAjax(Request $request){

		

		
		$sessionvar =$request->session()->get('Session');
		$mail= $sessionvar['mail'];
		
		
		if($request->ajax()){
			
			$respuestas = array(
				'ninguna' => $request->ninguna,
				'diabetes' => $request->diabetes,
				'cancer' => $request->cancer, 
				'respiratoria' => $request->respiratoria,
				'cardiaca' => $request->cardiaca,
				'especificacion' => $request->especificacion,
				'embarazo' => $request->embarazo,
				'edad' => $request->edad,
				'discapacidad' => $request->discapacidad,
				'especificacion2' => $request->especificacion2);

				$parametros = array(
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			);

				$arreglo = array('security' => $parametros,
									'data' => array(
										'respuesta' => $respuestas ));
				
				

				try {
					
					$callback = Mule::callApi('POST', '/encuesta/save', '9007', $arreglo);
						//dd($request);
					$arreglomail = array('data' => array(
										'asunto' =>'Censo Covid',
										'para' => $mail,
										'cuerpo' => '<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <style>
        p, h3{
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>
    <p>De acuerdo a lo que respondiste acerca de lo establecido en el ACUERDO POR EL QUE SE EXPIDEN LOS LINEAMIENTOS DE PROTECCI&Oacute;N A LA SALUD QUE DEBER&Aacute;N CUMPLIR LAS OFICINAS DE LA ADMINISTRACI&Oacute;N P&Uacute;BLICA DE LA CIUDAD DE M&Eacute;XICO EN EL MARCO DEL PLAN GRADUAL HACIA LA NUEVA NORMALIDAD, publicados en la Gaceta Oficial de la Ciudad de M&eacute;xico No. 359 Bis, de fecha 05 junio de 2020, en su numeral 6.6 PERSONAS SERVIDORAS P&Uacute;BLICAS QUE PERTENEZCAN A UN GRUPO EN SITUACI&Oacute;N DE RIESGO O VULNERABILIDAD ante el COVID-19 </p>
    <h3>NO OLVIDES ENVIAR TU COMPROBANTE M&Eacute;DICO</h3>
    <p><a href="mailto:ccensocovid@finanzas.cdmx.gob.mx">censocovid@finanzas.cdmx.gob.mx</a></p>
    <p>Si no padeces ninguna de las enfermedades o presentas alg&uacute;n factor de riesgo, por favor, haz caso omiso de este mensaje.</p>
</body>
</html>' ));

								
					//dd($arreglomail);
						//eniva correo
					$callbacksend = Mule::callApi('POST', '/mail/sendGenericMail', '9009', $arreglomail);
						//dd($callbacksend);

					//dump($callback);
					if($callback['error']['code'] === 0){

						

						return response('/usuario/inicio',200);
					}elseif ($callback == null) {
						return response('Cierre esta ventana por favor', 400);
					}
				} catch (\Throwable $th) {
					//dump($th);
					return response('No ha sido posible guardar su infomarción, cierre esta pestaña e intente nuevamente',400);
				}
			
		}


	}


	


}
