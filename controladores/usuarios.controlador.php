<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControladorUsuarios{


/*=============================================
    INGRESO DE USUARIO
    =============================================*/
	
	/**
     * Función para controlar el ingreso de usuarios
     * 
     * @return void
     */
    static public function ctrIngresoUsuario(){

        if(isset($_POST["ingUsuario"])){

            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"])){

                $tabla = "usuarios";

                $item = "usuario";
                $valor = $_POST["ingUsuario"];

                $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

                // Comparación de contraseñas utilizando password_verify
                if($respuesta["usuario"] == $_POST["ingUsuario"] && password_verify($_POST["ingPassword"], $respuesta["password"])){

                    if($respuesta["estado"] == 1){

$_SESSION["iniciarSesion"] = "ok";
						$_SESSION["id"] = $respuesta["id"];
						$_SESSION["nombre"] = $respuesta["nombre"];
						$_SESSION["apellidoPa"] = $respuesta["apellidoPa"];
						$_SESSION["apellidoMa"] = $respuesta["apellidoMa"];
						$_SESSION["correo"] = $respuesta["correo"];
						$_SESSION["usuario"] = $respuesta["usuario"];
						$_SESSION["foto"] = $respuesta["foto"];
						$_SESSION["perfil"] = $respuesta["perfil"];

						/*=============================================
						REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
						=============================================*/

						date_default_timezone_set('America/Bogota');

						$fecha = date('Y-m-d');
						$hora = date('H:i:s');

						$fechaActual = $fecha.' '.$hora;

						$item1 = "ultimo_login";
						$valor1 = $fechaActual;

						$item2 = "id";
						$valor2 = $respuesta["id"];

						$ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

						if($ultimoLogin == "ok"){

							echo '<script>

								window.location = "inicio";

							</script>';
							
						}			
                    } else {

                        echo '<br>
                            <div class="alert alert-danger">El usuario aún no está activado</div>';

                    }

                } else {

                    echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';

                }

            }

        }

    }


/*=============================================
	REGISTRO DE USUARIO
=============================================*/

static public function ctrCrearUsuario(){

    if(isset($_POST["nuevoUsuario"])){

        // Validar usuario repetido
        $usuarioRepetido = self::validarUsuarioRepetido($_POST["nuevoUsuario"]);
        $correoRepetido = self::validarCorreoRepetido($_POST["nuevoCorreo"]);

        if ($usuarioRepetido) {
            echo '<script>
                swal({
                    type: "error",
                    title: "¡El usuario ya existe! Por favor, elija otro nombre de usuario.",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        window.location = "usuarios";
                    }
                });
            </script>';
        } else if ($correoRepetido) {
            echo '<script>
                swal({
                    type: "error",
                    title: "¡El correo ya existe! Por favor, elija otro correo.",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        window.location = "usuarios";
                    }
                });
            </script>';
        } else {
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])){

                // Inicializar la variable $ruta
                $ruta = "";

                // Validar si se ha subido una foto
                if(isset($_FILES["nuevaFoto"]["tmp_name"])){

                    list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /*=============================================
                    CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                    =============================================*/

                    $directorio = "vistas/img/usuarios/".$_POST["nuevoUsuario"];

                    if (!is_dir($directorio)) {
                        mkdir($directorio, 0755);
                    }

                    /*=============================================
                    DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                    =============================================*/

                    if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){

                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/

                        $aleatorio = mt_rand(100,999);

                        $ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".jpg";

                        $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);                        

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino, $ruta);

                    }

                    if($_FILES["nuevaFoto"]["type"] == "image/png"){

                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/

                        $aleatorio = mt_rand(100,999);

                        $ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".png";

                        $origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);                        

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino, $ruta);

                    }

                }

                $tabla = "usuarios";

                $encriptar = crypt($_POST["nuevoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                // Ajustar la estructura del array $datos para permitir un valor vacío en "foto"
                $datos = array(
                    "nombre" => $_POST["nuevoNombre"],
                    "apellidoPa" => $_POST["nuevoApellidoPa"],
                    "apellidoMa" => $_POST["nuevoApellidoMa"],
                    "correo" => $_POST["nuevoCorreo"],
                    "usuario" => $_POST["nuevoUsuario"],
                    "password" => $encriptar,
                    "perfil" => $_POST["nuevoPerfil"],
                    "foto" => $ruta
                );

                $respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
            
                if($respuesta == "ok"){
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'cajo200007@upemor.edu.mx'; // Coloca tu dirección de correo de Gmail
                    $mail->Password = 'Isabela1414?'; // Coloca tu contraseña de Gmail
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('cajo200007u@upemor.edu.mx', 'VidaDivina'); // Coloca tu dirección de correo y nombre
                    $mail->addAddress($_POST["nuevoCorreo"]); // Utiliza el correo ingresado en el formulario

                    $mail->isHTML(true);
                    $mail->Subject = 'Bienvenido a VidaDivina';
                    $mail->Body = '¡Estas son tus credenciales de acceso en Vida Divina!<br>Tu usuario es: ' . $_POST["nuevoUsuario"] . '<br>Tu contraseña es: ' . $_POST["nuevoPassword"];
                    $mail->send();

                    echo '<script>
                        swal({
                            type: "success",
                            title: "¡El usuario ha sido guardado correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if(result.value){
                                window.location = "usuarios";
                            }
                        });
                    </script>';
                }   
            }else{
                echo '<script>
                    swal({
                        type: "error",
                        title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if(result.value){
                            window.location = "usuarios";
                        }
                    });
                </script>';
            }
        }
    }
}

static private function validarUsuarioRepetido($usuario){
    // Lógica para validar si el usuario ya existe en la base de datos
    $tabla = "usuarios";
    $usuarioExistente = ModeloUsuarios::verificarUsuarioExistente($tabla, $usuario);
    return $usuarioExistente;
}

static private function validarCorreoRepetido($correo){
    $tabla = "usuarios";
    $correoExistente = ModeloUsuarios::verificarCorreoExistente($tabla, $correo);
    return $correoExistente;
}



	/*=============================================
	MOSTRAR USUARIO
	=============================================*/

	static public function ctrMostrarUsuarios($item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function ctrEditarUsuario(){

		if(isset($_POST["editarUsuario"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = $_POST["fotoActual"];

				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/usuarios/".$_POST["editarUsuario"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if(!empty($_POST["fotoActual"])){

						unlink($_POST["fotoActual"]);

					}else{

						mkdir($directorio, 0755);

					}	

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["editarFoto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "usuarios";

				if($_POST["editarPassword"] != ""){

					if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){

						$encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

					}else{

						echo'<script>

								swal({
									  type: "error",
									  title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result) {
										if (result.value) {

										window.location = "usuarios";

										}
									})

						  	</script>';

						  	return;

					}

				}else{

					$encriptar = $_POST["passwordActual"];

				}

				$datos = array("nombre" => $_POST["editarNombre"],
								"apellidoPa" => $_POST["editarApellidopa"],
								"apellidoMa" => $_POST["editarApellidoma"],
								"correo" => $_POST["editarCorreo"],
							   "usuario" => $_POST["editarUsuario"],
							   "password" => $encriptar,
							   "perfil" => $_POST["editarPerfil"],
							   "foto" => $ruta);

				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El usuario ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "usuarios";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {

							window.location = "usuarios";

							}
						})

			  	</script>';

			}

		}

	}

/*=============================================
    CAMBIAR CONTRASEÑA
    =============================================*/
    static public function ctrCambiarContrasena() {
        if (isset($_POST["btnCambiarContrasena"])) {
            $currentPassword = $_POST["currentPassword"];
            $newPassword = $_POST["newPassword"];
            $confirmNewPassword = $_POST["confirmNewPassword"];

            // Validar que la nueva contraseña y la confirmación coincidan
            if ($newPassword != $confirmNewPassword) {
                echo'<script>
					swal({
						  type: "error",
						  title: "¡La contraseña actual y la nueva contraseña no coinciden!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {

							window.location = "contrasena";

							}
						})

			  	</script>';
                return;
            }

            // Validar la contraseña actual antes de cambiarla
            $usuarioId = $_SESSION["id"]; // Suponiendo que guardas el ID del usuario en la sesión
            $usuarioActual = ModeloUsuarios::MdlMostrarUsuarios("usuarios", "id", $usuarioId);

            if ($usuarioActual) {
                if (password_verify($currentPassword, $usuarioActual["password"])) {
                    // La contraseña actual es correcta, proceder al cambio

                    $respuesta = ModeloUsuarios::mdlActualizarContrasena($usuarioId, $newPassword);

                    if ($respuesta == "ok") {
                        echo'<script>
					swal({
						  type: "success",
						  title: "¡Contraseña cambiada exitosamente!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {

							window.location = "contrasena";

							}
						})

			  	</script>';
                    } else {
                        echo'<script>
					swal({
						  type: "error",
						  title: "¡Error al cambiar la contraseña!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {

							window.location = "contrasena";

							}
						})

			  	</script>';
                    }
                } else {
                    echo'<script>
					swal({
						  type: "error",
						  title: "¡La contraseña actual es incorrecta!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {

							window.location = "contrasena";

							}
						})

			  	</script>';
                }
            } else {
                echo '<div class="alert alert-danger">Usuario no encontrado.</div>';
            }
        }
    }

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function ctrBorrarUsuario(){

		if(isset($_GET["idUsuario"])){

			$tabla ="usuarios";
			$datos = $_GET["idUsuario"];

			if($_GET["fotoUsuario"] != ""){

				unlink($_GET["fotoUsuario"]);
				rmdir('vistas/img/usuarios/'.$_GET["usuario"]);

			}

			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El usuario ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {

								window.location = "usuarios";

								}
							})

				</script>';

			}		

		}

	}


}