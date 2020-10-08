<?php

namespace App\Http\Controllers\Recibos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mule;

class ViewRouting extends Controller
{

	
	public function administrador(Request $request){
		return \View::make('recibos.admin');
	}

	public function buscarRecibos(Request $request){
		\Session::put('Current.rfc',$request->rfc);
		\Session::put('Current.curp', '');
		return $this->listadoRecibos($request);
	}

	public function buscarRecibosAnio(Request $request){
		return $this->listadoRecibos($request);
	}

    public function misRecibos(Request $request){
    	\Session::put('Current.rfc',\Session::get('Session.rfc'));
    	\Session::put('Current.curp',\Session::get('Session.curp'));
    	return $this->listadoRecibos($request);
	}

	public function listadoRecibos(Request $request){
		if(!$request->has('anio')){
			$anio = date('Y');
		}else{
			$anio = $request->anio;
			\Session::reflash();
		}

		for($i=$anio;$i>$anio-3;$i--){
			$parametros = [
				'security' => [
					'token'     => env('TOKEN'),
					'sessionId' => \Session::get('Session.id')
				],
				'data'     => [
					'CURP' => \Session::get('Current.curp'),
					'anio' => (string)$i,
					'RFC'  => \Session::get('Current.rfc')
				]
			];

			$recibos = Mule::callApi('POST','/recibo/obtieneCFDIs','9001',$parametros);

			if($recibos['error']['code'] == 0){
				break;
			}
		}
		
		if($recibos['error']['code'] != 0){
			return \View::make('error.general')->with($recibos);
		}
		
		$recibos['data']['Comprobantes']['CFDI'] = collect($recibos['data']['Comprobantes']['CFDI'])->sortBy('fechaInicialPago');
			
		return \View::make('recibos.listado')->with([ 'recibos' => $recibos['data']['Comprobantes'] ]);
		
		

	}

}
