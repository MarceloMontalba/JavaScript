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

  // Se visualiza la solicitud deseada
  $(".btn-solicitud").click(function(){seleccionaTipoSolicitud($(this))});
})