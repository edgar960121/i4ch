<?php

namespace App\Http\Controllers\Recibos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mule;
use Carbon\Carbon;

dd('Entro a Archivos2');

class Archivos extends Controller
{
    public function notAllowed(){
        return \Redirect::to('/usuario/inicio');
    }

    public function obtieneReciboZIP(Request $request){//// el bueno zip

       
        $zipper = \Zipper::make(storage_path('tmpZip/'.$request->uuid.'.zip'));

        $recibo = $this->generarRecibo($request,'/recibo/obtenerReciboElectronicoXML');

        if($recibo['error']['code'] != 0){
            return \View::make('error.general')->with($recibo);
        }

        $zipper->addString($request->uuid.'.xml', $recibo['data']);
     
        $zipper->addString($request->uuid.'.pdf', $this->obtieneReciboPDFHist($request));
        
        $zipper->close();
        
        $zip = \File::get(storage_path('tmpZip/'.$request->uuid.'.zip'));
        \File::delete(storage_path('tmpZip/'.$request->uuid.'.zip'));
        
        return \Response::make($zip,'200',array(
            'Content-Type'=>'application/octet-stream',
            'Content-Disposition' => 'attachment;filename="'.$request->uuid.'.zip"'
        )); 

    }
    
    
    
    public function obtieneReciboXML(Request $request){
        $recibo = $this->generarRecibo($request,'/recibo/obtenerReciboElectronicoXML');
        //dd($recibo);

        if($recibo['error']['code'] != 0){
            return \View::make('error.general')->with($recibo);
        }
        dd($request);
    	return \Response::make($recibo['data'],'200',array(
          
            'Content-Type'=>'application/octet-stream',
            'Content-Disposition'=>'attachment; filename="' . $request->uuid . '.xml"'
           
        ));
       
    }

    
 
    private function obtieneFolioApertura($text){
    	$parametros = [
			'security' => [
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			],
			'data'     => [
				'text' => $text
			]
		];

		//$folio = Mule::callApi('POST','/recibo/folioApertura','9001',$parametros);
        $folio = Mule::callApi('POST','/recibo/folioApertura','9005',$parametros);

		if($folio['error']['code'] != 0){
			return \View::make('error.general')->with($folio);
		}

		return $folio['data']['idcdmx'];
    }

    private function generarRecibo(Request $request, $servicio){
    	
    	$parametros = [
			'security' => [
				'token'     => env('TOKEN'),
				'sessionId' => \Session::get('Session.id')
			],
			'data'     => [
				'anio' => $request->anio,
                'collection' =>$request->collection,
				'uuid' => $request->uuid
			]
		];
		
        //dd($parametros);
		//$recibo = Mule::callApi('POST',$servicio,'9001',$parametros);
        $recibo = Mule::callApi('POST',$servicio,'9005',$parametros);
        //dd($recibo);

		return $recibo;

    }


    public function notAllowedHist(){
        return \Redirect::to('/usuario/inicio');
    }

    public function obtieneReciboZIPHist(Request $request){
        $zipper = \Zipper::make(storage_path('tmpZip/'.$request->uuid.'.zip'));

        $recibo = $this->generarReciboHist($request,'/recibo/obtenerReciboElectronicoXML');

        if($recibo['error']['code'] != 0){
            return \View::make('error.general')->with($recibo);
        }

        $zipper->addString($request->uuid.'.xml', $recibo['data']);
        $zipper->addString($request->uuid.'.pdf', $this->obtieneReciboPDFHist($request));

        $zipper->close();
        
        $zip = \File::get(storage_path('tmpZip/'.$request->uuid.'.zip'));
        \File::delete(storage_path('tmpZip/'.$request->uuid.'.zip'));
        
        return \Response::make($zip,'200',array(
            'Content-Type'=>'application/octet-stream',
            'Content-Disposition' => 'attachment;filename="'.$request->uuid.'.zip"'
        )); 

    }
    

    public function obtieneReciboXMLHist(Request $request){
        $recibo = $this->generarReciboHist($request,'/recibo/obtenerReciboElectronicoXML');

        if($recibo['error']['code'] != 0){
            return \View::make('error.general')->with($recibo);
        }

        return \Response::make($recibo['data'],'200',array(
            'Content-Type'=>'application/octet-stream',
            'Content-Disposition'=>'attachment; filename="' . $request->uuid . '.xml"'
        ));
    }

    public function obtieneReciboPDFHist(Request $request){///colores rosa y verde
   
        $respuesta = $this->generarReciboHist($request,'/recibo/obtenerReciboElectronico');
                
        if($respuesta['error']['code'] != 0){
            return \View::make('error.general')->with($respuesta);
        }
        $recibo = $respuesta['data'];
        $recibo['idcdmx'] = $this->obtieneFolioAperturaHist(base64_encode(serialize($recibo)));
     

    }
}
