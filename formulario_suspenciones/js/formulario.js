let formulario = document.querySelector(".formulario-solicitud");
let progreso = document.querySelectorAll(".barra-progreso-opcion");

formulario.addEventListener("click", function(e){
  let elemento = e.target;
  let esBotonSiguiente = elemento.classList.contains("paso-boton-siguiente");
  let esBotonRegreso   = elemento.classList.contains("paso-boton-regresar");

  let esPaso = elemento.classList.contains("paso-pasar");

  if(esBotonSiguiente || esBotonRegreso) {
    let pasoActual = document.getElementById("paso-"+elemento.dataset.step);
    let pasoSaltar = document.getElementById("paso-"+elemento.dataset.to_step);
    
    pasoActual.classList.remove("paso-activo");
    pasoSaltar.classList.add("paso-activo");
    
    if(esBotonSiguiente) {
      pasoSaltar.classList.add("paso-izquierda");
      if(esPaso){
        progreso[elemento.dataset.paso_actual-1].classList.add('barra-progreso-opcion-activo');
      }
    } 
    if(esBotonRegreso){
      pasoActual.classList.remove("paso-izquierda");
      if(esPaso){
        progreso[elemento.dataset.paso_actual-1].classList.remove('barra-progreso-opcion-activo'); 
      }
    }
  }
})