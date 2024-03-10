<?php
class ControladorPlantilla {
    
    static public function ctrPlantilla() {
        
        // Aquí va tu código existente para mostrar la plantilla
        include "vistas/plantilla.php";
        
        // Obtener la lista de eventos (asumo que ya tienes este código en tu controlador)
        $eventos = ControladorEventos::ctrMostrarEventos(null, null);
        
        // Obtener la hora actual en formato Unix Timestamp
        $now = time();
        
        // Array para almacenar las alertas
        $alertas = [];
        
        // Array para almacenar los eventos para los cuales se ha mostrado la alerta
        $eventosConAlertaMostrada = [];
        
        // Recorrer cada evento
        foreach ($eventos as $evento) {
            // Obtener la hora de inicio del evento en formato Unix Timestamp
            $start = strtotime($evento['start_datetime']);
            
            // Calcular el tiempo restante en segundos
            $timeUntilStart = $start - $now;
            
            // Verificar si el evento ya ha comenzado
            $eventoYaComenzo = $now >= $start;
            
            // Si el tiempo restante es menor o igual a 60 segundos y el evento no ha comenzado, agregar la alerta al array
            if ($timeUntilStart <= 60 && !$eventoYaComenzo && !in_array($evento['id'], $eventosConAlertaMostrada)) {
                $alertas[] = [
                    'title' => $evento['title'],
                    'message' => "El evento '{$evento['title']}' está por comenzar."
                ];
                
                // Agregar el ID del evento al array de eventos con alerta mostrada
                $eventosConAlertaMostrada[] = $evento['id'];
            }
        }
        
        // Incluir el script de alerta con los datos de las alertas
        include "vistas/modulos/alerta_evento.php";
        
        // Script para ocultar la alerta después de 15 segundos
        echo "<script>
                $(document).ready(function() {
                    // Función para mostrar la alerta
                    function mostrarAlerta(title, message) {
                        swal({
                            type: 'info',
                            title: title,
                            text: message,
                            showConfirmButton: true,
                            confirmButtonText: 'Cerrar'
                        });
                        // Ocultar la alerta después de 15 segundos
                        setTimeout(function() {
                            $('.swal2-container').fadeOut('fast');
                        }, 15000); // 15 segundos en milisegundos
                    }

                    // Función para mostrar las alertas de eventos
                    function mostrarAlertas(alertas) {
                        alertas.forEach(function(alerta) {
                            mostrarAlerta(alerta.title, alerta.message);
                        });
                    }

                    // Obtener las alertas al cargar la página
                    mostrarAlertas(" . json_encode($alertas) . ");

                    // Refrescar las alertas cada cierto intervalo de tiempo (por ejemplo, cada 1 minuto)
                    setInterval(function() {
                        mostrarAlertas(" . json_encode($alertas) . ");
                    }, 60000); // 60000 milisegundos = 1 minuto
                });
            </script>";
    }
}

?>