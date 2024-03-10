<?php

if ($_SESSION["perfil"] == "Vendedor") {
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
                    Agregar Descuentos
                </button>

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                    <thead>

                        <tr>
                            <th style="width:10px">#</th>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Descuento</th>
                            <th>Fecha inicio</th>
                            <th>Fecha final</th>
                            <th>Acciones</th>
                        </tr>
                         </thead>      

       </table>

       <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto">

      </div>

    </div>

  </section>

</div>


<!--=====================================
MODAL AGREGAR PRODUCTO
======================================-->

<div id="modalAgregarDescuento" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">
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


            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" id="nuevaDescripcion" name="nuevaDescripcion" required>
                  
                  <option value="">Selecionar Producto</option>

                  <?php

                  $item = null;
                  $valor = null;

                  $productos = ControladorProductos::ctrMostrarProductos($item, $valor);

                  foreach ($productos as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["descripcion"].'</option>';
                  }

                  ?>

                   </select>

              </div>

            </div>

            <!-- ENTRADA PARA EL TEXTO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-font"></i></span> 

                <input type="text" class="form-control input-lg" id="nuevoTexto" name="nuevoTexto" placeholder="Ingresar Descripción" required>

              </div>

            </div>


            <!-- ENTRADA PARA EL DESCUENTO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-percent"></i></span> 

                <input type="number" class="form-control input-lg" id="nuevoDescuento" name="nuevoDescuento" placeholder="Ingresar Descuento" required>

              </div>

            </div>

                 <!-- ENTRADA PARA EL FECHA INICIO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="date" class="form-control input-lg" id="nuevoInicio" name="nuevoInicio" placeholder="Ingresar Fecha inicio" required>

              </div>

            </div>

             <!-- ENTRADA PARA EL FECHA FINAL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="date" class="form-control input-lg" id="nuevoFinal" name="nuevoFinal" placeholder="Ingresar Fecha Final" required>

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

          $crearDescuento = new ControladorDescuento();
          $crearDescuento -> ctrCrearDescuento();

        ?>  

    </div>

  </div>

</div>


<!--=====================================
MODAL EDITAR Descuento
======================================-->

<div id="modalEditarDescuento" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar Descuento</h4>

        </div>

<!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <!-- ENTRADA PARA SELECCIONAR Producto -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg"  name="editarDescripcion" readonly required>
                  
                  <option id="editarDescripcion"></option>

                </select>

              </div>

            </div>

    <!-- ENTRADA PARA EL TEXTO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-font"></i></span> 

                <input type="text" class="form-control input-lg" id="editarTexto" name="editarTexto" placeholder="Ingresar Descripción" required>

              </div>

            </div>
     <!-- ENTRADA PARA EL DESCUENTO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-percent"></i></span> 

                <input type="number" class="form-control input-lg" id="editarDescuento" name="editarDescuento" readonly required>

              </div>

            </div>

                 <!-- ENTRADA PARA EL FECHA INICIO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="date" class="form-control input-lg" id="editarInicio" name="editarInicio" readonly required>

              </div>

            </div>

             <!-- ENTRADA PARA EL FECHA FINAL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="date" class="form-control input-lg" id="editarFinal" name="editarFinal" placeholder="Ingresar Fecha Final" required>

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

          $editarDescuento = new ControladorDescuento();
          $editarDescuento -> ctrEditarDescuento();

        ?>      

         </div>

  </div>

</div>

<?php

  $eliminarDescuento = new ControladorDescuento();
  $eliminarDescuento -> ctrEliminarDescuento();

?>      
