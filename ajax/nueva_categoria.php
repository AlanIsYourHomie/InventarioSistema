<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['nombre'])) {
	$errors[] = "Nombre vacío";
} else if (!empty($_POST['nombre'])) {
	/* Connect To Database*/
	require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
	require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
	// escaping, additionally removing everything that could be (html/javascript-) code
	$nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
	$descripcion = mysqli_real_escape_string($con, (strip_tags($_POST["descripcion"], ENT_QUOTES)));
	$fecha_agregado = date("Y-m-d H:i:s");
	$sql = "INSERT INTO categoria (nom_Categoria, Descripcion,fecha_adicion, estado) VALUES ('$nombre','$descripcion','$fecha_agregado', '1')";
	$query_new_insert = mysqli_query($con, $sql);
	if ($query_new_insert) {
		$messages[] = "Categoría ha sido ingresada satisfactoriamente.";
	} else {
		$errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
	}
} else {
	$errors[] = "Error desconocido.";
}

if (isset($errors)) {
	?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<strong>Error!</strong>
		<?php
		foreach ($errors as $error) {
			echo $error;
		}
		?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
	<?php
}
if (isset($messages)) {
	?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<strong>¡Bien hecho!</strong>
		<?php
		foreach ($messages as $message) {
			echo $message;
		}
		?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
	<?php
}

?>