<?php
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("../libraries/password_compatibility_library.php");
}
if (empty($_POST['nombre'])) {
    $errors[] = "Nombres vacíos";
} elseif (empty($_POST['apepaterno'])) {
    $errors[] = "Apellido paterno vacio";
} elseif (empty($_POST['apematerno'])) {
    $errors[] = "Apellido materno vacio";
} elseif (empty($_POST['nombre_usuario'])) {
    $errors[] = "Nombre de usuario vacío";
} elseif (empty($_POST['user_password_new'])) {
    $errors[] = "Contraseña vacía";
} elseif (strlen($_POST['user_password_new']) < 6) {
    $errors[] = "La contraseña debe tener como mínimo 6 caracteres";
} elseif (strlen($_POST['nombre_usuario']) > 64 || strlen($_POST['nombre_usuario']) < 2) {
    $errors[] = "Nombre de usuario no puede ser inferior a 2 o más de 64 caracteres";
} elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['nombre_usuario'])) {
    $errors[] = "Nombre de usuario no encaja en el esquema de nombre: Sólo aZ y los números están permitidos , de 2 a 64 caracteres";
} elseif (empty($_POST['direccion'])) {
    $errors[] = "La dirección no puede estar vacía";
} elseif (empty($_POST['fecnac'])) {
    $errors[] = "El correo electrónico no puede estar vacío";
} elseif (empty($_POST['dni'])) {
    $errors[] = "Escriba su DNI";
} elseif (empty($_POST['celular'])) {
    $errors[] = "Escriba su celular";
} elseif (strlen($_POST['usuario_email']) > 64) {
    $errors[] = "El correo electrónico no puede ser superior a 64 caracteres";
} elseif (!filter_var($_POST['usuario_email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Su dirección de correo electrónico no está en un formato de correo electrónico válida";
} elseif (
    !empty($_POST['nombre_usuario'])
    && !empty($_POST['nombre'])
    && !empty($_POST['apepaterno'])
    && !empty($_POST['apematerno'])
    && strlen($_POST['nombre_usuario']) <= 64
    && strlen($_POST['nombre_usuario']) >= 2
    && preg_match('/^[a-z\d]{2,64}$/i', $_POST['nombre_usuario'])
    && !empty($_POST['usuario_email'])
    && strlen($_POST['usuario_email']) <= 64
    && filter_var($_POST['usuario_email'], FILTER_VALIDATE_EMAIL)
    && !empty($_POST['user_password_new'])
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
    $nombre_usuario = mysqli_real_escape_string($con, (strip_tags($_POST["nombre_usuario"], ENT_QUOTES)));
    $usuario_email = mysqli_real_escape_string($con, (strip_tags($_POST["usuario_email"], ENT_QUOTES)));
    $direccion = mysqli_real_escape_string($con, (strip_tags($_POST["direccion"], ENT_QUOTES)));
    $fecnac = mysqli_real_escape_string($con, (strip_tags($_POST["fecnac"], ENT_QUOTES)));
    $dni = mysqli_real_escape_string($con, (strip_tags($_POST["dni"], ENT_QUOTES)));
    $celular = mysqli_real_escape_string($con, (strip_tags($_POST["celular"], ENT_QUOTES)));
    $user_password = $_POST['user_password_new'];
    $fecha_agregado = date("Y-m-d H:i:s");
    // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
    // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
    // PHP 5.3/5.4, by the password hashing compatibility library
    $contraseña_hash = password_hash($user_password, PASSWORD_DEFAULT);

    $sexo = mysqli_real_escape_string($con, $_POST["sexo"]);
    $estado = mysqli_real_escape_string($con, $_POST["estado"]);
    $cargo = intval($_POST['cargo']);
    $area = intval($_POST['area']);
    $distrito = intval($_POST['distrito']);

    // check if user or email address already exists
    $sql = "SELECT * FROM usuario WHERE nombre_usuario = '" . $nombre_usuario . "' OR usuario_email = '" . $usuario_email . "';";
    $query_check_nombre_usuario = mysqli_query($con, $sql);
    $query_check_user = mysqli_num_rows($query_check_nombre_usuario);
    if ($query_check_user == 1) {
        $errors[] = "Lo sentimos , el nombre de usuario ó la dirección de correo electrónico ya está en uso.";
    } else {
        // write new user's data into database
        //$sql = "INSERT INTO usuario (nombre_usuario, contraseña_hash, usuario_email, fecha_agregado)
        //        VALUES('" . $nombre . "','" . $apepaterno . "','" . $nombre_usuario . "', '" . $contraseña_hash . "', '" . $usuario_email . "','" . $fecha_agregado . "');";
        $sql = "CALL sp_guardarUsuarioPersona('" . $nombre_usuario . "','" . $contraseña_hash . "','" . $usuario_email . "','" . $fecha_agregado . "',1,'" . $apepaterno . "',
               '" . $apematerno . "','" . $nombre . "','" . $dni . "','" . $sexo . "','" . $direccion . "','" . $estado . "','" . $celular . "'," . $distrito . ",'" . $fecnac . "'," . $cargo . ",
               " . $area . ")";
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