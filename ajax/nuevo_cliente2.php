<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
}
if (empty($_POST['razon'])) {
    $errors2[] = "Razon Social vacío";
} elseif (empty($_POST['direccion2'])) {
    $errors22[] = "La dirección no puede estar vacía";
} elseif (empty($_POST['ruc'])) {
    $errors2[] = "Escriba su RUC";
} elseif (empty($_POST['telefono'])) {
    $errors2[] = "Escriba su teléfono";
} elseif (empty($_POST['departamento2'])) {
    $errors2[] = "Seleccione su Departamento";
} elseif (empty($_POST['provincia2'])) {
    $errors2[] = "Seleccione su provincia";
} elseif (empty($_POST['distrito2'])) {
    $errors2[] = "Seleccione su distrito";
} elseif (
    !empty($_POST['razon'])
    && !empty($_POST['direccion2'])
    && !empty($_POST['ruc'])
    && !empty($_POST['telefono'])
) {
    require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

    // escaping, additionally removing everything that could be (html/javascript-) code
    $razon = mysqli_real_escape_string($con, (strip_tags($_POST["razon"], ENT_QUOTES)));
    $direccion2 = mysqli_real_escape_string($con, (strip_tags($_POST["direccion2"], ENT_QUOTES)));
    $ruc = mysqli_real_escape_string($con, (strip_tags($_POST["ruc"], ENT_QUOTES)));
    $telefono = mysqli_real_escape_string($con, (strip_tags($_POST["telefono"], ENT_QUOTES)));

    $distrito2 = intval($_POST['distrito2']);

    $sql = "SELECT * FROM empresa WHERE ruc = '" . $ruc . "';";
    $query_check_nombre_usuario = mysqli_query($con, $sql);
    $query_check_user = mysqli_num_rows($query_check_nombre_usuario);
    if ($query_check_user == 1) {
        $errors2[] = "Lo sentimos , el cliente ya existe.";
    } else {
        $sql = "CALL SP_guardarClienteEmpresa('" . $razon . "','" . $direccion2 . "','" . $ruc . "','" . $telefono . "'," . $distrito2 . ")";
        $query_new_user_insert = mysqli_query($con, $sql);

        // if user has been added successfully
        if ($query_new_user_insert) {
            $messages2[] = "El cliente ha sido creado con éxito.";
        } else {
            $errors22[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
        }
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