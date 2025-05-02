<?php


/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
	$idUsuario = intval($_GET['id']);
	$query = mysqli_query($con, "select * from usuario where idUsuario='" . $idUsuario . "'");
	$rw_user = mysqli_fetch_array($query);
	$count = $rw_user['idUsuario'];
	if ($idUsuario != 1) {
		$sqleliminar = "CALL SP_eliminarUsuario(" . $idUsuario . ")";
		if ($delete1 = mysqli_query($con, $sqleliminar)) {
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php

		}

	} else {
		?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
					aria-hidden="true">&times;</span></button>
			<strong>Error!</strong> No se puede borrar el usuario administrador.
		</div>
		<?php
	}



}
if ($action == 'ajax') {
	// escaping, additionally removing everything that could be (html/javascript-) code
	$q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
	$aColumns = array('p.nombre', 'p.Ape_Paterno', 'u.nombre_usuario', 'u.usuario_email', 'p.Ape_Materno'); // Columnas de búsqueda
	$sTable = "usuario u";
	$sWhere = "";
	if ($_GET['q'] != "") {
		$sWhere = "WHERE (";
		for ($i = 0; $i < count($aColumns); $i++) {
			$sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
		}
		$sWhere = substr_replace($sWhere, "", -3);
		$sWhere .= ')';
	}
	//$sWhere .= " WHERE u.estado = '1' ORDER BY u.idUsuario DESC";
	if ($sWhere != "") {
		$sWhere .= " AND u.estado='1'";
	} else {
		$sWhere .= " WHERE u.estado='1'";
	}
	$sWhere .= " ORDER BY u.idUsuario";
	include 'pagination.php'; // Incluir archivo de paginación
	// Variables de paginación
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
	$per_page = 10; // Cuántos registros quieres mostrar por página
	$adjacents = 4; // Brecha entre páginas después del número de adyacentes
	$offset = ($page - 1) * $per_page;
	// Contar el número total de filas en tu tabla
	$count_query = mysqli_query($con, "SELECT COUNT(*) AS numrows FROM $sTable
	INNER JOIN empleado e ON u.idEmpleado = e.idEmpleado
	INNER JOIN persona p ON e.idPersona = p.idPersona
	$sWhere");
	$row = mysqli_fetch_array($count_query);
	$numrows = $row['numrows'];
	$total_pages = ceil($numrows / $per_page);
	$reload = './usuarios.php';
	// Consulta principal para obtener los datos
	$sql = "SELECT u.idUsuario, CONCAT(p.nombre, ' ', p.Ape_Paterno, ' ',p.Ape_Materno) AS nombre_completo, u.nombre_usuario, u.usuario_email, u.fecha_agregado FROM $sTable
				INNER JOIN empleado e ON u.idEmpleado = e.idEmpleado
				INNER JOIN persona p ON e.idPersona = p.idPersona
				$sWhere LIMIT $offset, $per_page";
	$query = mysqli_query($con, $sql);
	// Loop para mostrar los datos
	if ($numrows > 0) {
		?>
		<div class="table-responsive mt-4">
			<table class="table table-light table-striped">
				<tr class="table-dark">
					<!--<th class="text-center">ID</th>-->
					<th class="text-center">Nombre</th>
					<th class="text-center">Usuario</th>
					<th class="text-center">Email</th>
					<th class="text-center">Agregado</th>
					<th class="text-center"><span>Acciones</span></th>
				</tr>
				<?php
				while ($row = mysqli_fetch_array($query)) {
					$idUsuario = $row['idUsuario'];
					$nombreCompleto = $row['nombre_completo'];
					$nombre_usuario = $row['nombre_usuario'];
					$usuario_email = $row['usuario_email'];
					$fecha_agregado = date('d/m/Y', strtotime($row['fecha_agregado']));
					?>

					<input type="hidden" value="<?php echo $nombre_usuario; ?>" id="usuario<?php echo $idUsuario; ?>">
					<input type="hidden" value="<?php echo $usuario_email; ?>" id="email<?php echo $idUsuario; ?>">

					<tr>
						<!--<td class="text-center">
							<?php //echo $idUsuario; ?>
						</td>-->
						<td>
							<?php echo $nombreCompleto; ?>
						</td>
						<td>
							<?php echo $nombre_usuario; ?>
						</td>
						<td>
							<?php echo $usuario_email; ?>
						</td>
						<td class="text-center">
							<?php echo $fecha_agregado; ?>
						</td>
						<td>
							<div class="text-center">
								<a href="#" class="btn btn-outline-secondary" title="Editar usuario"
									onclick="obtener_datos('<?php echo $idUsuario; ?>');" data-bs-toggle="modal"
									data-bs-target="#myModal2"><i class="bi bi-pencil"></i></a>
								<a href="#" class="btn btn-outline-secondary" title="Cambiar contraseña"
									onclick="get_user_id('<?php echo $idUsuario; ?>');" data-bs-toggle="modal"
									data-bs-target="#myModal3"><i class="bi bi-gear"></i></a>
								<a href="#" class="btn btn-outline-secondary" title="Borrar usuario"
									onclick="eliminar('<?php echo $idUsuario; ?>')"><i class="bi bi-trash"></i></a>
							</div>
						</td>

					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan="9"><span class="pull-right">
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