<?php


error_reporting(E_PARSE);

// Configuración de la conexión MySQLi
const USER = "root";
const SERVER = "localhost";
const BD = "basedatosvd";
const PASS = "";
const BACKUP_PATH = "../../backup/";

date_default_timezone_set('America/El_Salvador');

class SGBD
{
    // Función para hacer consultas a la base de datos con MySQLi
    public static function sql($query)
    {
        $con = self::conectarMySQLi();
        $con->beginTransaction();

        try {
            $stmt = $con->query($query);

            if ($stmt) {
                $con->commit();
                return $stmt;
            } else {
                throw new Exception("Falló la ejecución de la consulta");
            }
        } catch (Exception $e) {
            $con->rollBack();
            echo "Error: " . $e->getMessage();
            exit();
        }
    }

    // Función para limpiar variables que contengan inyección SQL
    public static function limpiarCadena($valor)
    {
        $valor = addslashes($valor);
        $valor = str_ireplace("<script>", "", $valor);
        $valor = str_ireplace("</script>", "", $valor);
        $valor = str_ireplace("SELECT * FROM", "", $valor);
        $valor = str_ireplace("DELETE FROM", "", $valor);
        $valor = str_ireplace("UPDATE", "", $valor);
        $valor = str_ireplace("INSERT INTO", "", $valor);
        $valor = str_ireplace("DROP TABLE", "", $valor);
        $valor = str_ireplace("TRUNCATE TABLE", "", $valor);
        $valor = str_ireplace("--", "", $valor);
        $valor = str_ireplace("^", "", $valor);
        $valor = str_ireplace("[", "", $valor);
        $valor = str_ireplace("]", "", $valor);
        $valor = str_ireplace("\\", "", $valor);
        $valor = str_ireplace("=", "", $valor);
        return $valor;
    }

    // Función para conectar con MySQLi
    private static function conectarMySQLi()
    {
        $con = mysqli_connect(SERVER, USER, PASS, BD);
        mysqli_set_charset($con, "utf8");

        if (mysqli_connect_errno()) {
            printf("Conexion fallida: %s\n", mysqli_connect_error());
            exit();
        } else {
            mysqli_autocommit($con, false);
            mysqli_begin_transaction($con, MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT);
            return $con;
        }
    }

    // Función para conectar con PDO
    private static function conectarPDO()
    {
        try {
            $link = new PDO("mysql:host=" . SERVER . ";dbname=" . BD, USER, PASS);
            $link->exec("set names utf8");
            return $link;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit();
        }
    }
}

class Conexion
{
    // Función para conectar con PDO
    static public function conectar()
    {
        $link = new PDO("mysql:host=" . SERVER . ";dbname=" . BD, USER, PASS);
        $link->exec("set names utf8");
        return $link;
    }
}
?>
