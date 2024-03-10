<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/descuentos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/ventas.controlador.php";
require_once "controladores/recuperarContra.controlador.php";
require_once "controladores/events.controlador.php";
require_once "controladores/inventario.controlador.php";


require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "modelos/descuentos.modelo.php";
require_once "modelos/events.modelo.php";
require_once "modelos/conexion.php";
require_once "modelos/inventario.modelo.php";


require_once "extensiones/vendor/autoload.php";
require_once "extensiones/libMail/vendor/autoload.php";
$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

