<?php


include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
    $idCliente = intval($_GET['id']);
    $query2 = "CALL SP_eliminarCliente(" . $idCliente . ")";
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
        'c.idCliente',
        'per.Ape_Materno',
        'per.Nombre',
        'per.Ape_Materno',
        'emp.Razon_Social',
        'per.dni',
        'emp.ruc',
        'per.celular',
        'emp.telefono',
        'd.nom_distrito'
    ); //Columnas de busqueda
    $sTable = "cliente c";
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
        $sWhere .= " AND c.estado='1'";
    } else {
        $sWhere .= " WHERE c.estado='1'";
    }
    $sWhere .= " ORDER BY c.idCliente ASC";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable 
    LEFT JOIN persona per ON c.idPersona = per.idPersona
    LEFT JOIN empresa emp ON c.idEmpresa = emp.idEmpresa
    LEFT JOIN distrito d ON per.idDistrito = d.idDistrito OR emp.idDistrito = d.idDistrito $sWhere");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = '../clientes.php';
    //main query to fetch the data
    $sql = "SELECT c.idCliente,per.ape_paterno,per.ape_materno,per.nombre,emp.razon_social as razonSocial,per.dni,emp.ruc as ruc,per.celular,
                   emp.telefono as telefonoempresa,d.nom_distrito,per.idPersona,emp.idEmpresa as idEmpresa,per.direccion,per.fecnac, per.sexo, per.estado_civil, per.idDistrito as distritopersona,
                   emp.idDistrito as distritoempresa, emp.direccion as direccionempresa,
            CASE
                WHEN per.idPersona IS NOT NULL THEN CONCAT(per.ape_paterno, ' ', per.ape_materno, ' ', per.nombre)
                WHEN emp.idEmpresa IS NOT NULL THEN emp.razon_social
            END AS nombre_cliente,
            CASE
                WHEN per.idPersona IS NOT NULL THEN per.dni
                WHEN emp.idEmpresa IS NOT NULL THEN emp.ruc
            END AS identificador,
            CASE
                WHEN per.idPersona IS NOT NULL THEN per.celular
                WHEN emp.idEmpresa IS NOT NULL THEN emp.telefono
            END AS telefono,
            d.nom_distrito AS nombre_distrito FROM $sTable  
            LEFT JOIN persona per ON c.idPersona = per.idPersona
            LEFT JOIN empresa emp ON c.idEmpresa = emp.idEmpresa
            LEFT JOIN distrito d ON per.idDistrito = d.idDistrito OR emp.idDistrito = d.idDistrito 
            $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
    //loop through fetched data
    if ($numrows > 0) {

        ?>
        <div class="table-responsive mt-4">
            <table class="table table-light table-striped">
                <tr class="table-dark">
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Identificador</th>
                    <th>Teléfono</th>
                    <!--<th class="text-center">Codigo Pedido</th>-->
                    <th>Ubicación</th>
                    <th class='text-center'>Acciones</th>

                </tr>

                <?php
                while ($row = mysqli_fetch_array($query)) {

                    $idPersona = $row['idPersona'];
                    $apepaterno = $row['ape_paterno'];
                    $apematerno = $row['ape_materno'];
                    $nombre_persona = $row['nombre'];
                    $dni = $row['dni'];
                    $sexo = $row['sexo'];
                    $direccion = $row['direccion'];
                    $estado_civil = $row['estado_civil'];
                    $celular = $row['celular'];
                    $idDistrio = $row['distritopersona'];
                    $fecnac = $row['fecnac'];

                    $idEmpresa = $row['idEmpresa'];
                    $razonSocial = $row['razonSocial'];
                    $direccion2 = $row['direccionempresa'];
                    $ruc = $row['ruc'];
                    $telefonoempresa = $row['telefonoempresa'];

                    $Codigo = $row['idCliente'];
                    $Nombre = $row['nombre_cliente'];
                    $Identificador = $row['identificador'];
                    $Teléfono = $row['telefono'];
                    $Ubicación = $row['nombre_distrito'];
                    ?>
                    <input type="hidden" value="<?php echo $apepaterno; ?>" id="apepaterno<?php echo $idPersona; ?>">
                    <input type="hidden" value="<?php echo $apematerno; ?>" id="apematerno<?php echo $idPersona; ?>">
                    <input type="hidden" value="<?php echo $nombre_persona; ?>" id="nombre_persona<?php echo $idPersona; ?>">
                    <input type="hidden" value="<?php echo $dni; ?>" id="dni<?php echo $idPersona; ?>">
                    <input type="hidden" value="<?php echo $sexo; ?>" id="sexo<?php echo $idPersona; ?>">
                    <input type="hidden" value="<?php echo $direccion; ?>" id="direccion<?php echo $idPersona; ?>">
                    <input type="hidden" value="<?php echo $estado_civil; ?>" id="estado_civil<?php echo $idPersona; ?>">
                    <input type="hidden" value="<?php echo $celular; ?>" id="celular<?php echo $idPersona; ?>">
                    <input type="hidden" value="<?php echo $idDistrio; ?>" id="idDistrio<?php echo $idPersona; ?>">
                    <input type="hidden" value="<?php echo $fecnac; ?>" id="fecnac<?php echo $idPersona; ?>">


                    <input type="hidden" value="<?php echo $razonSocial; ?>" id="razonSocial<?php echo $idEmpresa; ?>">
                    <input type="hidden" value="<?php echo $direccion2; ?>" id="direccion2<?php echo $idEmpresa; ?>">
                    <input type="hidden" value="<?php echo $ruc; ?>" id="ruc<?php echo $idEmpresa; ?>">
                    <input type="hidden" value="<?php echo $telefonoempresa; ?>" id="telefono<?php echo $idEmpresa; ?>">


                    <tr>
                        <td>
                            <?php echo $Codigo; ?>
                        </td>
                        <td>
                            <?php echo $Nombre; ?>
                        </td>
                        <td>
                            <?php echo $Identificador; ?>
                        </td>
                        <td>
                            <?php echo $Teléfono; ?>
                        </td>
                        <!--<td class="text-center">
                            <?php //echo $CodigoP; ?>
                        </td>-->
                        <td>
                            <?php echo $Ubicación; ?>
                        </td>

                        <td class="text-center">
                            <a href="#" class="btn btn-secondary" title="Editar cliente" onclick="editarCliente('<?php echo $Codigo; ?>', '<?php echo $Identificador; ?>');
                                obtener_datos('<?php echo $idPersona; ?>');
                                obtener_datos2('<?php echo $idEmpresa; ?>');">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <script>
                                function editarCliente(idCliente, identificador) {
                                    // Verificar el tipo de cliente mediante el identificador
                                    var tipoCliente = identificador.length === 8 ? 'persona' : 'empresa';

                                    // Luego, abre el modal correspondiente según el tipo_cliente
                                    if (tipoCliente === 'persona') {
                                        abrirModalPersona(idCliente);
                                    } else if (tipoCliente === 'empresa') {
                                        abrirModalEmpresa(idCliente);
                                    } else {
                                        alert('Tipo de cliente no reconocido');
                                    }
                                }

                                function abrirModalPersona(idCliente) {
                                    // Lógica para abrir el modal de persona
                                    // Por ejemplo, puedes utilizar el código que proporcionaste anteriormente
                                    $('#myModal2').modal('show');
                                }

                                function abrirModalEmpresa(idCliente) {
                                    // Lógica para abrir el modal de empresa
                                    // Por ejemplo, puedes utilizar el código que proporcionaste anteriormente
                                    $('#myModal3').modal('show');
                                }

                                function obtenerTipoCliente(idCliente) {
                                    return $.ajax({
                                        url: 'obtener_tipo_cliente.php',
                                        method: 'POST',
                                        data: { idCliente: idCliente },
                                        dataType: 'json'
                                    });
                                }

                            </script>
                            <a href="#" class="btn btn-secondary" title="Borrar cliente"
                                onclick="eliminar('<?php echo $Codigo; ?>');"><i class=" bi bi-trash"></i>
                            </a>
                        </td>


                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan=6><span class="pull-right">
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