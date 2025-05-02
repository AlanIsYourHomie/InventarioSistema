<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado

/*Inicia validacion del lado del servidor*/
if (empty($_POST['codigo'])) {
	$errors[] = "Código vacío";
} else if (empty($_POST['nombre'])) {
	$errors[] = "Nombre del producto vacío";
} else if ($_POST['stock'] == "") {
	$errors[] = "Stock del producto vacío";
} else if (empty($_POST['precio'])) {
	$errors[] = "Precio de venta vacío";
} else if (
	!empty($_POST['codigo']) &&
	!empty($_POST['nombre']) &&
	$_POST['stock'] != "" &&
	!empty($_POST['precio'])
) {
	/* Connect To Database*/
	require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
	require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
	include("../funciones.php");
	// escaping, additionally removing everything that could be (html/javascript-) code
	$codigo = mysqli_real_escape_string($con, (strip_tags($_POST["codigo"], ENT_QUOTES)));
	$nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
	$stock = intval($_POST['stock']);
	$id_categoria = intval($_POST['categoria']);
	$precio_venta = floatval($_POST['precio']);
	$date_added = date("Y-m-d H:i:s");
	$marca = mysqli_real_escape_string($con, (strip_tags($_POST["marca"], ENT_QUOTES)));

	$imagen_blob = file_get_contents($_FILES['imagen']['tmp_name']);


	$sql = "INSERT INTO producto (codigo_producto, nom_Producto, fecha_adicion, Precio_Venta, stock, idCategoria, estado, imagen, marca) 
		VALUES ('$codigo','$nombre','$date_added','$precio_venta', '$stock','$id_categoria', '1', ?, '$marca')";
	//$query_new_insert = mysqli_query($con, $sql);

	$query_new_insert = mysqli_prepare($con, $sql);

	mysqli_stmt_bind_param($query_new_insert, "s", $imagen_blob);

	if (mysqli_stmt_execute($query_new_insert)) {
		$messages[] = "Producto ha sido ingresado satisfactoriamente.";
	} else {
		echo "Error al insertar datos y subir la imagen: " . mysqli_error($con);
	}



	//if ($query_new_insert) {
	//	$messages[] = "Producto ha sido ingresado satisfactoriamente.";
	//	$id_producto = get_row('producto', 'idProducto', 'codigo_producto', $codigo);
	//	$user_id = $_SESSION['user_id'];
	//	$firstname = $_SESSION['nombre'];
	//	$nota = "$firstname agregó $stock producto(s) al inventario";
	//	echo guardar_historial($id_producto, $user_id, $date_added, $nota, $codigo, $stock);
//
//	} else {
//		$errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
//	}
} else {
	$errors[] = "Error desconocido.";
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