<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar Contraseña</title>

  <style>
    body {
      background: linear-gradient(rgba(0, 0, 0, 1), rgba(0, 30, 50, 1));
      color: #000;  /* Cambiado a texto negro */
      font-family: Arial, sans-serif;
    }

    #back {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      background: url('../../../vistas/img/plantilla/back.png');
      background-size: cover;
      overflow: hidden;
      z-index: -1;
    }

    .login-box {
      width: 400px;
      margin: 10% auto;
      border-radius: 10px;
      background: #fff;
      box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.2);
    }

    .login-logo {
      text-align: center;
      margin: 40px 0;  /* Ajustado el margen superior */
    }

    .login-logo img {
      max-width: 50%;  /* Reducido aún más el tamaño del logo */
      height: auto;
    }

    .login-box-body {
      padding: 50px;
    }

    .login-box-msg {
      margin: 0;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-control {
      box-shadow: none;
      border-radius: 4px;
    }

    .form-control-feedback {
      color: #777;
    }

    .login-btn {
      background-color: #f39c12;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    .login-btn:hover {
      background-color: #e67e22;
    }

    .back-to-login-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #3498db;
      text-decoration: underline;
    }
  </style>
</head>

<body>

  <div id="back"></div>

  <div class="login-box">
    <div class="login-logo">
      <img src="../../../vistas/img/plantilla/logo-blanco-bloque.png" class="img-responsive">
    </div>

    <div class="login-box-body">
      <p class="login-box-msg">Recuperar contraseña</p>

      <form method="post" action="procesar_recuperacion.php">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Usuario o Correo Electrónico" name="usuarioRecuperacion" required>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-warning btn-block btn-flat login-btn">Recuperar Contraseña</button>
          </div>
        </div>
      </form>

      <!-- Puedes agregar aquí la lógica para manejar la recuperación de contraseña -->

      <div class="row">
        <div class="col-xs-12">
          <a href="login" class="back-to-login-link"><i class="fa fa-arrow-left"></i> Volver al inicio de sesión</a>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
