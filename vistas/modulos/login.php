<!-- Formulario de Login -->
<div id="back"></div>

<div class="login-box">
  <div class="login-logo">
    <img src="vistas/img/plantilla/logo-blanco-bloque.png" class="img-responsive" style="padding:30px 100px 0px 100px">
  </div>

  <div class="login-box-body">
    <p class="login-box-msg">Ingresar al sistema</p>

    <!-- Inicio del formulario -->
    <form method="post">
      <!-- Campo de Usuario -->
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <!-- Campo de Contraseña -->
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <!-- Botón de Ingresar -->
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat login-btn">Ingresar</button>
        </div>
      </div>

      <!-- Enlace de Recuperar Contraseña -->
      <div class="row">
        <div class="col-xs-12">
          <a href="vistas/modulos/recuperar.php" class="forgot-password-link">Olvidaste la contraseña?</a>
        </div>
      </div>

      <!-- Llamado a la función del controlador de usuarios para ingresar -->
      <?php
        $login = new ControladorUsuarios();
        $login -> ctrIngresoUsuario();
      ?>
      
    </form>
    <!-- Fin del formulario -->

  </div>
</div>
<!-- Fin del Formulario de Login -->
