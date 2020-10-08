<?php

namespace App\Http\Controllers\Cau;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mule;
use App\Http\Controllers\Busqueda;

class Main extends Controller
{
    /**
     * [buscaEmpleados description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function buscaEmpleados(Request $request){

    	if(trim($request->filtro) == ''){
    		return \View::make('cau.busqueda')->with(['message'=>['class'=>'alert-danger','normal'=>'Debes ingresar la búsqueda']]);
		}

        $empleados = Busqueda::usuariosFiltro($request->filtro);

        if($empleados['error']['code'] != 0){
            $data = [
                'empleados' => [],
                'message'   => ['class'=>'alert-danger','normal'=>$empleados['error']['msg']],
                'filtro'    => $request->filtro
            ];

        }else{
            $data = [
                'empleados' => $empleados['data'],
                'filtro'    => $request->filtro
            ];
        } 

		if($request->has('message')){
			$data['message'] = ['class'=>$request->message['class'],'normal'=>$request->message['normal']];
		}
        //dd($data);
		\Session::put('Current.filter',$request->filtro);

    	return \View::make('cau.busqueda')->with($data);
    }

    /**
     * [updateMail description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateMail(Request $request){
    	
    	if(trim($request->mail) == ''){
    		return \View::make('cau.busqueda')->with(['message'=>['class'=>'alert-danger','normal'=>'Debes ingresar el correo']]);
		}

    	$parametros = [
            'security' => [
                'token'     => env('TOKEN'),
                'sessionId' => \Session::get('Session.id')
            ],
            'data'     => [
                'cdmxId'     => $request->id,
                'campo'      => 'correo',
                'nuevoValor' => $request->mail
                
            ]
        ];
        //dd(json_encode($parametros));
        $respuesta = Mule::callApi('PUT','/i4ch/actualizaDatosUsuario','9000',$parametros);

        if($respuesta['error']['code'] != 0){
        	return \View::make('cau.busqueda')->with(['message'=>['class'=>'alert-danger','normal'=>$respuesta['error']['msg']]]);
        }

        $request->request->add(['filtro' => \Session::get('Current.filter')]);
        $request->request->add(['message' => [
                                    'normal' => 'El correo se actualizó correctamente',
                                    'class'  => 'alert-success'
                                ]]); 
        \Session::forget('Current.filter');
        
        return $this->buscaEmpleados($request);

    }

    /**
     * [activarUsuario description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function activarUsuario(Request $request){
        $parametros = [
            'security' => [
                'token'     => env('TOKEN'),
                'sessionId' => \Session::get('Session.id')
            ],
            'data'     => [
                'cdmxId'     => $request->id 
            ]
        ];
        //dd(json_encode($parametros));
        $respuesta = Mule::callApi('PUT','/foundation/cau/usuarios','9004',$parametros);
        //dd($respuesta);
        if($respuesta['error']['code'] == 0){
            $request->request->add(['message' => [
                                        'normal' => 'El usuario se activó correctamente',
                                        'class'  => 'alert-success'
                                    ]]);
        }else{
            $request->request->add(['message' => [
                                        'normal' => 'Hubo un error al activar el usuario',
                                        'class'  => 'alert-danger'
                                    ]]);
        }

        return $this->buscaEmpleados($request);
    }
}
