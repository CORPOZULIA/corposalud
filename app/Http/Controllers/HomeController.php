<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $p_usr = $user->permisos;
            foreach ($p_usr as $permiso) {
                
                echo $permiso->permiso->nombre_permiso."<br>";
            }

            return dd($p_usr[0]->modulo->nombre_modulo);
        }
        return view('home');
    }
}
