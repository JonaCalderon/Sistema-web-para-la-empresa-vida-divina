

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Eventos
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar Eventos</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <!--<button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarEvento">
          
          Agregar Evento

        </button>-->

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Nombre</th>
           <th>Descripción</th>
           <th>Inicio</th>
           <th>Fin</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $eventos = ControladorEventos::ctrMostrarEventos($item, $valor);

          foreach ($eventos as $key => $value) {
            

            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["title"].'</td>

                    <td>'.$value["description"].'</td>

                    <td>'.$value["start_datetime"].'</td>

                    <td>'.$value["end_datetime"].'</td>

                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarEvento" data-toggle="modal" data-target="#modalEditarEvento" idEvento="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';

                      if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarEvento" idEvento="'.$value["id"].'"><i class="fa fa-times"></i></button>';

                      }

                      echo '</div>  

                    </td>

                  </tr>';
          
            }

        ?>
   
        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR Evento
======================================-->

<div id="modalAgregarEvento" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:
        #dd4b39; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Evento</h4>

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

                <input type="text" class="form-control input-lg" name="nuevoEvento" placeholder="Ingresar nombre" required>

              </div>

            </div>

            </div>

             <!-- ENTRADA PARA lA DESCRIPCION -->

          <div class="form-group">
            
             <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                   <textarea class="form-control input-lg" name="nuevoDescripcion" placeholder="Ingresa Descripción" required></textarea>
               </div>
          </div>

             <!-- ENTRADA PARA FECHAINICIO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="datetime-local" class="form-control input-lg" name="nuevoInicio" placeholder="Ingresar Fecha de inicio" required>

              </div>

            </div>

            <!-- ENTRADA PARA FECHAFINAL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="datetime-local" class="form-control input-lg" name="nuevoFinal" placeholder="Ingresar Fecha Final" required>

              </div>

            </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Evento</button>

        </div>

      </form>

      <?php

        $crearEvento = new ControladorEventos();
        $crearEvento -> ctrCrearEvento();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR EVENTO
======================================-->

<div id="modalEditarEvento" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar Evento</h4>

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

                <input type="text" class="form-control input-lg" name="editarEvento" id="editarEvento" required>
                <input type="hidden" id="idEvento" name="idEvento">
              </div>

            </div>

                      
            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <textarea class="form-control input-lg" name="editarDescripcion" id="editarDescripcion" required></textarea>

              </div>

            </div>

            <!-- ENTRADA PARA EL INICIO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="datetime-local" class="form-control input-lg" name="editarInicio" id="editarInicio" required>
              </div>

            </div>

             <!-- ENTRADA PARA EL FINAL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="datetime-local" class="form-control input-lg" name="editarFinal" id="editarFinal" required>
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

        $editarEvento = new ControladorEventos();
        $editarEvento -> ctrEditarEvento();

      ?>

    

    </div>

  </div>

</div>

<?php

  $eliminarEvento = new ControladorEventos();
  $eliminarEvento -> ctrEliminarEvento();

?>


