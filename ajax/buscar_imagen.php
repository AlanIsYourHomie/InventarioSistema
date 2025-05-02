<?php
// Conexión a la base de datos
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

// Obtén el id del producto desde la URL
$idProducto = isset($_GET['idProducto']) ? $_GET['idProducto'] : null;

if ($idProducto) {
    // Consulta para obtener la imagen del producto
    $consulta = "SELECT imagen FROM producto WHERE idProducto = ?";
    $stmt = $con->prepare($consulta);
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $stmt->bind_result($imagen);

    if ($stmt->fetch()) {
        // Establece las cabeceras para indicar que se trata de una imagen
        header('Content-Type: image/webp'); // Ajusta el tipo de contenido según el formato de tu imagen

        // Muestra la imagen binaria
        echo $imagen;
    } else {
        // Manejo de errores si no se encuentra la imagen
        echo "Imagen no encontrada";
    }

    // Cierra la conexión
    $stmt->close();
    $con->close();
}
?>