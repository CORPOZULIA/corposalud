@extends('layouts.dashboard_layout')

@section('titulo', 'Hola')

@section('css')
<!-- DataTables CSS -->
<link href="{{ asset('css/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
<link href="{{ asset('css/dataTables.responsive.css')}}" rel="stylesheet">
@endsection

@section('contenedor')

<div class="row">
	<h1 class="page-header">Usuarios del sistema</h1>
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Lista de usuarios registrados en el sistema
            </div>
                        <!-- /.panel-heading -->
            <div class="panel-body">
            	<div class="container">
            		<div class="row">
            			<div class="col-sm-12">
            				<button class="btn btn-primary btn-forms" formulario="crear_usuario" data-toggle="modal" data-target="#modal_forms">
            					 <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Crear
            				</button>
            			</div>
            		</div>
            	</div>
            	<br>
				
				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Cedula</th>
                            <th>Usuario</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach($personas as $persona)
                            @if($persona->empleado != null && $persona->empleado->user != null && $persona->empleado->user->edo_reg == 1)
                                <tr class="odd gradeX user_field">
                                    <td>{{ $persona->nombres }}</td>
                                    <td>{{ $persona->apellidos }}</td>
                                    <td>{{ $persona->cedula }}</td>
                                    <td>{{ $persona->empleado->user->usuario }}</td>
                                    <td>
                                        <button class="btn btn-danger usuario-option" token="{{ csrf_token() }}" role="DELETE" data-user="{{ $persona->empleado->user->id }}">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                        <button class="btn btn-success usuario-option" token="{{ csrf_token() }}" role="UPDATE" data-user="{{ $persona->empleado->user->id }}">
                                            <span class="glyphicon glyphicon-pencil "></span>
                                        </button>
                                        <button class="btn btn-warning usuario-option" token="{{ csrf_token() }}" id="permisos" role="PERMISOS" data-user="{{ $persona->empleado->user->id }}">
                                            <span class="glyphicon glyphicon-wrench"></span>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
				</table>

        	</div>
		</div>
	</div>
</div>

<!-- INICIO DE LA VENTANA MODAL DE LOS FORMULARIOS -->
<div class="modal fade" id="modal_forms" tabindex="-1" role="dialog" aria-labelledby="modal_formsLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Gestion de usuarios &nbsp;&nbsp;&nbsp;&nbsp; <span id="verificando"></span> </h4>
      </div>
      <div class="modal-body">

        <div class="container">
            <div class="row">
                <form action="" method="post" class=""  id="cargar_info">
                    <div class="row" id="row-form">
                        <input type="hidden" id="user_id" name="user_id" value="">
                        <div class="col-sm-3">
                            <center>
                                <label for="cedula" id="labele">Cedula de la persona<span id="verificando" class=""></span></label>

                                <input class="form-control" type="text" id="cedula" name="cedula" required placeholder="Ej. 11111111"> 
                                
                            </center>
                        </div>
                        <div class="col-sm-4">
                            <label for="email">Correo electronico</label>
                            <input type="text"  id="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div id="form-inputs">
                        
                    </div>
                </form>
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar ventana</button>
        <button type="button" class="btn btn-primary" id="modal-click">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- FIN DE LA VENTANA MODAL -->

</div>

@endsection

@section('jquery')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src=" {{ asset('js/dataTables.bootstrap.min.js') }} "></script>
<script src="{{ asset('js/dataTables.responsive.js')  }}"></script>

<script src="{{ asset('js/modulo_usuarios.js') }}"></script>
@endsection