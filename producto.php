<?php

session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
	header("location: login.php");
	exit;
}

/* Connect To Database*/
require_once("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php"); //Contiene funcion que conecta a la base de datos
include("funciones.php");

$active_productos = "active";
$active_clientes = "";
$active_usuarios = "";
$title = "Producto| ALMACEN TOTTUS";

if (isset($_POST['reference']) and isset($_POST['quantity'])) {
	$quantity = intval($_POST['quantity']);
	$reference = mysqli_real_escape_string($con, (strip_tags($_POST["reference"], ENT_QUOTES)));
	$idProducto = intval($_GET['id']);
	$idUsuario = $_SESSION['user_id'];
	$nombre = $_SESSION['firstname'];
	$nota = "$nombre agregó $quantity producto(s) al inventario";

	$fecha = date("Y-m-d H:i:s");
	guardar_historial($idProducto, $idUsuario, $fecha, $nota, $reference, $quantity);
	$update = agregar_stock($idProducto, $quantity);
	if ($update == 1) {
		$message = 1;
	} else {
		$error = 1;
	}
}

if (isset($_POST['reference_remove']) and isset($_POST['quantity_remove'])) {
	$quantity = intval($_POST['quantity_remove']);
	$reference = mysqli_real_escape_string($con, (strip_tags($_POST["reference_remove"], ENT_QUOTES)));
	$idProducto = intval($_GET['id']);
	$idUsuario = $_SESSION['user_id'];
	$nombre = $_SESSION['firstname'];
	$nota = "$nombre eliminó $quantity producto(s) del inventario";
	$fecha = date("Y-m-d H:i:s");
	guardar_historial($idProducto, $idUsuario, $fecha, $nota, $reference, $quantity);
	$update = eliminar_stock($idProducto, $quantity);
	if ($update == 1) {
		$message = 1;
	} else {
		$error = 1;
	}
}

if (isset($_GET['id'])) {
	$idProducto = intval($_GET['id']);
	$query = mysqli_query($con, "select * from producto where idProducto='$idProducto'");
	$row = mysqli_fetch_array($query);

} else {
	die("Producto no existe");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include("head.php"); ?>
</head>

<body style="display: flex; flex-direction: column; min-height: 100vh;">
	<?php
	//VER LA PROXIMA SEMANA
	include("navbar.php");
	include("modal/agregar_stock.php");
	include("modal/eliminar_stock.php");
	include("modal/editar_productos.php");

	?>
	<div class="container ">
		<div class="grid text-center mt-p1">
			<div class="g-col-12">
				<div class="card text-center">
					<div class="card-body align-items-center">
						<div class="row">
							<div class="col-sm-4 text-center">
								<img class="img-thumbnail img-fluid rounded"
									src="ajax/buscar_imagen.php?idProducto=<?php echo $row['idProducto']; ?>" alt="">
								<br>
								<a href="#" class="btn btn-danger mt-4"
									onclick="eliminar('<?php echo $row['idProducto']; ?>')" title="Eliminar">
									<i class="bi bi-trash"></i> Eliminar
								</a>
								<a href="#" data-bs-target="#myModal2" data-bs-toggle="modal"
									data-codigo='<?php echo $row['codigo_producto']; ?>'
									data-nombre='<?php echo $row['nom_Producto']; ?>'
									data-categoria='<?php echo $row['idCategoria'] ?>'
									data-precio='<?php echo $row['Precio_Venta'] ?>'
									data-stock='<?php echo $row['stock']; ?>'
									data-id='<?php echo $row['idProducto']; ?>' class="btn btn-info mt-4"
									title="Editar">
									<i class="bi bi-pencil"></i> Editar
								</a>
							</div>
							<div class="col-sm-4 text-start">
								<div class="row mb-sm-5">
									<div class="col-sm-12">
										<span class="card-title2">
											<?php echo $row['nom_Producto']; ?>
										</span>
									</div>
									<div class="col-sm-12 row mb-sm-1">
										<h6 class="card-subtitle mb-2 text-body-secondary">
											<?php echo $row['codigo_producto']; ?>
										</h6>
									</div>
									<div class="card mb-2 mt-2" style="width: 18rem;">
										<div class="card-header2">Stock disponible</div>
										<ul class="list-group list-group-flush">
											<li class="list-group-item">
												<?php echo number_format($row['stock']); ?>
											</li>
										</ul>
									</div>
									<div class="card mb-2 mt-2" style="width: 18rem;">
										<div class="card-header2">Precio venta</div>
										<ul class="list-group list-group-flush">
											<li class="list-group-item">
												S/.
												<?php echo number_format($row['Precio_Venta'], 2); ?>
											</li>
										</ul>
									</div>
									<div class="col-sm-12 row mb-sm-1">
									</div>
									<div class="col-sm-6 col-6 col-md-4">
										<a href="" data-bs-toggle="modal" data-bs-target="#add-stock">
											<img width="100px" src="img/stock-in.png" alt="Agregar Stock">
										</a>
									</div>

									<div class="col-sm-6 col-6 col-md-4">
										<a href="" data-bs-toggle="modal" data-bs-target="#remove-stock">
											<img width="100px" src="img/stock-out.png">
										</a>
									</div>
									<div class="col-sm-12 row mb-sm-1">
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-8 text-left">
								<div class="row">
									<?php
									if (isset($message)) {
										?>
										<div class="alert alert-success alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											<strong>Aviso!</strong> Datos procesados exitosamente.
										</div>
										<?php
									}
									if (isset($error)) {
										?>
										<div class="alert alert-danger alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											<strong>Error!</strong> No se pudo procesar los datos.
										</div>
										<?php
									}
									?>
									<table class='table table-bordered'>
										<tr>
											<th class='text-center' colspan="5">HISTORIAL DE INVENTARIO</th>
										</tr>
										<tr>
											<td>Fecha</td>
											<td>Hora</td>
											<td>Descripción</td>
											<td>Referencia</td>
											<td class='text-center'>Total</td>
										</tr>
										<?php
										$query = mysqli_query($con, "select * from historial where idProducto='$idProducto'");
										while ($row = mysqli_fetch_array($query)) {
											?>
											<tr>
												<td>
													<?php echo date('d/m/Y', strtotime($row['fecha'])); ?>
												</td>
												<td>
													<?php echo date('H:i:s', strtotime($row['fecha'])); ?>
												</td>
												<td>
													<?php echo $row['descripcion']; ?>
												</td>
												<td>
													<?php echo $row['referencia']; ?>
												</td>
												<td class='text-center'>
													<?php echo number_format($row['cantidad'], 2); ?>
												</td>
											</tr>
											<?php
										}
										?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



	<div class="mt-auto">
		<?php include("footer.php"); ?>
	</div>
	<script type="text/javascript" src="js/productos.js"></script>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
	$("#editar_producto").submit(function (event) {
		$('#actualizar_datos').attr("disabled", true);

		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "ajax/editar_producto.php",
			data: parametros,
			beforeSend: function (objeto) {
				$("#resultados_ajax5").html("Mensaje: Cargando...");
			},
			success: function (datos) {
				$("#resultados_ajax5").html(datos);
				$('#actualizar_datos').attr("disabled", false);
				window.setTimeout(function () {
					$(".alert").fadeTo(500, 0).slideUp(500, function () {
						$(this).remove();
					});
					location.replace('prueba.php');
				}, 4000);
			}
		});
		event.preventDefault();
	})

	$('#myModal2').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var codigo = button.data('codigo') // Extract info from data-* attributes
		var nombre = button.data('nombre')
		var categoria = button.data('categoria')
		var precio = button.data('precio')
		var stock = button.data('stock')
		var id = button.data('id')
		var modal = $(this)

		modal.find('.modal-body #mod_codigo').val(codigo)
		modal.find('.modal-body #mod_nombre').val(nombre)
		modal.find('.modal-body #mod_categoria').val(categoria)
		modal.find('.modal-body #mod_precio').val(precio)
		modal.find('.modal-body #mod_stock').val(stock)
		modal.find('.modal-body #mod_id').val(id)
	})

	function eliminar(id) {
		var q = $("#q").val();
		if (confirm("Realmente deseas eliminar el producto")) {
			location.replace('prueba.php?delete=' + id);
		}
	}
</script>