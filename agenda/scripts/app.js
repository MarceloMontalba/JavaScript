let idEliminado;

//Debido a que una pagina JQuery es reactiva y no proactiva,
//al filtrar datos, las funciones que escuchan los eventos de eliminar
//y editar ya no lo haran para entonces debido a que estos "nuevos" datos
//se crearon despues de que los eventos se ejecutaron.
function eliminarRecordatorio(id){
  idEliminado = id;
  $("#contenido-eliminar").css("visibility", "visible");
}

$(document).ready(function(){
  //Al cargar en un inicio la pagina se cargaran TODOS los recordatorios
    //almacenados en la bd de MySQL.
    let recordatorios;
    
    //Se establece el scroll en la parte superior
    $(".contenedor-recordatorios").scrollTop(0);
    
    $.ajax({
        url: "php/recordatorios_todos.php",
        type: "POST",
        async: false,
        success: function(respuesta){
            recordatorios = JSON.parse(respuesta);
        }
    })

    recordatorios.forEach(fila => {
        let nuevoRecordatorio = `
            <div class="card col-12 bg-warning mt-3 p-3">
              <h5 class="card-title"><b>${fila[1]}</b></h5>
              <h6 class="card-subtitle mb-2 text-muted">${fila[3]}</h6>

              <div style="padding: 10px">
                <div class="card-text">${fila[2]}</div>

                <div class="container mt-3">
                    <div class="row d-flex justify-content-center">
                        <a class="btn btn-primary col-5 col-sm-4 col-md-5 col-lg-3 m-2" href="php/ver_recordatorio.php?id=${fila[0]}">
                          <i class="fa-sharp fa-solid fa-pen-to-square"></i> Editar
                        </a>

                        <a class="btn btn-danger col-5 col-sm-4 col-md-5 col-lg-3 m-2 eliminar" alt=${fila[0]}>
                          <i class="fa-sharp fa-solid fa-trash"></i> Eliminar
                        </a>
                    </div>
                </div>
              </div>
            </div>`;
        $(".contenedor-recordatorios").append(nuevoRecordatorio);
    })

    //Se detecta si se precionó el boton de buscar
    $("#btn-buscar").click(function(){
      $.ajax({
        url: "php/buscar_recordatorio.php",
        method: "POST",
        async: false,
        data: $("#buscar-recordatorios").serialize(),
        success: function(respuesta){
          let datosFiltrados = JSON.parse(respuesta);
          
          $(".contenedor-recordatorios").html("");
          datosFiltrados.forEach(fila => {
            let nuevoRecordatorio = `
            <div class="card col-12 bg-warning mt-3 p-3">
              <h5 class="card-title"><b>${fila[1]}</b></h5>
              <h6 class="card-subtitle mb-2 text-muted">${fila[3]}</h6>

              <div style="padding: 10px">
                <div class="card-text">${fila[2]}</div>

                <div class="container mt-3">
                    <div class="row d-flex justify-content-center">
                        <a class="btn btn-primary col-5 col-sm-4 col-md-5 col-lg-3 m-2" href="php/ver_recordatorio.php?id=${fila[0]}">
                          <i class="fa-sharp fa-solid fa-pen-to-square"></i> Editar
                        </a>

                        <a class="btn btn-danger col-5 col-sm-4 col-md-5 col-lg-3 m-2 eliminar" alt=${fila[0]}>
                          <i class="fa-sharp fa-solid fa-trash"></i> Eliminar
                        </a>
                    </div>
                </div>
              </div>
            </div>`;
            
            $(".contenedor-recordatorios").append(nuevoRecordatorio);
          })
          //Se establece el scroll en la parte superior
          $(".contenedor-recordatorios").scrollTop(0);
        },
        error: function(respuesta){
          alert(respuesta);
        }
      })
    })

    //Se detecta si se hizo click en algun boton de eliminar del recordatorio
    $("div .eliminar").click(function(){
      idEliminado = $(this).attr("alt");
      $("#contenido-eliminar").css("visibility", "visible");
    })

    //Se detecta si se hizo click confirmar la eliminacion del recordatorio
    $("#confirmar-eliminacion").click(function(){
      $.ajax({
        url: "php/eliminar_recordatorio.php",
        method: "POST",
        data: {"id_eliminado": idEliminado},
        async: true,
        success: function(respuesta){
          window.location.href = "index.html"
        },
        error: function(){
          alert("Ha ocurrido un error!!!")
        }
      })

      $("#contenido-eliminar").css("visibility", "hidden");
    })

    //Se detecta si se hizo click cancelar la eliminacion del recordatorio
    $("#cancelar-eliminacion").click(function(){
      $("#contenido-eliminar").css("visibility", "hidden");
    })
});