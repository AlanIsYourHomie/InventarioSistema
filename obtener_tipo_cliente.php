<?php
// obtener_tipo_cliente.php

include('../config/db.php');
include('../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCliente = isset($_POST['idCliente']) ? intval($_POST['idCliente']) : 0;

    if ($idCliente > 0) {
        $query = "SELECT idPersona, idEmpresa FROM cliente WHERE idCliente = $idCliente";
        $result = mysqli_query($con, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                $idPersona = $row['idPersona'];
                $idEmpresa = $row['idEmpresa'];

                // Verificar si es una persona o empresa
                if (!is_null($idPersona)) {
                    echo json_encode(['tipoCliente' => 'persona']);
                } elseif (!is_null($idEmpresa)) {
                    echo json_encode(['tipoCliente' => 'empresa']);
                } else {
                    echo json_encode(['tipoCliente' => 'desconocido']);
                }
            } else {
                echo json_encode(['tipoCliente' => 'desconocido']);
            }
        } else {
            echo json_encode(['tipoCliente' => 'desconocido']);
        }
    } else {
        echo json_encode(['tipoCliente' => 'desconocido']);
    }
} else {
    echo json_encode(['tipoCliente' => 'desconocido']);
}
?>