<?php

class ControladorCategorias{
/*=============================================
    CREAR CATEGORIAS
=============================================*/

static public function ctrCrearCategoria() {
    if (isset($_POST["nuevaCategoria"])) {
        if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaCategoria"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"])) {

            // Verificar si ya existe una categoría con el mismo nombre
            $categoria = $_POST["nuevaCategoria"];
            $existeCategoria = self::verificarExistenciaCategoria($categoria);

            if (!$existeCategoria) {
                $tabla = "categorias";

                $datos = array(
                    "categoria" => $_POST["nuevaCategoria"],
                    "descripcion" => $_POST["nuevaDescripcion"]
                );

                $respuesta = ModeloCategorias::mdlIngresarCategoria($tabla, $datos);

                if ($respuesta == "ok") {
                    echo '<script>
                        swal({
                            type: "success",
                            title: "La categoría ha sido guardada correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "categorias";
                            }
                        });
                    </script>';
                }
            } else {
                echo '<script>
                    swal({
                        type: "error",
                        title: "¡Ya existe una categoría con el mismo nombre!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "categorias";
                        }
                    });
                </script>';
            }
        } else {
            echo '<script>
                swal({
                    type: "error",
                    title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if (result.value) {
                        window.location = "categorias";
                    }
                });
            </script>';
        }
    }
}

static public function verificarExistenciaCategoria($categoria) {
    $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as total FROM categorias WHERE categoria = :categoria");
    $stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado["total"] > 0;
}



	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarCategorias($item, $valor){

		$tabla = "categorias";

		$respuesta = ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor);

		return $respuesta;
	
	}
/*=============================================
EDITAR CATEGORIA
=============================================*/

static public function ctrEditarCategoria(){

    if(isset($_POST["editarCategoria"])){

        if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCategoria"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"])){

            $tabla = "categorias";

            $datos = array(
                "categoria" => $_POST["editarCategoria"],
                "descripcion" => $_POST["editarDescripcion"], // Corregido aquí
                "id" => $_POST["idCategoria"]
            );

            $respuesta = ModeloCategorias::mdlEditarCategoria($tabla, $datos);

            if($respuesta == "ok"){

                echo'<script>

                swal({
                        type: "success",
                        title: "La categoría ha sido cambiada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                if (result.value) {

                                window.location = "categorias";

                                }
                            })

                </script>';

            }


        }else{

            echo'<script>

                swal({
                        type: "error",
                        title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {

                            window.location = "categorias";

                            }
                        })

                </script>';

        }

    }

}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function ctrBorrarCategoria(){
    if(isset($_GET["idCategoria"])){
        $tabla = "Categorias";
        $datos = $_GET["idCategoria"];

        // Verificar si hay productos asociados a la categoría
        $productosEnCategoria = self::verificarProductosEnCategoria($datos);

        if ($productosEnCategoria) {
            echo '<script>
                swal({
                    type: "warning",
                    title: "No se puede eliminar la categoría",
                    text: "Existen productos registrados en esta categoría. Elimine los productos antes de eliminar la categoría.",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if (result.value) {
                        window.location = "categorias";
                    }
                });
            </script>';
        } else {
            // No hay productos asociados, proceder con la eliminación de la categoría
            $respuesta = ModeloCategorias::mdlBorrarCategoria($tabla, $datos);

            if($respuesta == "ok"){
                echo '<script>
                    swal({
                          type: "success",
                          title: "La categoría ha sido borrada correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {
                                        window.location = "categorias";
                                    }
                                })
                    </script>';
            }
        }
    }
}

static public function verificarProductosEnCategoria($idCategoria){
    $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as total FROM productos WHERE id_categoria = :idCategoria");
    $stmt->bindParam(":idCategoria", $idCategoria, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado["total"] > 0;
}
}