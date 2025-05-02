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
                <h4 class="my-auto"><i class='bi bi-search'></i> Buscar Clientes</h4>
                <div class="btn-group">
                    <button type='button' class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoCliente"
                        data-bs-original-title="Nuevo Cliente"><span class="bi bi-plus-circle"></span> Cliente
                        Persona</button>
                    <button type='button' class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#nuevoCliente2"><span class="bi bi-plus-circle"></span> Cliente Empresa</button>
                </div>
            </div>
            <div class="card-body">
                <?php
                include("modal/registro_clientes.php");
                include("modal/registro_clientes2.php");
                include("modal/editar_clientes.php");
                include("modal/editar_clientes2.php");
                ?>
                <form class="form" role="form" id="datos_cotizacion">
                    <div class="row">
                        <label for="q" class="col-md-2 col-form-label text-center">Nombre</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="q" placeholder="Nombre del Cliente"
                                onkeyup='load(1);'>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-default" onclick='load(1);'>
                                <span class="bi bi-search"></span> Buscar</button>
                            <span id="loader"></span>
                        </div>
                    </div>
                </form>
                <div id="resultados"></div><!-- Carga los datos ajax -->
                <div class='outer_div'></div><!-- Carga los datos ajax -->
            </div>
        </div>
    </div>
    <hr>
    <div class="mt-auto">
        <?php include("footer.php"); ?>
    </div>
    <script type="text/javascript" src="js/clientes.js"></script>
    <script type="text/javascript" src="js/clientes2.js"></script>
</body>

</html>

<style>
    .h4,
    h4 {
        font-weight: 800;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(function () {

        $('.custom-dropdown').on('show.bs.dropdown', function () {
            var that = $(this);
            setTimeout(function () {
                that.find('.dropdown-menu').addClass('active');
            }, 100);


        });
        $('.custom-dropdown').on('hide.bs.dropdown', function () {
            $(this).find('.dropdown-menu').removeClass('active');
        });

    });

    const dropdownLinks = document.querySelectorAll('.custom-dropdown .nav-link');
    const dropdownMenus = document.querySelectorAll('.custom-dropdown .dropdown-menu');

    dropdownLinks.forEach((link, index) => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const menu = dropdownMenus[index];
            const arrow = link.querySelector('i');

            if (menu.style.display === 'block') {
                menu.style.display = 'none';
                arrow.style.transform = 'rotate(0deg)';
            } else {
                menu.style.display = 'block';
                arrow.style.transform = 'rotate(-180deg)';
            }
        });
    });


</script>
<script>
    $(document).ready(function () {
        $('#sel_departamento').change(function () {
            var departamento_id = $(this).val();

            // Resetear los selects de provincias y distritos
            $('#sel_provincia').html('<option value="" selected disabled>Seleccione Provincia</option>');
            $('#sel_distrito').html('<option value="" selected disabled>Seleccione Distrito</option>');

            if (departamento_id !== '') {
                // Realizar una consulta AJAX para obtener las provincias del departamento seleccionado
                $.ajax({
                    url: 'get_provincias.php',
                    type: 'POST',
                    data: { departamento_id: departamento_id },
                    success: function (response) {
                        $('#sel_provincia').removeAttr('disabled').html(response);
                    }
                });
            }
        });

        $('#sel_provincia').change(function () {
            var provincia_id = $(this).val();

            // Resetear el select de distritos
            $('#sel_distrito').html('<option value="" selected disabled>Seleccione Distrito</option>');

            if (provincia_id !== '') {
                // Realizar una consulta AJAX para obtener los distritos de la provincia seleccionada
                $.ajax({
                    url: 'get_distritos.php',
                    type: 'POST',
                    data: { provincia_id: provincia_id },
                    success: function (response) {
                        $('#sel_distrito').removeAttr('disabled').html(response);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#sel_departamento2').change(function () {
            var departamento_id = $(this).val();

            // Resetear los selects de provincias y distritos
            $('#sel_provincia2').html('<option value="" selected disabled>Seleccione Provincia</option>');
            $('#sel_distrito2').html('<option value="" selected disabled>Seleccione Distrito</option>');

            if (departamento_id !== '') {
                // Realizar una consulta AJAX para obtener las provincias del departamento seleccionado
                $.ajax({
                    url: 'get_provincias.php',
                    type: 'POST',
                    data: { departamento_id: departamento_id },
                    success: function (response) {
                        $('#sel_provincia2').removeAttr('disabled').html(response);
                    }
                });
            }
        });

        $('#sel_provincia2').change(function () {
            var provincia_id = $(this).val();

            // Resetear el select de distritos
            $('#sel_distrito2').html('<option value="" selected disabled>Seleccione Distrito</option>');

            if (provincia_id !== '') {
                // Realizar una consulta AJAX para obtener los distritos de la provincia seleccionada
                $.ajax({
                    url: 'get_distritos.php',
                    type: 'POST',
                    data: { provincia_id: provincia_id },
                    success: function (response) {
                        $('#sel_distrito2').removeAttr('disabled').html(response);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#sel_departamento3').change(function () {
            var departamento_id = $(this).val();

            // Resetear los selects de provincias y distritos
            $('#sel_provincia3').html('<option value="" selected disabled>Seleccione Provincia</option>');
            $('#sel_distrito3').html(' < option value = "" selected disabled > Seleccione Distrito</option > ');

            if (departamento_id !== '') {
                // Realizar una consulta AJAX para obtener las provincias del departamento seleccionado
                $.ajax({
                    url: 'get_provincias.php',
                    type: 'POST',
                    data: { departamento_id: departamento_id },
                    success: function (response) {
                        $('#sel_provincia3').removeAttr('disabled').html(response);
                    }
                });
            }
        });

        $('#sel_provincia3').change(function () {
            var provincia_id = $(this).val();

            // Resetear el select de distritos
            $('#sel_distrito3').html('<option value="" selected disabled>Seleccione Distrito</option>');

            if (provincia_id !== '') {
                // Realizar una consulta AJAX para obtener los distritos de la provincia seleccionada
                $.ajax({
                    url: 'get_distritos.php',
                    type: 'POST',
                    data: { provincia_id: provincia_id },
                    success: function (response) {
                        $('#sel_distrito3').removeAttr('disabled').html(response);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#sel_departamento4').change(function () {
            var departamento_id = $(this).val();

            // Resetear los selects de provincias y distritos
            $('#sel_provincia4').html('<option value="" selected disabled>Seleccione Provincia</option>');
            $('#sel_distrito4').html(' < option value = "" selected disabled > Seleccione Distrito</option > ');

            if (departamento_id !== '') {
                // Realizar una consulta AJAX para obtener las provincias del departamento seleccionado
                $.ajax({
                    url: 'get_provincias.php',
                    type: 'POST',
                    data: { departamento_id: departamento_id },
                    success: function (response) {
                        $('#sel_provincia4').removeAttr('disabled').html(response);
                    }
                });
            }
        });

        $('#sel_provincia4').change(function () {
            var provincia_id = $(this).val();

            // Resetear el select de distritos
            $('#sel_distrito4').html('<option value="" selected disabled>Seleccione Distrito</option>');

            if (provincia_id !== '') {
                // Realizar una consulta AJAX para obtener los distritos de la provincia seleccionada
                $.ajax({
                    url: 'get_distritos.php',
                    type: 'POST',
                    data: { provincia_id: provincia_id },
                    success: function (response) {
                        $('#sel_distrito4').removeAttr('disabled').html(response);
                    }
                });
            }
        });
    });
</script>