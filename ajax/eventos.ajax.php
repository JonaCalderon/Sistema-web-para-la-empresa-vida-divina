<?php

require_once "../controladores/events.controlador.php";
require_once "../modelos/events.modelo.php";

class AjaxEventos{

	/*=============================================
	EDITAR CLIENTE
	=============================================*/	

	public $idEvento;

	public function ajaxEditarEvento(){

		$item = "id";
		$valor = $this->idEvento;

		$respuesta = ControladorEventos::ctrMostrarEventos($item, $valor);

		echo json_encode($respuesta);


	}

}

/*=============================================
EDITAR CLIENTE
=============================================*/	

if(isset($_POST["idEvento"])){

	$eventos = new AjaxEventos();
	$eventos -> idEvento = $_POST["idEvento"];
	$eventos -> ajaxEditarEvento();

}