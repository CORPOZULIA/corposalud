@extends('layouts.dashboard_layout')

@section('titulo', 'Modulo de corposalud')

@section('contenedor')

<div class="row">
	<h1 class="page-header">Gestión de facturas</h1>
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Listado de facturas pendientes por reembolsar
            </div>
                        <!-- /.panel-heading -->
            <div class="panel-body">
            	<div class="container">
            		<div class="row">
            			<div class="col-sm-12">
            				<button class="btn btn-primary btn-forms" formulario="cargar" data-toggle="modal" data-target="#modal_forms"">
            					 <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Cargar factura
            				</button>
                            <button class="btn btn-success btn-forms" formulario="buscar" data-toggle="modal" data-target="#modal_forms"">
                                 <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 
                                 Buscar Factura
                            </button>
                            <button class="btn btn-warning btn-forms" formulario="cerrar_facturas" data-toggle="modal" data-target="#modal_forms">
                                 <span class="glyphicon glyphicon-lock" aria-hidden="true"></span> 
                                 Cerrar Facturas
                            </button>
                           <!-- <button class="btn btn-warning btn-consulta disabled" formulario="buscar_familiares" data-toggle="modal" data-target="#modal_forms"" url="dashboard/corposalud/Familia/formulario">
                                 <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 
                                 Consultar familiares
                            </button> -->
            			</div>
            		</div>
            	</div>
            	<br>
				
				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Cedula</th>
                            <th>Monto asignado</th>
                            <th>Monto de las facturas</th>
                            <th>Monto disponible</th>
                            <th>Monto a cancelar</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    	
                    	@foreach($facturas as $factura)
                    		<tr class="odd gradeX user_field">

                    			<td> {{ $factura->nombres }} </td>
                    			<td> {{ $factura->apellidos }} </td>
                    			<td> {{ $factura->cedula }} </td>
                    			<td> {{ number_format($factura->monto_otorgado, 2) }} Bs </td>
                    			<td> {{ number_format($factura->a_pagar, 2) }} Bs </td>
                    			<td> {{ number_format($factura->monto_disponible, 2) }} Bs </td>
                    			<td>
                    				@if( ( $factura->monto_disponible - $factura->a_pagar ) < 0 )
                    					{{ number_format($factura->monto_disponible, 2) }} Bs

                                    @elseif( $factura->monto_disponible == $factura->a_pagar )
                                        {{ number_format($factura->a_pagar, 2 ) }}

                    				@elseif(( $factura->monto_disponible - $factura->a_pagar ) > 0)
                    					{{ number_format($factura->a_pagar, 2) }} Bs
                    				@endif

                    			</td>
                    		</tr>
                    	@endforeach

                    </tbody>
				</table>

        	</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal_forms" tabindex="-1" role="dialog" aria-labelledby="modal_formsLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Gestión y registro de facturas &nbsp;&nbsp;&nbsp;&nbsp; <span id="verificando"></span> </h4>
        <strong id="nombre_persona"></strong>
      </div>
      <div class="modal-body">

        <div class="container">
            <div class="row">
                <form action="" method="post" class=""  id="cargar_info">
                    <div class="row" id="row-form">
                  		{{ csrf_field() }}

                  		<div id="form-load"></div>      
                    </div>
                </form>
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onClick="limpiarTotal()">Cerrar ventana</button>
        <button type="button" class="btn btn-primary" id="modal-click">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('jquery')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src=" {{ asset('js/dataTables.bootstrap.min.js') }} "></script>
<script src="{{ asset('js/dataTables.responsive.js')  }}"></script>
<script type="text/javascript" src=" {{ asset('js/corposalud/corposalud.js') }} "></script>
@endsection