<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class ControladorClientes{

	/*=============================================
	CREAR CLIENTES
	=============================================*/

	static public function ctrCrearCliente(){

		if(isset($_POST["nuevoCliente"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCliente"]) &&
			   preg_match('/^[0-9]+$/', $_POST["nuevoDocumentoId"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["nuevoEmail"]) && 
			   preg_match('/^[()\-0-9 ]+$/', $_POST["nuevoTelefono"]) && 
			   preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevaDireccion"])){

			   	$tabla = "clientes";
  $existeDocumento = self::verificarExistenciaCliente("documento", $_POST["nuevoDocumentoId"]);
        $existeEmail = self::verificarExistenciaCliente("email", $_POST["nuevoEmail"]);
        $existeNombre = self::verificarExistenciaCliente("nombre", $_POST["nuevoCliente"]);


                if (!$existeDocumento && !$existeEmail && !$existeNombre) {

			   	$datos = array("nombre"=>$_POST["nuevoCliente"],
						   		"apellidoPa"=>$_POST["nuevoapellidopa"],
						   		"apellidoMa"=>$_POST["nuevoapellidoma"],
					           "documento"=>$_POST["nuevoDocumentoId"],
					           "email"=>$_POST["nuevoEmail"],
					           "telefono"=>$_POST["nuevoTelefono"],
					           "direccion"=>$_POST["nuevaDireccion"],
					           "fecha_nacimiento"=>$_POST["nuevaFechaNacimiento"]);

			   	$respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);

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
                    $mail->addAddress($_POST["nuevoEmail"]); // Utiliza el correo ingresado en el formulario

                    $mail->isHTML(true);
                    $mail->Subject = 'Bienvenido a VidaDivina';
$mail->Body = '
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            .header {
                text-align: center;
            }
            .header img {
                max-width: 100%;
                height: auto;
            }
            .content {
                margin-top: 20px;
                color: #555555;
            }
            .footer {
                margin-top: 20px;
                text-align: center;
                color: #777777;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Bienvenido a Nuestra Comunidad</h1>
            </div>
            <div class="content">
                <p>¡Hola ' . $_POST["nuevoCliente"] . '!</p>
                <p>Gracias por formar parte de nuestros preciados clientes. Estamos encantados de tenerte con nosotros.</p>
                <p>En Nuestra Comunidad, te mantendremos informado sobre ofertas, novedades y eventos especiales.</p>
            </div>
            <div class="footer">
                <p>¡Gracias por confiar en nosotros!</p>
            </div>
        </div>
    </body>
    </html>';

                    $mail->send();

  echo'<script>
                            swal({
                                type: "success",
                                title: "El cliente ha sido guardado correctamente",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if (result.value) {
                                    window.location = "clientes";
                                }
                            });
                        </script>';
                    }
                } else {
                    echo '<script>
                        swal({
                            type: "error",
                            title: "¡Ya existe un cliente con el mismo documento, correo electrónico o nombre!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "clientes";
                            }
                        });
                    </script>';
                }
            } else {
                echo '<script>
                    swal({
                        type: "error",
                        title: "¡El cliente no puede ir vacío o llevar caracteres especiales!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "clientes";
                        }
                    });
                </script>';
            }
        }
    }

    static public function verificarExistenciaCliente($campo, $valor){
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as total FROM clientes WHERE $campo = :valor");
        $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado["total"] > 0;
    }
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/

	static public function ctrMostrarClientes($item, $valor){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);

		return $respuesta;

	}

	
public function ctrDescargarReporteComprador(){

    if(isset($_GET["reporte"])){

        $tabla = "clientes";

        if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

            $clientes = ModeloClientes::mdlRangoFechasVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

        }else{

            $item = null;
            $valor = null;

            $clientes = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);

        }

        // Definir el nombre del archivo
        $Name = $_GET["reporte"].'.xls';

    // Configurar el encabezado para la descarga del archivo Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="'.$Name.'"');

    // Iniciar el contenido del archivo Excel
    echo utf8_decode("
        <table border='1' style='border-collapse: collapse; width: 100%;'>
            <caption><h2>Reporte de Compradores</h2></caption>
            <tr> 
                <th style='font-weight:bold; border:1px solid #000000;'>NOMBRE</th> 
                <th style='font-weight:bold; border:1px solid #000000;'>Apellido Pa</th> 
                <th style='font-weight:bold; border:1px solid #000000;'>Apellido Ma</th> 
                <th style='font-weight:bold; border:1px solid #000000;'>DOCUMENTO</th>
                <th style='font-weight:bold; border:1px solid #000000;'>CORREO</th>
                <th style='font-weight:bold; border:1px solid #000000;'>COMPRAS</th>
                <th style='font-weight:bold; border:1px solid #000000;'>ULTIMA COMPRA</th>
                <th style='font-weight:bold; border:1px solid #000000;'>FECHA</th>      
            </tr>
    ");

    // Recorrer los datos y agregarlos a la tabla del archivo Excel
    foreach ($clientes as $row => $item){
        $clientes = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);

        echo utf8_decode("
            <tr>
                <td style='border:1px solid #000000;'>".$item["nombre"]."</td>
                <td style='border:1px solid #000000;'>".$item["apellidoPa"]."</td>
                <td style='border:1px solid #000000;'>".$item["apellidoMa"]."</td>
                <td style='border:1px solid #000000;'>".$item["documento"]."</td>
                <td style='border:1px solid #000000;'>".$item["email"]."</td>
                <td style='border:1px solid #000000;'>".$item["compras"]."</td>
                <td style='border:1px solid #000000;'>".$item["ultima_compra"]."</td>
                <td style='border:1px solid #000000;'>".$item["fecha"]."</td>       
            </tr>
        ");
    }

    // Finalizar la tabla del archivo Excel
    echo "</table>";
    }
}
public function ctrDescargarReporteClientesNuevos(){

    if(isset($_GET["reporte"])){

        $tabla = "clientes";

        // Calcular la fecha hace 7 días
        $fechaHoy = date("Y-m-d H:i:s");
        $fechaHace7Dias = date("Y-m-d H:i:s", strtotime("-7 days", strtotime($fechaHoy)));

        // Obtener clientes registrados en los primeros 7 días
        $clientes = ModeloClientes::mdlClientesNuevos($tabla, $fechaHace7Dias);

        // Definir el nombre del archivo
        $Name = $_GET["reporte"].'.xls';

        // Configurar el encabezado para la descarga del archivo Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$Name.'"');

        // Iniciar el contenido del archivo Excel
        echo utf8_decode("
            <table border='1' style='border-collapse: collapse; width: 100%;'>
                <caption><h2>Reporte de Clientes Nuevos</h2></caption>
                <tr> 
                    <th style='font-weight:bold; border:1px solid #000000;'>NOMBRE</th> 
                    <th style='font-weight:bold; border:1px solid #000000;'>Apellido Pa</th> 
                    <th style='font-weight:bold; border:1px solid #000000;'>Apellido Ma</th> 
                    <th style='font-weight:bold; border:1px solid #000000;'>DOCUMENTO</th>
                    <th style='font-weight:bold; border:1px solid #000000;'>CORREO</th>
                    <th style='font-weight:bold; border:1px solid #000000;'>TELEFONO</th>
                    <th style='font-weight:bold; border:1px solid #000000;'>DIRECCION</th>
                    <th style='font-weight:bold; border:1px solid #000000;'>FECHA DE INGRESO</th>      
                </tr>
        ");

        // Recorrer los datos y agregarlos a la tabla del archivo Excel
        foreach ($clientes as $row => $cliente){
            echo utf8_decode("
                <tr>
                    <td style='border:1px solid #000000;'>".$cliente["nombre"]."</td>
                    <td style='border:1px solid #000000;'>".$cliente["apellidoPa"]."</td>
                    <td style='border:1px solid #000000;'>".$cliente["apellidoMa"]."</td>
                    <td style='border:1px solid #000000;'>".$cliente["documento"]."</td>
                    <td style='border:1px solid #000000;'>".$cliente["email"]."</td>
                    <td style='border:1px solid #000000;'>".$cliente["telefono"]."</td>
                    <td style='border:1px solid #000000;'>".$cliente["direccion"]."</td>
                    <td style='border:1px solid #000000;'>".$cliente["fecha"]."</td>       
                </tr>
            ");
        }

        // Finalizar la tabla del archivo Excel
        echo "</table>";
    }
}


	/*=============================================
	EDITAR CLIENTE
	=============================================*/

	static public function ctrEditarCliente(){

		if(isset($_POST["editarCliente"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCliente"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarDocumentoId"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["editarEmail"]) && 
			   preg_match('/^[()\-0-9 ]+$/', $_POST["editarTelefono"]) && 
			   preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["editarDireccion"])){

			   	$tabla = "clientes";

			   	$datos = array("id"=>$_POST["idCliente"],
			   				   "nombre"=>$_POST["editarCliente"],
			   				   	"apellidoPa"=>$_POST["editarapellidopa"],
			   				   "apellidoMa"=>$_POST["editarapellidoma"],
					           "documento"=>$_POST["editarDocumentoId"],
					           "email"=>$_POST["editarEmail"],
					           "telefono"=>$_POST["editarTelefono"],
					           "direccion"=>$_POST["editarDireccion"],
					           "fecha_nacimiento"=>$_POST["editarFechaNacimiento"]);

			   	$respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El cliente ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "clientes";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El cliente no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "clientes";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/

	static public function ctrEliminarCliente(){

		if(isset($_GET["idCliente"])){

			$tabla ="clientes";
			$datos = $_GET["idCliente"];

			$respuesta = ModeloClientes::mdlEliminarCliente($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El cliente ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result){
								if (result.value) {

								window.location = "clientes";

								}
							})

				</script>';

			}		

		}

	}

}




	
