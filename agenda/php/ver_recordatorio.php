<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar recordatorio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="../../cdn/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="h-100 d-flex align-items-center">
      <div class="container" id="contenedor">
        <div class="row">
          <div class="col-12 col-md-10 col-lg-7 container-fluid">
            
            <div class="card">
              <div class="card-header bg-warning">
                <h5>Modificar recordatorio</h5>
              </div>
              <div class="card-body container">

                <form id="editar-recordatorio">
                
                  <?php
                    include("conexion.php");

                    $id_recordatorio = $_GET["id"];
                    $consulta        = "SELECT * FROM agenda WHERE id={$id_recordatorio}";
                    $consulta        = mysqli_query($conexion, $consulta);

                    $datos_obtenidos = [];
                    while($datos = mysqli_fetch_assoc($consulta)){
                      $datos_obtenidos = [$datos["id"], $datos["titulo"], $datos["cuerpo"]];
                    }
                    

                    echo '
                      <span id="codigo_recordatorio" name="'.$datos_obtenidos[0].'"></span>
                      <div class="form-group row mt-2">
                        <label for="input_titulo" class="col-lg-3 col-form-label">Titulo</label>
                        <div class="col-lg-9">
                          <input type="text" class="form-control" name="input_titulo" placeholder="Ingresar titulo..." value="'.$datos_obtenidos[1].'">
                        </div>
                      </div>

                      <div class="form-group row mt-2">
                        <label for="inputEmail3" class="col-lg-3 col-form-label">Contenido</label>
                        <div class="col-lg-9">
                          <textarea class="form-control" name="input_contenido" placeholder="Ingresar contenido..." rows="10">'.$datos_obtenidos[2].'</textarea>
                        </div>
                      </div>
                    ';
                  ?>

                  <div class="form-group row mt-4">
                    <div class="col-12 d-flex justify-content-center">
                      <a class="btn btn-outline-success m-2" id="confirmar">
                        <i class="fa-solid fa-check"></i> Confirmar
                      </a>
                        
                      <a class="btn btn-outline-danger m-2" href="../index.html">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                      </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            
          </div>
        </div>
      </div>
    </div>
    
    <!--Scripts-->
    <script src="../../cdn/jquery-3.6.3.min.js"></script>
    <script src="../scripts/editar_recordatorio.js"></script>
  </body>
</html>