var ins = 0;
var formulario = $("#formulario_facturas").html();
function buscarDatos(evento, cedula){
	
	var url = location.href;

	if(evento.keyCode == 13)
	{
		evento.preventDefault();
		$.getJSON(url+'/verificarCliente/'+cedula, '', function(response){
			if(! response.fail)
			{
			 	$("#nombre").attr('value', response.nombres);
			 	$("#persona_id").attr('value', response.persona_id);
			 	$("#cliente_id").attr('value', response.cliente_id);
			 	$("#codigo_hardware").focus();
			}
			else
			{ 
				var modal = $("#modal_forms");
				modal.modal('show');
			}
		})
	}
}

function limpiarDatos(evento){

	if($("#nombres").attr('value')!=''){
		$("#nombres").attr('value', '');
	}
}

/**
 * VERIFICACION DE UN PRODUCTO MEDIANTE SU CODIGO
 * EN EL SISTEMA
 * @param  WINDOW.EVENT evento       detección de pulsación de teclas
 * @param  STRING codigo_hardware 	Contiene el codigo del hardware a consultar
 */
function codigo(evento, codigo_hardware){
	//window.open(location.href+'/factura', 'popup');

	/**
	 * url para las solicitudes al servidor
	 * @type URL|STRING
	 */
	var url = location.href;
	if(evento.keyCode == 13){ 
		evento.preventDefault();
		/**
		 * PRIMERO SE VERIFICA QUE LA TECLA PULSADA SEA ENTER (CODIGO 13)
		 * SE CANCELA SU ACCION POR DEFECTO PARA QUE NO ENVIE EL FORMULARIO
		 * A SER PROCESADO (preventDefault())
		 * LUEGO SE ENVIA UNA SOLICITUD AJAX PARA VERIFICAR EL HARDWARE
		 * QUE SE ESTA CONSULTANDO, DICHA SOLICITUD RETORNA UN OBJETO JSON
		 */

		$.getJSON(url+'/verificarCodigo/'+codigo_hardware, '', function(response){
			if(response[0].nombre_hardware){
				//alert(html);
				
				/**
				 * SI EXISTE UN NOMBRE DE HARDWARE ENTONCES SE CREA UN NUEVO TR
				 * EN LA TABLA DONDE SE MUESTRAN LA LISTA DE PRODUCTOS A COMPRAR
				 * SE LE AGREGA AL TBODY CON EL ID PRODUCTOS_LISTA 
				 * SE OBTIENE EL TOTAL PREVIO Y SE LE SUMA EL PRECIO DEL QUE SE VA
				 * INGRESANDO
				 */
				
				//var productos = $("#num-productos").attr('num-productos');

				html ='<tr><td><input type="text" onKeypress="stop(event, this.value)" class="form-control" onChange="editarTotal(this.value)" id="cantidad" name="cantidad[]" value="1"></td><td><input type="text" class="form-control disabled" readonly="readonly" name="producto[]" value="'+response[0].nombre_hardware+'"></td><td><input type="text" class="form-control disabled"  readonly="readonly" name="precio[]" id="precio'+ins+'" value="'+response[0].precio+'"></td><td><input type="hidden" name="hardware_id[]" value="'+response[0].id+'"></td></tr>';
				$("#productos_lista").append(html);
				var total = $("#total").attr('value');
				alert(total);
				var total = (parseFloat(total) + parseFloat(response[0].precio)) + ((response[0].precio)*0.12);
				
				$("#total").attr('value', total);
				
				
			}
		});
	}
	//html = html+'<tr><td><input type="text" class="form-control" name="cantidad[]" value="3"></td><td><input type="text" class="form-control disabled" name="producto[]" value="Mouse genius"></td><td><input type="text" class="form-control disabled" name="precio[]" value="1100"></td></tr>';
	
	//$("#productos_lista").focus();
}


function stop(evento, cant)
{	
	if(evento.keyCode == 13)
	{
		evento.preventDefault();
		$("#codigo_hardware").attr('value', '');
		$("#codigo_hardware").focus();
	}
}

$("#modal-click").click(function(e){
	datos = $("#cargar_info").serialize();
	var cedula = document.getElementById('cedula');
	datos += '&cedula='+cedula.value;

	var url = location.href+'/crearCliente';

    $("#verificando").html('<div class="loader"></div>');
	$.post(url, datos, function(response){

        $("#verificando").html('');
		if(! response.fail)
		{
			alert('El cliente se ha registrado exitosamente');
			
			document.getElementById('nombres').value='';
			document.getElementById('apellidos').value='';
			document.getElementById('telefono_personal').value='';
			document.getElementById('telefono_habitacion').value='';
			document.getElementById('email').value='';
			document.getElementById('telefono_direccion').value='';

		}
		else alert(response.mensaje_error);
	});
});

function facturar(evento)
{
	evento.preventDefault();
	var datos = $("#facturacion").serialize();

	var url = location.href +'/factura';
	$.post(url, datos, function(response){
		if(! response.fail)
		{
			window.open(location.href+'/consultarFactura/'+response.factura_id, 'popup');
		}
		else alert(response.mensaje_error);
	});
	$("#formulario_facturas").html(formulario);
	ins = 0;
}
