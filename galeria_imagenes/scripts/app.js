$(document).ready(inicio);

function inicio(){
    $("#container img").click(abrirImagen);
    $("#img-previa").click(cerrarImagen);
}

function abrirImagen(){
    let nombre    = $(this).attr("alt");
    let direccion = "./img/"+nombre+".jpg";

    $("#img-completa").attr("src", direccion);
    $("#img-previa").fadeIn();
}

function cerrarImagen(){
    $("#img-previa").fadeOut();
}