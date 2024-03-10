<?php

require_once "conexion.php";

class ModeloUsuarios {

    /*=============================================
    MOSTRAR USUARIOS
    =============================================*/

    static public function mdlMostrarUsuarios($tabla, $item, $valor) {

        if ($item != null) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();
        }


        $stmt->close();

        $stmt = null;
    }

    static public function verificarUsuarioExistente($tabla, $usuario) {
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as conteo FROM $tabla WHERE usuario = :usuario");
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['conteo'] > 0;
    }

    static public function verificarCorreoExistente($tabla, $correo) {
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as conteo FROM $tabla WHERE correo = :correo");
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['conteo'] > 0;
    }

    /*=============================================
    REGISTRO DE USUARIO
    =============================================*/

    static public function mdlIngresarUsuario($tabla, $datos) {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,apellidoPa,apellidoMa,correo, usuario, password, perfil, foto) VALUES (:nombre,:apellidoPa, :apellidoMa,:correo, :usuario, :password, :perfil, :foto)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellidoPa", $datos["apellidoPa"], PDO::PARAM_STR);
        $stmt->bindParam(":apellidoMa", $datos["apellidoMa"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();

        $stmt = null;
    }

    /*=============================================
    EDITAR USUARIO
    =============================================*/

    static public function mdlEditarUsuario($tabla, $datos) {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre,apellidoPa = :apellidoPa,apellidoMa = :apellidoMa,correo = :correo, password = :password, perfil = :perfil, foto = :foto WHERE usuario = :usuario");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellidoPa", $datos["apellidoPa"], PDO::PARAM_STR);
        $stmt->bindParam(":apellidoMa", $datos["apellidoMa"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();

        $stmt = null;
    }

    /*=============================================
    ACTUALIZAR USUARIO
    =============================================*/

    static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2) {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

        $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();

        $stmt = null;
    }

    /*=============================================
    BORRAR USUARIO
    =============================================*/

    static public function mdlBorrarUsuario($tabla, $datos) {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();

        $stmt = null;
    }

    /*=============================================
    ACTUALIZAR CONTRASEÑA DEL USUARIO
    =============================================*/

    static public function mdlActualizarContrasena($idUsuario, $nuevaContrasena) {
        $encriptar = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

        $stmt = Conexion::conectar()->prepare("UPDATE usuarios SET password = :password WHERE id = :idUsuario");

        $stmt->bindParam(":password", $encriptar, PDO::PARAM_STR);
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }
}
