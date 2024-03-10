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
        echo 'Token generado: ' . $token;

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
        $mail->Body = 'Haz clic en el siguiente enlace para restablecer tu contraseña: 
              <a href="http://localhost/VidaDivina/vistas/modulos/restablecer.php?token=' . urlencode($token) . '">Restablecer Contraseña</a>';





        // Enviar el correo
        if ($mail->send()) {
            echo 'Se ha enviado un correo con instrucciones para restablecer la contraseña. Por favor, revisa tu bandeja de entrada.';
        } else {
            echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
        }
    } else {
        echo 'El correo electrónico no está registrado en nuestro sistema.';
    }
}

$conn->close();
?>
