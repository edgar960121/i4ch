<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Busqueda extends Controller
{
    public static function usuariosFiltro($filtro){

    	$parametros = [
			'security' => [
				'token'     => env('TOKEN')
			],
			'data'     => [
				'search'    => $filtro      
			]
		];

		//dd($parametros);		
		$busqueda = Mule::callApi('POST','/foundation/getCitizenInformation','9004',$parametros);
		//dd($busqueda);
    	return $busqueda;
    }

    public static function usuarioRoles($cdmxId){
    	$parametros = [
			'security' => [
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			],
			'data'     => [
				'cdmxId'    => $cdmxId 
			]
		];

		//dd($parametros);		
		$busqueda = Mule::callApi('POST','/foundation/admin/accessSecurity','9004',$parametros);
		//dd($busqueda);
    	return $busqueda;
    }
}
