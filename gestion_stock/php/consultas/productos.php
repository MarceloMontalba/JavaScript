<?php
    include("conexion.php");

    $consulta = "SELECT * FROM productos";
    $consulta = mysqli_query($conexion, $consulta);

    $tabla = "
    <table class='mt-5'>
        <tr>
           <th>Código</th>
           <th>Producto</th>
           <th>Cantidad c/u</th>
           <th>Precio</th>
           <th>Stock</th>
           <th>Opciones</th>
        </tr>
        ";

    while($datos = mysqli_fetch_assoc($consulta)){
        $tabla .= "<tr>
                    <td>{$datos['id_producto']}</td>
                    <td>{$datos['nombre_producto']}</td>
                    <td>{$datos['cantidad_unidad']}</td>
                    <td>{$datos['precio']}</td>
                    <td>{$datos['unidades_existentes']}</td>
                    <td>
                        <a class='btn btn-sm btn-primary text-white'>
                            <i class='fa-solid fa-eye'></i> Ver Detalles
                        </a>

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