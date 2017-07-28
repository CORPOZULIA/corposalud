<div class="container">
	
	<div class="row">
		<div class="col-sm-4">
			<h3 class="page-header">
					Cierre de Facturas 
					<span> 
						<small>Desde - Hasta</small>
						<select name="nomina" class="form-control">
							<option value = "0">TODAS</option>
							@foreach($nominas as $nomina)

								<option value = "{{ $nomina->descripcion_nomina }}"> {{ $nomina->descripcion_nomina }} </option>

							@endforeach
						</select>
					</span>
			</h3>

		</div>
		
	</div>
	<div class="row">
		<input type="hidden" name="accion" id="accion" value="cerrar_facturas">
		<div class="col-sm-1">
			<label>Día:</label><input type="number" name="dia_desde" id="dia_desde" class="form-control" placeholder="dd">
		</div>
		<div class="col-sm-1">
			<label>Mes:</label><input type="number" name="mes_desde" id="mes_desde" class="form-control" placeholder="mm">
		</div>
		<div class="col-sm-2">
			<label>Año:</label><input type="number" name="ano_desde" id="ano_desde" class="form-control" placeholder="yyyy">
		</div>
		<div class="col-sm-1">
			<label>Día:</label><input type="number" name="dia_hasta" id="dia_hasta" class="form-control" placeholder="dd">
		</div>
		<div class="col-sm-1">
			<label>Mes:</label><input type="number" name="mes_hasta" id="mes_hasta" class="form-control" placeholder="mm">
		</div>
		<div class="col-sm-2">
			<label>Año:</label><input type="number" name="ano_hasta" id="ano_hasta" class="form-control" placeholder="yyyy">
		</div>

	</div>
	
	<div class="row">
		
	
		
	</div>
</div>
