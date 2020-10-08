<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Mule;
use Carbon\Carbon;


class FormularioU extends Controller
{
    /*public function prueba(){
        return view('usuarios');
    }*/

    public function busquedaUsuarios(){
        return \View::make('buscar_rfc');
    }

    public function validacion(){
        request()->validate([
            'RFC' => 'required|min:13'
        ]);

        $rfc = $_POST["RFC"]; 
        // dd($rfc);
         $curl = curl_init();
         curl_setopt_array($curl, array(
             CURLOPT_URL => "10.1.181.9:9003/usuarios/ConsultaRFCuser",
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_ENCODING => "",
             CURLOPT_MAXREDIRS => 10,
             CURLOPT_TIMEOUT => 0,
             CURLOPT_FOLLOWLOCATION => true,
             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
             CURLOPT_CUSTOMREQUEST => "POST",
             CURLOPT_POSTFIELDS =>"{\n\t \"data\":\n  {\n \n    \"RFC\":\"$rfc\"\n  }\n}",
             CURLOPT_HTTPHEADER => array(
               "Content-Type: application/json"
             ),
           ));           
           $response = curl_exec($curl);
           $datos = json_decode($response, true);
          // dd($datos);
           if($datos['error']['code'] == 0){
            // dd('datos correctos');
             curl_close($curl);
             return view('usuarios')->with('informacion', $response);
           
           }else {
             //dd('no correctos');
             echo $datos['error']['msg'];
             return view('buscar_rfc');
          
           }
           
           
    }
   
    
    public function bajausuario(){
      return \View::make('bajas_usuario');

    }         
    
    public function prueba(){
      request()->validate([
        'email' => 'required|min:13'
    ]);
      echo 'No has eliminado';
    }

    //Estadisticas de la credencial
    public function estadistica(){
      return \View::make('credencial\estadisticas');
    }
   
}
