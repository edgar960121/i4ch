<?php

namespace App\Http\Controllers\VirtualOffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RocketChat;

class ViewRouting extends Controller
{
    
    public function index(){
    	$user = [
    		'user'     => \Session::get('Session.mail'),
    		'password' => \Session::get('Session.rocketChatId')
    	];
    	$respuesta = RocketChat::callApi('POST','/api/v1/login',$user);

        if($respuesta['status'] == 'error'){
            $error = [
                'message' => [
                    'normal' => 'Hubo un error al iniciar la Oficina Virtual CDMX. Contacta con el administrador.',
                    'class'  => 'alert-danger'
                ]
            ];

            return \View::make('principal')->with($error);
        }
    	
    	\Session::put('RocketChat.userId',$respuesta['data']['userId']);
    	\Session::put('RocketChat.authToken',$respuesta['data']['authToken']);
    	
    	/*$channels = [
    		'X-Auth-Token' => $respuesta['data']['authToken'],
    		'X-User-Id'    => $respuesta['data']['userId']
    	];

    	$respuesta = RocketChat::callApi('GET','/api/v1/channels.list.joined',[],$channels,'array');
    	//dd($respuesta);*/
    	return \View::make('virtualOffice.main');
    }

    public function logout(){

    	$user = [
    		'X-Auth-Token' => \Session::put('RocketChat.authToken'),
    		'X-User-Id'    => \Session::put('RocketChat.userId')
    	];

    	$respuesta = RocketChat::callApi('GET','/api/v1/logout',[],$user,'array');
    	dd($respuesta);
    }
}
