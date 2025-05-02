<?php

session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
	header("location: login.php");
	exit;
}

/* Connect To Database*/
require_once("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php"); //Contiene funcion que conecta a la base de datos
$active_usuarios = "active";
$title = "Usuarios | TOTTUS";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include("head.php"); ?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body style="display: flex; flex-direction: column; min-height: 100vh;">
	<?php
	include("navbar.php");
	?>
	<div class="container mt-p1">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h4 class="my-auto"><i class='bi bi-search'></i> Buscar Usuarios</h4>
				<div class="btn-group">
					<button type='button' class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal"><span
							class="bi bi-plus-circle"></span></button>
				</div>
			</div>
			<div class="card-body">
				<?php
				include("modal/registro_usuarios.php");
				include("modal/editar_usuarios.php");
				include("modal/cambiar_password.php");
				?>
				<form class="form-horizontal" role="form" id="datos_cotizacion">

					<div class="form-group row">
						<label for="q" class="col-md-2 col-form-label text-center">Nombres</label>
						<div class="col-md-5">
							<input type="text" class="form-control" id="q" placeholder="Nombre" onkeyup='load(1);'>
						</div>



						<!--<div class="col-md-3">
							<button type="button" class="btn btn-default" onclick='load(1);'>
								<span class="glyphicon glyphicon-search"></span> Buscar</button>
							<span id="loader"></span>
						</div>-->

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
	<script type="text/javascript" src="js/usuarios.js"></script>
</body>

</html>

<style>
	.h4,
	h4 {
		font-weight: 800;
	}
</style>
<script>
	$("#guardar_usuario").submit(function (event) {
		$('#guardar_datos').attr("disabled", true);

		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "ajax/nuevo_usuario.php",
			data: parametros,
			beforeSend: function (objeto) {
				$("#resultados_ajax").html("Mensaje: Cargando...");
			},
			success: function (datos) {
				$("#resultados_ajax").html(datos);
				$('#guardar_datos').attr("disabled", false);
				load(1);
			}
		});
		event.preventDefault();
	})

	$("#editar_usuario").submit(function (event) {
		$('#actualizar_datos2').attr("disabled", true);

		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "ajax/editar_usuario.php",
			data: parametros,
			beforeSend: function (objeto) {
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			},
			success: function (datos) {
				$("#resultados_ajax2").html(datos);
				$('#actualizar_datos2').attr("disabled", false);
				load(1);
			}
		});
		event.preventDefault();
	})

	$("#editar_password").submit(function (event) {
		$('#actualizar_datos3').attr("disabled", true);

		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "ajax/editar_password.php",
			data: parametros,
			beforeSend: function (objeto) {
				$("#resultados_ajax3").html("Mensaje: Cargando...");
			},
			success: function (datos) {
				$("#resultados_ajax3").html(datos);
				$('#actualizar_datos3').attr("disabled", false);
				load(1);
			}
		});
		event.preventDefault();
	})
	function get_user_id(id) {
		$("#user_id_mod").val(id);
	}

	function obtener_datos(id) {
		var usuario = $("#usuario" + id).val();
		var email = $("#email" + id).val();

		$("#idUsuaruiMod").val(id);
		$("#nombre_usuario2").val(usuario);
		$("#usuario_email2").val(email);

	}

</script>
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

<script>
	$(document).ready(function () {
		$('#sel_departamento').change(function () {
			var departamento_id = $(this).val();

			// Resetear los selects de provincias y distritos
			$('#sel_provincia').html('<option value="" selected disabled>Seleccione Provincia</option>');
			$('#sel_distrito').html('<option value="" selected disabled>Seleccione Distrito</option>');

			if (departamento_id !== '') {
				// Realizar una consulta AJAX para obtener las provincias del departamento seleccionado
				$.ajax({
					url: 'get_provincias.php',
					type: 'POST',
					data: { departamento_id: departamento_id },
					success: function (response) {
						$('#sel_provincia').removeAttr('disabled').html(response);
					}
				});
			}
		});

		$('#sel_provincia').change(function () {
			var provincia_id = $(this).val();

			// Resetear el select de distritos
			$('#sel_distrito').html('<option value="" selected disabled>Seleccione Distrito</option>');

			if (provincia_id !== '') {
				// Realizar una consulta AJAX para obtener los distritos de la provincia seleccionada
				$.ajax({
					url: 'get_distritos.php',
					type: 'POST',
					data: { provincia_id: provincia_id },
					success: function (response) {
						$('#sel_distrito').removeAttr('disabled').html(response);
					}
				});
			}
		});
	});
</script>