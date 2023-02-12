<?php
  include("conexion.php");
  
  $id_eliminado   = $_POST["id_eliminado"];
  $consulta = "DELETE FROM agenda WHERE id={$id_eliminado}";

  $consulta = mysqli_query($conexion, $consulta);

?>