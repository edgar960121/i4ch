<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewRouting extends Controller
{
	public function index(){
		return view('sections/home');
	}

	public function inicio(){
		return  \View::make('principal');
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
		return \Redirect::to(url('/login'));
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
        //dd($parametros);
		//dd($respuesta['data']);
		$modulos = collect($respuesta['data'])->prepend(['group'=>'0','title'=>'Selecciona']);
		//dd($modulos);
		return \View::make('admin.roles')->with(compact('modulos'));
	}

	public function scgcdmx(){

		return \Redirect::to('http://www.contraloria.cdmx.gob.mx');
	}

}
