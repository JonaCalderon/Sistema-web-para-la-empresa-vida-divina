<?php

class ControladorInventarios{

    /*=============================================
    MOSTRAR PRODUCTOS
    =============================================*/

    static public function ctrMostrarProductos($item, $valor, $orden){

        $tabla = "productos";

        $respuesta = ModeloInventarios::mdlMostrarProductos($tabla, $item, $valor, $orden);

        return $respuesta;

    }
/*=============================================
    CREAR PRODUCTO
=============================================*/

static public function ctrCrearProducto(){

    if(isset($_POST["nuevaDescripcion"])){

        if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"]) &&
            preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) &&   

            preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompra"]) &&
            preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioVenta"])&&
         preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["nuevoFecha"]))

        {

            // Verificar que el precio de venta no sea menor al precio de compra
            if(floatval($_POST["nuevoPrecioVenta"]) >= floatval($_POST["nuevoPrecioCompra"])){

                // Verificar si ya existe un producto con la misma descripción
                $descripcion = $_POST["nuevaDescripcion"];
                $existeProducto = self::verificarExistenciaProducto($descripcion);

                if(!$existeProducto){

                    /*=============================================
                    VALIDAR IMAGEN
                    =============================================*/

                    $ruta = "vistas/img/productos/default/anonymous.png";

                    if(isset($_FILES["nuevaImagen"]["tmp_name"])){

                        list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);

                        $nuevoAncho = 500;
                        $nuevoAlto = 500;

                        /*=============================================
                        CREAR EL DIRECTORIO DONDE SE GUARDARÁ LA FOTO DEL PRODUCTO
                        =============================================*/

                        $directorio = "vistas/img/productos/".$_POST["nuevoCodigo"];

                        mkdir($directorio, 0755);

                        /*=============================================
                        DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                        =============================================*/

                        if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){

                            $aleatorio = mt_rand(100,999);

                            $ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".jpg";

                            $origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);                        

                            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                            imagejpeg($destino, $ruta);

                        }

                        if($_FILES["nuevaImagen"]["type"] == "image/png"){

                            $aleatorio = mt_rand(100,999);

                            $ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".png";

                            $origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);                        

                            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                            imagepng($destino, $ruta);

                        }

                    }

                    $tabla = "productos";

                    $datos = array("id_categoria" => $_POST["nuevaCategoria"],
                                   "codigo" => $_POST["nuevoCodigo"],
                                   "descripcion" => $_POST["nuevaDescripcion"],
                                   "stock" => $_POST["nuevoStock"],
                                   "precio_compra" => $_POST["nuevoPrecioCompra"],
                                   "precio_venta" => $_POST["nuevoPrecioVenta"],
                                    "fecha_caducidad" => $_POST["nuevoFecha"],

                                   "imagen" => $ruta);

                    $respuesta = ModeloInventarios::mdlIngresarProducto($tabla, $datos);

                    if($respuesta == "ok"){

                        echo '<script>
                                swal({
                                    type: "success",
                                    title: "El producto ha sido guardado correctamente",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                }).then(function(result){
                                    if (result.value) {
                                        window.location = "inventario";
                                    }
                                });
                            </script>';

                    }

                } else {
                    echo '<script>
                            swal({
                                type: "error",
                                title: "¡Ya existe un producto con la misma descripción!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if (result.value) {
                                    window.location = "inventario";
                                }
                            });
                        </script>';
                }

            } else {
                echo '<script>
                        swal({
                            type: "error",
                            title: "¡El precio de venta no puede ser menor al precio de compra!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "inventario";
                            }
                        });
                    </script>';
            }

        } else {

            echo '<script>
                    swal({
                        type: "error",
                        title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "inventario";
                        }
                    });
                </script>';
        }
    }
}

static public function verificarExistenciaProducto($descripcion){
    $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as total FROM productos WHERE descripcion = :descripcion");
    $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado["total"] > 0;
}

 /*=============================================
    OBTENER LISTA DE PRODUCTOS
    =============================================*/

    static public function obtenerListaProductos(){

        $productos = array();

        // Obtener la lista de productos desde el modelo
        $productosDB = ModeloInventarios::mdlMostrarProductos("productos", null, null, null);

        // Construir un array con los nombres de los productos
        foreach ($productosDB as $producto) {
            $productos[] = $producto["descripcion"];
        }

        return $productos;
    }

    /*=============================================
    EDITAR PRODUCTO
    =============================================*/

    static public function ctrEditarProducto(){

        if(isset($_POST["editarDescripcion"])){

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"]) &&
               preg_match('/^[0-9]+$/', $_POST["editarStock"]) &&   
               preg_match('/^[0-9.]+$/', $_POST["editarPrecioCompra"]) &&
               preg_match('/^[0-9.]+$/', $_POST["editarPrecioVenta"]) 
               

           ){

                /*=============================================
                VALIDAR IMAGEN
                =============================================*/

                $ruta = $_POST["imagenActual"];

                if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){

                    list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /*=============================================
                    CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                    =============================================*/

                    $directorio = "vistas/img/productos/".$_POST["editarCodigo"];

                    /*=============================================
                    PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
                    =============================================*/

                    if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png"){

                        unlink($_POST["imagenActual"]);

                    }else{

                        mkdir($directorio, 0755);   
                    
                    }
                    
                    /*=============================================
                    DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                    =============================================*/

                    if($_FILES["editarImagen"]["type"] == "image/jpeg"){

                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/

                        $aleatorio = mt_rand(100,999);

                        $ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".jpg";

                        $origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);                     

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino, $ruta);

                    }

                    if($_FILES["editarImagen"]["type"] == "image/png"){

                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/

                        $aleatorio = mt_rand(100,999);

                        $ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".png";

                        $origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);                      

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino, $ruta);

                    }

                }

                $tabla = "productos";

                $datos = array("id_categoria" => $_POST["editarCategoria"],
                               "codigo" => $_POST["editarCodigo"],
                               "descripcion" => $_POST["editarDescripcion"],
                               "stock" => $_POST["editarStock"],
                               "precio_compra" => $_POST["editarPrecioCompra"],
                               "precio_venta" => $_POST["editarPrecioVenta"],
                               "imagen" => $ruta);

                $respuesta = ModeloInventarios::mdlEditarProducto($tabla, $datos);

                if($respuesta == "ok"){

                    echo'<script>

                        swal({
                              type: "success",
                              title: "El producto ha sido editado correctamente",
                              showConfirmButton: true,
                              confirmButtonText: "Cerrar"
                              }).then(function(result){
                                        if (result.value) {

                                        window.location = "inventario";

                                        }
                                    })

                        </script>';

                }


            }else{

                echo'<script>

                    swal({
                          type: "error",
                          title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                            if (result.value) {

                            window.location = "inventario";

                            }
                        })

                </script>';
            }
        }

    }

    /*=============================================
    BORRAR PRODUCTO
    =============================================*/
    static public function ctrEliminarProducto(){

        if(isset($_GET["idProducto"])){

            $tabla ="productos";
            $datos = $_GET["idProducto"];

            if($_GET["imagen"] != "" && $_GET["imagen"] != "vistas/img/productos/default/anonymous.png"){

                unlink($_GET["imagen"]);
                rmdir('vistas/img/productos/'.$_GET["codigo"]);

            }

            $respuesta = ModeloInventarios::mdlEliminarProducto($tabla, $datos);

            if($respuesta == "ok"){

                echo'<script>

                swal({
                      type: "success",
                      title: "El producto ha sido borrado correctamente",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      }).then(function(result){
                                if (result.value) {

                                window.location = "inventario";

                                }
                            })

                </script>';

            }       
        }


    }

    /*=============================================
    MOSTRAR SUMA VENTAS
    =============================================*/

    static public function ctrMostrarSumaVentas(){

        $tabla = "productos";

        $respuesta = ModeloInventarios::mdlMostrarSumaVentas($tabla);

        return $respuesta;

    }


}