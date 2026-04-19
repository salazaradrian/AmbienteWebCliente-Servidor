<?php
$conn = new mysqli('localhost:3306', 'root', '', 'db_ambienteweb');
if ($conn->connect_error) {
    die('ERR: ' . $conn->connect_error);
}
$res = $conn->query('SELECT id, usuario_id, tipo_servicio, descripcion, urgencia, estado, fecha_solicitud, hora_solicitud FROM solicitudes');
if (!$res) {
    die('QERR: ' . $conn->error);
}
while ($row = $res->fetch_assoc()) {
    echo $row['id'] . '|' . $row['usuario_id'] . '|' . $row['tipo_servicio'] . '|' . $row['descripcion'] . '|' . $row['urgencia'] . '|' . $row['estado'] . '|' . $row['fecha_solicitud'] . '|' . $row['hora_solicitud'] . PHP_EOL;
}
$conn->close();
?>