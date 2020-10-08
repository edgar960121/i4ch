<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mule;

class Main extends Controller
{

	public function addProcess(Request $request){
		
		if(is_null($request->nombre) || trim($request->nombre) == ''){
			$error = [
				'message' => [
					'normal' => 'El nombre del proceso es obligatorio.',
					'class' => 'alert-danger'
				]

			];

			return \View::make('dashboard.agregarProceso')->with($error);
		}
			
		$parametros = [
            'security' => [
                'token'     => env('TOKEN'),
                'sessionId' => \Session::get('Session.id')
            ],
            'data'     => [
                'nombre'     => $request->nombre, 
            ]
        ];
        
        $respuesta = Mule::callApi('POST','/tablero/procesos','9006',$parametros);

        if($respuesta['error']['code'] != 0){
        	$error = [
				'message' => [
					'normal' => $respuesta['error']['msg'],
					'class' => 'alert-danger'
				]

			];

			return \View::make('dashboard.agregarProceso')->with($error);
        }

        $error = [
			'message' => [
				'normal' => $respuesta['error']['msg'],
				'class' => 'alert-success'
			]

		];

		return \View::make('dashboard.agregarProceso')->with($error);
	}
}
