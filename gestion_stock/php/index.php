<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/styles.css">
  <title>Gestion de Stock</title>
</head>

<body>
  <!--Barra de navegación-->
  <nav class="navbar navbar-expand-lg navbar-dark mi-nav">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
        
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <ul class="navbar-nav mt-2 mr-4 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link active" style="font-size: 1.3em" id="boton-stock">
            <i class="fa-solid fa-cart-flatbed"></i> Gestión de Stock
          </a>
        </li>
      </ul>

      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item mr-2">
          <a class="nav-link" id="boton-proveedores">
            <i class="fa-solid fa-handshake"></i> Proveedores
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link">
            <i class="fa-solid fa-users"></i> Usuarios
          </a>
        </li>
      </ul>

      <ul class="navbar-nav mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!--Contenido-->
  <div class="container-fluid">
    <div class="row contenido-pagina d-flex justify-content-center">
      <?php include("consultas/productos.php"); ?>
    </div>
  </div>

  <!--Scripts-->
  <script src="../scripts/jquery-3.6.3.js"></script>
  <script src="../scripts/bootstrap.min.js"></script>
  <script src="../scripts/app.js"></script>
</body>
</html>