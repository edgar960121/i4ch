<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Externo extends Controller
{

    public function registro(){
    	return \View::make('registro');
    }

    public function reenvio(){
		return \View::make('reenvio');
	}

	public function hacerReenvio(Request $request){
        
        if(!$request->has('g-recaptcha-response') || $request->input('g-recaptcha-response') == '' || is_null($request->input('g-recaptcha-response'))){
            \Session::flash('Current.message',['normal'=>'Debes confirmar el recaptcha','class'=>'alert-danger']);
            return \View::make('reenvio');
        }

    	$parametros = [
            'security' => [
                'token' => env('TOKEN')
            ],
            'data'     => [
                "mail"  => $request->mail 
            ]
        ];
        //dd(json_encode($parametros));
        $respuesta = Mule::callApi('POST','/i4ch/registro/reenviarMailConfirmacion','9000',$parametros);

        if($respuesta['error']['code'] != 0){
        	\Session::flash('Current.message',['normal'=>$respuesta['error']['msg'],'class'=>'alert-danger']);
        	return \View::make('reenvio');
        }

        \Session::flash('Current.message',['normal'=>'El correo fué enviado correctamente','class'=>'alert-success']);
        return \View::make('procesoFinalizado');
    }	

    public function recuperacion(Request $request){
    	return \View::make('recuperacion')->with(['request' => $request->all()]);
    }

    public function recuperar(Request $request){

    	if(trim($request->password) != trim($request->retype)){
    		\Session::flash('Current.message',['normal'=>'Las contraseñas no coinciden','class'=>'alert-danger']);
    		return \View::make('recuperacion')->with(['request' => $request->all()]);;
    	}
    	$parametros = [
            'security' => [
                'token'           => env('TOKEN'),
                'sessionRecovery' => $request->recuperacionCode
            ],
            'data'     => [
                "password" => md5($request->password) 
            ]
        ];
        //dd(json_encode($parametros));
        $respuesta = Mule::callApi('PUT','/i4ch/registro/actualizaPassword','9000',$parametros);

        if($respuesta['error']['code'] != 0){
        	\Session::flash('Current.message',['normal'=>'Hubo un error al reestablecer la contraseña','class'=>'alert-danger']);
        	return \View::make('recuperacion')->with(['request' => $request->all()]);
        }

        \Session::flash('Current.message',['normal'=>'La contraseña fué reestablecida correctamente','class'=>'alert-success']);
        return \View::make('procesoFinalizado');
    }

	public function olvido(){
		return \View::make('olvido');
	}

	public function hacerOlvido(Request $request){
        if(!$request->has('g-recaptcha-response') || $request->input('g-recaptcha-response') == '' || is_null($request->input('g-recaptcha-response'))){
            \Session::flash('Current.message',['normal'=>'Debes confirmar el recaptcha','class'=>'alert-danger']);
            return \View::make('olvido');
        }

    	$parametros = [
            'security' => [
                'token' => env('TOKEN')
            ],
            'data'     => [
                "mail"  => $request->mail 
            ]
        ];
        //dd(json_encode($parametros));
        $respuesta = Mule::callApi('POST','/i4ch/registro/enviarMailResetPassword','9000',$parametros);

        if($respuesta['error']['code'] != 0){
        	\Session::flash('Current.message',['normal'=>$respuesta['error']['msg'],'class'=>'alert-danger']);
        	return \View::make('olvido');
        }

        \Session::flash('Current.message',['bold'=>'El correo fué enviado correctamente.', 'normal'=>'Verifica en la bandeja de correos no deseados ó spam en caso de que no te llegue el correo.','class'=>'alert-success']);
        return \View::make('procesoFinalizado');
    }

    public function activacion(Request $request){
    	return \View::make('activacion')->with(['request' => $request->all() ]);
    }

    public function activar(Request $request){
    	$parametros = [
            'security' => [
                'token'     => env('TOKEN')
            ],
            'data'     => [
                "sessionId" => $request->activationCode 
            ]
        ];
        //dd(json_encode($parametros));
        $respuesta = Mule::callApi('POST','/i4ch/registro/confirmarRegistro','9000',$parametros);

        if($respuesta['error']['code'] != 0){
        	\Session::flash('Current.message',['normal'=>'Cuenta previamente activada','class'=>'alert-danger']);
        	return \View::make('activacion')->with(['request' => $request->all()]);
        }

        \Session::flash('Current.message',['normal'=>'Cuenta fué activada correctamente','class'=>'alert-success']);
        return \View::make('procesoFinalizado');
    }

    public function cancelacion(Request $request){
    	return \View::make('cancelacion')->with(['request' => $request->all() ]);
    }

    public function cancelar(Request $request){
    	$parametros = [
            'security' => [
                'token'     => env('TOKEN')
            ],
            'data'     => [
                "sessionId" => $request->activationCode 
            ]
        ];
        //dd(json_encode($parametros));
        $respuesta = Mule::callApi('DELETE','/i4ch/registro/confirmarRegistro','9000',$parametros);

        if($respuesta['error']['code'] != 0){
        	\Session::flash('Current.message',['normal'=>'Cuenta previamente cancelada','class'=>'alert-danger']);
        	return \View::make('activacion')->with(['request' => $request->all()]);
        }

        \Session::flash('Current.message',['normal'=>'Cuenta fué cancelada correctamente','class'=>'alert-success']);
        return \View::make('procesoFinalizado');
    }

    public function altaRegistro(Request $request){

        /*if(!$request->has('g-recaptcha-response') || $request->input('g-recaptcha-response') == '' || is_null($request->input('g-recaptcha-response'))){
            \Session::flash('Current.message',['normal'=>'Debes confirmar el recaptcha','class'=>'alert-danger']);
            return \View::make('registro')->with(['request' => $request->all()]);
        }

    	$validacion = collect($request->all())->filter(function($i,$k){
    		return $k != '_token' && trim($i) == '';
    	})->count();

    	if($validacion > 0){
    		\Session::flash('Current.message',['normal'=>'Todos los campos son obligatorios','class'=>'alert-danger']);
    		return \View::make('registro')->with(['request' => $request->all()]);
    	}*/

    	if($request->password != $request->retype){
    		\Session::flash('Current.message',['normal'=>'Las contraseñas no coinciden','class'=>'alert-danger']);
    		return \View::make('registro')->with(['request' => $request->all()]);
    	}

    	if(strlen($request->rfc) < 12 && strlen($request->rfc) > 13 ){
    		\Session::flash('Current.message',['normal'=>'El RFC no es válido','class'=>'alert-danger']);
    		return \View::make('registro')->with(['request' => $request->all()]);
    	}

    	if(strlen($request->curp) != 18){
    		\Session::flash('Current.message',['normal'=>'El CURP no es válido','class'=>'alert-danger']);
    		return \View::make('registro')->with(['request' => $request->all()]);
    	}

    	$parametros = [
            'security' => [
                'token'     => env('TOKEN')
            ],
            'data'     => [
                'RFC'      => $request->rfc,
                'CURP'     => $request->curp,
                'mail'     => $request->mail,
                'materno'  => $this->_fixString($request->materno),
                'nombres'  => $this->_fixString($request->nombres),
                'password' => md5($request->password),
                'paterno'  => $this->_fixString($request->paterno),
                'OCR'      => $request->ocr
                
            ]
        ];
        //dd(json_encode($parametros));
        $respuesta = Mule::callApi('POST','/i4ch/registro','9000',$parametros);

        if($respuesta['error']['code'] != 0){
        	\Session::flash('Current.message',['normal'=>$respuesta['error']['msg'],'class'=>'alert-danger']);
    		return \View::make('registro')->with(['request' => $request->all()]);
        }

        \Session::flash('Current.message',[
            'bold'   => 'Registro finalizado',
            'normal' => 'Se enviará un mensaje al correo electrónico proporcionado para confirmar la cuenta y poder accesar al sitio',
            'class'  => 'alert-success'
        ]);
        return \View::make('procesoFinalizado');
    }

    private function _fixString($string){
 
	    $string = trim($string);
	 
	    $string = str_replace(
	        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
	        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
	        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
	        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
	        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
	        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	        $string
	    );
	 
	 	/*
	    $string = str_replace(
	        array('ñ', 'Ñ', 'ç', 'Ç'),
	        array('n', 'N', 'c', 'C',),
	        $string
	    );
	 	*/
	    //Esta parte se encarga de eliminar cualquier caracter extraño
	    $string = str_replace(
	        array("\\", "¨", "º", "-", "~",
	             "#", "@", "|", "!", "\"",
	             "·", "$", "%", "&", "/",
	             "(", ")", "?", "'", "¡",
	             "¿", "[", "^", "<code>", "]",
	             "+", "}", "{", "¨", "´",
	             ">", "< ", ";", ",", ":",
	             "."),
	        '',
	        $string
	    );
	 
	 
	    return $string;
	}
}
