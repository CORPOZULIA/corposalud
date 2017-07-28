<div class="container">

	<input type="hidden" name="tipo_factura_id" id="tipo_factura_id">
	<input type="hidden" name="accion" id="accion" value="guardar">

	<div class="row">
		<div class="col-sm-3">
			<h3 class="page-header">
					Datos de la factura
			</h3>
		</div>
		<div class="col-sm-2">
			<label>Cedula del empleado</label>
			<input type="text" name="cedula" id="cedula" onBlur="consultarPersona(event, this.value)" class="form-control" onChange="limpiarPersona(event, this.value)"> 
			
		</div>
		<div class="col-sm-3">
			<label>Disponibilidad actual: <span id="disponibilidad_actual"></span></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-1">
			<label>Tipo</label>
			<input type="text" name="codigo_factura" id="codigo_factura" class="form-control" onBlur="buscarTipoFactura(event, this.value)">
		</div>

		<div class="col-sm-7">
			<label>Tipo de la factura</label>
			<input type="text" name="descripcion_factura" id="descripcion_factura" readonly="readonly" class="form-control">
		</div>

	</div>
	<div class="row">
		
		<div class="col-sm-3">
			<label>Número de la factura</label>
			<input type="text" name="numero_factura" id="numero_factura" class="form-control" disabled onBlur="activarFormulario(event, this.value)" onChange="limpiarPersona(event, this.value)">
		</div>

		<div class="col-sm-4">
			<label>Total Sin IVA</label>
			<input type="number" name="total" id="total" class="form-control" disabled>
		</div>
	</div>

	<div class="row hidden" id="detalles">
		<div class="container">
			<div class="row">
				<div class="col-sm-7">
					<h3 class="page-header">Detalles del gasto</h3>
				</div>
			</div>
		</div>
		<div class="col-sm-7">
			<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr>
						<th>Descripción</th>
						<th>Valor</th>
						<th>iva</th>
					</tr>
					
				</thead>
				<tbody id="tbody">
					<tr>
						<td>
							<input type="text" name="descripcion_gasto[]" id="descripcion_gasto" onkeypress="verificarDescripcion(event,this.value)" class="form-control">
						</td>
						<td>
							<input type="number" name="costo[]"  disabled onkeypress="calcularTotal(event,this.value)" class="form-control costo">

						</td>
						<td>
							<input type="number" name="iva[]" class="form-control" value="0" onkeypress="appendField(event)">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<input name="beneficiario_id" value="" id="bid" type="hidden">
	</div>


</div>