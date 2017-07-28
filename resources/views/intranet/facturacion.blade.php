@extends('layouts.dashboard_layout')

@section('titulo', 'Gestion de facturación')

@section('css')

<link rel="stylesheet" href="{{ asset('css/facturacion.css') }}">

@endsection

@section('contenedor')

<div class="container">
	<div class="row">
		<div class="col-sm-8 col-md-8">	
			<h1 class="page-header">Facturación</h1>

			<form action="{{ url('dashboard/facturacion/factura') }}" method="post" id="facturacion">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-sm-5 pull-right">
						<label for="cedula">Cedula</label>
						<input type="text" name="cedula" id="cedula" class="form-control col-sm-3 ced-factura">
					</div>
				</div>
				
				<br><br>
				<div class="row">
					<h4 class="page-header">Datos del cliente</h4>
					<div class="col-sm-5">
						<label for="nombres">Nombre(s) del cliente</label>
						<input type="text" id="nombre" name="nombres" class="form-control">
					</div>
					<div class="col-sm-5">
						<label for="apellidos">Apellido(s) del cliente</label>
						<input type="text" id="apellido" name="apellidos" class="form-control">
					</div>

					<div class="col-sm-10">
						<label for="email">Correo electronico</label>
						<input type="email" name="email" id="email" class="form-control">
					</div>

					<div class="col-sm-10">
						<label for="direccion">Dirección</label>
						<textarea name="direccion" id="direccion" class="form-control" cols="30" rows="10"></textarea>
					</div>
				</div>
				<!--./ DATOS DELCLIENTE -->

				<div class="row">
					<h4 class="page-header">Datos de la factura</h4>
					<button type="submit" class="btn btn-primary">Factura</button>
					<div class="col-sm-5">
						<label for="codigo">Codigo del producto o servicio</label>
						<input type="text" id="codigo_hardware" onBlur="codigo(this.value)" name="codigo_hardware" class="form-control">
					</div>
					<div class="col-sm-5">
						<label for="codigo">Total</label>
						<input type="text" id="codigo_hardware" name="total" class="form-control">
					</div>
					<br>
					<h4 class="page-header">Productos</h4>
					<div class="col-sm-10">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>Cantidad</th>
									<th>Producto</th>
									<th>Precio unitario</th>
								</tr>
							</thead>

							<tbody id="productos_lista">
								<tr>
									<td>
										<input type="text" class="form-control" name="cantidad[]" value="3">
									</td>
									<td>
										<input type="text" class="form-control disabled" name="producto[]" value="Monitor led">
									</td>
									<td>
										<input type="text" class="form-control disabled" name="precio[]" value="3500">
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" class="form-control disabled" name="cantidad[]" value="1">
									</td>
									<td>
										<input type="text" class="form-control disabled" name="producto[]" value="Teclado USB">
									</td>
									<td>
										<input type="text" class="form-control disabled" name="precio[]" value="1500">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

			</form>
		</div>
		<!-- ./Fin del div col-sm del formulario -->
	</div>

@section('jquery')
<script src="{{ asset('js/modulo_factura.js') }}"></script>
@endsection
</div>

@endsection