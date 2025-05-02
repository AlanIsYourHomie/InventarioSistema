<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['producto'])) {
    $errors[] = "Nombre vacío";
} else if (!empty($_POST['producto'])) {
    /* Connect To Database*/
    require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
    // escaping, additionally removing everything that could be (html/javascript-) code
    $producto = intval($_POST['producto']);
    $cliente = intval($_POST['cliente']);
    $cantidad = intval($_POST['cantidad']);
    $sql = "CALL SP_agregarPedido(" . $producto . ", '" . $cantidad . "'," . $cliente . ")";
    $query_new_insert = mysqli_query($con, $sql);
    if ($query_new_insert) {
        $messages[] = "Pedido ingresado satisfactoriamente.";
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