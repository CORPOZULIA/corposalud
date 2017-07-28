<?php

namespace App\Http\Controllers\Modulos\credito;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\ModPerUser;

class Credito extends Controller
{
	private $mods;

	public function __construct()
	{
		$this->mods = ModPerUser::getModulos(Auth::user()->id);
	}

    public function index(){
    	
    	return  view('intranet.credito.consulta_credito', ['modulos' => $this->mods]);

    }
}
