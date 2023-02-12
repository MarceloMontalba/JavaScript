<?php
  include("conexion.php");

  $cadena_buscada = $_POST["input-busqueda"];
  $consulta       = "SELECT * FROM agenda WHERE titulo LIKE '%{$cadena_buscada}%' OR cuerpo LIKE '%{$cadena_buscada}%' ORDER BY id DESC;";
  $consulta       = mysqli_query($conexion, $consulta);

  $datos_obtenidos =[];
  while($datos = mysqli_fetch_assoc($consulta)){
    $datos_obtenidos[] = [$datos["id"], $datos["titulo"], str_replace("\r","<br>",$datos["cuerpo"]), $datos["fecha_hora"]];
  }

  echo json_encode($datos_obtenidos);
?>