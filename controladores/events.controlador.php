<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControladorEventos{

  /*=============================================
    CREAR EVENTOS
    =============================================*/

    static public function ctrCrearEvento(){

        if(isset($_POST["nuevoEvento"])){

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoDescripcion"]) &&
               preg_match('/^[0-9]+$/', $_POST["nuevoInicio"]) &&
               preg_match('/^[0-9]+$/', $_POST["nuevoFinal"])){ // Cambiado el patrón de la expresión regular

                $tabla = "schedule_list";

                $datos = array(
                    "title" => $_POST["nuevoEvento"],
                    "description" => $_POST["nuevoDescripcion"],
                     "start_datetime" => date('Y-m-d H:i:s', strtotime($_POST["nuevoInicio"])),
                 "end_datetime" => date('Y-m-d H:i:s', strtotime($_POST["nuevoFinal"]))

                );

                $respuesta = ModeloEventos::mdlIngresarEvento($tabla, $datos);

                if($respuesta == "ok"){
                    
                    // Calcular el tiempo restante hasta el inicio del evento
                    $startTimestamp = strtotime($_POST["nuevoInicio"]);
                    $currentTimestamp = time();
                    $timeUntilStart = $startTimestamp - $currentTimestamp;

                    // Si el tiempo restante es menor o igual a 60 segundos (1 minuto), mostrar la alerta
                    if ($timeUntilStart <= 60) {
                        echo '<script>
                                swal({
                                    type: "info",
                                    title: "El evento está por comenzar",
                                    text: "El evento '.$_POST["nuevoEvento"].' está por comenzar en menos de un minuto.",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                });
                            </script>';
                    } else {
                        // Si el tiempo restante es mayor a 60 segundos, redirigir a la página de eventos
                        echo '<script>
                                swal({
                                    type: "success",
                                    title: "El evento ha sido guardado correctamente",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                }).then(function(result){
                                    if (result.value) {
                                        window.location = "events";
                                    }
                                });
                            </script>';
                    }
                } else {
                    echo '<script>
                            swal({
                                type: "error",
                                title: "¡Ya existe un evento con el mismo título!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if (result.value) {
                                    window.location = "events";
                                }
                            });
                        </script>';
                }
            } else {
                echo '<script>
                        swal({
                            type: "error",
                            title: "¡El formato de los datos ingresados es incorrecto!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "events";
                            }
                        });
                    </script>';
            }
        }
    }
/*=============================================
MOSTRAR EVENTOS
=============================================*/

static public function ctrMostrarEventos($item, $valor){

    $tabla = "schedule_list";

    $respuesta = ModeloEventos::mdlMostrarEventos($tabla, $item, $valor);

    // Obtener la fecha y hora actual
    $now = date('Y-m-d H:i:s');

    foreach ($respuesta as $evento) {
        // Calcular la fecha y hora límite para notificar (por ejemplo, 30 minutos antes del inicio del evento)
        $notificationLimit = date('Y-m-d H:i:s', strtotime($evento['start_datetime']) - (1 * 60)); // Resta 30 minutos al inicio del evento

        // Comparar con la fecha y hora actual
        if ($now >= $notificationLimit) {
            // Llamar a la función para mostrar la alerta
            ControladorEventos::mostrarAlerta("warning", "Atención", "El evento '" . $evento['title'] . "' está a punto de comenzar");
        }
    }

    return $respuesta;
}

/*=============================================
MOSTRAR ALERTA
=============================================*/

static public function mostrarAlerta($type, $title, $message) {
    echo '<script>
            contadorNotificaciones++;
            document.getElementById("notification-count").innerText = contadorNotificaciones;
            var notificationContent = document.getElementById("notification-content");
            var newNotification = document.createElement("li");
            newNotification.innerHTML = "<a href=\"#\">" + "' . $title . '" + "<br><small>" + "' . $message . '" + "</small></a>";
            notificationContent.appendChild(newNotification);
            newNotification.addEventListener("click", function(event) {
                event.preventDefault();
                swal({
                    type: "' . $type . '",
                    title: "' . $title . '",
                    text: "' . $message . '",
                    icon: "' . $type . '",
                    button: "Entendido"
                });
            });
          </script>';
}


    
    /*=============================================
    EDITAR EVENTO
    =============================================*/

    static public function ctrEditarEvento(){

        if(isset($_POST["editarEvento"])){

            if(isset($_POST["nuevoEvento"])){

                if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoDescripcion"]) &&
                   preg_match('/^[0-9]+$/', $_POST["nuevoInicio"]) &&
                   preg_match('/^[0-9]+$/', $_POST["nuevoFinal"])){ // Cambiado el patrón de la expresión regular

                    $tabla = "schedule_list";

                    $datos = array(
                        "title" => $_POST["nuevoEvento"],
                        "description" => $_POST["nuevoDescripcion"],
                        "start_datetime" => date('Y-m-d H:i:s', strtotime($_POST["nuevoInicio"])),
					    "end_datetime" => date('Y-m-d H:i:s', strtotime($_POST["nuevoFinal"]))
					);
                    $respuesta = ModeloEventos::mdlEditarEvento($tabla, $datos);

                    if($respuesta == "ok"){

                        echo '<script>
                                swal({
                                      type: "success",
                                      title: "El evento ha sido editado correctamente",
                                      showConfirmButton: true,
                                      confirmButtonText: "Cerrar"
                                      }).then(function(result){
                                                if (result.value) {
    
                                                window.location = "events";
    
                                                }
                                            })
    
                                </script>';

                    }

                } else {

                    echo '<script>
                            swal({
                                  type: "error",
                                  title: "¡El formato de los datos ingresados es incorrecto!",
                                  showConfirmButton: true,
                                  confirmButtonText: "Cerrar"
                                  }).then(function(result){
                                        if (result.value) {
    
                                        window.location = "events";
    
                                        }
                                    })
    
                            </script>';

                }

            }

        }

    }

    /*=============================================
    ELIMINAR EVENTO
    =============================================*/

    static public function ctrEliminarEvento(){

        if(isset($_GET["idEvento"])){

            $tabla ="schedule_list";
            $datos = $_GET["idEvento"];

            $respuesta = ModeloEventos::mdlEliminarEvento($tabla, $datos);

            if($respuesta == "ok"){

                echo '<script>
                        swal({
                              type: "success",
                              title: "El evento ha sido eliminado correctamente",
                              showConfirmButton: true,
                              confirmButtonText: "Cerrar",
                              closeOnConfirm: false
                              }).then(function(result){
                                        if (result.value) {
    
                                        window.location = "events";
    
                                        }
                                    })
    
                        </script>';

            }       

        }

    }

}

?>
