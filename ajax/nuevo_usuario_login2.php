<?php

require_once("../libraries/password_compatibility_library.php");
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

$nombre = $_POST['nombre'];
$apepaterno = $_POST['apepaterno'];
$apematerno = $_POST['apematerno'];
$direccion = $_POST['direccion'];
$nombre_usuario = $_POST['nombre_usuario'];
$usuario_email = $_POST['usuario_email'];
$dni = $_POST['dni'];
$sexo = intval($_POST['sexo']);
$cargo = intval($_POST['cargo']);
$user_password = $_POST['user_password_new'];
$contraseña_hash = password_hash($user_password, PASSWORD_DEFAULT);
$fecnac = $_POST['fecnac'];
$celular = $_POST['celular'];
$estado = $_POST['estado'];
$area = $_POST['area'];
$fecha_agregado = date("Y-m-d H:i:s");

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
               '" . $apematerno . "','" . $nombre . "','" . $dni . "','" . $sexo . "','" . $direccion . "','" . $estado . "','" . $celular . "',967,'" . $fecnac . "'," . $cargo . ",
               " . $area . ")";
    $query_new_user_insert = mysqli_query($con, $sql);

    // if user has been added successfully
    if ($query_new_user_insert) {
        $messages[] = "La cuenta ha sido creada con éxito.";
        Header("Location: ../login.php");
    } else {
        $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
    }
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