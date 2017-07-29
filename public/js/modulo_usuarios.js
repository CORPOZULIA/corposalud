/**
 * FORMAS DE IDENTIFICAR UNA SOLICITUD AJAX:
 * LAS FUNCIONES $.getJSON, $.get, $.post
 * SOM FUNCIONES ENCARGADAS DE HACER SOLICITUDES AJAX AL SERVIDOR
 * ($.getJSON envia una solicitud GET RECIBE OBJETOS JSON COMO RESPUESTA)
 */

$(document).ready(function() {

        /**
         * AL MOMENTO DE CREAR UN USUARIO EN EL SISTEMA
         * PRIMERAMENTE SE DEBE HACER CLICK SOBRE EL CAMPO CEDULA
         * PARA BUSCAR UNA POSIBLE CEDULA EXISTENTE DENTRO DEL SISTEMA
         * AL QUITAR EL "FOCO" DEL CAMPO DE LA CEDULA
         * SE BUSCA LOS DATOS DE LA PERSONA CORRESPONDIENTE A LA CEDULA
         * EN EL SISTEMA, SI SE ENCUENTRA UN REGISTRO CON ESA CEDULA O RIF
         * ENTONCES REGRESA UN OBJETO JSON
         */

        $("#cedula").blur(function(){
            var ced = document.getElementById('cedula');
            var url = location.href+'/consultar/'+ced.value;

            $("#verificando").html('<div class="loader"></div>');
            $.getJSON(url,'', function(response){
                if(!response.fail)
                {
                    document.getElementById('nombres').value = response.nombres;
                    document.getElementById('apellidos').value = response.apellidos;
                    document.getElementById('telefono_habitacion').value= response.telefono_habitacion;
                    document.getElementById('telefono_personal').value = response.telefono_personal;
                    document.getElementById('email').value = response.email;
                    document.getElementById('direccion').value = response.direccion;
                }
                $("#verificando").html("");
            })
         });

        $('#dataTables-example').DataTable({
            responsive: true
        });

        $(".user_field").on('click', function(event){
        	var id_user = $(this).attr('data-user');
        	//alert(id_user);
        });

        /**
         * ESTE EVENTO SE "DISPARA" CUANDO ALGUNO DE LOS BOTONES
         * DE LA COLUMNA ACCIONES (DENTRO DE LA VISTA "LISTAR_USUARIOS" DEL MODULO USUARIOS)
         * BUSCA EL FORMULARIO CORRESPONDIENTE AL BOTON PRESIONADO
         */

        $(".btn-forms").click(function(){
            $("#verificando").html('<div class="loader"></div>');
            $("#row-form").removeClass('hidden');
            var form = $(this).attr('formulario');
            var url = location.href+'/formulario/'+form;
            
            $.getJSON(url, '', function(response){
                if(!response.fail)
                {
                    $("#verificando").html("");
                    $("#form-inputs").append(response.formulario);
                    $("#cargar_info").attr("util-form", form);
                }
            });
        });

        /**
         * ESTA SENTENCIA HACE QUE SE LIMPIE EL FORMULARIO
         * DE LA VENTANA EMERGENTE AL MOMENTO DE CREAR UN USUARIO O AL
         * ASIGNARLE PERMISOS
         */

        $("#modal_forms").on('hidden.bs.modal', function(e){
            $('#form-inputs').html("");

        });

        $("#modal-click").click(function(e){
            var accion = $("#accion").attr('value');
          
            if(accion == "crear")
            {

                var password = document.getElementById('password').value;
                var password2 = document.getElementById('password-repeat').value;
                if((password != password2) || (password2=='' || password=='') ){
                    alert("Las contraseñas deben coinsidir y no estar vacias");
                    return false;
                }
                else if(document.getElementById('usuario').value == '')
                {
                    alert("Debe completar el campo de nombre de usuario");
                    return false;
                }
            }

            var formulario = $("#cargar_info");
                

            formulario.attr('action', location.href+"/"+accion);
            formulario.submit();
            
        });

        $(".usuario-option").click(function(e)
        {
            var user = $(this).attr('data-user');
            var role = $(this).attr('role');
            var url = location.href+'/'+role;
            var token = $(this).attr('token');

            $("#user_id").attr('value', user);
            if(role=="DELETE" && confirm("¿Esta seguro que desea suprimir este usuario?"))
            {
               $.post(url, {'id' : user, '_token': token},function(response){

                    if(!response.fail){
                        alert("Se ha suprimido el registro satisfactoriamente");
                        location.reload();

                    }

               });
            }

            if(role == "PERMISOS")
            {
                $("#verificando").html('<div class="loader"></div>');

               var url = location.href+'/formulario/permisos';

               var modal = $("#modal_forms");
               $("#row-form").addClass('hidden');
               modal.modal('show');
               $.getJSON(url, '', function(response){
                    if(! response.fail)
                    {
                        $("#verificando").html("");
                        $("#form-inputs").html(response.formulario);
                    }
               })
            }
        });

    });
        
    function permiso_modulo(modulo_id)
    {
        var url = location.href+'/consultar_modulo/'+modulo_id;
        var user_id = $("#user_id").attr('value');
        var token = $("#permisos").attr('token');

        $("#verificando").html('<div class="loader"></div>');
        $.post(url, {'user_id': user_id, '_token': token}, function(response){
            for(i = 0; i< response.permiso.length; i++)
            {
                $("#"+response.permiso[i]).prop('checked', true);
            }
            $("#verificando").html("");
        });
    }