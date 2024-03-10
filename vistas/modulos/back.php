<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tu Título</title>
    <!-- Agrega SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

<?php
include 'Connet.php';

$day = date("d");
$mont = date("m");
$year = date("Y");
$hora = date("H-i-s");
$fecha = $day . '_' . $mont . '_' . $year;
$DataBASE = $fecha . "_(" . $hora . "_hrs).sql";
$tables = array();
$result = SGBD::sql('SHOW TABLES');
if ($result) {
    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }
    $sql = 'SET FOREIGN_KEY_CHECKS=0;' . "\n\n";
    $sql .= 'CREATE DATABASE IF NOT EXISTS ' . BD . ";\n\n";
    $sql .= 'USE ' . BD . ";\n\n";;
    foreach ($tables as $table) {
        $result = SGBD::sql('SELECT * FROM ' . $table);
        if ($result) {
            $numFields = mysqli_num_fields($result);
            $sql .= 'DROP TABLE IF EXISTS ' . $table . ';';
            $row2 = mysqli_fetch_row(SGBD::sql('SHOW CREATE TABLE ' . $table));
            $sql .= "\n\n" . $row2[1] . ";\n\n";
            for ($i = 0; $i < $numFields; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $sql .= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $numFields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        if (isset($row[$j])) {
                            $sql .= '"' . $row[$j] . '"';
                        } else {
                            $sql .= '""';
                        }
                        if ($j < ($numFields - 1)) {
                            $sql .= ',';
                        }
                    }
                    $sql .= ");\n";
                }
            }
            $sql .= "\n\n\n";
        } else {
            $error = 1;
        }
    }
    if (isset($error) && $error == 1) {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Ocurrió un error inesperado al crear la copia de seguridad"
                });
              </script>';
    } else {
        chmod(BACKUP_PATH, 0777);
        $sql .= 'SET FOREIGN_KEY_CHECKS=1;';
        $handle = fopen(BACKUP_PATH . $DataBASE, 'w+');
        if ($handle && fwrite($handle, $sql)) {
            fclose($handle);
            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "Copia de seguridad realizada con éxito"
                    }).then(function() {
                        window.location = "base";
                    });
                  </script>';
        } else {
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Ocurrió un error inesperado al crear la copia de seguridad"
                    });
                  </script>';
        }
    }
} else {
    echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Ocurrió un error inesperado"
            });
          </script>';
}
mysqli_free_result($result);
?>

</body>
</html>
