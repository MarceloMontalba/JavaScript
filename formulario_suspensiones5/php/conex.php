<?php

  function conectarBd() {
    $usuario	= "portal.alumno";
    $clave		= "des.palumno.2017"; 
    $base	  	= "ACADEMIA";
    $db_host	= "desa.uct.cl";

    if( ($link=@mssql_connect($db_host, $usuario, $clave )) ){   
      if ( (@mssql_select_db($base, $link)) ) {   
        // Establece el formato de la fecha y ajustes para vistas remotas
        @mssql_query("SET DATEFORMAT DMY;", $link);
        @mssql_query("SET ANSI_NULLS ON; SET ANSI_WARNINGS ON", $link);
        return $link;	
      }
      else {   
        $mensaje 	=  "<h4><br/>No se pudo seleccionar la base de datos</h4>";
        $mensaje 	.= "<p><b>MOTIVO: </b>".mssql_get_last_message()."<p>";
        $mensaje	.= "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";
        echo err_header($mensaje);
        die();
      }
    }
    else{   
      $mensaje 	 = "<h4><br/>Error de conexión a la base de datos</h4>";
      $mensaje 	.="<h5>Ocurrió un error al intentar conectarse a la base de datos, puede probar recargando esta página.</h5>";
      $mensaje 	.="<p>Si el problema persiste contactarse con el administrador del sistema.</p>";
      $mensaje	.= "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";
      echo err_header($mensaje);
      die();
    }
  }
?>