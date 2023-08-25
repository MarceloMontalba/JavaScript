const btnCierra = document.querySelector("#btn-cierra");
const btnAdelanta = document.querySelector("#btn-adelanta");
const btnRetrocede = document.querySelector("#btn-retrocede");
const imagenes = document.querySelectorAll("#galeria img");
const contenedorPrincipal = document.querySelector("#contenedor-principal");
const imagenActiva = document.querySelector("#img-activa");
let indiceImagen = 0;

const abreVentana = (event) => {
    imagenActiva.src = event.target.src;
    contenedorPrincipal.style.display = "flex";
    indiceImagen = Array.from(imagenes).indexOf(event.target);
}

imagenes.forEach(imagen => {
    imagen.addEventListener("click", abreVentana);
});

btnCierra.addEventListener("click", () => {
    contenedorPrincipal.style.display = "none";
})

const adelantaImagen =  () => {
    indiceImagen = (indiceImagen === imagenes.length-1)? -1 : indiceImagen;
    imagenActiva.src = imagenes[indiceImagen + 1].src;
    indiceImagen ++;
}

btnAdelanta.addEventListener("click", adelantaImagen);

const retrocedeImagen = () => {
    indiceImagen = (indiceImagen === 0)? imagenes.length : indiceImagen; 
    imagenActiva.src = imagenes[indiceImagen - 1].src;
    indiceImagen --;
}

btnRetrocede.addEventListener("click", retrocedeImagen);