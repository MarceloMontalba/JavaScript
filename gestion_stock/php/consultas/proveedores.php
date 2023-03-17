<?php
    include("conexion.php");

    $consulta = "SELECT * FROM proveedores";
    $consulta = mysqli_query($conexion, $consulta);

    $tabla = "
    <table class='mt-5'>
        <tr>
           <th>Código</th>
           <th>Proveedor</th>
           <th>Opciones</th>
        </tr>
        ";

    while($datos = mysqli_fetch_assoc($consulta)){
        $tabla .= "<tr>
                    <td>{$datos['id_proveedor']}</td>
                    <td>{$datos['nombre_proveedor']}</td>
                    <td>
                        <a class='btn btn-sm btn-warning'>
                            <i class='fa-solid fa-pencil'></i> Editar
                        </a>

                        <a class='btn btn-sm btn-danger text-white'>
                            <i class='fa-solid fa-trash'></i> Eliminar
                        </a>
                    </td>
                   </tr>";
        }

        $tabla .= "</table>";

        echo $tabla;
      ?>