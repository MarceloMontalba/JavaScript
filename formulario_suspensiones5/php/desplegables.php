<?php
  header('Content-Type: text/html; charset=utf-8');
  $accion = isset($_POST["accion"])?$_POST["accion"]:"";
  $idMotivo = isset($_POST["id_motivo"])?$_POST["id_motivo"]:"";

  // Motivos
  function listarMotivos(){
    $link = conectarBd();
    $sql = "SELECT tmos_codigo, tmos_nombre 
            FROM ACADEMIA.dbo.tipo_motivos_solicitud";
    
    $query = mssql_query($sql, $link);
    $desplegable = array();
    while($respuesta = mssql_fetch_object($query)){
      array_push($desplegable, array("id"=>$respuesta->tmos_codigo, "nombre"=>utf8_encode($respuesta->tmos_nombre)));
    }

    return $desplegable;
  }

  if ($accion=="motivosDetallados" AND $idMotivo!=""){
    include_once("./conex.php");

    $link = conectarBd();
    $sql = "SELECT DISTINCT stm.stmo_codigo codigo, stm.stmo_nombre nombre 
            FROM ACADEMIA.dbo.solicitud_motivos_detalle smd
            INNER JOIN ACADEMIA.dbo.solicitud_tipo_motivo stm
            ON smd.stmo_codigo=stm.stmo_codigo
            WHERE smd.tmos_codigo=$idMotivo and smd.smde_vigente='S'";
    
    $query = mssql_query($sql, $link);
    $desplegable = array();
    while($respuesta = mssql_fetch_object($query)){
      array_push($desplegable, array("id"=>$respuesta->codigo, "nombre"=>utf8_encode($respuesta->nombre)));
    }

    echo json_encode($desplegable);
  }
?>