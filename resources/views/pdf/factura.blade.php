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
	border: 2px solid #e3e3e3;
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

</style>

<div class="membrete">
	<p>
		
		<div class="barcode_span">
			<center class="membrete_texto">
				<br>
				<h6>
						MARACAIBO - ESTADO ZULIA <br>
					FACTURA DE SERVICIO PRESTADO POR CONCEPTO DE: 
					 <br>[NOMBRE DE LA EMPRESA]
					 <br><br>
					 Factura que se emite a nombre de: {{ $nombres." ".$apellidos }} <br>
					 Cedula: {{ $cedula }} <br>
					 Emitida por: {{ Auth::user()->empleado->persona->nombres }} <br>
					 Fecha y hora: {{ Carbon\Carbon::now() }}
				</h6>
			</center>
			<img src="data:image/png;base64,{{ $barcode }}" alt="barcode" class="barcode"  />
		</div>
	</p>
</div>
<br><br>
<table width="100%" class="table table-bordered">
	<thead>
		<tr>
			<th width="12%">Cantidad</th>
			<th>Articulo</th>
			<th width="23%">Precio unitario</th>
		</tr>
	</thead>

	<tbody>
		@for($i = 0; $i < count($cantidad); $i++)
		<tr>
			<td>{{ $cantidad[$i] }}</td>
			<td>{{ $producto[$i] }}</td>
			<td>{{ $precio[$i] }}</td>
		</tr>
		@endfor
	</tbody>
</table>

<table width="100%" class="table table-bordered">
	<thead>
		<tr>
			<th width="3%">IVA</th>
			<th width = "3%">SUB TOTAL</th>
			<th width="3%">TOTAL</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{ $iva }}</td>
			<td>{{ $subtotal }}</td>
			<td>{{ $total }}</td>
		</tr>
	</tbody>
</table>

<div class="footer">
	<small>
	
		Gracias por adquirir nuestros servicios, esta factura es un soporte del servicio
		ofrecido.
		
	</small>
</div>
</body>

</html>