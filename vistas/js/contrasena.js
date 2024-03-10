$(document).ready(function() {
    $("#btnCambiarContrasena").click(function() {
        var currentPassword = $("#currentPassword").val();
        var newPassword = $("#newPassword").val();
        var confirmNewPassword = $("#confirmNewPassword").val();

        // Validación básica de campos
        if (currentPassword === '' || newPassword === '' || confirmNewPassword === '') {
            $("#mensajeCambioContrasena").html('<div class="alert alert-danger">Todos los campos son obligatorios.</div>');
            return;
        }

        // Validación de que las nuevas contraseñas coincidan
        if (newPassword !== confirmNewPassword) {
            $("#mensajeCambioContrasena").html('<div class="alert alert-danger">Las nuevas contraseñas no coinciden.</div>');
            return;
        }

        // Realizar la solicitud AJAX al servidor para cambiar la contraseña
        $.ajax({
            type: 'POST',
            url: 'ruta_a_tu_controlador/funcion_para_cambiar_contrasena',
            data: {
                currentPassword: currentPassword,
                newPassword: newPassword
            },
            success: function(response) {
                // Manejar la respuesta del servidor
                if (response === 'ok') {
                    $("#mensajeCambioContrasena").html('<div class="alert alert-success">Contraseña cambiada exitosamente.</div>');
                } else {
                    $("#mensajeCambioContrasena").html('<div class="alert alert-danger">Error al cambiar la contraseña.</div>');
                }
            }
        });
    });
});
</script>
