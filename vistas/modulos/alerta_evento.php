<?php
if (!empty($alertas)) {
    echo '<script>';
    foreach ($alertas as $alerta) {
        echo 'swal({
            type: "info",
            title: "El evento está por comenzar",
            text: "' . $alerta['message'] . '",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        });';
    }
    echo '</script>';
}
?>
