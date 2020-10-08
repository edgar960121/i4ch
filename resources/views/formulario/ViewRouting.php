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
		//dd($respuesta);
		return  \View::make('principal')->with(['user'=>$respuesta['Status']]);
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
		return \View::make('formulario.formulario1_1');
	}

	public function cuestionarioAjax(Request $request){

		if($request->ajax()){
			//dd($request->input());
			$respuestas = array(
				'nombre' => $request->nombre,
				'appat' => $request->appat, 
				'apmat' => $request->apmat,
				'genero' => $request->genero,
				'discapacidad' => (isset($request->discapacidad)) ? $request->discapacidad:null, 
				'discapacidadSelect' => (isset($request->discapacidadSelect)) ? $request->discapacidadSelect:null, 
				'discapacidadSelectAyuda' => (isset($request->discapacidadSelectAyuda)) ? $request->discapacidadSelectAyuda:null,
				'OtraDiscapacidadNecesidad' => (isset($request->OtraDiscapacidadNecesidad)) ? $request->OtraDiscapacidadNecesidad:null,
				'limitfisic' => (isset($request->limitfisic)) ? $request->limitfisic:null,
				'limitfisicselect' => (isset($request->limitfisicselect)) ? $request->limitfisicselect:null,
				'OtraLimitFisic' => (isset($request->OtraLimitFisic)) ? $request->OtraLimitFisic:null,
				'estudioscert' => (isset($request->estudioscert)) ? $request->estudioscert:null,
				'actividadesPrincipales' => (isset($request->actividadesPrincipales)) ? $request->actividadesPrincipales:null,
				'nivel_inconcluso1A' => (isset($request->nivel_inconcluso1A)) ? $request->nivel_inconcluso1A:null,
				'nivel_inconcluso2A' => (isset($request->nivel_inconcluso2A)) ? $request->nivel_inconcluso2A:null,
				'nivel_inconcluso3A' => (isset($request->nivel_inconcluso3A)) ? $request->nivel_inconcluso3A:null,
				'nivel_inconcluso7A' => (isset($request->nivel_inconcluso7A)) ? $request->nivel_inconcluso7A:null,
				'nivel_inconcluso25A' => (isset($request->nivel_inconcluso25A)) ? $request->nivel_inconcluso25A:null,
				'nivel_inconcluso26A' => (isset($request->nivel_inconcluso26A)) ? $request->nivel_inconcluso26A:null,
				'nivel_inconcluso27A' => (isset($request->nivel_inconcluso27A)) ? $request->nivel_inconcluso27A:null,
				'nivel_inconcluso28A' => (isset($request->nivel_inconcluso28A)) ? $request->nivel_inconcluso28A:null,
				'nivel_inconcluso29A' => (isset($request->nivel_inconcluso29A)) ? $request->nivel_inconcluso29A:null,
				'nivel_inconcluso1B' => (isset($request->nivel_inconcluso1B)) ? $request->nivel_inconcluso1B:null,
				'nivel_inconcluso2B' => (isset($request->nivel_inconcluso2B)) ? $request->nivel_inconcluso2B:null,
				'nivel_inconcluso3B' => (isset($request->nivel_inconcluso3B)) ? $request->nivel_inconcluso3B:null,
				'nivel_inconcluso7B' => (isset($request->nivel_inconcluso7B)) ? $request->nivel_inconcluso7B:null,
				'nivel_inconcluso25B' => (isset($request->nivel_inconcluso25B)) ? $request->nivel_inconcluso25B:null,
				'nivel_inconcluso26B' => (isset($request->nivel_inconcluso26B)) ? $request->nivel_inconcluso26B:null,
				'nivel_inconcluso27B' => (isset($request->nivel_inconcluso27B)) ? $request->nivel_inconcluso27B:null,
				'nivel_inconcluso28B' => (isset($request->nivel_inconcluso28B)) ? $request->nivel_inconcluso28B:null,
				'nivel_inconcluso29B' => (isset($request->nivel_inconcluso29B)) ? $request->nivel_inconcluso29B:null,
				'nivel_inconcluso30B' => (isset($request->nivel_inconcluso30B)) ? $request->nivel_inconcluso30B:null,
				'nivel_inconcluso31B' => (isset($request->nivel_inconcluso31B)) ? $request->nivel_inconcluso31B:null,
				'nivel_inconcluso32B' => (isset($request->nivel_inconcluso32B)) ? $request->nivel_inconcluso32B:null,
				'nivel_inconcluso1C' => (isset($request->nivel_inconcluso1C)) ? $request->nivel_inconcluso1C:null,
				'nivel_inconcluso2C' => (isset($request->nivel_inconcluso2C)) ? $request->nivel_inconcluso2C:null,
				'nivel_inconcluso3C' => (isset($request->nivel_inconcluso3C)) ? $request->nivel_inconcluso3C:null,
				'nivel_inconcluso7C' => (isset($request->nivel_inconcluso7C)) ? $request->nivel_inconcluso7C:null,
				'nivel_inconcluso25C' => (isset($request->nivel_inconcluso25C)) ? $request->nivel_inconcluso25C:null,
				'nivel_inconcluso26C' => (isset($request->nivel_inconcluso26C)) ? $request->nivel_inconcluso26C:null,
				'nivel_inconcluso27C' => (isset($request->nivel_inconcluso27C)) ? $request->nivel_inconcluso27C:null,
				'nivel_inconcluso28C' => (isset($request->nivel_inconcluso28C)) ? $request->nivel_inconcluso28C:null,
				'nivel_inconcluso29C' => (isset($request->nivel_inconcluso29C)) ? $request->nivel_inconcluso29C:null,
				'nivel_inconcluso30C' => (isset($request->nivel_inconcluso30C)) ? $request->nivel_inconcluso30C:null,
				'nivel_inconcluso1D' => (isset($request->nivel_inconcluso1D)) ? $request->nivel_inconcluso1D:null,
				'nivel_inconcluso2D' => (isset($request->nivel_inconcluso2D)) ? $request->nivel_inconcluso2D:null,
				'nivel_inconcluso3D' => (isset($request->nivel_inconcluso3D)) ? $request->nivel_inconcluso3D:null,
				'nivel_inconcluso7D' => (isset($request->nivel_inconcluso7D)) ? $request->nivel_inconcluso7D:null,
				'nivel_inconcluso25D' => (isset($request->nivel_inconcluso25D)) ? $request->nivel_inconcluso25D:null,
				'nivel_inconcluso26D' => (isset($request->nivel_inconcluso26D)) ? $request->nivel_inconcluso26D:null,
				'nivel_inconcluso27D' => (isset($request->nivel_inconcluso27D)) ? $request->nivel_inconcluso27D:null,
				'nivel_inconcluso28D' => (isset($request->nivel_inconcluso28D)) ? $request->nivel_inconcluso28D:null,
				'nivel_inconcluso29D' => (isset($request->nivel_inconcluso29D)) ? $request->nivel_inconcluso29D:null,
				'nivel_inconcluso30D' => (isset($request->nivel_inconcluso30D)) ? $request->nivel_inconcluso30D:null,
				'nivel_inconcluso31D' => (isset($request->nivel_inconcluso31D)) ? $request->nivel_inconcluso31D:null,
				'nivel_inconcluso32D' => (isset($request->nivel_inconcluso32D)) ? $request->nivel_inconcluso32D:null);
			$parametros = array(
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			);

				$arreglo = array('security' => $parametros,
									'data' => array(
										'respuesta' => $respuestas ));
				//dd($arreglo);
				try {
					$callback = Mule::callApi('POST', '/encuesta/save', '9007', $arreglo);
					//dd($callback);
					if($callback['error']['code'] != 0){
						return response('/usuario/inicio',200);
					}
				} catch (\Throwable $th) {
					return response('No ha sido posible guardar su infomarción, cierre esta pestaña e intente nuevamente',400);
				}
			
		}


	}

}
