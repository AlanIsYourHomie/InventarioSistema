<?php
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
	exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
	// if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
	// (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
	require_once("libraries/password_compatibility_library.php");
}

// include the configs / constants for the database connection
require_once("config/db.php");

// load the login class
require_once("classes/Login.php");
require_once("config/conexion.php"); //Contiene funcion que conecta a la base de datos

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
	// the user is logged in. you can do whatever you want here.
	// for demonstration purposes, we simply show the "you are logged in" view.
	header("location: prueba.php");

} else {
	// the user is not logged in. you can do whatever you want here.
	// for demonstration purposes, we simply show the "you are not logged in" view.
	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title>ALMACEN | TOTTUS</title>
		<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
		<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
		<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
		<!--<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>-->
		<!--<script src="css/datepicker.js"></script>
		<link href="css/datepicker.css" rel="stylesheet">-->
		<link rel='stylesheet' href='css/bootstrap2.css'>
		<link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
		<link rel=icon href='img/logo2.png' sizes="32x32" type="image/png">
	</head>

	<body>
		<div class="section">
			<div class="container">
				<div class="row full-height justify-content-center">
					<div class="col-12 text-center align-self-center py-5">
						<div class="section pb-5 pt-5 pt-sm-2 text-center">
							<h6 class="mb-0 pb-3"><span>Iniciar Sesión </span><span>Registrarse</span></h6>
							<input class="checkbox" type="checkbox" id="reg-log" name="reg-log" />
							<label for="reg-log"></label>
							<div class="card-3d-wrap mx-auto">
								<div class="card-3d-wrapper">
									<div class="card-front">
										<a href="#" class="logo">
											<img src="img/logoTottus.png" alt="">
										</a>
										<div class="center-wrap">
											<div class="section text-center">
												<h4 class="mb-4 pb-3">Inicio de Sesión</h4>
												<form method="post" accept-charset="utf-8" action="login.php"
													name="loginform" autocomplete="off" role="form" class="form-signin">
													<?php
													// show potential errors / feedback (from login object)
													if (isset($login)) {
														if ($login->errors) {
															?>
															<div class="alert alert-danger alert-dismissible" role="alert">
																<strong>Error!</strong>

																<?php
																foreach ($login->errors as $error) {
																	echo $error;
																}
																?>
															</div>
															<?php
														}
														if ($login->messages) {
															?>
															<div class="alert alert-success alert-dismissible" role="alert">
																<strong>Aviso!</strong>
																<?php
																foreach ($login->messages as $message) {
																	echo $message;
																}
																?>
															</div>
															<?php
														}
													}
													?>
													<div class="form-group">
														<input type="text" name="user_name" class="form-style2"
															placeholder="Tu usuario" id="logemail" value="" autofocus=""
															required>
														<i class="input-icon2 uil uil-at"></i>
													</div>
													<div class="form-group mt-2">
														<input type="password" name="user_password" class="form-style2"
															placeholder="Tu contraseña" id="logpass" value="" required>
														<i class="input-icon2 uil uil-lock-alt"></i>
													</div>
													<button type="submit" class="btn mt-4" name="login"
														id="submit">ingresar</button>
												</form>
												<!--<p class="mb-0 mt-4 text-center"><a href="#0" class="link">Olvidaste tu
														contraseña?</a></p>-->
											</div>
										</div>
									</div>
									<div class="card-back">
										<!--<a href="#" class="logo2">
											<img src="img/logoTottus.png" alt="">
										</a>-->
										<div class="center-wrap">
											<div class="section text-center">
												<h4 class="mb-4 pb-3">Registrarse</h4>
												<div id="mensaje-error" style="display: none;">
												</div>
												<div id="mensaje-exito" style="display: none;">
													<!-- Aquí se mostrarán los mensajes de éxito -->
												</div>
												<form id="registro" name="registro" method="post" accept-charset="utf-8">
													<div class="form-group mt-2">
														<input type="text" name="nombre" class="form-style"
															placeholder="Nombres Completos" id="nombre" autocomplete="off">
														<i class="input-icon uil uil-user"></i>
													</div>
													<div class="input-group mt-2">
														<input type="text" name="apepaterno" class="form-control"
															placeholder="Apellido Paterno" id="apepaterno"
															autocomplete="off">
														<input type="text" name="apematerno" class="form-control"
															placeholder="Apellido Materno" id="apematerno"
															autocomplete="off">
														<i class="input-icon uil uil-user"></i>
														<script>
															$(document).ready(function () {
																// Obtener los inputs
																const apePaterno = $("#apepaterno");
																const apeMaterno = $("#apematerno");

																// Agregar un evento keydown al input de Apellido Paterno
																apePaterno.on("keydown", function (event) {
																	// Si el usuario presiona la tecla espacio, evitar que escriba más caracteres y pasar al input de Apellido Materno
																	if (event.keyCode === 32) {
																		event.preventDefault();
																		apeMaterno.focus();
																	}
																});

																// Agregar un evento keydown al input de Apellido Materno
																apeMaterno.on("keydown", function (event) {
																	// Si el usuario presiona la tecla espacio, evitar que escriba más caracteres
																	if (event.keyCode === 32) {
																		event.preventDefault();
																	}
																});
															});
														</script>
													</div>
													<!--<div class="form-group mt-2">
														<i class="input-icon uil uil-house-user"></i>
														<input type="text" name="direccion" class="form-control"
															placeholder="Tu Dirección" id="direccion" autocomplete="off">
													</div>-->

													<div class="form-row">
														<div class="col-md-6">
															<div class="form-group mt-2">
																<i class="input-icon uil uil-house-user"></i>
																<input type="text" name="direccion" class="form-control"
																	placeholder="Tu Dirección" id="direccion"
																	autocomplete="off">
															</div>
															<div class="form-group mt-2">
																<i class="input-icon uil uil-user-circle"></i>
																<input type="text" name="nombre_usuario"
																	class="form-control" placeholder="Tu Usuario"
																	id="nombre_usuario" autocomplete="off">
															</div>
															<div class="form-group mt-2">
																<i class="input-icon uil uil-check-square"></i>
																<select name="tipo_identificador" class="form-control"
																	id="tipo_identificador">
																	<option value="dni">DNI</option>
																	<option value="pasaporte">Pasaporte</option>
																</select>
															</div>
															<div class="form-group mt-2">
																<i class="input-icon uil uil-dialpad-alt"></i>
																<input type="text" name="identificador" class="form-control"
																	placeholder="Tu Identificador" id="identificador"
																	autocomplete="off">
																<script>
																	document.getElementById("identificador").addEventListener("input", function () {
																		let inputValue = this.value.trim();
																		let tipoIdentificador = document.getElementById("tipo_identificador").value;

																		// Validar DNI: longitud de 8 dígitos
																		if (tipoIdentificador === "dni") {
																			if (inputValue.length === 8 && !isNaN(inputValue)) {
																				this.value = inputValue;
																			} else {
																				this.value = inputValue.slice(0, 8); // Limitar a 8 caracteres
																			}
																		}
																		// Validar Pasaporte: longitud máxima de 10 caracteres
																		else if (tipoIdentificador === "pasaporte") {
																			if (inputValue.length <= 10 && !isNaN(inputValue)) {
																				this.value = inputValue;
																			} else {
																				this.value = inputValue.slice(0, 10); // Limitar a 10 caracteres
																			}
																		}
																	});
																</script>
															</div>
															<div class="form-group mt-2">
																<i class="input-icon uil uil-users-alt"></i>
																<select class="form-control" id="sexo" name="sexo">
																	<option>Masculino</option>
																	<option>Femenino</option>
																</select>
															</div>
															<div class="form-group mt-2">
																<i class="input-icon uil uil-hard-hat"></i>
																<select class="form-control" id="cargo" name="cargo">
																	<?php
																	$query_categoria = mysqli_query($con, "select * from cargo order by nomCargo");
																	while ($rw = mysqli_fetch_array($query_categoria)) {
																		?>
																		<option value="<?php echo $rw['idCargo']; ?>">
																			<?php echo $rw['nomCargo']; ?>
																		</option>
																		<?php
																	}
																	?>
																</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group mt-2">
																<i class="input-icon uil uil-at"></i>
																<input type="email" name="usuario_email"
																	class="form-control" placeholder="Tu Email"
																	id="usuario_email" autocomplete="off">
															</div>
															<div class="form-group mt-2">
																<i class="input-icon uil uil-lock-alt"></i>
																<input type="password" name="user_password_new"
																	class="form-control" placeholder="Tu contraseña"
																	id="user_password_new" autocomplete="off">
															</div>
															<div class="form-group mt-2">
																<input type="text" name="fecnac"
																	class="form-control datepicker"
																	placeholder="Fecha de Nacimiento" id="fecnac"
																	autocomplete="off">
																<i class="input-icon uil uil-calendar-alt"></i>
															</div>
															<script>
																const hoy = new Date();
																const MaxFecha = new Date(hoy.getFullYear() - 18, hoy.getMonth(), hoy.getDate())
																$('#fecnac').datepicker({
																	format: 'yyyy-mm-dd',
																	value: '2000-01-01',
																	language: 'es',
																	showRightIcon: false,
																	uiLibrary: 'bootstrap4.5',
																	maxDate: MaxFecha
																});

																$('#registro').on('submit', function (e) {
																	const fechaNacStr = $('#fecnac').val();
																	if (!fechaNacStr) {
																		alert("Por favor, selecciona tu fecha de nacimiento.");
																		e.preventDefault();
																		return;
																	}

																	const fechaNac = new Date(fechaNacStr);
																	let edad = hoy.getFullYear() - fechaNac.getFullYear();
																	const mes = hoy.getMonth() - fechaNac.getMonth();
																	if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())) {
																		edad--;
																	}

																	if (edad < 18) {
																		alert("Debes tener al menos 18 años para registrarte.");
																		e.preventDefault();
																	}
																});
															</script>
															<div class="form-group mt-2">
																<i class="input-icon uil uil-mobile-android"></i>
																<input type="number" name="celular" class="form-control"
																	placeholder="Tu celular" id="celular"
																	autocomplete="off">
																<script>
																	document.getElementById("celular").addEventListener("input", function () {
																		let dniInput = this.value.trim();
																		if (dniInput.length === 9 && !isNaN(dniInput)) {
																		} else {
																			this.value = dniInput.slice(0, 9);
																		}
																	});
																</script>
															</div>
															<div class="form-group mt-2">
																<i class="input-icon uil uil-user-square"></i>
																<select class="form-control" id="estado" name="estado">
																	<option>Soltero/a</option>
																	<option>Casado/a</option>
																	<option>Separado/a</option>
																	<option>Viudo/a</option>
																</select>
															</div>
															<div class="form-group mt-2">
																<i class="input-icon uil uil-bag"></i>
																<select class="form-control" id="area" name="area">
																	<?php
																	$query_categoria = mysqli_query($con, "select * from area order by nomArea");
																	while ($rw = mysqli_fetch_array($query_categoria)) {
																		?>
																		<option value="<?php echo $rw['idArea']; ?>">
																			<?php echo $rw['nomArea']; ?>
																		</option>
																		<?php
																	}
																	?>
																</select>
															</div>
														</div>
													</div>
													<div class="form-group mt-2">
														<div class="row">
															<div class="col-md-4">
																<div class="form-group">
																	<i class="input-icon uil uil-house-user"></i>
																	<select name="departamento" class="form-control"
																		id="sel_departamento" required>
																		<option value="" selected disabled>Departamento
																		</option>
																		<?php
																		$query_departamento = mysqli_query($con, "SELECT * FROM departamento ORDER BY Nom_Departamento");
																		while ($rw = mysqli_fetch_array($query_departamento)) {
																			echo "<option value='{$rw['idDepartamento']}'>{$rw['Nom_Departamento']}</option>";
																		}
																		?>
																	</select>
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<i class="input-icon uil uil-house-user"></i>
																	<select name="provincia" class="form-control"
																		id="sel_provincia" disabled required></select>
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<i class="input-icon uil uil-house-user"></i>
																	<select name="distrito" class="form-control"
																		id="sel_distrito" disabled required></select>
																</div>
															</div>
														</div>
													</div>

													<div class="form-group mt-4">
														<button type="submit" class="btn" id="enviar_datos">Enviar</button>
													</div>
													<div id="message-dialog" style="display: none;">
														<!-- Aquí mostrarás el mensaje de éxito o error -->
														<p id="message-text"></p>
														<button id="close-button">Aceptar</button>
													</div>
												</form>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- partial -->
		<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/main.js"></script>
		<script src="js/registro.js"></script>
	</body>
	<style>
		.input-icon {
			position: absolute;
			top: 50%;
			/* Centra verticalmente en el contenedor */
			left: 1%;
			/* Ajusta la distancia izquierda en porcentaje */
			transform: translateY(-50%);
			/* Centra verticalmente */
			font-size: 24px;
			line-height: 48px;
			text-align: left;
			color: #78c444;
			-webkit-transition: all 200ms linear;
			transition: all 200ms linear;
		}

		.input-icon2 {
			position: absolute;
			top: 50%;
			/* Centra verticalmente en el contenedor */
			left: 29%;
			/* Ajusta la distancia izquierda en porcentaje */
			transform: translateY(-50%);
			/* Centra verticalmente */
			font-size: 24px;
			line-height: 48px;
			text-align: left;
			color: #78c444;
			-webkit-transition: all 200ms linear;
			transition: all 200ms linear;
		}

		.form-style {
			padding: 13px 20px;
			padding-left: 55px;
			height: 48px;
			width: 100%;
			font-weight: 500;
			border-radius: 4px;
			font-size: 14px;
			line-height: 22px;
			letter-spacing: 0.5px;
			outline: none;
			color: #18191b;
			background-color: #e6e6e6;
			border: none;
			-webkit-transition: all 200ms linear;
			transition: all 200ms linear;
		}


		.form-style {
			padding: 13px 20px;
			padding-left: 55px;
			height: 48px;
			width: 100%;
			font-weight: 500;
			border-radius: 4px;
			font-size: 14px;
			line-height: 22px;
			letter-spacing: 0.5px;
			outline: none;
			color: #18191b;
			background-color: #e6e6e6;
			border: none;
			-webkit-transition: all 200ms linear;
			transition: all 200ms linear;
		}

		.form-style:focus,
		.form-style:active {
			border: none;
			outline: none;
			box-shadow: 0 4px 8px 0 rgba(21, 21, 21, .2);
		}

		.form-control {
			display: block;
			width: 100%;
			height: 48px;
			padding: 13px 20px;
			padding-left: 55px;
			font-size: 14px;
			font-weight: 400;
			line-height: 22px;
			color: #495057;
			letter-spacing: 0.5px;
			background-color: #e6e6e6;
			border: 1px solid #ced4da;
			border-radius: 4px;
			transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
			box-shadow: 0 4px 8px 0 rgba(21, 21, 21, .2);
		}
	</style>
	<script>
		$(document).ready(function () {
			$('#sel_departamento').change(function () {
				var departamento_id = $(this).val();

				// Resetear los selects de provincias y distritos
				$('#sel_provincia').html('<option value="" selected disabled>Provincia</option>');
				$('#sel_distrito').html('<option value="" selected disabled>Distrito</option>');

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
				$('#sel_distrito').html('<option value="" selected disabled>Distrito</option>');

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

	</html>
	<?php
}