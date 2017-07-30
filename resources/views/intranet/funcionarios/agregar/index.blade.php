@extends('layouts.dashboard_layout')

@section('titulo', 'Agregar nuevos funcionarios al sistema')

@section('contenedor')

<div class="container">

<div class="row">
	
	<div class="col-sm-6 col-md-6 col-lg-6">
		
		<h3 class="page-header">Formulario para agregar funcionarios</h3>

	</div>

</div>

<div class="row">
	
	<form action="#" id="nuevo_funcionario">
		{{ csrf_field() }}
		<div class="container">
			
			<div class="row">
				
				<div class="col-sm-5">
					
					<h3 class="page-header">Datos personales</h3>

				</div>

			</div>
			<div class="row">
				
				<div class="col-sm-3">
					<label for="">Nombres *</label>
					<input type="text" id="nombres" class="form-control" required placeholder="Nombres del funcionario" name="nombres">
				</div>
				<div class="col-sm-3">
					<label for="">Apellidos *</label>
					<input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos del funcionario" required>
				</div>
				<div class="col-sm-3">
					<label for="">Cedula *</label>
					<input type="text" id="cedula" name="cedula" placeholder="Cedula" required class="form-control">
				</div>

			</div>
			<div class="row">
				
				<div class="col-sm-3">
					<label for="">Telefono personal</label>
					<input type="text" id="telefono_personal" name="telefono_personal" placeholder="Telefono personal" class="form-control">
				</div>
				<div class="col-sm-3">
					<label for="">Telefono de contacto</label>
					<input type="text" id="telefono_habitacion" name="telefono_habitacion" placeholder="Telefono personal" class="form-control">
				</div>
				<div class="col-sm-3">
					<label for="">Correo *</label>
					<input type="email" id="email" name="email" placeholder="Correo electronico" class="form-control">
				</div>

			</div>
			<div class="row">
				<div class="col-sm-7">
					<label for="">Direccion</label>
					<textarea name="direccion" id="direccion" cols="30" rows="10" class="form-control" type="text"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-5">
					<h3 class="page-header">Datos de beneficiario</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label for="">Asignacion inicial</label>
					<select required name="disponibilidad_id" id="disponibilidad_id" class="form-control">
						<option value="">------</option>
						@foreach($disponibilidades as $key => $disponibilidad)
							<option value="{{ $disponibilidad->id }}">{{ $disponibilidad->monto_disponible }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-3">
					<label for="">Nomina</label>
					<select required name="nomina_id" id="nomina_id" class="form-control">
						<option value="">------</option>
						@foreach($nominas as $key => $nomina)
							<option value="{{ $nomina->id }}">
								{{ $nomina->descripcion_nomina }} ({{ $nomina->codigo_nomina }})
							</option>
						@endforeach
					</select>
				</div>
			</div>

			<br>
			<br>
			<br>
			<div class="row">
				<div class="col-sm-7">
					<a  class="btn btn-success btn-block" id="salvar">Guardar datos</a>
				</div>
			</div>
		</div>
		
	</form>

</div>
	
</div>

@endsection
@section('jquery')

<script>
	
$(document).ready(()=>{

	/**
	 * ESTE FRAGMENTO PRIMERAMENTE VERIFICA QUE CADA CAMPO REQUERIDO
	 * ESTE DEBIDAMENTE COMPLETADO, HACE UNA COMPROBACION RECORRIENDO EL ARREGLO
	 * Inputs EL CUAL CONTIENE LOS ID DE LOS CAMPOS QUE SON OBLIGATRIOS DE COMPLETAR
	 * (SI SE NECESITA AGREGAR OTRO CAMPO OBLIGATORIO, AGREGAR EL ID DE DICHO
	 * INPUT EN ESE ARREGLO)
	 */
	$("#salvar").on('click', (e)=>{
		var btn = $("#salvar")
		var inputs = [
			'nombres', 'apellidos', 'correo', 'nomina_id', 'disponibilidad_id'
		];

		if( btn.hasClass('disabled'))
		{	
			alert("EN ESTE MOMENTO SE ESTAN PROCESANDO LOS DATOS, ESPERE");
		}
		else{
			btn.addClass('disabled')
			btn.text('Guardando, por favor espere...')
			var cantidad = inputs.length;
			var completado = true;

			for(var i = 0; i < cantidad; i++){
				if( $("#"+inputs[i]).val() == ""){
					alert("AUN TIENE DATOS POR COMPLETAR EN EL FORMULARIO")
					completado = false;
					break;
				}
			}

			if(completado){
				var form = $("#nuevo_funcionario").serialize();
				var url = location.href
				$.post(url+"/salvar", form, (resp)=>{
					if(! resp.error && confirm(resp.mensaje))
						location.reload();
				})
			}
			btn.text('Guardar datos')
			btn.removeClass('disabled')
		}
	
	})
})
</script>

@endsection