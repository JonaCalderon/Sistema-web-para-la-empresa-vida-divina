<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
    Administración de la BD
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administración de la BD</li>
    
    </ol>
<style>
  .btn-container {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .btn-instrucciones {
    margin-bottom: 20px;
    text-align: center;
  }

  .btn-icon {
    width: 100px; /* Ajusta el tamaño de la imagen según sea necesario */
    height: 100px; /* Ajusta el tamaño de la imagen según sea necesario */
    margin-bottom: 10px;
  }

  .btn-text {
    margin-top: 5px;
    margin-bottom: 10px;
    font-size: 16px;
    font-weight: bold;
  }

  .btn-custom {
    border-radius: 5px;
    font-size: 16px;
    padding: 10px 20px;
    transition: all 0.3s ease;
  }

  .btn-custom:hover {
    transform: scale(1.05);
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }

  .btn-success {
    background-color: #28a745;
    border-color: #28a745;
    color: #fff;
  }

  .btn-success:hover {
    background-color: #218838;
    border-color: #218838;
  }

  .form-select {
    border-radius: 5px;
    padding: 10px;
    font-size: 16px;
  }

  .select-custom {
    width: 250px;
  }
</style>


  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Administración de la base de datos</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
   <div class="btn-container">
  <div class="btn-instrucciones">
    <img src="vistas/img/plantilla/backup.png" alt="Icono Backup" class="btn-icon">
    <p class="btn-text">Realizar copia de seguridad</p>
    <button onclick="backup()" class="btn btn-primary btn-custom">Realizar copia</button>
  </div>
  <div class="btn-instrucciones">
    <img src="vistas/img/plantilla/restore.png" alt="Icono Restaurar" class="btn-icon">
    <p class="btn-text">Restaurar desde punto seleccionado</p>
    <select id="restorePoint" name="restorePoint" class="form-select select-custom">
      <option value="" disabled selected>Selecciona un punto de restauración</option>
      <?php
      include "conexion.php";

      $ruta = "backup/";
      if (is_dir($ruta)) {
          if ($aux = opendir($ruta)) {
              while (($archivo = readdir($aux)) !== false) {
                  if ($archivo != "." && $archivo != "..") {
                      $nombrearchivo = str_replace(".sql", "", $archivo);
                      $nombrearchivo = str_replace("-", ":", $nombrearchivo);
                      $ruta_completa = $ruta . $archivo;
                      if (is_dir($ruta_completa)) {
                      } else {
                          echo '<option value="'.$ruta_completa.'">'.$nombrearchivo.'</option>';
                      }
                  }
              }
              closedir($aux);
          }
      } else {
          echo $ruta . " No es ruta válida";
      }
      ?>
    </select>
    <button onclick="restore()" class="btn btn-success btn-custom">Restaurar</button>
  </div>
</div>

</div>

      </div>
    </section>
  </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
 <script>
 function backup() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "vistas/modulos/back.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        swal({
          type: "success",
          title: "Éxito",
          text: "Se realizó el respaldo.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result) {
          if (result.value) {
            window.location = "base";
          }
        });
      } else {
        swal({
          type: "error",
          title: "Error",
          text: "Ocurrió un error inesperado al realizar la copia de seguridad",
          confirmButtonText: "Cerrar"
        });
      }
    }
  };
  xhr.send();
}
  function restore() {
    var restorePoint = document.getElementById("restorePoint").value;
    if (restorePoint === "") {
    swal({
                            type: "error",
                            title: "¡Error!",
                            text: "Seleccione un punto de restauración primero.",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "base";
                            }
                        });        return;
      }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "vistas/modulos/restore.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
     if (xhr.readyState === 4 && xhr.status === 200) {
      swal({
        type: "success",
        title: "Hecho!",
        text: "Se realizó la restauración",
        showConfirmButton: true,
        confirmButtonText: "Cerrar"
      }).then(function(result) {
        if (result.value) {
          window.location = "base";
        }
      });
      return;
    } else if (xhr.readyState === 4) {
      swal({
        type: "error",
        title: "Error",
        text: "Ocurrió un error inesperado al restaurar la copia de seguridad",
        confirmButtonText: "Cerrar"
      });
    }
  };
    xhr.send("restorePoint=" + restorePoint);
  }
</script>
