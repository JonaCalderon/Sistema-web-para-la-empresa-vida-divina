<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Cambiar Contraseña
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Cambiar contraseña</li>
    
    </ol>

  </section>
<style>
  .login-box,
  .register-box {
    width: 100%;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border: 1px solid #d2d6de;
    border-radius: 5px;
  }

  .login-logo a,
  .register-logo a {
    color: #333;
    font-size: 24px;
  }

  .login-logo a b,
  .register-logo a b {
    color: #0073b7;
  }

  .login-box-msg,
  .register-box-msg {
    margin: 0;
    padding: 15px 0;
    text-align: center;
    font-size: 18px;
  }

  .login-box-body,
  .register-box-body {
    background: #f9f9f9;
    padding: 20px;
    border-top: 1px solid #d2d6de;
  }

  .has-feedback .form-control-feedback {
    right: 15px;
    color: #777;
  }

  .form-group.has-feedback label ~ .form-control-feedback {
    top: 25px;
  }

  .form-control {
    border-radius: 0;
    box-shadow: none;
    border-color: #d2d6de;
  }

  .form-control:focus {
    border-color: #0073b7;
    box-shadow: none;
  }

  .btn-primary {
    background-color: #0073b7;
    border-color: #0073b7;
    color: #fff;
    border-radius: 5px;
  }

  .btn-primary:hover {
    background-color: #005b8a;
    border-color: #005b8a;
  }
</style>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Cambio de contraseña</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="login-box">
              <div class="login-logo">
                <a href="#"><b>Cambio de</b> Contraseña</a>
              </div>
              <!-- /.login-logo -->
              <div class="login-box-body">
                <p class="login-box-msg">Por favor ingresa tus credenciales para cambiar la contraseña.</p>
                
                <form id="cambiarContrasenaForm" method="post" action="">
                  <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Contraseña actual" id="currentPassword" name="currentPassword" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Nueva contraseña" id="newPassword" name="newPassword" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Confirmar nueva contraseña" id="confirmNewPassword" name="confirmNewPassword" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="row">
                    <div class="col-xs-12">
                      <button type="submit" class="btn btn-primary btn-block btn-flat" name="btnCambiarContrasena">Cambiar Contraseña</button>
                    </div>
                     <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $editarContrasena = new ControladorUsuarios();
        $editarContrasena->ctrCambiarContrasena();  // Asegúrate de que el nombre del método sea ctrCambiarContrasena()
      }
    ?>
                    <!-- /.col -->
                  </div>
                </form>
              </div>
              <!-- /.login-box-body -->
            </div>
            <!-- /.login-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
      </div>
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
