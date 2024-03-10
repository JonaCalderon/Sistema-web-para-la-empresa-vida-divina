<?php

require_once "conexion.php";

class ModeloCategorias{

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	 static public function mdlIngresarCategoria($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(categoria, descripcion) VALUES (:categoria, :descripcion)");

        $stmt->bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }


	/*=============================================
    MOSTRAR CATEGORIAS
    =============================================*/
  static public function mdlMostrarCategorias($tabla, $item, $valor){

    if($item != null){

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

        $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

        $stmt->execute();

        $resultado = $stmt->fetch(); // Cambiar a fetch()

        $stmt->closeCursor(); // Cerrar la conexión, cambie a closeCursor

        return $resultado;

    } else {

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

        $stmt->execute();

        $resultado = $stmt->fetchAll(); // Cambiar a fetchAll()

        $stmt->closeCursor(); // Cerrar la conexión, cambie a closeCursor

        return $resultado;

    }
}


	

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function mdlEditarCategoria($tabla, $datos){
$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET categoria = :categoria, descripcion = :descripcion WHERE id = :id");

$stmt->bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

if (!$stmt->execute()) {
    $errorInfo = $stmt->errorInfo();
    echo "Error en la consulta SQL: " . $errorInfo[2];
    $respuesta = "error";
} else {
    $respuesta = "ok";
}

return $respuesta;

}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function mdlBorrarCategoria($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

}

