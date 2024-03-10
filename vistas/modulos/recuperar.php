<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "basedatosvd";

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Verifica si el correo existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE correo = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Genera un token único y lo almacena en la base de datos
        $token = bin2hex(random_bytes(32));

        $sql = "UPDATE usuarios SET token_recuperacion = '$token', expiracion_token = NOW() + INTERVAL 1 HOUR WHERE correo = '$email'";

        $conn->query($sql);

        // Configuración de PHPMailer para Gmail
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cajo200007@upemor.edu.mx'; // Coloca tu dirección de correo de Gmail
        $mail->Password = 'Isabela1414?'; // Coloca tu contraseña de Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('cajo200007u@upemor.edu.mx', 'VidaDivina'); // Coloca tu dirección de correo y nombre
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Restablecer Contraseña';
       $mail->Body = '<div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif;">

                    <p style="font-size: 18px; color: #333; text-align: center; margin-bottom: 20px;">Restablecimiento de Contraseña</p>

                    <p style="font-size: 16px; color: #555; text-align: center; margin-bottom: 30px;">Estimado usuario de Vida Divina,</p>

                    <p style="font-size: 16px; color: #333; text-align: center; margin-bottom: 20px;">Hemos recibido una solicitud para restablecer tu contraseña. Haz clic en el siguiente enlace para proceder:</p>

                    <p style="text-align: center; margin-bottom: 30px;">
                        <a style="display: inline-block; padding: 15px 30px; background-color: #4CAF50; color: #fff; text-decoration: none; border-radius: 5px;" href="http://localhost/VidaDivina/vistas/modulos/restablecer.php?token=' . urlencode($token) . '">Restablecer Contraseña</a>
                    </p>

                    <p style="font-size: 16px; color: #555; text-align: center; margin-bottom: 30px;">Si no has solicitado este cambio, por favor ignora este correo.</p>

                    <p style="font-size: 16px; color: #555; text-align: center;">Gracias por confiar en Vida Divina.</p>

                </div>';



        // Enviar el correo
       if ($mail->send()) {
    // Éxito: El correo se envió correctamente
    echo '
        <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin: 10px 0;">
            Hemos enviado un correo con instrucciones para restablecer tu contraseña. Por favor, revisa tu bandeja de entrada.
        </div>';
} elseif ($algo) {  // Asegúrate de reemplazar $algo con la condición que necesitas evaluar
    // Manejar otra condición si es necesario
    echo '
        <div style="background-color: #ff0000; color: #ffffff; border: 1px solid #c3e6cb; padding: 10px; margin: 10px 0;">
            Otra condición específica.
        </div>';
} else {
    // Error al enviar el correo o correo no registrado
    echo '
        <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin: 10px 0;">
            Lo sentimos, no pudimos enviar el correo. Error: ' . $mail->ErrorInfo . '
        </div>';

}
}
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">


<head>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar Contraseña</title>

  <style>
    body {
      background: #f0f8ff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    #back {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      background: url(../img/plantilla/back.png);
      background-size: cover;
      overflow: hidden;
      z-index: -1;
    }

    .recovery-box {
      width: 400px;
      margin: 10% auto;
      border-radius: 10px;
      background: #fff;
      box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.2);
    }

    .recovery-logo {
      text-align: center;
      padding: 30px 20px 20px 20px;
    }

    .recovery-logo img {
      width: 80%; /* Aumenté el tamaño del logo */
      max-width: 200px;
    }

    .recovery-box-body {
      padding: 20px;
      color: #333;
    }

    .form-group {
      position: relative;
      margin-bottom: 20px;
    }

    .form-control {
      box-sizing: border-box;
      width: 100%;
      padding: 10px;
      font-size: 14px;
      border-radius: 5px;
      border: 1px solid #ccc;
      background-color: #f5f5f5;
      color: #333;
    }

    .form-control-feedback {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      color: #555;
    }

    .btn-primary {
      background-color: #dd4b39; /* Cambié el color del botón */
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 15px 20px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
      display: block;
      margin: 0 auto;
    }

    .btn-primary:hover {
      background-color: #cc3f31; /* Cambié el color de hover */
    }

    .recovery-title {
      text-align: center;
      font-size: 24px;
      color: #3498db;
      margin-bottom: 20px;
    }

    .forgot-password-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #3498db;
      text-decoration: underline;
      font-size: 18px;
    }
  </style>
</head>

<body>

  <div id="back"></div>

  <div class="recovery-box">
    <div class="recovery-logo">
      <img src="../img/plantilla/logo-blanco-bloque.png" class="img-responsive">
    </div>

    <div class="recovery-box-body">
      <p class="recovery-title"><i class="fa fa-key"></i> Recuperar Contraseña</p>

<form method="post" action="recuperar.php">


 <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Correo Electrónico" name="email" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar Solicitud <i class="fa fa-paper-plane"></i></button>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <a href="../../login" class="forgot-password-link">¿Recordaste tu contraseña? Inicia sesión</a>
          </div>
        </div>
      
      </form>
    </div>
  </div>

</body>

</html>
