<?php

namespace App\Http\Controllers\Modulos\constancias;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\ModPerUser;
use App\User;
use App\Persona;
use App\Empleado;
use App\Modulo;
use Storage;

class Trabajo extends Controller
{
	private $mods;

	public function __construct()
	{
		$this->mods = ModPerUser::getModulos(Auth::user()->id);
	}

   	public function index()
   	{
   		return view('intranet.dashboard', ['modulos' => $this->mods]);
   	}
}
