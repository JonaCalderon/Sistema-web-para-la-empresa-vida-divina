
<?php 
require_once('db-connect.php');

if (!isset($_GET['id'])) {
    echo "<script> alert('Id. de programa no definido.'); window.location = 'eventos'; </script>";
    $conn->close();
    exit;
}

$delete = $conn->query("DELETE FROM `schedule_list` WHERE id = '{$_GET['id']}'");

if ($delete) {
        echo "<script> alert('Evento Eliminado Correctamente.'); windows.location.('eventos') </script>";
} else {
    echo "<pre>";
    echo "An Error occurred.<br>";
    echo "Error: " . $conn->error . "<br>";
    echo "SQL: " . $sql . "<br>";
    echo "</pre>";
}

$conn->close();
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
                          <div class="cardt rounded- shadow">
    <div class="card-header bg-gradient bg-primary text-light text-center">
        <h3 class="card-title fw-bold">Crear Evento</h3>
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
                                    <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Eliminar</button>
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
