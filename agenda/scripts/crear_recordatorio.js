$(document).ready(function(){
    $("#confirmar").click(function(){
        let formulario = $("#crear-recordatorio");
        $.ajax({
            type: "POST",
            url: "../php/crear_recordatorio.php",
            async: false,
            data: formulario.serialize(),
            success: function(){
                window.location.href = "../index.html";
            },
            error: function(){
                window.location.href = "../index.html";
                alert("Ha ocurrido un error!.")
            }
        })
    })
})