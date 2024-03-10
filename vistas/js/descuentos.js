/*=============================================
EDITAR DESCUENTO
=============================================*/
$(".tablas").on("click", ".btnEditarDescuento", function(){

  var idDescuento = $(this).attr("idDescuento");

  var datos = new FormData();
  datos.append("idDescuento", idDescuento);

  $.ajax({

    url:"ajax/descuentos.ajax.php",
    method: "POST",
    data: datos, 
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(respuesta){
    
      $("#idDescuento").val(respuesta["id"]);
      $("#editarProducto").val(respuesta["id_producto"]);
      $("#editarDescripcionDescuentos").val(respuesta["descripcion"]);
      $("#editarDescuento").val(respuesta["descuento"]);

      // Convertir la fecha de inicio al formato YYYY-MM-DD
      var fechaInicio = new Date(respuesta["fecha_inicio"]);
      var fechaInicioFormato = fechaInicio.toISOString().split('T')[0];
      $("#editarInicio").val(fechaInicioFormato);

      // Convertir la fecha final al formato YYYY-MM-DD
      var fechaFinal = new Date(respuesta["fecha_final"]);
      var fechaFinalFormato = fechaFinal.toISOString().split('T')[0];
      $("#editarFinal").val(fechaFinalFormato);
    }

  });

});

/*=============================================
ELIMINAR DESCUENTO
=============================================*/
$(".tablas").on("click", ".btnEliminarDescuentos", function(){

  var idDescuento = $(this).attr("idDescuento");
  
  swal({
        title: '¿Está seguro de borrar el Descuento?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar Descuento!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=descuentos&idDescuento="+idDescuento;
        }

  })

})