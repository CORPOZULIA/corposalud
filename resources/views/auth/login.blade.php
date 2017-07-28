<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bienvenido, logeese</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/estilos.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    @if( session()->has('codper_repeat'))
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger">
                {{ session()->get('codper_repeat') }}
            </div>
        </div>
    </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Por favor, ingrese sus credenciales</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuario" name="usuario" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Recordarme">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" onClick="verificar(event)" class="btn btn-md btn-success btn-block">Ingresar</button>
                                <button type="button" class="btn btn-warning btn-block disabled" id="nuevo">Crear usuario</button>
                            </fieldset> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- INICIO DE LA VENTANA MODAL DE LOS FORMULARIOS -->
        <div class="modal fade" id="modal_forms" tabindex="-1" role="dialog" aria-labelledby="modal_formsLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Gestion de usuarios &nbsp;&nbsp;&nbsp;&nbsp; <span id="verificando"></span> </h4>
              </div>
              <div class="modal-body">

                <div class="container">

                    <div class="row">
                        <form action="{{url('login/corpoz/crear')}}" method="post" class=""  id="cargar_info">
                        {{ csrf_field() }}
                        <input type="hidden" name="codper" id="codper">
                            <div class="container">
                                
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Cedula: </label>
                                    <input type="text" name="cedula" id="codper" onkeypress="capturarEnter(event, this.value)" class="form-control" autofocus>
                                </div>

                                <div class="col-sm-3">
                                    <label>Nombres: </label>
                                    <input type="text" name="nombres"  id="nombres" class="form-control" disabled>
                                </div>


                            </div>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Usuario: </label>
                                        <input type="text" name="usuario" id="usuario"  class="form-control" autofocus disabled>
                                    </div>

                                </div>

                                 <div class="row">
                                    <div class="col-sm-3">
                                        <label>Clave: </label>
                                        <input type="password" name="password" id="password"  class="form-control" autofocus disabled>

                                    </div>
                                    <div class="col-sm-3">
                                        <label>Repite su Clave: </label>
                                        <input type="password" name="password2" id="password2"  class="form-control" autofocus disabled>
                                        
                                    </div>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar ventana</button>
                <button type="button" class="btn btn-primary" id="modal-click">Save changes</button>
              </div>
            </div>
          </div>
        </div>

        <!-- FIN DE LA VENTANA MODAL -->
    

    </div>


    <!-- jQuery -->
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('js/sb-admin-2.js') }}"></script>
    <script type="text/javascript">
        
        $(document).ready(function(){

            $("#nuevo").click(function(){

                if(! $("#nuevo").hasClass('disabled'))
                {
                    var modal = $("#modal_forms");
                    modal.modal('show');
                }
                else alert('Actualmente esta opción no esta en uso, favor intenar luego');
            })

            $("#modal-click").click(function(){
              
                var p1 = document.getElementById('password');
                var p2 = document.getElementById('password2');
                var usuario = document.getElementById('usuario');
                
                if( (p1.value!='' ) && (p1.value == p2.value) && (usuario.value!=''))
                {
                    var formulario = $("#cargar_info");
                    
                    formulario.submit();
                }
                else if( p1.value=='' || p2.value!='' ){
                    alert('Las contraseñas deben ser iguales, favor verifique que esten bien escritas');
                }
                else if(usuario.value==''){
                    alert('El campo de nombre de usuario debe estar completo');
                }
            });



        });

        function capturarEnter(e, cedula){
          if (e.keyCode == 13) {

                $("#verificando").html('<div class="loader"></div>');
                var url = location.href + '/corpoz/verificar/'+cedula;
                var token = $("input[name=_token]").attr('value');
                $.getJSON(url, function(response)
                {   
                    if(!response[0].fail)
                    {
                        $("#nombres").attr('value', response[0].nomper);
                        $("#codper").attr('value', response[0].codper);
                        $("#usuario").prop('disabled', false);
                        $("#password2").prop('disabled', false);
                        $("#password").prop('disabled', false);
                    }
                    else
                    {
                        $("#usuario").prop('disabled', true);
                        $("#password2").prop('disabled', true);
                        $("#password").prop('disabled', true);

                        $("#nombres").attr('value', '');
                        $("#codper").attr('value', '');
                        $("#usuario").attr('value', '');
                        $("#password2").attr('value', '');
                        $("#password").attr('value', '');
                        alert(response[0].mensaje_error);
                    }
                });
                $("#verificando").html('');
            }
        }
    </script>

</body>

</html>
