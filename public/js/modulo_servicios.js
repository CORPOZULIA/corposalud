$(document).ready(function(){

	$('#dataTables-example').DataTable({
            responsive: true
     });


	/*
	*	APERTURA DE LOS MODALES PARA FORMULARIOS
	 */
	$(".btn_forms").click(function(){
		var btn = $(this);
		var url = location.href +'/'+$(this).attr('data-url')+'/'+$(this).attr('data-solicitud');
		var form = $("#modal_forms");
		var id = btn.attr('data-solicitud');
		form.modal('show');
		$.getJSON(url, '', function(response){
			 $("#form-inputs").html(response.formulario);
		});

	});

	$("#modal-click").click(function(){
		var datos = $("#cargar_info").serialize();
		var url = location.href +'/'+$("#accion").val();
		
		if(confirm('¿Esta seguro de realizar esta operacion?'))
		{
			$.post(url, datos, function(response){
				alert(response.mensaje);
				location.reload();
			});
		}
	});
});

function calcularTotal(event)
{	
	if(event.keyCode == 13)
	{
		event.preventDefault()

		var por_iva = document.getElementById('iva');
		var abono = document.getElementById('abono');
		var precio = document.getElementById('precio');
		$("#iva_servicio").val( parseFloat(precio.value) *parseFloat(por_iva.value)  )
		$("#total").val( parseFloat(precio.value) + ( parseFloat(precio.value) *parseFloat(por_iva.value) ) - parseFloat(abono.value) ); 
	}
}