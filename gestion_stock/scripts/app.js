$(document).ready(function(){
  //El Encabezado seleccionado de la barra de navegacion se deja activo
  $(".nav-link").click(function(){
    $(".nav-link").removeClass("active")
    $(this).addClass("active")
  })

  $("#boton-stock").click(function(){
    $.ajax({
      url: "consultas/productos.php",
      method: "POST",
      success: function(result){
        $(".contenido-pagina").html(result)
      }
    })
  })

  $("#boton-proveedores").click(function(){
    $.ajax({
      url: "consultas/proveedores.php",
      method: "POST",
      success: function(result){
        $(".contenido-pagina").html(result)
      }
    })
  })
})