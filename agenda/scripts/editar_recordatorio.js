$(document).ready(function(){
  $("div #confirmar").click(function(){
    let id = $("#codigo_recordatorio").attr("name");

    $.ajax({
      url: "../php/editar_recordatorio.php",
      method: "POST",
      async: false,
      data: $("#editar-recordatorio").serialize()+"&id="+id,
      success: function(){
        window.location.href = "../index.html";
      },
      error: function(respuesta){
        alert(respuesta);
      }
    })
  })
})