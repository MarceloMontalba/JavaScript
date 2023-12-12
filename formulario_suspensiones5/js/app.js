// Función que selecciona el tipo de solicitud
function seleccionaTipoSolicitud(boton){
  let idBoton = boton.attr("id");

  // Se deja activo el boton seleccionado
  $(".btn-solicitud").removeClass("active");
  $(`#${idBoton}`).addClass("active");

  // Se deja visible el formulario deseado
  if(idBoton === "btn-suspension"){
    $(".mensaje-bienvenida").hide();
    $(".seleccion-tipo-solicitud").hide();
    $("#seleccion-suspensiones").show();
  }
  if(idBoton === "btn-renuncia"){
    $(".mensaje-bienvenida").hide();
    $(".seleccion-tipo-solicitud").hide();
    $("#seleccion-renuncia").show();
  }
  if(idBoton === "btn-reincorporacion"){
    $(".mensaje-bienvenida").hide();
    $(".seleccion-tipo-solicitud").hide();
    $("#seleccion-reincorporacion").show();
  }
}

$(document).ready(function(){
  // Selecciones Estarán Ocultas
  $(".seleccion-tipo-solicitud").hide();

  // Secciones de los formularios que estan invosibles al inicio
  $("#suspension-beneficios1").hide();
  $("#suspension-confirmacion1").hide();

  // Se visualiza la solicitud deseada
  $(".btn-solicitud").click(function(){seleccionaTipoSolicitud($(this))});

  // Botones continuar 
  $(".boton-continuar").click(function(){
    let idBoton = $(this).attr("id");

    if(idBoton === "btn-continuar-suspension") {
      $("#suspension-academica").hide();
      $("#suspension-beneficios1").show();
    }
    if(idBoton === "btn-regresar-suspension-academica") {
      $("#suspension-beneficios1").hide();
      $("#suspension-academica").show();
    }
    if(idBoton === "btn-continuar-confirmacion1") {
      $("#suspension-beneficios1").hide();
      $("#suspension-confirmacion1").show();
    }
    if(idBoton == "btn-regresar-suspension-beneficios1") {
      $("#suspension-confirmacion1").hide();
      $("#suspension-beneficios1").show();
    }
  });
})