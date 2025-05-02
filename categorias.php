<?php

session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
	header("location: login.php");
	exit;
}

/* Connect To Database*/
require_once("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php"); //Contiene funcion que conecta a la base de datos

$active_categoria = "active";
$title = "Categoría | TOTTUS";
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
				<h4 class="my-auto"><i class='bi bi-search'></i> Buscar Categorías</h4>
				<div class="btn-group">
					<button type='button' class="btn btn-success" data-bs-toggle="modal"
						data-bs-target="#nuevoCliente"><span class="bi bi-plus-circle"></span></button>
				</div>
			</div>
			<div class="card-body">
				<?php
				include("modal/registro_categorias.php");
				include("modal/editar_categorias.php");
				?>
				<form class="form" role="form" id="datos_cotizacion">
					<div class="row">
						<label for="q" class="col-md-2 col-form-label text-center">Nombre</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="q" placeholder="Nombre de la categoría"
								onkeyup='load(1);'>
						</div>
						<div class="col-md-4">
							<button type="button" class="btn btn-default" onclick='load(1);'>
								<span class="bi bi-search"></span> Buscar</button>
							<span id="loader"></span>
						</div>
					</div>
				</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			</div>
		</div>
	</div>
	<hr>
	<div class="mt-auto">
		<?php include("footer.php"); ?>
	</div>
	<script type="text/javascript" src="js/categorias.js"></script>
</body>

</html>

<style>
	.h4,
	h4 {
		font-weight: 800;
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