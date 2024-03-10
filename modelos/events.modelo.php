
<?php

require_once "conexion.php";

class ModeloEventos{

	/*=============================================
	CREAR CLIENTE
	=============================================*/

	static public function mdlIngresarEvento($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(title,descripcion,start_datetime, end_datetime) VALUES (:title,:descripcion,:start_datetime, :end_datetime)");

		$stmt->bindParam(":title", $datos["title"], PDO::PARAM_STR);
		$stmt->bindParam(":description", $datos["description"], PDO::PARAM_STR);
		$stmt->bindParam(":start_datetime", $datos["start_datetime"], PDO::PARAM_STR);
		$stmt->bindParam(":end_datetime", $datos["end_datetime"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	    /*=============================================
	MOSTRAR CLIENTES
	=============================================*/

	static public function mdlMostrarEventos($tabla, $item, $valor){

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
	EDITAR CLIENTE
	=============================================*/

	static public function mdlEditarEvento($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(title,descripcion,start_datetime, end_datetime) VALUES (:title,:descripcion,:start_datetime, :end_datetime)");

		$stmt->bindParam(":title", $datos["title"], PDO::PARAM_STR);
		$stmt->bindParam(":description", $datos["description"], PDO::PARAM_STR);
		$stmt->bindParam(":start_datetime", $datos["start_datetime"], PDO::PARAM_STR);
		$stmt->bindParam(":end_datetime", $datos["end_datetime"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/

	static public function mdlEliminarEvento($tabla, $datos){

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
	ACTUALIZAR CLIENTE
	=============================================*/

	static public function mdlActualizarEvento($tabla, $item1, $valor1, $valor){

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
