let formulario = document.querySelector(".formulario-solicitud");
formulario.addEventListener("click", function(e){
  let elemento = e.target;
  let esBotonSiguiente = elemento.classList.contains("paso-boton-siguiente");
  let esBotonRegreso   = elemento.classList.contains("paso-boton-regresar");

  if(esBotonSiguiente || esBotonRegreso) {
    let pasoActual = document.getElementById("paso-"+elemento.dataset.step);
    let pasoSaltar = document.getElementById("paso-"+elemento.dataset.to_step);
    
    pasoActual.classList.remove("paso-activo");
    pasoSaltar.classList.add("paso-activo");
    
    console.log(pasoActual);
    console.log(pasoSaltar);
    if(esBotonSiguiente) {
      pasoSaltar.classList.add("paso-izquierda");
    } 
    if(esBotonRegreso){
      pasoSaltar.classList.remove("paso-izquierda");
    }
  }
})