<?php
include 'Connet.php';

$backupFiles = glob(BACKUP_PATH . '*.sql');
rsort($backupFiles);

if (!empty($backupFiles)) {
    $latestBackup = $backupFiles[0];
    echo "Último archivo de respaldo encontrado: " . $latestBackup . "<br>";

    $sql = file_get_contents($latestBackup);
    $totalErrors = 0;
    set_time_limit(60);
    $con = mysqli_connect(SERVER, USER, PASS, BD);
    $con->query("SET FOREIGN_KEY_CHECKS=0");

    if ($con->multi_query($sql)) {
        do {
            if ($result = $con->store_result()) {
                // Bucle para procesar los resultados si es necesario
                $result->free();
            }
        } while ($con->next_result());
    } else {
        $totalErrors++;
        echo "Error al ejecutar las consultas: " . $con->error . "<br>";
    }

    $con->query("SET FOREIGN_KEY_CHECKS=1");
    $con->close();

    if ($totalErrors > 0) {
        echo "Ocurrió un error inesperado, no se pudo hacer la restauración completamente";
    } else {
        echo "Restauración realizada con éxito";
    }
} else {
    echo "No se encontraron archivos de respaldo en la ruta especificada.";
}
?>
