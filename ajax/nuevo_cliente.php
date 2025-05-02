<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
}
if (empty($_POST['nombre'])) {
    $errors[] = "Nombres vacíos";
} elseif (empty($_POST['apepaterno'])) {
    $errors[] = "Apellido paterno vacio";
} elseif (empty($_POST['apematerno'])) {
    $errors[] = "Apellido materno vacio";
} elseif (empty($_POST['direccion'])) {
    $errors[] = "La dirección no puede estar vacía";
} elseif (empty($_POST['fecnac'])) {
    $errors[] = "La fecha de nacimiento no puede estar vacío";
} elseif (empty($_POST['dni'])) {
    $errors[] = "Escriba su DNI";
} elseif (empty($_POST['celular'])) {
    $errors[] = "Escriba su celular";
} elseif (empty($_POST['estado'])) {
    $errors[] = "Seleccione su Estado Civil";
} elseif (empty($_POST['departamento'])) {
    $errors[] = "Seleccione su Departamento";
} elseif (empty($_POST['provincia'])) {
    $errors[] = "Seleccione su provincia";
} elseif (empty($_POST['distrito'])) {
    $errors[] = "Seleccione su distrito";
} elseif (
    !empty($_POST['nombre'])
    && !empty($_POST['apepaterno'])
    && !empty($_POST['apematerno'])
    && !empty($_POST['direccion'])
    && !empty($_POST['fecnac'])
    //&& !empty($_POST['sexo'])
    //&& !empty($_POST['estado'])
    && !empty($_POST['dni'])
    && !empty($_POST['celular'])
) {
    require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

    // escaping, additionally removing everything that could be (html/javascript-) code
    $nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $apepaterno = mysqli_real_escape_string($con, (strip_tags($_POST["apepaterno"], ENT_QUOTES)));
    $apematerno = mysqli_real_escape_string($con, (strip_tags($_POST["apematerno"], ENT_QUOTES)));
    $direccion = mysqli_real_escape_string($con, (strip_tags($_POST["direccion"], ENT_QUOTES)));
    $fecnac = mysqli_real_escape_string($con, (strip_tags($_POST["fecnac"], ENT_QUOTES)));
    $dni = mysqli_real_escape_string($con, (strip_tags($_POST["dni"], ENT_QUOTES)));
    $celular = mysqli_real_escape_string($con, (strip_tags($_POST["celular"], ENT_QUOTES)));
    $sexo = mysqli_real_escape_string($con, $_POST["sexo"]);
    $estado = mysqli_real_escape_string($con, $_POST["estado"]);

    $distrito = intval($_POST['distrito']);

    $sql = "SELECT * FROM persona WHERE dni = '" . $dni . "';";
    $query_check_nombre_usuario = mysqli_query($con, $sql);
    $query_check_user = mysqli_num_rows($query_check_nombre_usuario);
    if ($query_check_user == 1) {
        $errors[] = "Lo sentimos , el cliente ya existe.";
    } else {
        $sql = "CALL SP_guardarClientePersona('" . $nombre . "','" . $apepaterno . "','" . $apematerno . "','" . $direccion . "','" . $fecnac . "',
               '" . $dni . "','" . $celular . "','" . $sexo . "','" . $estado . "'," . $distrito . ")";
        $query_new_user_insert = mysqli_query($con, $sql);

        // if user has been added successfully
        if ($query_new_user_insert) {
            $messages[] = "La cuenta ha sido creada con éxito.";
        } else {
            $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
        }
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