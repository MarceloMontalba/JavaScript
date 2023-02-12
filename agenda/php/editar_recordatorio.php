<?php
  include("conexion.php");

  $id     = $_POST["id"];
  $titulo = $_POST["input_titulo"];
  $cuerpo = $_POST["input_contenido"];

  $consulta = "UPDATE agenda SET titulo='{$titulo}',cuerpo='{$cuerpo}' WHERE id={$id}";
  $consulta = mysqli_query($conexion, $consulta);

?>