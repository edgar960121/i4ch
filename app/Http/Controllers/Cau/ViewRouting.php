<?php

namespace App\Http\Controllers\Cau;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewRouting extends Controller
{
    

    public function busquedaEmpleados(){


    	return \View::make('cau.busqueda');
    }
}
