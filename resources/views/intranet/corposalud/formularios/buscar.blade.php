<div class="container">
	<input type="hidden" name="accion" id="accion" value="suprimir">
	<input type="hidden" name="factura_id" id="factura_id">
	<div class="row">
		<div class="col-sm-4">
			<h3 class="page-header">
					Búsqueda de Factura
			</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-7">
			<a class="btn btn-danger disabled" id="suprimir" onclick="suprimir(event)">Suprimir</a>
		</div>
	</div>
	<input type="hidden" name="id">
	<div class="row">
		
		<div class="col-sm-2">
			<label>Número de la factura</label>
			<input type="text" name="numero_factura" id="numero_factura" class="form-control" onkeypress="buscarFactura(event, this.value)">
		</div>

		<div class="col-sm-2">
			<label>Nombre y apellido</label>
			<input type="text" name="nombres" id="nombres" readonly="readonly" class="form-control">
		</div>
		<div class="col-sm-2">
			<label>Cedula del beneficiario</label>
			<input type="text" name="cedula" id="cedula" readonly="readonly" class="form-control">
		</div>

		<div class="col-sm-2">
			<label>Total</label>
			<input type="text" name="total" id="total" readonly="readonly" class="form-control">
		</div>
	</div>
	<br>

	<div class="row">
		<div class="col-sm-8">
			<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr>
						<th>Descripción</th>
						<th>Costo</th>
					</tr>
				</thead>
				<tbody id="detalles">
					
				</tbody>
			</table>
		</div>

	</div>

</div>