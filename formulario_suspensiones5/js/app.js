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
  let listaIds = "#seleccion-suspensiones, #seleccion-renuncia";
  let tipoFormulario = boton.closest(listaIds).attr("id");
  let idBoton = $(boton).attr("id");
  let pasosProgreso = $("#"+tipoFormulario+" .barra-progreso-opcion");
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
      if(pasoActual-2>=0){
        pasosProgreso[pasoActual-2].classList.remove("barra-progreso-opcion-completado");
        pasosProgreso[pasoActual-2].classList.add("barra-progreso-opcion-activo");
      }
    }
  }

  // Se ocultan todos los pasos de la suspension excepto el actual
  $("#"+tipoFormulario+" .paso-suspensiones").hide();
  if(idBoton === "btn-continuar-suspension") {
    $("#"+tipoFormulario+" #aviso-suspension-beneficios1").show();
  }
  if(idBoton === "btn-continuar-suspension2") {
    $("#"+tipoFormulario+" #suspension-beneficios1").show();
  }
  if(idBoton === "btn-continuar-confirmacion1") {
    $("#"+tipoFormulario+" #suspension-confirmacion1").show();
  }
  if(idBoton === "btn-regresar-suspension-beneficios1") {
    $("#"+tipoFormulario+" #suspension-beneficios1").show();
  }
  if(idBoton === "btn-aviso-suspension-beneficios1") {
    $("#"+tipoFormulario+" #aviso-suspension-beneficios1").show();
  }
  if(idBoton === "btn-regresar-suspension-academica") {
    $("#"+tipoFormulario+" #suspension-academica").show();
  }

  // Se redirecciona a la cabecera del modulo
  let cabeceraApartado = $("#posicionador-scroll").offset().top-110;
  $(".contenedor-principal").animate({
    scrollTop: "+=" + cabeceraApartado
  }, 900)
}

function actualizaMotivos(idComboSeleccionado, idComboModificable){
  // Se bloquea el combo modificable
  $("#"+idComboModificable).attr("disabled", true);
  let reseteoOption = "<option value='-1' selected>Seleccionar motivo...</option>";
  $("#"+idComboModificable).html(reseteoOption)

  $.ajax({
    url: "php/desplegables.php",
    method: "POST",
    data: {
      accion: "motivosDetallados",
      id_motivo: idComboSeleccionado
    },
    success: function(respuesta){
      let nuevosOption = "<option value='-1' selected>Seleccionar motivo...</option>";

      let contador = 0;
      Object.values(JSON.parse(respuesta)).forEach(motivo => {
        nuevosOption += "<option value='"+motivo.id+"'>"+motivo.nombre+"</option>";
        contador++;
      })
      
      if (contador>0){
        $("#"+idComboModificable).attr("disabled", false);
      }else {
        $("#"+idComboModificable).attr("disabled", true);
      }
      $("#"+idComboModificable).html(nuevosOption);
    }
  })
}

function eliminarMotivo(boton){
  alert("hola");
  console.log(boton.closest("tr"));
}

function agregarMotivosTabla(idMotivo, idMotivoDetallado, idTabla){
  let valorMotivo          = $("#"+idMotivo).val();
  let valorMotivoDetallado = $("#"+idMotivoDetallado).val();


  if(parseInt(valorMotivo)!==-1 && parseInt(valorMotivoDetallado)!==-1){
    let motivo = $("#"+idMotivo+" option:selected").text();
    let motivoDetallado = $("#"+idMotivoDetallado+" option:selected").text();
    let tablaMotivos = $("#"+idTabla+" tbody");

    // Se eliminan los espaciados del cuerpo y se analiza si la lista esta vacia
    let contenidoLista = tablaMotivos.html().replace(/\s+/g,"")==="<tr><td></td><td></td><td></td></tr>"?"":tablaMotivos.html();

    contenidoLista += `<tr>
                        <td style='width:7rem'>${motivo}</td>
                        <td>${motivoDetallado}</td>
                        <td style='width:7rem'>
                          <button class='boton boton-rojo boton-chico' type='button'>
                            <i class="fa-solid fa-xmark boton-quitar-motivo"></i> Quitar
                          </button>
                        </td>
                      </tr>`;
    tablaMotivos.html(contenidoLista);
    
    // Si se preciona el boton de quitar motivo
    $("main").on("click",".boton-quitar-motivo",function(){eliminarMotivo($(this))});
  }
}

$(document).ready(function(){
  // Selecciones Estarán Ocultas
  $(".seleccion-tipo-solicitud").hide();

  // Secciones de los formularios que estan invosibles al inicio
  $("#seleccion-suspensiones #aviso-suspension-beneficios1").hide();
  $("#seleccion-suspensiones #suspension-beneficios1").hide();
  $("#seleccion-suspensiones #suspension-confirmacion1").hide();

  $("#seleccion-renuncia #aviso-suspension-beneficios1").hide();
  $("#seleccion-renuncia #suspension-beneficios1").hide();
  $("#seleccion-renuncia #suspension-confirmacion1").hide();

  // Se dejan los motivos detallados como desactivados
  $("#input-motivo-detallado-suspension1").attr("disabled", true);

  // Se visualiza la solicitud deseada
  $(".btn-solicitud").click(function(){seleccionaTipoSolicitud($(this))});

  // Se intercambia de paso dependiendo de lo que se presionó
  $(".boton-secuencia").click(function(){cambiarPaso($(this))});

  // Se actualizan los motivos
  $("#input-motivo-suspension1").change(function(){actualizaMotivos($(this).val(), "input-motivo-detallado-suspension1")});

  // Si se presiona el boton de agregar 
  $("#boton-agregar-motivo-suspension1").click(function(){agregarMotivosTabla("input-motivo-suspension1", "input-motivo-detallado-suspension1", "tabla-motivos-suspensiones1")});
})