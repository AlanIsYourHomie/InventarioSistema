<?php

session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

/* Connect To Database*/
require_once("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php"); //Contiene funcion que conecta a la base de datos

$active_clientes = "active";
$title = "Clientes | TOTTUS";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php"); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body style="display: flex; flex-direction: column; min-height: 100vh;">
    <?php
    include("navbar.php");
    ?>

    <div class="container mt-p1">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="my-2"><i class='bi bi-search'></i> Informe de Recuento de Empleados</h4>
            </div>
            <div class="card-body">
                <iframe title="Report Section" width="100%" height="800"
                    src="https://app.powerbi.com/view?r=eyJrIjoiOTQ2MTU3NmYtZTkwOS00N2M4LWFhYzMtNjVmZmFlODc1ZTVlIiwidCI6IjEzODQxZDVmLTk2OGQtNDYyNC1hN2RhLWQ2OGE2MDA2YTg0YSIsImMiOjR9&embedImagePlaceholder=true"
                    frameborder="0" allowFullScreen="true"></iframe>
            </div>
        </div>
    </div>
    <hr>
    <div class="mt-auto">
        <?php include("footer.php"); ?>
    </div>
</body>

</html>

<style>
    .h4,
    h4 {
        font-weight: 800;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>