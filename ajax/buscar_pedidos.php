<?php


include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
    $idPedido = intval($_GET['id']);
    $query2 = "CALL SP_eliminarPedido(" . $idPedido . ")";
    if ($delete1 = mysqli_query($con, $query2)) {
        ?>
        <div class="alert alert-success mt-p1" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <strong>Aviso!</strong> Datos eliminados exitosamente.
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-danger alert-dismissible mt-p1" role="alert">
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
        </div>
        <?php

    }
}
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array(
        'prod.nom_Producto',
        'ped.fecha_pedido',
        'ped.idPedido',
        'c.idCliente'
    ); //Columnas de busqueda
    $sTable = "Pedidos ped";
    $sWhere = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    //$sWhere .= " WHERE ped.estado = '1' ORDER BY ped.idPedido DESC";
    if ($sWhere != "") {
        $sWhere .= " AND ped.estado='1'";
    } else {
        $sWhere .= " WHERE ped.estado='1'";
    }
    $sWhere .= " ORDER BY ped.idPedido DESC";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable JOIN Detalle_Pedidos det ON ped.idPedido = det.idPedido
    JOIN Producto prod ON det.idProducto = prod.idProducto
    JOIN cliente c ON ped.idCliente = c.idCliente
    LEFT JOIN Persona per ON c.idPersona = per.idPersona
    LEFT JOIN Empresa emp ON c.idEmpresa = emp.idEmpresa $sWhere");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = './clientes.php';
    //main query to fetch the data
    $sql = "SELECT ped.idPedido, det.idProducto,
            prod.nom_Producto AS producto,
            det.Cantidad,
            det.Precio_Total,
            ped.fecha_pedido, c.idCliente FROM  $sTable  
            JOIN Detalle_Pedidos det ON ped.idPedido = det.idPedido
            JOIN Producto prod ON det.idProducto = prod.idProducto
            JOIN cliente c ON ped.idCliente = c.idCliente
            LEFT JOIN Persona per ON c.idPersona = per.idPersona
            LEFT JOIN Empresa emp ON c.idEmpresa = emp.idEmpresa
            $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
    //loop through fetched data
    if ($numrows > 0) {

        ?>
        <div class="table-responsive mt-4">
            <table class="table table-light table-striped">
                <tr class="table-dark">
                    <th class="text-center">Codigo</th>
                    <th class="text-center">Producto</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Codigo Cliente</th>
                    <th class='text-center'>Acciones</th>

                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $idPedido = $row['idPedido'];
                    $cliente = $row['idCliente'];
                    $producto = $row['producto'];
                    $cantidad = $row['Cantidad'];
                    $idProducto = $row['idProducto'];
                    $precio = number_format($row['Precio_Total'], 2);
                    $fecha_adicion = date('Y-m-d', strtotime($row['fecha_pedido']));
                    ?>

                    <input type="hidden" value="<?php echo $idProducto; ?>" id="producto<?php echo $idPedido; ?>">
                    <input type="hidden" value="<?php echo $cantidad; ?>" id="cantidad<?php echo $idPedido; ?>">
                    <input type="hidden" value="<?php echo $cliente; ?>" id="cliente<?php echo $idPedido; ?>">

                    <tr>
                        <td class="text-center">
                            <?php echo $idPedido; ?>
                        </td>
                        <!--<td>
                            <?php //echo $cliente; ?>
                        </td>-->
                        <td>
                            <?php echo $producto; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $cantidad; ?>
                        </td>
                        <td class="text-center">S/.
                            <?php echo $precio; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $fecha_adicion; ?>
                        </td>

                        <td class="text-center">
                            <?php echo $cliente; ?>
                        </td>

                        <td class="text-center">
                            <!--<a href="#" class="btn btn-secondary" title="Editar categoría"
                                data-nombre="<?php //echo $nom_Categoria; ?>" 
                                data-descripcion="<?php //echo $Descripcion; ?>"
                                data-id="<?php //echo $idPedido; ?>" data-bs-toggle="modal" data-bs-target="#myModal2">
                                <i class="bi bi-pencil"></i>
                            </a>-->
                            <a href="#" class="btn btn-secondary" title="Editar Pedido" data-bs-toggle="modal"
                                data-bs-target="#myModal2" onclick="obtener_datos('<?php echo $idPedido; ?>');"><i
                                    class="bi bi-pencil"></i></a>
                            <a href="#" class="btn btn-secondary" title="Borrar categoría"
                                onclick="eliminar('<?php echo $idPedido; ?>')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>


                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan=7><span class="pull-right">
                            <?php
                            echo paginate($reload, $page, $total_pages, $adjacents);
                            ?>
                        </span></td>
                </tr>
            </table>
        </div>
        <?php
    }
}
?>
<style>
    pagination>.active>a,
    .pagination>.active>a:focus,
    .pagination>.active>a:hover,
    .pagination>.active>span,
    .pagination>.active>span:focus,
    .pagination>.active>span:hover {
        z-index: 3;
        color: #fff;
        cursor: default;
        background-color: #3c763d;
        border-color: #ccc;
    }

    .pagination li {
        margin-right: 5px;
    }

    a {
        color: #3c763d;
    }
</style>