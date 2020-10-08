<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Informacion extends Controller
{ 
    public function usoSistema(){
    	return view('sections.uso');
    }

    public function quejasSugerencias(){
    	return view('sections.quejas');
    }

    public function preguntasFrecuentes(){
    	return view('sections.faqs');
    }

    public function privacidad(){
    	return view('sections.privacidad');
    }

    public function veracidad(){
    	return view('sections.veracidad');
    }
}
