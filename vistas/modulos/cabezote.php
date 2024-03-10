<header class="main-header">
 	
	<!--=====================================
	LOGOTIPO
	======================================-->
	<a href="inicio" class="logo">
		
		<!-- logo mini -->
		<span class="logo-mini">
			<img src="vistas/img/plantilla/icono-blanco.png" class="img-responsive" style="padding:0px">
		</span>

		<!-- logo normal -->
		<span class="logo-lg">
			<img src="vistas/img/plantilla/logo-blanco-lineal.png" class="img-responsive" style="padding:10px 0px">
		</span>
	</a>

<!--=====================================
BARRA DE NAVEGACIÓN
======================================-->
<nav class="navbar navbar-static-top" role="navigation">
    
    <!-- Botón de navegación -->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

<!-- Campana de notificaciones -->
<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <!-- Elementos del menú de la campana de notificaciones -->
        <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span id="notification-count" class="label label-warning"></span>
            </a>
            <ul id="notification-list" class="dropdown-menu">
                <!-- Las notificaciones se cargarán dinámicamente aquí -->
                <li class="header">Notificaciones</li>
                <li id="notification-content"></li>
                <li class="footer"><a href="#">Ver todas</a></li>
            </ul>
        </li>
    </ul>
</div>


    <!-- Perfil de usuario -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php
                    if($_SESSION["foto"] != ""){
                        echo '<img src="'.$_SESSION["foto"].'" class="user-image">';
                    }else{
                        echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';
                    }
                    ?>
                    <span class="hidden-xs"><?php echo $_SESSION["nombre"]; ?></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="user-body">
                        <div class="pull-right">
                            <a href="salir" class="btn btn-default btn-flat">Salir</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- Fin del perfil de usuario -->

</nav>

</header>
