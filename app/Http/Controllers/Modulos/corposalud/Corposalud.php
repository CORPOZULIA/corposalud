<?php
/**********************************************************************************
*			MODULO: CORPOSALUD
*			PROGRAMA: CORPOSALUD
*			ESCRITO POR: Giovanny Avila [<gjavila1995@gmail.com> | <gavila@corposulia.gob.ve>]
*							Julio Chirinos
*			FECHA: 09-01-2017
*	--------------------------------------------------------------------------------
*			MODULO QUE TIENE COMO TAREA EL DESPLIEGUE DE LA INFORMACIÓN DE
*			LAS FACTURAS INGRESADAS POR CORPOSALUD
*/
namespace App\Http\Controllers\Modulos\corposalud;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use Storage;

/**
*	INVOCACION DE MODELOS
*/

use App\ModPerUser;
use App\Persona;
use DB;

use App\Http\Controllers\Modulos\corposalud\Models\TipoFactura as tipos;
use App\Http\Controllers\Modulos\corposalud\Models\Beneficiario;
use App\Http\Controllers\Modulos\corposalud\Models\Factura;
use App\Http\Controllers\Modulos\corposalud\Models\DetalleFactura as detalles;

#DisponibilidadView hace referencia a una vista dentro del gestor
#de bases de datos
use App\Http\Controllers\Modulos\corposalud\Models\DisponibilidadView;
use App\Http\Controllers\Modulos\corposalud\Models\TipoFactura;

use App\Http\Controllers\Modulos\corposalud\Models\Nomina;

use PDF;
use Carbon\Carbon;
use Response;

class Corposalud extends Controller
{
    private $mods;
    private $modulo_id;

    public function __construct($id)
    {
    	$this->mods = ModPerUser::getModulos(Auth::user()->id);
    	$this->modulo_id = $id;
    }


    public function index()
    {
    	$datos = DisponibilidadView::where('a_pagar', '>', 0)
    								->where('monto_disponible', '>', 0)->get();
    	
    	$datos_vista = [
    		'modulos' 	=> $this->mods,
    		'facturas' 	=> $datos
    	];
    	return view('intranet.corposalud.corposalud', $datos_vista);
    }


    /**
    * @function FORMULARIO
    * @var OBJETO / REQUEST $request DATOS DE LA SOLICITUD ENTRANTE
    * @var STRING $formulario FORMULARIO REQUERIDO EN LA SOLICITUD
    * @return JSON retorna el JSON con el formulario ya construido
    */
    public function formulario(Request $request, $formularios)
    {
		
    	//$formulario = Storage::disk('local')->get('formularios/corposalud/'.$formularios.'.html');
    	
    	if($formularios == 'cerrar_facturas')
    	{
            $nominas = Nomina::where('edo_reg', 1)->get();
			$formulario = view()
						->make('intranet.corposalud.formularios.'.$formularios, [
								'nominas' => $nominas
						])->render();
		}
		else
		{
			$formulario = view()
					->make('intranet.corposalud.formularios.'.$formularios)->render();
		}
			
    	$retorno = [
    		'fail' => false,
    		'mensaje' => $formulario
    	];

    	return $retorno;
    }

    /**
    *	ESTA FUNCION CONSULTA DENTRO DEL MODELO TipoFactura UN TIPO DE FACTURA
    * 	CUYO TIPO LLEGA POR LA URL 
    */
    public function tipoDeFactura(Request $request, $tipo)
    {
    	$tipo = TipoFactura::where('codigo_factura', $tipo)->get();

    	$respuesta = [];
    	if(! empty($tipo[0])){
    		$respuesta = [
    			'fail' => false,
    			'tipos' => $tipo[0]
    		];

    		return $respuesta;
    	} #FIN DE LA ESTRUCTURA IF 
    }

    /**
    *	FUNCION PARA CONSULTAR PERSONA DENTRO DE LA BASE DE DATOS
    * 	DEL SISTEMA
    */

    function consultarPersona(Request $request, $cedula){
    	#CON EL MODELO Persona SE HACCE UNA CONSULTA CON WHERE
    	#DONDE LA CEDULA SEA IDENTICA A LA QUE LLLEGA POR PARAMETRO Y EL ESTADO DEL REGISTRO SEA 1
    	$persona = Persona::where('cedula', $cedula)->where('edo_reg', 1)->get();

       $disp = DB::table('corposalud.tiene_disp')->where('corposalud.tiene_disp.cedula', $cedula)->first();

        $puede_cargarse = (empty($disp))? true : ( ( $disp_funcionario = ($disp->monto_otorgado - $disp->a_pagar ) > $disp->monto_otorgado ) );

    	$respuesta = [];
    	if(! empty($persona[0]) )
    	{
    		$respuesta = [
    			'fail' => false,
    			'persona' => $persona[0],
                'beneficiario' => $persona[0]->beneficiario->id,
                'disponibles' => ( empty($disp) ? DB::table('corposalud.disponibilidades')->where('edo_reg',1)->first()->monto_disponible : $disp->monto_otorgado - $disp->a_pagar ) ,
                'puede_cargar' =>  $puede_cargarse,/* HACE REFERENCIA A QUE EL FUNCIONARIO PUEDE CARGARSE MAS FACTURAS */ 
    		];

    	}
    	else
        { 
            $respuesta = [
        		'fail' => true, 
        		'mensaje' => 'Esta cedula de identidad no se encuentra en la Base de datos o esta desabilitada. En caso de sospecha de desactivación, llamar a sistemas',
        	];
        }

    	return $respuesta; 
    }

    /**
    *   FUNCION ENCARGADA DE GUARDAR LOS DATOS QUE LLEGAN DEL
    *   FORMULARIO DE REGISTRO DE FACTURAS
    */
    public function guardar(Request $request, $id)
    {
        if($this->_auth('CREATE'))
        {
            //SE CREA LA NUEVA FACTURA
            $factura = Factura::create($request->only(['tipo_factura_id', 'total', 'beneficiario_id', 'numero_factura', ]));

            
            $items = $request->input('costo');
            $descripcion = $request->input('descripcion_gasto');
            $iva = $request->input('iva');

            $detallesFactura = [];
            $total = 0.00;
            for($i = 0; $i < count($items) ; $i++){

                /**
                *   SI TIENE IVA SE LE AGREGA
                */
                $total += ( $items[$i] + ( ($items[$i] * $iva[$i])/100 ) );

                $detallesFactura[$i] = new detalles([ 
                    'descripcion_gasto' => $descripcion[$i],
                    'costo' => $items[$i],
                    'iva'   => $iva[$i],
                ]);
            }

            $factura->total = $total;
            $factura->save();
            $factura->detalles()->saveMany( $detallesFactura );
            return ['fail' => false, 'mensaje' => 'Se ha guardado la factura exitosamente :D'];
        }
        return ['fail' => true, 'mensaje' => 'Usted no posee permisos para realizar esta acción'];
    }


    private function _auth($accion)
    {
        if(verificar_permisos($accion, $this->modulo_id))
        {
            push_auditoria('EL USUARIO '.Auth::user()->empleado->persona->nombres.' HA EJERCIDO UNA ACCION DE '.$accion, 'CORPOSALUD', 'FACTURAS');

            return true;
        }

        return false;
    }

    /**
    *   FUNCIÓN ENCARGADA DE CERRAR LAS FACTURAS COMPRENDIDAS ENTRE 2 FECHAS
    *   INDICADAS POR EL USUARIO
    *   @var OBJETO / Request $request  - DATOS DE LA PETICIÓN HTTP
    *   @return ARRAY / JSON    retona un arreglo que se transformara en JSON
    */
    public function cerrar_facturas(Request $request)
    {
        /**
        *   SE VERIFICA SI EL USUARIO CONECTADO POSEE PERMISOS PARA REALIZAR
        *   LA ACCIÓN, EN ESTE CASO ES UNA ACCIÓN DE ACTUALIZAR, YA QUE
        *   SE ACTUALIZARA LA COLUMNA edo_factura A 1 (QUE SIGNIFICA CERRADO)
        *   RETORNA TRUE DE TENER PERMSOS
        */
        if(verificar_permisos('UPDATE', $this->modulo_id))
        {
            $desde  = '';
            $hasta = '';
            foreach (['ano', 'mes', 'dia'] as $clave => $fecha) {
                $desde.= ($fecha != 'dia') ? $request->input($fecha.'_desde').'-': $request->input($fecha.'_desde');
            }


            foreach (['ano', 'mes', 'dia'] as $clave => $fecha) {
                $hasta.= ($fecha != 'dia') ? $request->input($fecha.'_hasta').'-': $request->input($fecha.'_hasta');
            }


            $datos = DisponibilidadView::where('a_pagar', '>', 0)
                                    ->where('monto_disponible', '>', 0);

            /**
            *   SI LA NOMINA ES DIFERENTE A 0 (LA PRIMERA OPCION) ENTONCES
            *   SE FILTRA POR LA DESCRIPCION DE LA NOMINA
            */
            if($request->nomina != '0') $datos->where('descripcion_nomina', $request->nomina);
            

            $datos = $datos->get();

            foreach($datos as $dato )
            {
                $facturas = Factura::where([
                    ['created_at', '>=', $desde],
                    ['created_at', '<=', $hasta],
                    ['beneficiario_id', $dato->beneficiario_id],
                ])->get();

                 $facturas = Factura::where([
                    ['created_at', '>=', $desde.' 00:00:00'],
                    ['created_at', '<=', $hasta.' 00:00:00'],
                    ['beneficiario_id', $dato->beneficiario_id],
                ])->update(['edo_factura'=>1]);
            }

            push_auditoria('EL USUARIO '.Auth::user()->empleado->persona->nombres.' HA REALIZADO UN CIERRE DE LAS FACTURAS EN LAS FECHAS COMPRENDIDAS ENTRE: '.$desde.' Y '.$hasta, 'CORPOSALUD', 'GESTION DE FACTURAS');

            $pdf = PDF::loadView('intranet.corposalud.pdf.reporte_facturas',[
                'facturas'=>$datos, 
                'desde'=> $request->dia_desde.'/'.$request->mes_desde.'/'.$request->ano_desde, 
                'hasta' => $request->dia_hasta.'/'.$request->mes_hasta.'/'.$request->ano_hasta,
                'nomina' => $request->nomina,
            ]);

            $archivo = md5( Carbon::now().'_interno' ).'.pdf';
            $pdf->save(storage_path('app/formularios/corposalud/pdf/').$archivo);

            return ['fail' => false, 'mensaje' => 'Se han cerrado las facturas exitosamente.','pdf'=>$archivo];
        }

        else return ['fail' => true, 'mensaje' => 'Usted no posee permisos para realizar esta acción, llamar a sistemas'];
    }

    public function reporte(Request $request)
    {  
        $pdf = PDF::loadView('intranet.corposalud.pdf.reporte_facturas');
        $archivo = bcrypt( Carbon::now() ).'.pdf';
        return $pdf->save(storage_path('app/formularios/corposalud/pdf/').$archivo);
    }

    public function ver_reporte(Request $request,$archivo){
        return Response::download(storage_path('app/formularios/corposalud/pdf/').$archivo );
    }


    public function buscarFactura(Request $request, $numero_factura){
        $factura = Factura::where('numero_factura',$numero_factura) -> get();
        return [
            'factura' =>$factura[0]->toArray(),
            'detalles' =>$factura[0]->detalles->toArray(),
            'beneficiario'=>$factura[0] ->beneficiario->persona->toArray(), 
            'reload' => false,
            'suprimir' => true
        ];
    }


    public function suprimir(Request $request)
    {
        if(verificar_permisos('DELETE', $this->modulo_id))
        {
            $factura = Factura::where('id', $request->factura_id)
                            ->update(['edo_reg' => 0]);


            if( $factura)
            {
                push_auditoria('EL USUARIO HA ELIMINADO LA FACUTRA CON EL ID '.$request->factura_id,
                                'CORPOSALUD', 'GESTION DE FACTURAS');

                return ['fail' => false, 'mensaje' => 'La factura se ha suprimido satisfactoriamente', 'factura' => $request->id];
            }
            else 
                return[
                        'fail' => true, 
                        'mensaje' => 'No se ha podido suprimir la factura, contactar a sistemas'
                ];
        }

        return ['fail' => true, 'mensaje' => 'Usted no posee permisos para realizar esta acción'];
    }
}
