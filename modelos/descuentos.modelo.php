<?php

require_once "conexion.php";

class ModeloDescuentos{

	/*=============================================
	CREAR DESCUENTO
	=============================================*/

	static public function mdlIngresarDescuentos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_producto,descripcion,descuento, fecha_inicio, fecha_final) VALUES (:id_producto,:descripcion,:descuento , :fecha_inicio, :fecha_final)");

		$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_final", $datos["fecha_final"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR DESCUENTOS
	=============================================*/

	static public function mdlMostrarDescuentos($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
 
		$stmt = null;

	}

	/*=============================================
	EDITAR DESCUENTO
	=============================================*/

	static public function mdlEditarDescuentos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_producto = :id_producto,descripcion = :descripcion, descuento = :descuento, fecha_inicio = :fecha_inicio, fecha_final = :fecha_final WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_final", $datos["fecha_final"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}
	/* En el ModeloDescuentos */

static public function mdlObtenerProductos(){
    $stmt = Conexion::conectar()->prepare("SELECT id_producto, nombre_producto FROM productos");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


	/*=============================================
	ELIMINAR DESCUENTO
	=============================================*/

	static public function mdlEliminarDescuentos($tabla, $datos){

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

	/*=============================================
	ACTUALIZAR DESCUENTO
	=============================================*/

	static public function mdlActualizarDescuentos($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

}