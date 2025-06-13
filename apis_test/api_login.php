<?php
session_start();
require_once '../classes/login.php';
require_once '../config/db.php';

$login = new Login();

ob_start();
$login_result = $login->dologinWithPostData(); // ahora devuelve true/false
ob_end_clean();

if ($login_result === true && isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] == 1) {
    echo json_encode(['status' => 'ok', 'message' => 'Login exitoso']);
} else {
    $error = isset($login->errors[0]) ? $login->errors[0] : 'Login fallido';
    echo json_encode(['status' => 'error', 'message' => $error]);
}
