$(document).ready(function(){
  let ranas = [1,1,1,0,2,2,2];

  $(".rana").click(function(){
    let idRana   = parseInt($(this).attr("id"));
    let sonidoSalto = new Audio("sounds/rana.mp3");
    let sonidoError = new Audio("sounds/error.mp3");

    //Si son ranas tipo 1
    if(ranas[idRana] === 1){
      if(idRana+1<ranas.length){
        if(ranas[idRana+1] === 0){
          ranas[idRana]   = 0;
          ranas[idRana+1] = 1;

          sonidoSalto.play();
        }
        else{
          if(idRana+2<ranas.length && ranas[idRana+2]===0 && ranas[idRana+1]!==1){
            ranas[idRana]   = 0;
            ranas[idRana+2] = 1;

            sonidoSalto.play();
          }
          else{
            sonidoError.play();
          }
        }
      }
      else{
        sonidoError.play();
      }
    }

    //Si son ranas tipo 2
    if(ranas[idRana] === 2){
      if(idRana-1 >= 0){
        if(ranas[idRana-1] === 0){
          ranas[idRana]   = 0;
          ranas[idRana-1] = 2;

          sonidoSalto.play();
        }
        else{
          if(idRana-2>=0 && ranas[idRana-2]===0 && ranas[idRana-1]!==2){
            ranas[idRana]   = 0;
            ranas[idRana-2] = 2;

            sonidoSalto.play();
          }
          else{
            sonidoError.play();
          }
        }
      }
      else{
        sonidoError.play();
      }
    }

    //Se pintan las imagenes de las ranas y en la piedra vacia se vuelve invisible
    //la imagen de dicha rana.
    for(i=0;i<7;i++){
      let rana = $("#"+i);

      if(ranas[i]===0){
        rana.css("visibility","hidden");
      }
      else{
        rana.css("visibility","visible");
        if(ranas[i]===1){
          rana.attr("src","img/rana_1.png");
        }
  
        if(ranas[i]===2){
          rana.attr("src","img/rana_2.png");
        }
      }
    }

    //Si el arreglo tiene los elementos en el orden señalado, 
    //significa que el jugador ganó.
    if(ranas.every((val, i) => val === [2,2,2,0,1,1,1][i])){
      $(".recarga").css("visibility","hidden");
      $(".contenedor-ganador").css("visibility","visible");
      let sonidoGanador = new Audio("sounds/ganar.mp3");
      sonidoGanador.play();
    }
  })

  function resetearJuego(){
    ranas = [1,1,1,0,2,2,2];
    $(".recarga").css("visibility","visible");
    $(".contenedor-ganador").css("visibility","hidden");

    //Se pintan las imagenes de las ranas y en la piedra vacia se vuelve invisible
    //la imagen de dicha rana.
    for(i=0;i<7;i++){
      let rana = $("#"+i);

      if(ranas[i]===0){
        rana.css("visibility","hidden");
      }
      else{
        rana.css("visibility","visible");
        if(ranas[i]===1){
          rana.attr("src","img/rana_1.png");
        }
  
        if(ranas[i]===2){
          rana.attr("src","img/rana_2.png");
        }
      }
    }

    let sonidoReseteo = new Audio("sounds/resetear.mp3");
    sonidoReseteo.play();
  }

  //Funcion que reseta el juego
  $(".recarga").click(resetearJuego);
  $(".btn-recargar").click(resetearJuego);
})