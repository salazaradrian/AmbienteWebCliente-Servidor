<?php
require 'conexion.php';

echo "Conexión exitosa<br>";

$resultado = $con->query("SELECT DATABASE() as bd");

if ($resultado) {
    $fila = $resultado->fetch_assoc();
    echo "Base actual: " . $fila['bd'];
} else {
    echo "Error al consultar la base: " . $con->error;
}
?>