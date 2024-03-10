$(document).ready(function() {
    $("#btnCambiarContrasena").on("click", function() {
        var currentPassword = $("#currentPassword").val();
        var newPassword = $("#newPassword").val();
        var confirmNewPassword = $("#confirmNewPassword").val();

        // Realiza una solicitud AJAX al servidor
        $.ajax({
            type: "POST",
            url: "contrasena", // Reemplaza con el nombre de tu archivo PHP
            data: {
                currentPassword: currentPassword,
                newPassword: newPassword,
                confirmNewPassword: confirmNewPassword
            },
            success: function(response) {
                $("#mensajeCambioContrasena").html(response);
            }
        });
    });
});
</script>
