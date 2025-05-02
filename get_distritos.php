<?php
require_once("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php"); //Contiene funcion que conecta a la base de datos

if (isset($_POST['provincia_id'])) {
    $provincia_id = $_POST['provincia_id'];

    $query_distrito = mysqli_query($con, "SELECT * FROM distrito WHERE idProvincia = $provincia_id ORDER BY Nom_Distrito");

    echo '<option value="" selected disabled>Distrito</option>';

    while ($rw = mysqli_fetch_array($query_distrito)) {
        echo "<option value='{$rw['idDistrito']}'>{$rw['Nom_Distrito']}</option>";
    }
}
?>