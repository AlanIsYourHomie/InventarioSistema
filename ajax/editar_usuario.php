<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
	exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
	// if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
	// (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
	require_once("../libraries/password_compatibility_library.php");
}
if (empty($_POST['nombre_usuario2'])) {
	$errors[] = "Usuario vacío";
} elseif (empty($_POST['usuario_email2'])) {
	$errors[] = "Email vacío";
} elseif (
	!empty($_POST['nombre_usuario2'])
	&& strlen($_POST['nombre_usuario2']) <= 64
	&& strlen($_POST['nombre_usuario2']) >= 2
	&& preg_match('/^[a-z\d]{2,64}$/i', $_POST['nombre_usuario2'])
	&& !empty($_POST['usuario_email2'])
	&& strlen($_POST['usuario_email2']) <= 64
	&& filter_var($_POST['usuario_email2'], FILTER_VALIDATE_EMAIL)
) {
	require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
	require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

	// escaping, additionally removing everything that could be (html/javascript-) code
	$user_name = mysqli_real_escape_string($con, (strip_tags($_POST["nombre_usuario2"], ENT_QUOTES)));
	$user_email = mysqli_real_escape_string($con, (strip_tags($_POST["usuario_email2"], ENT_QUOTES)));

	$user_id = intval($_POST['idUsuaruiMod']);


	// write new user's data into database
	$sql = "UPDATE usuario SET nombre_usuario='" . $user_name . "', usuario_email='" . $user_email . "' WHERE idUsuario='" . $user_id . "';";
	$query_update = mysqli_query($con, $sql);

	// if user has been added successfully
	if ($query_update) {
		$messages[] = "La cuenta ha sido modificada con éxito.";
	} else {
		$errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
	}


} else {
	$errors[] = "Un error desconocido ocurrió.";
}

if (isset($errors)) {

	?>
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Error!</strong>
		<?php
		foreach ($errors as $error) {
			echo $error;
		}
		?>
	</div>
	<?php
}
if (isset($messages)) {

	?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡Bien hecho!</strong>
		<?php
		foreach ($messages as $message) {
			echo $message;
		}
		?>
	</div>
	<?php
}

?>