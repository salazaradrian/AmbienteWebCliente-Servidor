<?php
$conexion = new mysqli('localhost:3306', 'root', '', 'db_ambienteweb');
if ($conexion->connect_error) {
    die('CONN_ERR: ' . $conexion->connect_error);
}
$result = $conexion->query('SELECT id, nombre, email, tipo_usuario FROM usuarios');
if (!$result) {
    die('QUERY_ERR: ' . $conexion->error);
}
while ($row = $result->fetch_assoc()) {
    echo $row['id'] . '|' . $row['nombre'] . '|' . $row['email'] . '|' . $row['tipo_usuario'] . PHP_EOL;
}
$conexion->close();
?>