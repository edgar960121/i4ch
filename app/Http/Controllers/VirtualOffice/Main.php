<?php

namespace App\Http\Controllers\VirtualOffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Main extends Controller
{
    
    public function generateToken(){

    }

    public function getToken(){
    	header('Content-type: application/json');
    	return [
    		'loginToken' => \Session::get('RocketChat.authToken')
    	];
    }
}
