<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
}
if (empty($_POST['producto2'])) {
    $errors[] = "Producto Vacio";
} elseif (empty($_POST['cantidad2'])) {
    $errors[] = "Cantidad vacío";
} elseif (empty($_POST['cliente2'])) {
    $errors[] = "Cliente vacío";
} elseif (
    !empty($_POST['producto2'])
    && !empty($_POST['cantidad2'])
    && !empty($_POST['cliente2'])
) {
    require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

    // escaping, additionally removing everything that could be (html/javascript-) code
    $producto = intval($_POST["producto2"]);
    $cliente = intval($_POST["cliente2"]);
    $cantidad = intval($_POST["cantidad2"]);
    $idPedido2 = intval($_POST['idPedido2']);


    // write new user's data into database
    $sql = "CALL SP_editarPedido(" . $producto . "," . $cliente . "," . $cantidad . "," . $idPedido2 . ")";
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