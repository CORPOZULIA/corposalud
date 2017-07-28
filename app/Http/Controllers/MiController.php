<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MiController extends Controller
{
    public function mi_metodo($id_producto){

    	return view('miVista',array('id'=>$id_producto));
    }

    public function recogeDatos(Request $request){
    	//return (string) $request->isMethod('GET');
    	return dd($request);
    }



}
