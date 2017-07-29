/**
 * FORMAS DE IDENTIFICAR UNA SOLICITUD AJAX:
 * LAS FUNCIONES $.getJSON, $.get, $.post
 * SOM FUNCIONES ENCARGADAS DE HACER SOLICITUDES AJAX AL SERVIDOR
 * ($.getJSON envia una solicitud GET RECIBE OBJETOS JSON COMO RESPUESTA)
 */

$(document).ready(function() {

        $('#dataTables-example').DataTable({
            responsive: true
        });


        $(".btn-forms").click(function(){
            var dataForms = $(this).attr('formulario');
            $(".modal-footer").html("");
            modal = $('#modal_hardware');
            modal.modal('show');
            var url = location.href+'/formularios/'+dataForms;

            $("#verificando").html('<div class="loader"></div>');
            $.getJSON(url, '', function(response){
                if(! response.fail)
                {
                    $("#formulario").html(response.formulario);
                }
            });
            $("#verificando").html('');
        });


        $("#modal-click").click(function(){

            var datos = $("#insertar_datos");
            var url = location.href+'/'+datos.attr('data-url');

            datos.submit();

        });

        $(".delete").click(function(){
            if( confirm('¿Seguro que desea realizar esta acción?'))
            {
                var id = $(this).attr('data-id');
                var token = $(this).attr('token');
                var url = location.href +'/'+$(this).attr('role');

                $.post(url, {'id': id, '_token': token}, function(response){
                    
                        alert(response.mensaje);
                });
            }
        });
        var id = 0;

        $(".edit").click(function(){

            var url = location.href ;
            $.getJSON(url+ '/consultar/'+$(this).attr('data-id'), '', function(response){
                if(response.nombre_categoria != null){

                }

            });
        });
});

