<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
}
if (empty($_POST['razon4'])) {
    $errors2[] = "Razon Social vacío";
} elseif (empty($_POST['direccion4'])) {
    $errors22[] = "La dirección no puede estar vacía";
} elseif (empty($_POST['ruc4'])) {
    $errors2[] = "Escriba su RUC";
} elseif (empty($_POST['telefono4'])) {
    $errors2[] = "Escriba su teléfono";
} elseif (empty($_POST['departamento4'])) {
    $errors2[] = "Seleccione su Departamento";
} elseif (empty($_POST['provincia4'])) {
    $errors2[] = "Seleccione su provincia";
} elseif (empty($_POST['distrito4'])) {
    $errors2[] = "Seleccione su distrito";
} elseif (
    !empty($_POST['razon4'])
    && !empty($_POST['direccion4'])
    && !empty($_POST['ruc4'])
    && !empty($_POST['telefono4'])
) {
    require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

    // escaping, additionally removing everything that could be (html/javascript-) code
    $razon = mysqli_real_escape_string($con, (strip_tags($_POST["razon4"], ENT_QUOTES)));
    $direccion2 = mysqli_real_escape_string($con, (strip_tags($_POST["direccion4"], ENT_QUOTES)));
    $ruc = mysqli_real_escape_string($con, (strip_tags($_POST["ruc4"], ENT_QUOTES)));
    $telefono = mysqli_real_escape_string($con, (strip_tags($_POST["telefono4"], ENT_QUOTES)));

    $distrito2 = intval($_POST['distrito4']);
    $idEmpresa = intval($_POST['idempresa3']);

    $sql = "CALL SP_actualizarClienteEmpresa(" . $idEmpresa . ",'" . $razon . "','" . $direccion2 . "','" . $ruc . "','" . $telefono . "'," . $distrito2 . ")";
    $query_new_user_insert = mysqli_query($con, $sql);

    // if user has been added successfully
    if ($query_new_user_insert) {
        $messages2[] = "El cliente ha sido creado con éxito.";
    } else {
        $errors22[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
    }


} else {
    $errors2[] = "Un error desconocido ocurrió.";
}

if (isset($errors2)) {

    ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong>
        <?php
        foreach ($errors2 as $error2) {
            echo $error2;
        }
        ?>
    </div>
    <?php
}
if (isset($messages2)) {

    ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Bien hecho!</strong>
        <?php
        foreach ($messages2 as $message2) {
            echo $message2;
        }
        ?>
    </div>
    <?php
}

?>