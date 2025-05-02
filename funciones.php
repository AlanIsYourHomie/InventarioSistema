<?php
function get_row($table, $row, $id, $equal)
{
	global $con;
	$query = mysqli_query($con, "select $row from $table where $id='$equal'");

	$rw = mysqli_fetch_array($query);
	$value = $rw[$row];
	return $value;
}
function guardar_historial($idProducto, $idUsuario, $fecha, $nota, $reference, $quantity)
{
	global $con;
	$sql = "INSERT INTO historial (fecha, descripcion, referencia, cantidad, idProducto, idUsuario)
	VALUES ( '$fecha', '$nota', '$reference', '$quantity', '$idProducto', '$idUsuario');";
	$query = mysqli_query($con, $sql);
}
function agregar_stock($idProducto, $quantity)
{
	global $con;
	$update = mysqli_query($con, "update producto set stock=stock+'$quantity' where idProducto='$idProducto'");
	if ($update) {
		return 1;
	} else {
		return 0;
	}

}
function eliminar_stock($idProducto, $quantity)
{
	global $con;
	$update = mysqli_query($con, "update producto set stock=stock-'$quantity' where idProducto='$idProducto'");
	if ($update) {
		return 1;
	} else {
		return 0;
	}

}
?>