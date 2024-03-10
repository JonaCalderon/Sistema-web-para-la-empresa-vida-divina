<?php
session_start();
$tiempoMaximoInactividad = 15 * 60;
if (isset($_SESSION['usuario']) && isset($_SESSION['perfil']) && isset($_SESSION['ultima_actividad'])) {
    // Calcular el tiempo transcurrido desde la última actividad
    $tiempoTranscurrido = time() - $_SESSION['ultima_actividad'];
    // Verificar si se ha superado el tiempo máximo de inactividad
    if ($tiempoTranscurrido > $tiempoMaximoInactividad) {
        // Cerrar la sesión
        session_unset();
        session_destroy();

        // Redirigir a la página de inicio de sesión u otra página de tu elección
        header("Location: login");
        exit();
    }
}
// Actualizar la última actividad en cada solicitud
$_SESSION['ultima_actividad'] = time();
?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Vida Divina</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="vistas/img/plantilla/icono-negro.png">

   <!--=====================================
  PLUGINS DE CSS
  ======================================-->

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">


  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="vistas/fullcalendar/lib/main.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">


  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="vistas/dist/css/skins/skin-red.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

   <!-- DataTables -->
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">


  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="vistas/plugins/iCheck/all.css">
   <!-- Daterange picker -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <!-- Morris chart -->
  <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css">

  <!--=====================================
  PLUGINS DE JAVASCRIPT
  ======================================-->

  
  <!-- jQuery 3 -->
  <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Bootstrap 3.3.7 -->
  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- FastClick -->
  <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
  
  <!-- AdminLTE App -->
  <script src="vistas/dist/js/adminlte.min.js"></script>

  <!-- DataTables -->
  <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>

  <!-- SweetAlert 2 -->
  <script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
   <!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

  <!-- iCheck 1.0.1 -->
  <script src="vistas/plugins/iCheck/icheck.min.js"></script>

  <!-- InputMask -->
  <script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>

  <!-- jQuery Number -->
  <script src="vistas/plugins/jqueryNumber/jquerynumber.min.js"></script>

  <!-- daterangepicker http://www.daterangepicker.com/-->
  <script src="vistas/bower_components/moment/min/moment.min.js"></script>
  <script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
  <script src="vistas/bower_components/raphael/raphael.min.js"></script>
  <script src="vistas/bower_components/morris.js/morris.min.js"></script>

  <!-- ChartJS http://www.chartjs.org/-->
  <script src="vistas/bower_components/Chart.js/Chart.js"></script>

  <!-- Fullcalendar -->
    <script src="vistas/fullcalendar/lib/main.min.js"></script>

<!-- Agrega este script al final de tu archivo base.php -->




<style>
  .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
    z-index: 3;
    color: #fff;
    cursor: default;
    background-color: #dd4b39;
    border-color: #dd4b39;
}
</style>

</head>

<!--=====================================
CUERPO DOCUMENTO
======================================-->

<body class="hold-transition skin-red sidebar-collapse sidebar-mini login-page">
 
  <?php

  if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"){

   echo '<div class="wrapper">';

/*=============================================
  CABEZOTE
  =============================================*/

include "modulos/cabezote.php";

/*=============================================
  MENU
  =============================================*/

include "modulos/menu.php";


/*=============================================
  CONTENIDO
  =============================================*/

if (isset($_GET["ruta"])) {

    if ($_GET["ruta"] == "inicio" ||
        $_GET["ruta"] == "usuarios" ||
        $_GET["ruta"] == "contrasena" ||
        $_GET["ruta"] == "categorias" ||
        $_GET["ruta"] == "productos" ||
        $_GET["ruta"] == "eventos" ||
        $_GET["ruta"] == "events" ||
        $_GET["ruta"] == "save_schedule" ||
        $_GET["ruta"] == "descuentos" ||
        $_GET["ruta"] == "rebaja" ||
        $_GET["ruta"] == "inventario" ||
        $_GET["ruta"] == "clientes" ||
        $_GET["ruta"] == "base" ||
        $_GET["ruta"] == "back" ||
        $_GET["ruta"] == "devoluciones" ||
        $_GET["ruta"] == "restaurar" ||
        $_GET["ruta"] == "ventas" ||
        $_GET["ruta"] == "crear-venta" ||
        $_GET["ruta"] == "editar-venta" ||
        $_GET["ruta"] == "reportes" ||
        $_GET["ruta"] == "salir"
    ) {

        include "modulos/" . $_GET["ruta"] . ".php";

    } else {

        include "modulos/404.php";

    }

} else {

    include "modulos/inicio.php";
    

}

/*=============================================
  FOOTER
  =============================================*/

include "modulos/footer.php";

echo '</div>';

} else {

    include "modulos/login.php";

}

?>
<script src="vistas/js/base.js"></script>
<script src="vistas/js/events.js"></script>
<script src="vistas/js/plantilla.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/categorias.js"></script>
<script src="vistas/js/productos.js"></script>
<script src="vistas/js/clientes.js"></script>
<script src="vistas/js/ventas.js"></script>
<script src="vistas/js/reportes.js"></script>
<script src="vistas/js/descuentos.js"></script>
<script src="vistas/jscalendar/es.js"></script>
<script src="vistas/js/inventario.js"></script>


<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script src="vistas/jscalendar/script.js"></script>




</body>
</html>
<!-- Script para mostrar alerta de evento por comenzar -->
