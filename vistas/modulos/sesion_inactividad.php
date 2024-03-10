<?php

$tiempoMaximoInactividad =  1 * 60;

if (isset($_SESSION['usuario']) && isset($_SESSION['perfil']) && isset($_SESSION['ultima_actividad'])) {
    // Calcular el tiempo transcurrido desde la última actividad
    $tiempoTranscurrido = time() - $_SESSION['ultima_actividad'];

    // Verificar si se ha superado el tiempo máximo de inactividad
    if ($tiempoTranscurrido > $tiempoMaximoInactividad) {
        // Cerrar la sesión
        session_unset();
        session_destroy();

        // Redirigir a la página de inicio de sesión u otra página de tu elección
        header("Location: login");
        exit();
    }
}

// Actualizar la última actividad en cada solicitud
$_SESSION['ultima_actividad'] = time();
?>
