<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class ControladorDescuentos{

	static public function ctrCrearDescuentos() {
    if(isset($_POST["nuevaDescripcionDescuento"])) {
        // Validar el formato de las fechas
        if (
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcionDescuento"]) &&
            preg_match('/^[0-9]+$/', $_POST["nuevoDescuento"]) &&
            strtotime($_POST["nuevoInicio"]) !== false &&  // Verificar si la fecha de inicio es válida
            strtotime($_POST["nuevoFinal"]) !== false     // Verificar si la fecha final es válida
        ) {
            // Validar si la fecha de inicio es anterior a la fecha actual
            $fechaInicio = strtotime($_POST["nuevoInicio"]);
            $fechaActual = strtotime(date("Y-m-d"));

            if($fechaInicio < $fechaActual) {
                echo'<script>
                        swal({
                            type: "error",
                            title: "¡La fecha de inicio no puede ser anterior a la fecha actual!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "descuentos";
                            }
                        });
                    </script>';
                return;
            }

            // Validar si el descuento ya existe
            $descuentoExistente = ModeloDescuentos::mdlMostrarDescuentos("descuentos", "descuento", $_POST["nuevoDescuento"]);
            if($descuentoExistente) {
                echo'<script>
                        swal({
                            type: "error",
                            title: "¡El descuento ya existe!",
                            text: "Por favor, elija otro descuento.",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "descuentos";
                            }
                        });
                    </script>';
                return;
            }

            // Agregamos un echo para verificar la fecha de inicio antes de formatearla
            echo "Fecha de inicio recibida: " . $_POST["nuevoInicio"] . "<br>";

            // Validar y formatear la fecha de inicio
            $fechaInicioFormateada = date('Y-m-d', strtotime($_POST["nuevoInicio"]));

            // Agregamos otro echo para verificar la fecha de inicio después de formatearla
            echo "Fecha de inicio formateada: " . $fechaInicioFormateada . "<br>";

            // Utiliza $fechaInicioFormateada en tus consultas a la base de datos
            $tabla = "descuentos";

            $datos = array(
                "id_producto" => $_POST["nuevaDescripcion"],
                "descripcion" => $_POST["nuevaDescripcionDescuento"],
                "descuento" => $_POST["nuevoDescuento"],
                "fecha_inicio" => $fechaInicioFormateada,
                "fecha_final" => $_POST["nuevoFinal"]
            ); 
			   	$respuesta = ModeloDescuentos::mdlIngresarDescuentos( $tabla, $datos);
			   	if($respuesta == "ok"){

                $actualizarProducto = ModeloProductos::mdlActualizarProducto("productos", "descuento_activo", 1, $_POST["nuevaDescripcion"]);

			   	// Obtener lista de correos electrónicos de clientes
        $listaCorreos = ModeloClientes::obtenerCorreosClientes();


        // Configurar el correo para el descuento
        $mail = new PHPMailer(true);
        $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'cajo200007@upemor.edu.mx'; // 
                    $mail->Password = 'Isabela1414?'; // 
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
        // ... Configuración del servidor SMTP ...

        // Configurar el contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo Descuento Disponible';
        $mail->Body = "
   <html>

<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        strong {
            color: #0056b3;
        }

        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class='container'>
        <h2>Nuevo Descuento Disponible en Vida Divina</h2>
        <p><strong>Producto:</strong> {$_POST['nuevaDescripcion']}</p>
        <p><strong>Descripción:</strong> {$_POST['nuevaDescripcionDescuento']}</p>
        <p><strong>Descuento:</strong> {$_POST['nuevoDescuento']}%</p>
        <p><strong>Fecha de Inicio:</strong> {$_POST['nuevoInicio']}</p>
        <p><strong>Fecha Final:</strong> {$_POST['nuevoFinal']}</p>
        <div class='footer'>
            <p>Este mensaje es generado automáticamente. Por favor, no responda a este correo.</p>
        </div>
    </div>
</body>

</html>

";


        // Enviar correo a cada cliente
        foreach ($listaCorreos as $correo) {
            $mail->addAddress($correo);
            $mail->send();
            $mail->clearAddresses();
        }

					echo'<script>

					swal({
						  type: "success",
						  title: "El Descuento ha sido guardado correctamente",
 						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "descuentos";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El Descuento no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "descuentos";

							}
						})

			  	</script>';



			}

		}

	}


	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/

	static public function ctrMostrarDescuentos($item, $valor){

		$tabla = "descuentos";

		$respuesta = ModeloDescuentos::mdlMostrarDescuentos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	EDITAR CLIENTE
	=============================================*/

	static public function ctrEditarDescuentos(){

		if(isset($_POST["editarDescripcion"])){

			if (
    preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"]) &&
    preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcionDescuentos"]) &&
    preg_match('/^[0-9]+$/', $_POST["editarDescuento"]) &&
    preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $_POST["editarInicio"]) &&
    preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $_POST["editarFinal"])
) {
    $tabla = "descuentos";

    $datos = array(
    	    "id" => $_POST["idDescuento"],

        "id_producto" => $_POST["editarDescripcion"],
        "descripcion" => $_POST["editarDescripcionDescuentos"],
        "descuento" => $_POST["editarDescuento"],
        "fecha_inicio" => $_POST["editarInicio"],
        "fecha_final" => $_POST["editarFinal"]
    );



			   	$respuesta = ModeloDescuentos::mdlEditarDescuentos($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El Descuento ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "descuentos";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El Descuento no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "descuentos";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/

	static public function ctrEliminarDescuentos(){

		if(isset($_GET["idDescuento"])){

			$tabla ="descuentos";
			$datos = $_GET["idDescuento"];

			$respuesta = ModeloDescuentos::mdlEliminarDescuentos($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El Descuento ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result){
								if (result.value) {

								window.location = "descuentos";

								}
							})

				</script>';

			}		

		}

	}

}

