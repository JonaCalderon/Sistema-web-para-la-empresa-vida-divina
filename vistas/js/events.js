/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarEvento", function(){

	var idEvento = $(this).attr("idEvento");

	var datos = new FormData();
    datos.append("idEvento", idEvento);

    $.ajax({

      url:"ajax/eventos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      
      	   $("#idEvento").val(respuesta["id"]);
	       $("#editarEvento").val(respuesta["title"]);
	       $("#editarDescripcion").val(respuesta["description"]);
	       $("#editarInicio").val(respuesta["start_datetime"]);
	       $("#editarFinal").val(respuesta["end_datetime"]);
	      
	  }

  	})

})



/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarEvento", function(){

	var idEvento = $(this).attr("idEvento");
	
	swal({
        title: '¿Está seguro de borrar el Evento?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar Evento!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=events&idEvento="+idEvento;
        }

  })

})
