<?php
session_start();
header('Content-Type: application/json');

// Verificar si el usuario está logueado (de forma limpia)
if (!isset($_SESSION['user_login_status']) || $_SESSION['user_login_status'] != 1) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Sesinn no iniciada'
    ]);
    exit;
}

// Validar entradas obligatorias
$campos = ['nombre', 'apepaterno', 'apematerno', 'direccion', 'fecnac', 'dni', 'celular', 'estado', 'departamento', 'provincia', 'distrito', 'sexo'];
foreach ($campos as $campo) {
    if (empty($_POST[$campo])) {
        echo json_encode([
            'status' => 'error',
            'message' => "El campo '$campo' es obligatorio"
        ]);
        exit;
    }
}

// Conexión
require_once("../config/db.php");
require_once("../config/conexion.php");

// Escapar y sanitizar datos
$con = $con ?? null;
$nombre = mysqli_real_escape_string($con, $_POST['nombre']);
$apepaterno = mysqli_real_escape_string($con, $_POST['apepaterno']);
$apematerno = mysqli_real_escape_string($con, $_POST['apematerno']);
$direccion = mysqli_real_escape_string($con, $_POST['direccion']);
$fecnac = mysqli_real_escape_string($con, $_POST['fecnac']);
$dni = mysqli_real_escape_string($con, $_POST['dni']);
$celular = mysqli_real_escape_string($con, $_POST['celular']);
$sexo = mysqli_real_escape_string($con, $_POST['sexo']);
$estado = mysqli_real_escape_string($con, $_POST['estado']);
$distrito = intval($_POST['distrito']);

// Verificar si el cliente ya existe
$check = mysqli_query($con, "SELECT * FROM persona WHERE dni = '$dni'");
if (mysqli_num_rows($check) > 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'El cliente ya existe con ese DNI'
    ]);
    exit;
}

// Llamar procedimiento almacenado
$sql = "CALL SP_guardarClientePersona('$nombre','$apepaterno','$apematerno','$direccion','$fecnac','$dni','$celular','$sexo','$estado',$distrito)";
$result = mysqli_query($con, $sql);

if ($result) {
    echo json_encode([
        'status' => 'ok',
        'message' => 'Cliente creado exitosamente'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al guardar el cliente'
    ]);
}
