<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
}
if (empty($_POST['nombre3'])) {
    $errors[] = "Nombres vacíos";
} elseif (empty($_POST['apepaterno3'])) {
    $errors[] = "Apellido paterno vacio";
} elseif (empty($_POST['apematerno3'])) {
    $errors[] = "Apellido materno vacio";
} elseif (empty($_POST['direccion3'])) {
    $errors[] = "La dirección no puede estar vacía";
} elseif (empty($_POST['fecnac3'])) {
    $errors[] = "La fecha de nacimiento no puede estar vacío";
} elseif (empty($_POST['dni3'])) {
    $errors[] = "Escriba su DNI";
} elseif (empty($_POST['celular3'])) {
    $errors[] = "Escriba su celular";
} elseif (empty($_POST['estado3'])) {
    $errors[] = "Seleccione su Estado Civil";
} elseif (empty($_POST['departamento3'])) {
    $errors[] = "Seleccione su Departamento";
} elseif (empty($_POST['provincia3'])) {
    $errors[] = "Seleccione su provincia";
} elseif (empty($_POST['distrito3'])) {
    $errors[] = "Seleccione su distrito";
} elseif (
    !empty($_POST['nombre3'])
    && !empty($_POST['apepaterno3'])
    && !empty($_POST['apematerno3'])
    && !empty($_POST['direccion3'])
    && !empty($_POST['fecnac3'])
    //&& !empty($_POST['sexo'])
    //&& !empty($_POST['estado'])
    && !empty($_POST['dni3'])
    && !empty($_POST['celular3'])
) {
    require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

    // escaping, additionally removing everything that could be (html/javascript-) code
    $nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre3"], ENT_QUOTES)));
    $apepaterno = mysqli_real_escape_string($con, (strip_tags($_POST["apepaterno3"], ENT_QUOTES)));
    $apematerno = mysqli_real_escape_string($con, (strip_tags($_POST["apematerno3"], ENT_QUOTES)));
    $direccion = mysqli_real_escape_string($con, (strip_tags($_POST["direccion3"], ENT_QUOTES)));
    $fecnac = mysqli_real_escape_string($con, (strip_tags($_POST["fecnac3"], ENT_QUOTES)));
    $dni = mysqli_real_escape_string($con, (strip_tags($_POST["dni3"], ENT_QUOTES)));
    $celular = mysqli_real_escape_string($con, (strip_tags($_POST["celular3"], ENT_QUOTES)));
    $sexo = mysqli_real_escape_string($con, $_POST["sexo3"]);
    $estado = mysqli_real_escape_string($con, $_POST["estado3"]);

    $distrito = intval($_POST['distrito3']);
    $idPersona = intval($_POST['idPersona3']);


    $sql = "CALL SP_actualizarClientePersona(" . $idPersona . ",'" . $nombre . "','" . $apepaterno . "','" . $apematerno . "','" . $direccion . "','" . $fecnac . "',
               '" . $dni . "','" . $celular . "','" . $sexo . "','" . $estado . "'," . $distrito . ")";
    $query_new_user_insert = mysqli_query($con, $sql);

    // if user has been added successfully
    if ($query_new_user_insert) {
        $messages[] = "La cuenta ha sido creada con éxito.";
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