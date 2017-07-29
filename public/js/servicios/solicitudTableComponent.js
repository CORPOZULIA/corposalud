const customBadge = (valor, tipo="label-default") =>{

	return `
		<h4><span class="label label-md ${tipo}">${valor}</span></h4>
	`

}

const table = (data = Object) =>{

	var solicitud = data.solicitud.datos
	var fecha = data.solicitud
	var cliente = data.cliente
	console.log(codigo_solicitud)
	return `
	
		<div class="container">
		<div class="row">
			<div class="col-sm-11 col-lg-11 col-sm-12">
				<table class="table table-responsive">
					<tr align="center">
						<td>
							<h1> ${(solicitud) ? solicitud.codigo_solicitud: ""} </h1>
						</td>
					</tr>
					<tr align="center">
						<td>
							<table class="table table-responsive">
								<tr aling="center">
									<td>
										<strong>
											Cliente: ${cliente.nombres+' '+cliente.apellidos} 
										</strong>
									</td>
									<td>
										<strong>
											Cedula: ${cliente.cedula}
										</strong>
									</td>
									<td>
										<strong>
											Fecha: ${fecha.fecha_solicitud}
										</strong>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr align="center">
						<td>
							<table class="table table-responsive">
								<tr align="center">
									<td>
										<strong>Total: ${ 
											(solicitud.precio == 0)? customBadge('Sin definir'): customBadge(solicitud.precio, 'label-success') 
											}
										</strong>

									</td>
									<td>
										<strong>
											Abono / Anticipo
											${
												(solicitud.abono == 0)? 
													customBadge('NO HAY ABONOS') : 
													customBadge(solicitud.abono, 'label-primary')
											}
										</strong>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr align="center">
						<td>
							<strong>Observaciones</strong>
							<blockquote>
							${
								solicitud.detalles
							}
							</blockquote>
						</td>
					</tr>
				</table>
				</div>
			</div>
		</div>
	`

}


const formTransferencia = () =>{

	return `
		<form action="#" id="form_transaccion" method="post">
			<input type="hidden" name="tipo_formulario" value="transferencia" />
			<div class="row">
				<div class="col-sm-12 col-md-8 col-lg-8">
					<label for="">Nro de transaccion</label>
					<div class="input-group">
						<input type="text" name="numero_transaccion" class="form-control" />
						<span class="input-group-btn">
							<button class="btn btn-primary" id="guardar">Guardar</button>
						</span>
					</div class="col-sm-12 col-md-8 col-lg-8">
						<label for="">Observacion de la transaccion</label>
						<textarea name="observacion" id="" cols="50" rows="10" class="form-control"></textarea>
					</div>
				</div>
				<div></div>
			</div>

		</form>
	`;

}

const tdc = () =>{

	return `
		<form action="#" id="form_transaccion" method="post">
			<input type="hidden" name="tipo_formulario" value="transferencia" />
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6">
					
				</div>
			</div>

		</form>
	`

}

const formPago = () =>{

	return`
		<form action="">
			<div class="container">
				
				<div class="row">
					<div class="col-sm-11">
						<label for="">Cedula</label>
						<input type="text" style="text-align:center;" onKeyPress="buscarCedula(event, this)" name="cedula" id="cedula" class="form-control" />
					</div>
				</div>

			</div>
		</form>

	`
}