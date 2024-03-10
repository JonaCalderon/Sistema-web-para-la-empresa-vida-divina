<?php


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

echo '<pre>';
var_dump($_SESSION);
echo '</pre>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se ha enviado el formulario de restablecimiento de contraseña
    if (isset($_POST['token'], $_POST['new_password'], $_POST['confirm_password'])) {
        $token = $_POST['token'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        // Verifica si las contraseñas coinciden
        if ($newPassword === $confirmPassword) {
            // Verifica si se proporcionó un token válido
            if (!empty($token)) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE usuarios SET password = '$hashedPassword' WHERE token_recuperacion = '$token'";

                // Ejecuta la consulta y verifica si fue exitosa
                if ($conn->query($sql) === TRUE) {
                    echo 
                    ' <div style="background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <p style="color: #155724; margin-bottom: 10px;">
                Contraseña restablecida exitosamente. Ahora puedes <a href="../../login" style="color: #155724; text-decoration: underline;">iniciar sesión</a>.
            </p>
        </div>';
                } else {
                    echo ' <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin: 10px 0;">
                    Error al restablecer la contraseña: ' . $conn->error;
                }
            } else {
                echo ' <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin: 10px 0;">
                Token no válido. Por favor, solicita una nueva recuperación de contraseña.';
            }
        } else {
            echo ' <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin: 10px 0;">
            Las contraseñas no coinciden. Vuelve a intentarlo.';
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restablecer Contraseña</title>

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
      <p class="recovery-title"><i class="fa fa-key"></i> Restablecer Contraseña</p>

      <form method="post" action="restablecer.php">
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Nueva Contraseña" name="new_password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
          <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? $_GET['token'] : ''; ?>">

          <input type="password" class="form-control" placeholder="Confirmar Nueva Contraseña" name="confirm_password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Restablecer Contraseña <i class="fa fa-check"></i></button>
          </div>
        </div>
      </form>
    </div>
  </div>

</body>

</html>


