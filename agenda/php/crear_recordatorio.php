<?php
  include("conexion.php");
  
  $titulo   = $_POST["input_titulo"];
  $cuerpo   = $_POST["input_contenido"];
  $fecha    = date("Y-m-d H:i:s");
  $consulta = "INSERT INTO agenda(titulo, cuerpo, fecha_hora) VALUES('{$titulo}','{$cuerpo}','{$fecha}')";

  $consulta = mysqli_query($conexion, $consulta);
?>