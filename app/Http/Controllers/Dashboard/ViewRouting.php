<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mule;

class ViewRouting extends Controller
{

	public function addProcess(){
		//dd(\Session::all());
		return \View::make('dashboard.agregarProceso');
	}

	public function main(){
		$permissions = collect(\Session::get('Session.modulos'))->filter(function($i,$k){
			return $k == 'Dashboard';
		})->flatMap(function($i){
			return $i['roles'];
		})->keys();

		if($permissions->contains('Dashboard_Admin')){
			return $this->admin();
		}

		if($permissions->contains('Dashboard_Lider')){
			return $this->lider();
		}

		if($permissions->contains('Dashboard_Participante')){
			return $this->participante();
		}

	}

	private function participante(){
		return \View::make('dashboard.principal');
	}

	private function lider(){
		$processes = $this->getProcesses();

		$parameters = [
			'addProcess' => true,
			'addTask'    => true,
			'processes'  => $processes['data'] 
		];

		if($processes['error']['code'] != 0){
			$parameters['message'] = [
				'normal' => $processes['error']['msg'],
				'class'  => 'alert-danger'
			];
		}

		return \View::make('dashboard.principal')->with($parameters);
	}

	private function admin(){
		return \View::make('dashboard.pricipal');
	}

	private function getProcesses(){

		$headers = [
			'Authorization' => env('TOKEN'),
			'cdmxId'		=> \Session::get('Session.cdmxId'),
            'sessionId' 	=> \Session::get('Session.id')
        ];
        
        $respuesta = Mule::callApi('GET','/tablero/procesos','9006',[],$headers);
        //dd($respuesta);
		
		if($respuesta['error']['code'] == 0){
			$respuesta['data'] = collect($respuesta['data'])->map(function($i){
				return [
					'id'      => $i['_id'],
					'name'    => $i['nombre'],
					'percent' => rand(1,100)
				];
			});
		}

		return $respuesta;
		

		return [
			['id'=>1,'name'=>'proceso 1','percent'=> 20],
			['id'=>2,'name'=>'proceso 2','percent'=> 30],
			['id'=>3,'name'=>'proceso 3','percent'=> 40],
			['id'=>4,'name'=>'proceso 4','percent'=> 50],
			['id'=>5,'name'=>'proceso 5','percent'=> 10],
		];
	}
}
