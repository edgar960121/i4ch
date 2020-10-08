<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests;

class RocketChat extends Controller
{
    /*const SERVS = [
        [
            'id'   => 1,
            'ip'   => env('ROCKET_SERVER'),
            'desc' => '',
            'tipo' => 'dev',
        ]
    ];*/

    private static function getServer(){
    	return [
            'ip'   => env('ROCKET_SERVER'),
    	];

    	//return collect(SELF::SERVS)->filter(function($i){ return $i['tipo'] == env('ROCKET_ENV'); })->first();
    }

    public static function CallApi($type, $method, $parameters = [], $headers = [],$returnType = 'array'){
    	$server = SELF::getServer();
    	
    	$client = new \GuzzleHttp\Client();

		$data['headers'] = $headers;
		$data['headers']['Content-Type'] = 'application/json'; 

		if($type != 'GET'){
			$data['body'] = json_encode($parameters);
		}
		
		$url = $server['ip'].$method;
		
		try{
			$response = $client->request($type, $url, $data);

			$contents = $response->getBody()->getContents();

		}catch(ClientException $e){
		
			$contents = (string)$e->getResponse()->getBody();
			
		}catch(RequestException $e){
	        if(!$e->hasResponse()){
				$contents = json_encode([
	            	'error' => [
	              		'code' => 999,
	              		'msg'  => 'Contacta con el administrador'
	            	]
	          	]);
			}else{
				$contents = (string)$e->getResponse()->getBody();
			}

	    }
	    
	    switch($returnType){
			case 'array': 
				$contents = json_decode($contents,true);
				break;
			case 'object':
				$contents = json_decode($contents);
				break;
		}

		return $contents;
    }
}
