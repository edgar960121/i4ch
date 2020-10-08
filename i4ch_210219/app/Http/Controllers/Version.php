<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Version extends Controller
{
    const VERSION = 'v1.4.6';
    
    public static function getCurrent(){
    	\Session::put('Current.version', SELF::VERSION);
    }
}
