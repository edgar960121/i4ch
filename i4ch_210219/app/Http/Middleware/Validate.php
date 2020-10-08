<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Mule;
use App\Http\Controllers\Version;

class Validate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Version::getCurrent();

        if($request->is('usuario/*')){
            
            if(env('DISABLED',false)){
                $message = [
                    'class'  => 'alert-danger',
                    'bold'   => 'El sistema se encuentra en mantenimiento, por favor intente más tarde.',
                    'normal' => ''
                ];
                \Session::flash('Message',$message);
                return \Redirect::to(url('/login'));
            }
            if($request->has('loginmail')){

                if(trim($request->loginmail) == '' || trim($request->password) == ''){
                    $message = [
                        'class'  => 'alert-danger',
                        'bold'   => 'Error:',
                        'normal' => 'Credenciales incorrectas.'
                    ];
                    \Session::flash('Message',$message);
                    return \Redirect::to(url('/login'));
                }

                $parametros = [
                    'security' => [
                        'token'     => env('TOKEN'),
                    ],
                    'data'     => [
                        'mail'     => $request->loginmail,
                        'password' => md5($request->password)
                        
                    ]
                ];
                
                $respuesta = Mule::callApi('POST','/i4ch/login','9000',$parametros);
                //dd($respuesta);
                if($respuesta['error']['code'] != 0){

                    $message = [
                        'class'  => 'alert-danger',
                        'bold'   => 'Error:',
                        'normal' => $respuesta['error']['msg']
                    ];
                    \Session::flash('Message',$message);
                    return \Redirect::to(url('/login'));

                }
                //dd($respuesta);
                $modulos = collect($respuesta['data']['modulos'])->flatMap(function($i){
                    return [
                        $i['group'] => [
                            'name'  => $i['title'],
                            'img'   => $i['img'],
                            'url'   => $i['url'],
                            'group' => strtolower($i['group']),
                            'roles' => collect($i['roles'])->flatMap(function($j){
                                return [
                                    $j['role'] => [
                                        'name' => $j['roleDescripcion'],
                                        'url'  => $j['url'],
                                        'menu' => $j['menu']
                                    ]
                                ];
                            })
                        ]
                    ];
                });
                //dd($respuesta);
                \Session::put('Session.id',$respuesta['data']['sessionId']);
                \Session::put('Session.rfc',$respuesta['data']['citizenData']['RFC']);
                \Session::put('Session.curp',$respuesta['data']['citizenData']['CURP']);
                \Session::put('Session.mail',$respuesta['data']['citizenData']['mail']);
                \Session::put('Session.ocr',$respuesta['data']['citizenData']['OCR']);
                \Session::put('Session.user',$respuesta['data']['citizenData']['nombreCompleto']);
                \Session::put('Session.paterno',$respuesta['data']['citizenData']['paterno']);
                \Session::put('Session.materno',$respuesta['data']['citizenData']['materno']);
                \Session::put('Session.nombres',$respuesta['data']['citizenData']['nombres']);
                \Session::put('Session.cdmxId',$respuesta['data']['citizenData']['cdmxId']);
                \Session::put('Session.modulos',$modulos);
                \Session::put('Session.enlaces',$respuesta['data']['enlacesRelacionados']);
                \Session::put('Session.rocketChatId',md5($request->password));
                //dd(\Session::all());
                return $next($request);
            }

            if(!\Session::has('Session')){
                return \Redirect::to(url('/login')); 
            }

        }

        return $next($request);      
    }
}
