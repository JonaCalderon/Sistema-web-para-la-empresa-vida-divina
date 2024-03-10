<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxUsuarios{

	/*=============================================
	EDITAR USUARIO
	=============================================*/	

	public $idUsuario;

	public function ajaxEditarUsuario(){

		$item = "id";
		$valor = $this->idUsuario;

		// Llama al controlador para obtener los datos del usuario por ID
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

		// Devuelve los datos del usuario en formato JSON
		echo json_encode($respuesta);

	}

	/*=============================================
	ACTIVAR USUARIO
	=============================================*/	

	public $activarUsuario;
	public $activarId;

	public function ajaxActivarUsuario(){

		$tabla = "usuarios";

		$item1 = "estado";
		$valor1 = $this->activarUsuario;

		$item2 = "id";
		$valor2 = $this->activarId;

		// Llama al modelo para activar o desactivar un usuario
		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

		// No se envía ninguna salida directa ya que es una operación interna

	}

	/*=============================================
	VALIDAR NO REPETIR USUARIO
	=============================================*/	

	public $validarUsuario;

	public function ajaxValidarUsuario(){

		$item = "usuario";
		$valor = $this->validarUsuario;

		// Llama al controlador para verificar si el usuario ya existe
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

		// Devuelve el resultado de la verificación en formato JSON
		echo json_encode($respuesta);

	}

	/*=============================================
	VALIDAR NO REPETIR CORREO
	=============================================*/	

	public $validarCorreo;

	public function ajaxValidarCorreo(){

		$item = "correo";
		$valor = $this->validarCorreo;

		// Llama al controlador para verificar si el correo ya está registrado
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

		// Devuelve el resultado de la verificación en formato JSON
		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["idUsuario"])){

	$editar = new AjaxUsuarios();
	$editar -> idUsuario = $_POST["idUsuario"];
	$editar -> ajaxEditarUsuario();

}

/*=============================================
ACTIVAR USUARIO
=============================================*/	

if(isset($_POST["activarUsuario"])){

	$activarUsuario = new AjaxUsuarios();
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"];
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarUsuario();

}

/*=============================================
VALIDAR NO REPETIR USUARIO
=============================================*/

if(isset($_POST["validarUsuario"])){

	$valUsuario = new AjaxUsuarios();
	$valUsuario -> validarUsuario = $_POST["validarUsuario"];
	$valUsuario -> ajaxValidarUsuario();

}

/*=============================================
VALIDAR NO REPETIR CORREO
=============================================*/

if(isset($_POST["validarCorreo"])){

	$valUsuario = new AjaxUsuarios();
	$valUsuario -> validarCorreo = $_POST["validarCorreo"];
	$valUsuario -> ajaxValidarCorreo();

}
