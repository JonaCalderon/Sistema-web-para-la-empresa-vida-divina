<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Descuentos
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar Descuentos</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarDescuento">
          
          Agregar Descuento

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>ID</th>
           <th>Nombre</th>
           <th>Descuento</th>
           <th>Fecha inicio</th>
           <th>Fecha final</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $descuentos = ControladorDescuentos::ctrMostrardescuentos($item, $valor);

          foreach ($descuentos as $key => $value) {
            

            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["id_producto"].'</td>

                    <td>'.$value["descripcion"].'</td>

                    <td>'.$value["descuento"].'</td>

                    <td>'.$value["fecha_inicio"].'</td>

                    <td>'.$value["fecha_final"].'</td>

                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarDescuento" data-toggle="modal" data-target="#modalEditarDescuento" idDescuento="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';

                      if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarDescuentos" idDescuento="'.$value["id"].'"><i class="fa fa-times"></i></button>';

                      }

                      echo '</div>  

                    </td>

                  </tr>';
          
            }

        ?>
   
        </tbody>

       </table>
<?php
// echo "<pre>";
//   print_r($descuentos);
//   echo "</pre>";
//   die();
  ?>
      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR DESCUENTO
======================================-->

<div id="modalAgregarDescuento" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:
        #dd4b39; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Descuento</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


      <!-- ENTRADA PARA SELECCIONAR EL PRODUCTO -->
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-lg" id="nuevaDescripcion" name="nuevaDescripcion" required>
                   <option value="">Selecionar Producto</option>

                  <?php

                  $item = null;
                  $valor = null;
                        $orden = "id";

      $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);  

                  foreach ($productos as $key => $value) {
                    if ($value["descuento_activo"]== 0 ){
                        echo '<option value="'.$value["id"].'">'.$value["descripcion"].'</option>';

                    }
                  }

                  ?>
  
                </select>

              </div>

            </div>

       <!-- ENTRADA PARA EL DESCRIPCION -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaDescripcionDescuento" placeholder="Ingresar Descripción" required>

              </div>

            </div>

             <!-- ENTRADA PARA EL DESCUENTO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="number" class="form-control input-lg" name="nuevoDescuento" placeholder="Ingresa descuento" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA LA FECHA INICIO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="date" class="form-control input-lg" name="nuevoInicio" placeholder="Fecha de Inicio" required>

              </div>

            </div>

            <!-- ENTRADA PARA LA FECHA FINAL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="date" class="form-control input-lg" name="nuevoFinal" placeholder="Fecha final" required>

              </div>

            </div>

    
          </div>

        </div>
        
        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Descuento</button>

        </div>

      </form>

      <?php

        $crearDescuento = new ControladorDescuentos();
        $crearDescuento -> ctrCrearDescuentos();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR DESCUENTO
======================================-->

<div id="modalEditarDescuento" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#dd4b39; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar Descuento</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="editarProducto" id="editarProducto" required>
                <input type="hidden" id="idDescuento" name="idDescuento">
              </div>

            </div>
            <!-- ENTRADA PARA LA DESCRIPCION -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="editarDescripcionDescuentos" id="editarDescripcionDescuentos" required> 
              </div>

            </div>
             <!-- ENTRADA PARA EL DESCUENTO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="number" class="form-control input-lg" name="editarDescuento" placeholder="Ingresa descuento" required>

              </div>

            </div>
             <!-- ENTRADA PARA LA FECHA INICIO-->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="date" class="form-control input-lg" name="editarInicio" placeholder="Ingresa Fecha de inicio" required>

              </div>

            </div>

            <!-- ENTRADA PARA LA FECHA FINAL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="date"  class="form-control input-lg" name="editarFinal" placeholder="Fecha final" required>

              </div>

            </div>
        
       </div>

        </div>


        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

      <?php

        $editarDescuento = new ControladorDescuentos();
        $editarDescuento -> ctrEditarDescuentos();

      ?>

    

    </div>

  </div>

</div>

<?php

  $eliminarDescuento = new ControladorDescuentos();
  $eliminarDescuento -> ctrEliminarDescuentos();

?>


