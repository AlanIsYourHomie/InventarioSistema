<?php


include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
	$idCategoria = intval($_GET['id']);
	//$query = mysqli_query($con, "select * from producto where idCategoria='" . $idCategoria . "'");
	//$count = mysqli_num_rows($query);
	//if ($count == 0) {
	$query2 = "CALL SP_eliminarCategoriaYProductos(" . $idCategoria . ")";
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

	//} else {
	?><!--
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
					aria-hidden="true">&times;</span></button>
			<strong>Error!</strong> No se pudo eliminar ésta categoría. Existen productos vinculados a ésta categoría.
		</div>-->
	<?php
	//}




}
if ($action == 'ajax') {
	// escaping, additionally removing everything that could be (html/javascript-) code
	$q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
	$aColumns = array('nom_Categoria'); //Columnas de busqueda
	$sTable = "categoria";
	$sWhere = "";
	if ($_GET['q'] != "") {
		$sWhere = "WHERE (";
		for ($i = 0; $i < count($aColumns); $i++) {
			$sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
		}
		$sWhere = substr_replace($sWhere, "", -3);
		$sWhere .= ')';
	}
	//$sWhere .= " where estado='1' order by nom_Categoria";
	if ($sWhere != "") {
		$sWhere .= " AND estado='1'";
	} else {
		$sWhere .= " WHERE estado='1'";
	}
	$sWhere .= " ORDER BY nom_Categoria";
	include 'pagination.php'; //include pagination file
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
	$per_page = 10; //how much records you want to show
	$adjacents = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	//Count the total number of row in your table*/
	$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
	$row = mysqli_fetch_array($count_query);
	$numrows = $row['numrows'];
	$total_pages = ceil($numrows / $per_page);
	$reload = './clientes.php';
	//main query to fetch the data
	$sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
	$query = mysqli_query($con, $sql);
	//loop through fetched data
	if ($numrows > 0) {

		?>
		<div class="table-responsive mt-4">
			<table class="table table-light table-striped">
				<tr class="table-dark">
					<th>Nombre</th>
					<th>Descripción</th>
					<th>Agregado</th>
					<th class='text-center'>Acciones</th>

				</tr>
				<?php
				while ($row = mysqli_fetch_array($query)) {
					$idCategoria = $row['idCategoria'];
					$nom_Categoria = $row['nom_Categoria'];
					$Descripcion = $row['Descripcion'];
					$fecha_adicion = date('d/m/Y', strtotime($row['fecha_adicion']));

					?>
					<tr>

						<td>
							<?php echo $nom_Categoria; ?>
						</td>
						<td>
							<?php echo $Descripcion; ?>
						</td>
						<td>
							<?php echo $fecha_adicion; ?>
						</td>

						<td class="text-center">
							<a href="#" class="btn btn-secondary" title="Editar categoría"
								data-nombre="<?php echo $nom_Categoria; ?>" data-descripcion="<?php echo $Descripcion; ?>"
								data-id="<?php echo $idCategoria; ?>" data-bs-toggle="modal" data-bs-target="#myModal2">
								<i class="bi bi-pencil"></i>
							</a>
							<a href="#" class="btn btn-secondary" title="Borrar categoría"
								onclick="eliminar('<?php echo $idCategoria; ?>')">
								<i class="bi bi-trash"></i>
							</a>
						</td>


					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=4><span class="pull-right">
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