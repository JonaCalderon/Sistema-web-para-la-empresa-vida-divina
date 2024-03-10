<?php

require_once "../controladores/descuentos.controlador.php";
require_once "../modelos/descuentos.modelo.php";

class AjaxDescuentos{



  /*=============================================
  EDITAR DESCUENTOS
  =============================================*/ 

  public $idDescuento;

  public function ajaxEditarDescuento(){

    $item = "id";
    $valor = $this->idDescuento;

    $respuesta = ControladorDescuentos::ctrMostrarDescuentos($item, $valor);

    echo json_encode($respuesta);


  }

}

/*=============================================
EDITAR DESCUENTOS
=============================================*/ 

if(isset($_POST["idDescuento"])){

  $descuento = new AjaxDescuentos();
  $descuento -> idDescuento = $_POST["idDescuento"];
  $descuento -> ajaxEditarDescuento();

}