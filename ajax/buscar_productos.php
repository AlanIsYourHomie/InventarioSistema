<?php


include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
include("../funciones.php");
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
	$idProducto = intval($_GET['id']);
	$query2 = "CALL SP_eliminarProducto(" . $idProducto . ")";
	if ($delete1 = mysqli_query($con, $query2)) {
		?>
		<div class="alert alert-success mt-1" role="alert">
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			<strong>Aviso!</strong> Datos eliminados exitosamente.
		</div>
		<?php

		header("Location: prueba.php");
		exit();
	} else {
		?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
					aria-hidden="true">&times;</span></button>
			<strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
		</div>
		<?php

	}

}

if ($action == 'ajax') {
	// escaping, additionally removing everything that could be (html/javascript-) code
	$q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
	$idCategoria = intval($_REQUEST['idCategoria']);
	$aColumns = array('codigo_producto', 'nom_Producto'); //Columnas de busqueda
	$sTable = "producto";
	$sWhere = "";
	$sWhere2 = "";

	$sWhere = "WHERE (";
	for ($i = 0; $i < count($aColumns); $i++) {
		$sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
	}
	$sWhere = substr_replace($sWhere, "", -3);
	$sWhere .= ')';

	if ($idCategoria > 0) {
		$sWhere .= " and idCategoria='$idCategoria'";
	}
	$sWhere .= " AND estado = 1";
	$sWhere .= " order by idProducto asc";
	include 'pagination.php'; //include pagination file
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
	$per_page = 18; //how much records you want to show
	$adjacents = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	//Count the total number of row in your table*/
	$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
	$row = mysqli_fetch_array($count_query);
	$numrows = $row['numrows'];
	$total_pages = ceil($numrows / $per_page);
	$reload = './productos.php';
	//main query to fetch the data
	$sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
	$query = mysqli_query($con, $sql);
	//loop through fetched data
	if ($numrows > 0) {

		?>
		<div class="row">
			<?php

			$nums = 1;
			while ($row = mysqli_fetch_array($query)) {
				$idProducto = $row['idProducto'];
				$codigo_producto = $row['codigo_producto'];
				$nom_Producto = $row['nom_Producto'];
				$stock = $row['stock'];
				?>

				<div class="col-lg-2 col-md-6 col-sm-6 col-12 text-center">
					<div class="card mb-4 mt-2 h-100 d-flex flex-column">
						<a class="thumbnail" href="producto.php?id=<?php echo $idProducto; ?>">
							<span title="Current quantity" class="badge badge-secondary stock-counter">
								<?php echo number_format($stock, 2); ?>
							</span>
							<span title="Low stock" class="low-stock-alert"
								ng-show="item.current_quantity <= item.low_stock_threshold">
								<i class="fas fa-exclamation-triangle"></i>
							</span>
							<div class="img-container" style="height: 200px; overflow: hidden; display: flex; align-items: center;">
								<img class="card-img-top img-fluid"
									src="ajax/buscar_imagen.php?idProducto=<?php echo $row['idProducto']; ?>" alt="">
							</div>
						</a>
						<div class="card-body flex-column justify-content-between">
							<h6 class="card-title">
								<?php echo $nom_Producto; ?>
							</h6>
							<p class="card-text">
								<?php echo $codigo_producto; ?>
							</p>
						</div>
					</div>
				</div>




				<?php
				if ($nums % 6 == 0) {
					echo "<div class='clearfix'></div>";
				}
				$nums++;
			}
			?>
		</div>
		<div class="clearfix"></div>
		<div class='row'>
			<div>
				<?php
				echo paginate($reload, $page, $total_pages, $adjacents);
				?>
			</div>
		</div>

		<?php
	}
}
?>

<style>
	.thumb-name {
		font-weight: bold;
		display: block;
		font-size: 12px;
	}

	.stock-counter {
		opacity: 0.8;
		position: absolute;
		margin-top: 5px;
		right: 21px;
	}

	.badge {
		display: inline-block;
		min-width: 10px;
		padding: 3px 7px;
		font-size: 12px;
		font-weight: 700;
		line-height: 1;
		color: #fff;
		text-align: center;
		white-space: nowrap;
		vertical-align: middle;
		background-color: #777;
		border-radius: 10px;
	}

	.low-stock-alert {
		opacity: 0.8;
		position: absolute;
		margin-top: 5px;
		left: 21px;
		color: red;
	}

	.item-quantity {
		font-size: 40px;
	}

	.current-stock {
		font-size: 16px;
		font-weight: bold;
	}

	.item-number {
		font-size: 20px;
	}

	.item-title {
		font-size: 23px;
		font-weight: bold;
	}

	.item-price {
		font-size: 23px;
		font-weight: bold;
		color: #388e3c;
	}

	.pagination>.active>a,
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