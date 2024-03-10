<?php
require_once('db-connect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Manejar la lógica de guardar eventos
    extract($_POST);
    $allday = isset($allday);

    // Validar que la fecha de inicio no sea en el pasado
    $currentDateTime = new DateTime();
    $startDateTimeObj = new DateTime($start_datetime);

    if ($startDateTimeObj < $currentDateTime) {
        echo '<script>
            swal({
                type: "error",
                title: "Error",
                text: "La fecha de inicio no puede ser en el pasado",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"}).then(function(result){
                        if (result.value) {
                            window.location = "eventos";
                        }
                    });
        </script>';
        exit;  // Detener la ejecución si la fecha es inválida
    }
$existingEvents = $conn->query("SELECT * FROM `schedule_list` WHERE
    (`start_datetime` BETWEEN '$start_datetime' AND '$end_datetime') OR
    (`end_datetime` BETWEEN '$start_datetime' AND '$end_datetime')");

if ($existingEvents->num_rows > 0) {
    echo '<script>
        swal({
            type: "error",
            title: "Error",
            text: "Ya existe un evento en este rango de tiempo",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        }).then(function(result){
            if (result.value) {
                window.location = "eventos";
            }
        });
    </script>';
    exit;  // Detener la ejecución si ya existe un evento en el mismo rango de tiempo
}
    if (empty($id)) {
        $sql = "INSERT INTO `schedule_list` (`title`, `description`, `start_datetime`, `end_datetime`) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $description, $start_datetime, $end_datetime);
        $operation = 'save';
    } else {
        $sql = "UPDATE `schedule_list` SET `title` = ?, `description` = ?, `start_datetime` = ?, `end_datetime` = ? WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $title, $description, $start_datetime, $end_datetime, $id);
        $operation = 'update';
    }

    $save = $stmt->execute();
    $stmt->close();

  if ($save) {
            // Envío de correo con PHPMailer
            try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'cajo200007@upemor.edu.mx'; // Coloca tu dirección de correo de Gmail
                    $mail->Password = 'Isabela1414?'; // Coloca tu contraseña de Gmail
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;


                // Obtener lista de correos electrónicos de clientes
                $listaCorreos = ModeloClientes::obtenerCorreosClientes();
                $mail->isHTML(true);

                // Configurar el contenido del correo
                $mail->Subject = 'Nuevo Evento Disponible';
                $mail->Body = "
    <html>
    <head>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f7f7f7;
                color: #333;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 400px;
                margin: 0 auto;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                padding: 20px;
            }

            h2 {
                color: #007bff;
                text-align: center;
                margin-bottom: 20px;
            }

            p {
                margin-bottom: 10px;
                line-height: 1.6;
            }

            strong {
                color: #0056b3;
            }

            .footer {
                margin-top: 20px;
                padding-top: 10px;
                border-top: 1px solid #ddd;
                text-align: center;
                font-size: 12px;
                color: #777;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Nuevo Evento en Vida Divina</h2>
            <p><strong>Evento:</strong> $title</p>
            <p><strong>Descripción:</strong> $description</p>
            <p><strong>Inicio:</strong> $start_datetime</p>
            <p><strong>Fin:</strong> $end_datetime</p>
            <div class='footer'>
                <p>Este mensaje es generado automáticamente. Por favor, no responda a este correo.</p>
            </div>
        </div>
    </body>
    </html>
";


                // Enviar correo a cada cliente
                foreach ($listaCorreos as $correo) {
                    $mail->addAddress($correo);
                    $mail->send();
                    $mail->clearAddresses();
                }

                // Alerta si el evento está por comenzar
                $startTimestamp = strtotime($start_datetime);
                $currentTimestamp = time();
                $timeUntilStart = $startTimestamp - $currentTimestamp;

                if ($timeUntilStart <= 60) {
                    echo '<script>
                            swal({
                                type: "info",
                                title: "El evento está por joojo",
                                text: "El evento '.$title.' está por comenzar en menos de un .",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            });
                        </script>';
                } else {
                    echo '<script>
                            swal({
                                type: "success",
                                title: "Evento Guardado Correctamente",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if (result.value) {
                                    window.location = "eventos";
                                }
                            });
                        </script>';
                }
            } catch (Exception $e) {
                echo 'Error en el envío del correo: ', $mail->ErrorInfo;
            }
        } else {
        echo "<pre>";
        echo "An Error occurred.<br>";
        echo "Error: " . $conn->error . "<br>";
        echo "SQL: " . $sql . "<br>";
        echo "</pre>";
    }

    $conn->close();
}


?>

<style>
    :root {
        --bs-primary: #dd4b39;
        --bs-secondary: #6C757D;
        --bs-success-rgb: 71, 222, 152;
    }

    html,
    body {
        height: 100%;
        width: 100%;
        font-family: 'Apple Chancery', cursive;
    }

    .btn-info.text-light:hover,
    .btn-info.text-light:focus {
        background: var(--bs-secondary);
    }

    table,
    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border-color: #ededed !important;
        border-style: solid;
        border-width: 1px !important;
    }

    .content-wrapper {
        padding: 20px;
    }

    .box {
        border: 1px solid var(--bs-secondary);
    }

    .box-header {
        background-color: var(--bs-primary);
        color: #fff;
        padding: 10px;
    }

    .cardt {
        border: 1px solid var(--bs-secondary);
    }

    .cardt .card-header {
        background-color: var(--bs-primary);
        color: #fff;
        padding: 10px;
    }

    .modal-content {
        border: 1px solid var(--bs-secondary);
    }

    .modal-header {
        background-color: var(--bs-primary);
        color: #fff;
        padding: 10px;
    }

    .modal-footer {
        border-top: 1px solid var(--bs-secondary);
        padding: 10px;
    }

    #calendar {
        height: 100%;
    }

    .card-footer {
        padding: 10px;
    }

    .cardt .card-header {
        background-color: var(--bs-primary);
        color: #fff;
        padding: 10px;
    }

    .cardt .card-title {
        font-size: 1.5rem; /* Ajusta el tamaño de la fuente según tus preferencias */
        margin-bottom: 0; /* Puedes ajustar el margen inferior según sea necesario */
    }
.cardt {
    border: 1px solid var(--bs-secondary);
    border-radius: 10px; /* Añadido para bordes redondeados */
    overflow: hidden; /* Añadido para ocultar esquinas redondeadas del formulario */
}

.cardt .card-body {
    padding: 20px; /* Aumento del espacio interno del formulario */
}

.cardt .form-group {
    margin-bottom: 15px; /* Espaciado entre grupos de formulario */
}

.cardt .form-control {
    border-radius: 5px; /* Bordes redondeados para campos de formulario */
}

.cardt .btn-primary,
.cardt .btn-default {
    border-radius: 5px; /* Bordes redondeados para botones */
    margin-right: 10px; /* Espaciado entre botones */
}
</style>

<body>

    <div class="content-wrapper">

        <section class="content-header">

            <h1>Gestión de eventos</h1>

            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <li class="active">Administrar Eventos</li>
            </ol>

        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Gestión de eventos</h3>
                </div>
                    <div class="container py-5" id="page-container">
        <div class="row">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div>
            <div class="col-md-3">
                <div class="cardt rounded-0 shadow">
                    <div class="card-header bg-gradient bg-primary text-light">
                        <h5 class="card-title">Crear Evento</h5>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <form action="eventos" method="post" id="schedule-form">
                                <input type="hidden" name="id" value="">
                                <div class="form-group mb-2">
                                    <label for="title" class="control-label">Nombre</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="description" class="control-label">Descripción</label>
                                    <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="start_datetime" class="control-label">Inicio</label>
                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="end_datetime" class="control-label">Fin</label>
                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                <!-- Event Details Modal -->
                <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-0">
                            <div class="modal-header rounded-0">
                                <h5 class="modal-title">Detalles de evento</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body rounded-0">
                                <div class="container-fluid">
                                    <dl>
                                        <dt class="text-muted">Nombre</dt>
                                        <dd id="title" class="fw-bold fs-4"></dd>
                                        <dt class="text-muted">Descripción</dt>
                                        <dd id="description" class=""></dd>
                                        <dt class="text-muted">Inicio</dt>
                                        <dd id="start" class=""></dd>
                                        <dt class="text-muted">Fin</dt>
                                        <dd id="end" class=""></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="modal-footer rounded-0">
                                <div class="text-end">
                                    <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Editar</button>
                                    <a href="events" class="btn btn-danger btn-sm rounded-0">Eliminar</a>
                                    <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.termina -->

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                Footer
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->
        <?php
        $schedules = $conn->query("SELECT * FROM `schedule_list`");
        $sched_res = [];
        foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
            $row['sdate'] = date("F d, Y h:i A", strtotime($row['start_datetime']));
            $row['edate'] = date("F d, Y h:i A", strtotime($row['end_datetime']));
            $sched_res[$row['id']] = $row;
        }
        ?>
        <?php
        if (isset($conn)) $conn->close();
        ?>


</body>

</html>
