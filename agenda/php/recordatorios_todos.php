<?php
  include("conexion.php");

  $consulta = "SELECT * FROM agenda ORDER BY id DESC";
  $consulta = mysqli_query($conexion, $consulta);

  $datos_obtenidos = [];
  while($datos = mysqli_fetch_assoc($consulta)){
    $datos_obtenidos[] = [$datos["id"], $datos["titulo"], str_replace("\r","<br>",$datos["cuerpo"]), $datos["fecha_hora"]];
  }
  
  echo json_encode($datos_obtenidos);
?>