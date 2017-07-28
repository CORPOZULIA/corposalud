<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
</head>
<body>

<style>
body{
	font-family: sans-serif;
}

table {
  border-spacing: 0;
  border-collapse: collapse;
}
td,
th {
  padding: 0;
}

.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 20px;
}
.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
  padding: 8px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #ddd;
}
.table > thead > tr > th {
  vertical-align: bottom;
  border-bottom: 2px solid #ddd;
}
.table > caption + thead > tr:first-child > th,
.table > colgroup + thead > tr:first-child > th,
.table > thead:first-child > tr:first-child > th,
.table > caption + thead > tr:first-child > td,
.table > colgroup + thead > tr:first-child > td,
.table > thead:first-child > tr:first-child > td {
  border-top: 0;
}
.table > tbody + tbody {
  border-top: 2px solid #ddd;
}
.table .table {
  background-color: #fff;
}
.table-condensed > thead > tr > th,
.table-condensed > tbody > tr > th,
.table-condensed > tfoot > tr > th,
.table-condensed > thead > tr > td,
.table-condensed > tbody > tr > td,
.table-condensed > tfoot > tr > td {
  padding: 5px;
}
.table-bordered {
  border: 1px solid #ddd;
}
.table-bordered > thead > tr > th,
.table-bordered > tbody > tr > th,
.table-bordered > tfoot > tr > th,
.table-bordered > thead > tr > td,
.table-bordered > tbody > tr > td,
.table-bordered > tfoot > tr > td {
  border: 1px solid #ddd;
}
.table-bordered > thead > tr > th,
.table-bordered > thead > tr > td {
  border-bottom-width: 2px;
}
.table-striped > tbody > tr:nth-of-type(odd) {
  background-color: #f9f9f9;
}
.table-hover > tbody > tr:hover {
  background-color: #f5f5f5;
}

h6{
	font-family: Helvetica, Arial, san-serif
	margin-bottom: 0px;
	margin-top: -7px;
}
.barcode{
	margin-top: -80px;
}

.barcode_span{
	margin-top: -110px;
	height: 120px;
}

.barcode_span > h6{
	margin-bottom: -33px;
}

.header,
.footer {
    width: 100%;
    text-align: center;
    position: fixed;
    font-family: sans-serif;
}

.footer {
    bottom: 0px;
}
.header {
    top: 0px;
}

.page-break{
	page-break-after: always;
}

.membrete_texto {

	margin-top: -46px;
	z-index: 9999;
}

.CORPOZULIA{
	margin-top:  6px;
}

h4{
	margin-bottom: -3px;
}
</style>
<div class="membrete">
	<p>
		<div class="barcode_span">
			<img src="{{ public_path('logo2.jpg') }}" style="max-width: 110px;">
			<center class="membrete_texto">
				<h4>
					<h4 class="CORPOZULIA">
						CORPORACIÓN PARA EL DESARROLLO DE LA REGIÓN ZULIANA <br>
						<small>CORPOSALUD</small> <br>
						<strong>Tipo de nomina: {{ $nomina }} </strong>
					</h4> 
					<small>
						Relación de pago de facturas medicas del {{ $desde }} al {{ $hasta }}
					</small>
				</h4>
			</center>
		</div>
	</p>
</div>
<br><br>
<table width="100%" class="table table-bordered">
	<thead>
		<tr>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>Cedula</th>
			<th>Monto de las facturas</th>
			<th>Monto a cancelar</th>
		</tr>
	</thead>

	<tbody>
		
	<?php $total = 0; $personas = 0; ?>

		@foreach($facturas as $factura)
			<?php
				$personas ++;
				if( ( $factura->monto_disponible - $factura->a_pagar ) < 0 )
					$total += $factura->monto_disponible;

				else if($factura->monto_disponible == $factura->a_pagar  )
					$total+= $factura->a_pagar;
				else if( ( $factura->monto_disponible - $factura->a_pagar ) > 0 )
					$total += $factura->a_pagar;
			?>
            <tr class="odd gradeX user_field">

       			<td> {{ $factura->nombres }} </td>
				<td> {{ $factura->apellidos }} </td>
                <td> {{ $factura->cedula }} </td>
                <td> {{ number_format($factura->a_pagar, 2) }} Bs </td>
                <td>
                 	@if( ( $factura->monto_disponible - $factura->a_pagar ) < 0 )
                    		{{ number_format($factura->monto_disponible, 2) }} Bs

                    	@elseif( $factura->monto_disponible == $factura->a_pagar )
                    		{{ number_format($factura->a_pagar, 2) }} Bs


                    	@elseif(( $factura->monto_disponible - $factura->a_pagar ) > 0)
                    					{{ number_format($factura->a_pagar, 2) }} Bs
                    @endif

                </td>
            </tr>
        @endforeach
	
	</tbody>
</table>

<table width="100%" class="table table-bordered">
	<thead>
		<tr>
			<th width="3%">Total de empleados</th>
			<th width = "3%">Monto total</th>
		</tr>
	</thead>	
	<tbody>
		<tr>
			<td> {{ $personas }} </td>
			<td> {{ number_format($total, 2) }} Bs </td>
		</tr>
	</tbody>
</table>
<!-- FIN DEL TOTAL -->
<table width="100%" class="table table-bordered">
	<thead>
		<tr>
			<th width="3%">Elaborado por</th>
			<th width = "3%">Firma</th>
			<th width="3%">Firma autorizada (CORPOSALUD)</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>
			{{ Auth::user()->empleado->persona->nombres. ' '.Auth::user()->empleado->persona->apellidos}}</td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>

<table width="100%" class="table table-bordered">
	<thead>
		<tr>
			<th width="3%">Recibido por</th>
			<th width = "3%">Firma</th>
			<th width="3%">Observación</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>
			<br><br>
			</td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>

<div class="footer">
	<small>
	
		Corporación para el Desarrollo de la Región Zuliana, CORPOZULIA.
	</small>
</div>

<!-- PAGINA 2 -->

<div class="page-break"></div>

<div class="membrete">
	<p>
		<div class="barcode_span">
			<img src="{{ public_path('logo2.jpg') }}" style="max-width: 110px;">
			<center class="membrete_texto">
				<h4>
					<h4 class="CORPOZULIA">
						CORPORACIÓN PARA EL DESARROLLO DE LA REGIÓN ZULIANA <br>
						<small>CORPOSALUD</small> <br>
						<strong>Tipo de nomina: {{ $nomina }} </strong>
					</h4> 
					<small>
						Relación de pago de facturas medicas del {{ $desde }} al {{ $hasta }}
					</small>
				</h4>
			</center>
		</div>
	</p>
</div>
<br><br>
<table width="100%" class="table table-bordered">
	<thead>
		<tr>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>Cedula</th>
			<th>Monto a cancelar</th>
		</tr>
	</thead>

	<tbody>
		<?php $total = 0;  $personas = 0;?>
		@foreach($facturas as $factura)
			<?php
				$personas ++;
				if( ( $factura->monto_disponible - $factura->a_pagar ) < 0 )
					$total += $factura->monto_disponible;

				else if($factura->monto_disponible == $factura->a_pagar  )
					$total+= $factura->a_pagar;
				else if( ( $factura->monto_disponible - $factura->a_pagar ) > 0 )
					$total += $factura->a_pagar;
			?>
            <tr class="odd gradeX user_field">

       			<td> {{ $factura->nombres }} </td>
				<td> {{ $factura->apellidos }} </td>
                <td> {{ $factura->cedula }} </td>
                <td>
                 	@if( ( $factura->monto_disponible - $factura->a_pagar ) < 0 )
                    		{{ number_format($factura->monto_disponible, 2) }} Bs

                    	@elseif( $factura->monto_disponible == $factura->a_pagar )
                    		{{ number_format($factura->a_pagar) }} Bs

                    	@elseif(( $factura->monto_disponible - $factura->a_pagar ) > 0)
                    		{{ number_format($factura->a_pagar, 2) }} Bs
                    @endif

                </td>
            </tr>
        @endforeach
	
	</tbody>
</table>


<table width="100%" class="table table-bordered">
	<thead>
		<tr>
			<th width="3%">Total de empleados</th>
			<th width = "3%">Monto total</th>
		</tr>
	</thead>	
	<tbody>
		<tr>
			<td> {{ $personas }} </td>
			<td> {{ number_format($total, 2) }} Bs </td>
		</tr>
	</tbody>
</table>
<!-- FIN DEL TOTAL -->

<table width="100%" class="table table-bordered">
	<thead>
		<tr>
			<th width="3%">Elaborado por</th>
			<th width = "3%">Firma</th>
			<th width="3%">Firma autorizada (CORPOSALUD)</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>
			{{ Auth::user()->empleado->persona->nombres. ' '.Auth::user()->empleado->persona->apellidos}}</td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>

<table width="100%" class="table table-bordered">
	<thead>
		<tr>
			<th width="3%">Recibido por</th>
			<th width = "3%">Firma</th>
			<th width="3%">Observación</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>
				<br><br>
			</td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>

<div class="footer">
	<small>
	
		Corporación para el Desarrollo de la Región Zuliana, CORPOZULIA.
	</small>
</div>

</body>

</html>