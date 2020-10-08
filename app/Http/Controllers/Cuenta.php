<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Cuenta extends Controller
{
    
    public function actualizar(Request $request){
    	//dd(\Session::all());

    	$data = collect($request->all())->filter(function($i,$k){
    		return $k != '_token' && $k != 'retype';
    	})->flatMap(function($i,$k){
    		return [
    			'key'   => $k,
    			'value' => $i
    		];
    	});

    	if($request->has('retype') && \Session::get('Current.informationForm.'.$data['key'].'.bdname') == 'contrasenia'){
    		if($request->retype != $data['value'] || trim($data['value']) == ''){
    			\Session::flash('Current.message',['class'=>'alert-danger','normal'=>'Las contraseñas no coinciden']);
                return \Redirect::to(\URL::previous());
    		}
            $data['value'] = md5($data['value']);
    	}
    	
    	$parametros = [
            'security' => [
                'token'     => env('TOKEN'),
                'sessionId' => \Session::get('Session.id')
            ],
            'data'     => [
                'cdmxId'     => \Session::get('Session.cdmxId'),
                'campo'      => \Session::get('Current.informationForm.'.$data['key'].'.bdname'),
                'nuevoValor' => $data['value']
                
            ]
        ];
        //dd(json_encode($parametros));
        $respuesta = Mule::callApi('PUT','/i4ch/actualizaDatosUsuario','9000',$parametros);

        if($respuesta['error']['code'] != 0){
        	\Session::flash('Current.message',['class'=>'alert-danger','normal'=>'Hubo un error al modificar la información']);
        	return \Redirect::to(\URL::previous());
        }

        if(\Session::get('Current.informationForm.'.$data['key'].'.bdname') != 'contrasenia'){
        	\Session::flash('Current.message',['class'=>'alert-success','normal'=>'Se ha modificado la información correctamente']);
        	\Session::put(\Session::get('Current.informationForm.'.$data['key'].'.sesname'),
        		          $respuesta['data'][\Session::get('Current.informationForm.'.$data['key'].'.bdname')]);
        }
        //dd(json_encode($respuesta));

        return \Redirect::to(\URL::previous());
    	
    }
}
