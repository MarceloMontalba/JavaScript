// Función que selecciona el tipo de solicitud
function seleccionaTipoSolicitud(boton){
  let idBoton = boton.attr("id");

  // Se deja activo el boton seleccionado
  $(".btn-solicitud").removeClass("active");
  $(`#${idBoton}`).addClass("active");

  // Se deja visible el formulario deseado
  if(idBoton === "btn-instrucciones"){
    $("#mensaje-bienvenida").show();
    $("#seleccion-suspensiones").hide();
    $("#seleccion-renuncia").hide();
    $("#seleccion-reincorporacion").hide();
  }
  if(idBoton === "btn-suspension"){
    $("#mensaje-bienvenida").hide();
    $("#seleccion-suspensiones").show();
    $("#seleccion-renuncia").hide();
    $("#seleccion-reincorporacion").hide();
  }
  if(idBoton === "btn-renuncia"){
    $("#mensaje-bienvenida").hide();
    $("#seleccion-suspensiones").hide();
    $("#seleccion-renuncia").show();
    $("#seleccion-reincorporacion").hide();
  }
  if(idBoton === "btn-reincorporacion"){
    $("#mensaje-bienvenida").hide();
    $("#seleccion-suspensiones").hide();
    $("#seleccion-renuncia").hide();
    $("#seleccion-reincorporacion").show();
  }
}

// Funcion para cambiar de vista de cada uno de los pasos
function cambiarPaso(boton){
  let idBoton = $(boton).attr("id");
    let pasosProgreso = $(".barra-progreso-opcion");
    let pasoActual = $(boton).attr("data-step");

    // Se cambian los check de los pasos segun sea el caso
    if(boton.hasClass("boton-continua")){
      pasosProgreso[pasoActual].classList.add("barra-progreso-opcion-activo");
      if(pasoActual-1>=0){
        pasosProgreso[pasoActual-1].classList.remove("barra-progreso-opcion-activo");
        pasosProgreso[pasoActual-1].classList.add("barra-progreso-opcion-completado");
      }
    }else {
      if(boton.hasClass("boton-regresa")){
        pasosProgreso[pasoActual-1].classList.remove("barra-progreso-opcion-activo");
        console.log(pasoActual)
        if(pasoActual-2>=0){
          pasosProgreso[pasoActual-2].classList.remove("barra-progreso-opcion-completado");
          pasosProgreso[pasoActual-2].classList.add("barra-progreso-opcion-activo");
        }
      }
    }

    // Se ocultan todos los pasos excepto el actual
    $(".paso-suspensiones").hide();
    if(idBoton === "btn-continuar-suspension") {
      $("#aviso-suspension-beneficios1").show();
    }
    if(idBoton === "btn-continuar-suspension2") {
      $("#suspension-beneficios1").show();
    }
    if(idBoton === "btn-continuar-confirmacion1") {
      $("#suspension-confirmacion1").show();
    }
    if(idBoton === "btn-regresar-suspension-beneficios1") {
      $("#suspension-beneficios1").show();
    }
    if(idBoton === "btn-aviso-suspension-beneficios1") {
      $("#aviso-suspension-beneficios1").show();
    }
    if(idBoton === "btn-regresar-suspension-academica") {
      $("#suspension-academica").show();
    }
    // Se redirecciona a la cabecera del modulo
    let cabeceraApartado = $("#posicionador-scroll").offset().top-110;
    console.log(cabeceraApartado)
    $(".contenedor-principal").animate({
      scrollTop: "+=" + cabeceraApartado
    }, 900)
}

$(document).ready(function(){
  // Selecciones Estarán Ocultas
  $(".seleccion-tipo-solicitud").hide();

  // Secciones de los formularios que estan invosibles al inicio
  $("#aviso-suspension-beneficios1").hide();
  $("#suspension-beneficios1").hide();
  $("#suspension-confirmacion1").hide();

  // Se visualiza la solicitud deseada
  $(".btn-solicitud").click(function(){seleccionaTipoSolicitud($(this))});

  // Se intercambia de paso dependiendo de lo que se presionó
  $(".boton-secuencia").click(function(){cambiarPaso($(this))});
})