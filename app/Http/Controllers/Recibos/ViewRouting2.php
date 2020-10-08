<?php

namespace App\Http\Controllers\Recibos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mule;

class ViewRouting2 extends Controller
{

	
	public function administrador(Request $request){
     //   dd('Entro a administrador');
		return \View::make('recibos.admin2');
	}

	public function buscarRecibos(Request $request){
		\Session::put('Current.rfc',$request->rfc);
		\Session::put('Current.curp', '');
		return $this->listadoRecibos($request);
	}

	public function buscarRecibosAnio(Request $request){
		return $this->listadoRecibos($request);
	}
	public function buscarRecibosAnioEnlace(Request $request){
		return $this->listadoRecibosEnlace($request);
	}

    public function misRecibos(Request $request){
    	//dd('akisi');
    	\Session::put('Current.rfc',\Session::get('Session.rfc'));
    	\Session::put('Current.curp',\Session::get('Session.curp'));
    	return $this->listadoRecibos($request);
	}

	
	public function listadoRecibos(Request $request){
		//dd($request->input());

		if(!$request->has('anio')){
			$anio = date('Y');
		}else{
			$anio = $request->anio;
			\Session::reflash();
		}

		for($i=$anio;$i>$anio-4;$i--){
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

			//$recibos = Mule::callApi('POST','/recibo/obtieneCFDIs','9001',$parametros);
			$recibos = Mule::callApi('POST','/recibo/obtieneCFDIs','9005',$parametros);

			//dd($parametros);

			if($recibos['error']['code'] == 0){
				break;
			}
		}
		
		if($recibos['error']['code'] != 0){
			return \View::make('error.general')->with($recibos);
		}
		
		$recibos['data']['Comprobantes']['CFDI'] = collect($recibos['data']['Comprobantes']['CFDI'])->sortBy('fechaInicialPago');
			
		//$anemles = $recibos['data'];
		//dd($anemles);
		//dd('mm');
		//dd($recibos);
		return \View::make('recibos.listado')->with([ 'recibos' => $recibos['data']['Comprobantes'] ]);
		
		

	}
   /*************************** L I S T A D O   R E C I B O S  E N L A C E **************************************/

	//buscador de los RFC para los recibos
	public function buscarRecibosEnlace(Request $request){
		\Session::put('Current.rfc',$request->rfc);
		\Session::put('Current.curp', '');
		//return $this->listadoRecibosHist($request);//apuntahistorico
		
		return $this->listadoRecibosEnlace($request);
	}

	public function listadoRecibosEnlace(Request $request){
		
			//dd($request);
		//dd("aquiedtoy");

		if(!$request->has('anio')){
			$anio = date('Y');
		}else{
			$anio = $request->anio;
			\Session::reflash();
		}

		for($i=$anio;$i>$anio-4;$i--){
			$parametros = [
				'security' => [
					'token'     => env('TOKEN'),
					'sessionId' => \Session::get('Session.id')
				],
				'data'     => [
					'CURP' => \Session::get('Session.curp'),
					'anio' => (string)$i,
					'RFC'  => \Session::get('Current.rfc')
				]
			];


			//dd($parametros['data']['anio']);

			//$recibos = Mule::callApi('POST','/recibo/obtieneCFDIs','9001',$parametros);
			$recibos = Mule::callApi('POST','/recibo/obtieneCFDIsEnlace','9005',$parametros);

			//dd($parametros);

			if($recibos['error']['code'] == 0){
				break;
			}
		}
		
		if($recibos['error']['code'] != 0){
			return \View::make('error.general')->with($recibos);
		}
		
		$recibos['data']['Comprobantes']['CFDI'] = collect($recibos['data']['Comprobantes']['CFDI'])->sortBy('fechaInicialPago');
			
		//$anemles = $recibos['data'];
		//dd($anemles);
		//dd('mm');
		//dd($recibos);
		return \View::make('recibos.UUID')->with([ 'recibos' => $recibos['data']['Comprobantes'] ]);
		
		

	}


}