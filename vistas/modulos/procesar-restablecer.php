<?php
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera las contraseñas desde el formulario
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Verifica si las contraseñas coinciden
    if ($newPassword === $confirmPassword) {
        // Recupera el token de la URL
       // Recupera el token de la URL
    $token = isset($_GET['token']) ? $_GET['token'] : '';


        // Muestra información para depuración
        echo 'Token obtenido de la URL: ' . $token . '<br>';
        echo 'URL Completa: ' . $_SERVER['REQUEST_URI'] . '<br>';


        // Verifica si se proporcionó un token válido
        if (!empty($token)) {
           
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET password = '$hashedPassword' WHERE token_recuperacion = '$token'";
            // Ejecuta la consulta y verifica si fue exitosa

            echo 'Contraseña restablecida exitosamente. Ahora puedes <a href="../../login">iniciar sesión</a>.';
        } else {
            echo 'Token no válido. Por favor, solicita una nueva recuperación de contraseña.';
        }
    } else {
        echo 'Las contraseñas no coinciden. Vuelve a intentarlo.';
    }
} else {
    // Si alguien intenta acceder directamente a este archivo sin enviar el formulario, redirige a la página de recuperación de contraseña
    header("Location: restablecer.php");
    exit();
}
?> 


