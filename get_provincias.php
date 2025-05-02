<?php
require_once("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php"); //Contiene funcion que conecta a la base de datos

if (isset($_POST['departamento_id'])) {
    $departamento_id = $_POST['departamento_id'];

    $query_provincia = mysqli_query($con, "SELECT * FROM provincia WHERE idDepartamento = $departamento_id ORDER BY Nom_Provincia");

    echo '<option value="" selected disabled>Provincia</option>';

    while ($rw = mysqli_fetch_array($query_provincia)) {
        echo "<option value='{$rw['idProvincia']}'>{$rw['Nom_Provincia']}</option>";
    }
}
?>