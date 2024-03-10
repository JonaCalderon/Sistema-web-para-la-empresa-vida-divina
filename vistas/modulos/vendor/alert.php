<?php
function mostrarAlerta($type, $title, $message) {
    echo '<script>
        swal({
            type: "'.$type.'",
            title: "'.$title.'",
            text: "'.$message.'",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        });
    </script>';
}
?>
