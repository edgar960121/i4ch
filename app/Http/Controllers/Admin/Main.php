<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mule;
use App\Http\Controllers\Busqueda;

class Main extends Controller
{
    
    public function getRoles(Request $request){
    	
		dd($request);
    	$parametros = [
			'security' => [
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			],
			'data'     => [
				'group'     => $request->modulo
			]
		];
		
		

		$respuesta = Mule::callApi('POST','/foundation/admin/getRoles','9004',$parametros);
		
		

		if($respuesta['error']['code'] != 0){
			$roles = collect([])->prepend([ 'permiso'=>'0', 'nombre'=>'Permisos no disponibles']);
			return \View::make('admin.itemRole')->with(compact('roles'));
		}

		$roles = collect($respuesta['data'])->map(function($i){
			return [
				'permiso' => $i['role'],
				'nombre'  => $i['descripcion']  
			];
		});

		if($roles->count() == 0){
			$roles->prepend([ 'permiso'=>'0', 'nombre'=>'Permisos no disponibles ']);
		}else{
			$roles->prepend([ 'permiso'=>'0', 'nombre'=>'Selecciona ']);
		}

		return \View::make('admin.itemRole')->with(compact('roles'));
    }

    public function getUsers(Request $request){
    	
    	$resultado = Busqueda::usuariosFiltro($request->filtro);

    	if($resultado['error']['code'] != 0){
    		$empleados = [];
    	}else{
    		$empleados = collect($resultado['data'])->map(function($i){
    			return [
    				'nombre' => $i['nombreCompleto'],
    				'mail'   => $i['mail'],
    				'cdmxId' => $i['cdmxId']
    			];
    		});
    	}

    	return $empleados;

    }

    public function getUserRolesItems(Request $request){
    	$resultado = Busqueda::usuarioRoles($request->cdmxId);
    	//dd($resultado);
    	if($resultado['error']['code'] != 0){
    		$roles = [];
    	}else{
    		$roles = collect($resultado['data'])->filter(function($i){ return $i['role'] != 'Recibo_Consulta'; });
    	}

    	return \View::make('admin.itemUsuarioRoles')->with(compact('roles'));

    }

    public function delUserRole(Request $request){
    	
    	$parametros = [
			'security' => [
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			],
			'data'     => [
				'cdmxId'    => $request->cdmxId,
				'role'      => $request->role, 
			]
		];

		//dd($parametros);		
		$busqueda = Mule::callApi('DELETE','/foundation/admin/accessSecurity','9004',$parametros);

		if($busqueda['error']['code'] == 0){
			$busqueda['error']['msg']   = 'El permiso fue actualizado';
			$busqueda['error']['class'] = 'alert-success';
		}else{
			$busqueda['error']['msg']   = 'Hubo un error al actualizar el permiso';
			$busqueda['error']['class'] = 'alert-danger';
		}
		//dd($busqueda);
    	return $busqueda['error'];
    }

    public function addUserRole(Request $request){
    	
    	$parametros = [
			'security' => [
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			],
			'data'     => [
				'cdmxId'    => $request->cdmxId,
				'role'      => $request->role, 
			]
		];

		// sdd($parametros);		
		$busqueda = Mule::callApi('PUT','/foundation/admin/accessSecurity','9004',$parametros);

		if($busqueda['error']['code'] == 0){
			$busqueda['error']['msg']   = 'El permiso fue actualizado';
			$busqueda['error']['class'] = 'alert-success';
		}else{
			$busqueda['error']['msg']   = 'Hubo un error al actualizar el permiso';
			$busqueda['error']['class'] = 'alert-danger';
		}
		//dd($busqueda);
    	return $busqueda['error'];
    }
    
}
