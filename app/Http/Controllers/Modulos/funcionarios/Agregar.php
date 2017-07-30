<?php

namespace App\Http\Controllers\Modulos\funcionarios;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use AUth;
use App\ModPerUser;
use App\Persona;
use DB;


use App\Http\Controllers\Modulos\corposalud\Models\Disponibilidad;
use App\Http\Controllers\Modulos\corposalud\Models\Nomina;
use App\Http\Controllers\Modulos\corposalud\Models\Beneficiario;
use App\Http\Controllers\Modulos\corposalud\Models\BeneficiarioNomina;

class Agregar extends Controller
{
    private $mods;
    private $modulo_id;

    public function __construct($id)
    {
    	$this->mods = ModPerUser::getModulos(Auth::user()->id);
    	$this->modulo_id = $id;
    }

    public function index(){
    	return view('intranet.funcionarios.agregar.index', [
    		'modulos' 	=> $this->mods,
    		'disponibilidades' => Disponibilidad::where('edo_reg',1)->get(),
    		'nominas' => Nomina::all()
    	]);
    }

    public function salvar(Request $req){
    	DB::beginTransaction();
    	try{
    		$persona = Persona::create($req->all());
    		if($persona){
    			$ben = array_merge($req->all(), [
    				'persona_id' => $persona->id
    			]);
    			$bene = Beneficiario::create( $ben);

    			if( $bene){
    				$nom = array_merge($req->all(), ['beneficiario_id'=> $bene->id]);
    				if($nom = BeneficiarioNomina::create($nom)){
    					DB::commit();
    					$resp = [
    						'error' => false,
    						'mensaje' => 'SE HA GUARDADO CORRECTAMENTE LOS DATOS'
    					];
    					return response($resp, 200)
    							->header('Content-Type', 'application/json');
    				}
    			}
    		}
    		throw new \Exception("Error al guardar los datos del beneficiario", 1);
    		

    	}catch(\Exception $e){
    		DB::rollback();
    		return response(['error'=> true, 'mensaje'=> $e->getMessage()],200)
    				->header('Content-Type', 'application/json');
    	}
    }
}
