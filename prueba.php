<?php

session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
	header("location: login.php");
	exit;
}

/* Connect To Database*/
require_once("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php"); //Contiene funcion que conecta a la base de datos

$active_productos = "active";
$title = "Inventario | TOTTUS";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include("head.php"); ?>
</head>

<body style="display: flex; flex-direction: column; min-height: 100vh;">
	<?php
	include("navbar.php");
	?>

	<div class="container mt-p1">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h4 class="my-auto"><i class='bi bi-search'></i> Consultar inventario</h4>
				<div class="btn-group">
					<button type='button' class="btn btn-success" data-bs-toggle="modal"
						data-bs-target="#nuevoProducto">
						<span class="bi bi-plus-circle"></span>
					</button>
				</div>
			</div>
			<div class="card-body">
				<?php
				include("modal/registro_productos.php");
				include("modal/editar_productos.php");
				?>
				<form class="form" role="form" id="datos">
					<div class="row">
						<div class='col-md-4'>
							<label for="q" class="form-label">Filtrar por código o nombre</label>
							<input type="text" class="form-control" id="q" placeholder="Código o nombre del producto"
								oninput="load(1);">
						</div>

						<div class='col-md-4'>
							<label for="idCategoria" class="form-label">Filtrar por categoría</label>
							<select class='form-select' name='idCategoria' id='idCategoria' onchange="load(1);">
								<option value="">Selecciona una categoría</option>
								<?php
								$query_categoria = mysqli_query($con, "select * from categoria order by nom_Categoria");
								while ($rw = mysqli_fetch_array($query_categoria)) {
									?>
									<option value="<?php echo $rw['idCategoria']; ?>">
										<?php echo $rw['nom_Categoria']; ?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
						<div class='col-md-12 text-center'>
							<span id="loader"></span>
						</div>
					</div>
					<hr>
					<div class='row align-items-start'>
						<div id="resultados"></div><!-- Carga los datos ajax -->
					</div>
					<div class='row'>
						<div class='outer_div'></div><!-- Carga los datos ajax -->
					</div>
				</form>
			</div>
		</div>
	</div>
	<hr>
	<?php
	include("footer.php");
	?> <!-- Agrega el enlace al archivo JavaScript de tus productos -->
	<script src="js/productos.js"></script>
</body>

</html>
<script>
	function eliminar(id) {
		var q = $("#q").val();
		var idCategoria = $("#idCategoria").val();
		$.ajax({
			type: "GET",
			url: "./ajax/buscar_productos.php",
			data: "id=" + id, "q": q + " idCategoria=" + idCategoria,
			beforeSend: function (objeto) {
				$("#resultados").html("Mensaje: Cargando...");
			},
			success: function (datos) {
				$("#resultados").html(datos);
				load(1);
			}
		});
	}

	$(document).ready(function () {

		<?php
		if (isset($_GET['delete'])) {
			?>
			eliminar(<?php echo intval($_GET['delete']) ?>);
			<?php
		}

		?>
	});

	$("#guardar_producto").submit(function (event) {
		$('#guardar_datos').attr("disabled", true);

		var formData = new FormData($(this)[0]); // Crea un objeto FormData con los datos del formulario

		$.ajax({
			type: "POST",
			url: "ajax/nuevo_producto.php",
			data: formData,
			contentType: false, // Importante: Desactiva el tipo de contenido de la petición
			processData: false, // Importante: Desactiva el procesamiento de datos de la petición
			beforeSend: function (objeto) {
				$("#resultados_ajax_productos").html("Mensaje: Cargando...");
			},
			success: function (datos) {
				$("#resultados_ajax_productos").html(datos);
				$('#guardar_datos').attr("disabled", false);
				load(1);
			}
		});

		event.preventDefault();
	});


</script>

<style>
	.row2 {
		margin-right: -15px;
		margin-left: -15px;
	}

	.card-header .h4 {
		color: white;
	}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
	$(function () {

		$('.custom-dropdown').on('show.bs.dropdown', function () {
			var that = $(this);
			setTimeout(function () {
				that.find('.dropdown-menu').addClass('active');
			}, 100);


		});
		$('.custom-dropdown').on('hide.bs.dropdown', function () {
			$(this).find('.dropdown-menu').removeClass('active');
		});

	});

	const dropdownLinks = document.querySelectorAll('.custom-dropdown .nav-link');
	const dropdownMenus = document.querySelectorAll('.custom-dropdown .dropdown-menu');

	dropdownLinks.forEach((link, index) => {
		link.addEventListener('click', (e) => {
			e.preventDefault();
			const menu = dropdownMenus[index];
			const arrow = link.querySelector('i');

			if (menu.style.display === 'block') {
				menu.style.display = 'none';
				arrow.style.transform = 'rotate(0deg)';
			} else {
				menu.style.display = 'block';
				arrow.style.transform = 'rotate(-180deg)';
			}
		});
	});


</script>

<style>
	.h4,
	h4 {
		font-weight: 800;
	}
</style>