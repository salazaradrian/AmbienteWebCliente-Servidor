<?php
session_start();

// Verificar que el usuario esté logueado y sea voluntario
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'voluntario') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Acceso no autorizado']);
    exit;
}

require_once 'conexion.php';

// Obtener solicitudes pendientes
$query = "SELECT s.id, s.tipo_servicio, s.descripcion, s.urgencia, s.fecha_solicitud, s.hora_solicitud,
                 s.detalles_adicionales, s.estado, s.prioridad,
                 u.nombre, u.telefono, u.direccion
          FROM solicitudes s
          JOIN usuarios u ON s.usuario_id = u.id
          WHERE s.estado = 'pendiente'
          ORDER BY
              CASE s.prioridad
                  WHEN 'alta' THEN 1
                  WHEN 'media' THEN 2
                  WHEN 'baja' THEN 3
              END,
              s.fecha_solicitud ASC,
              s.hora_solicitud ASC";

$result = mysqli_query($con, $query);
if (!$result) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error en la consulta', 'details' => mysqli_error($con)]);
    exit;
}

$solicitudes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $solicitudes[] = [
        'id' => $row['id'],
        'tipo' => $row['tipo_servicio'],
        'titulo' => ucfirst($row['tipo_servicio']),
        'usuario' => $row['nombre'],
        'telefono' => $row['telefono'],
        'ubicacion' => $row['direccion'],
        'descripcion' => $row['descripcion'],
        'urgencia' => $row['urgencia'],
        'fecha' => date('Y-m-d', strtotime($row['fecha_solicitud'])),
        'hora' => $row['hora_solicitud'],
        'estado' => $row['estado'],
        'detalles' => $row['detalles_adicionales'] ?: 'Sin detalles adicionales',
        'prioridad' => $row['prioridad']
    ];
}

$query_stats = "SELECT
    COUNT(*) as total_pendientes,
    SUM(CASE WHEN urgencia = 'urgente' THEN 1 ELSE 0 END) as total_urgentes,
    (SELECT COUNT(*) FROM solicitudes WHERE estado = 'asignada' AND voluntario_id = ?) as mis_asignadas,
    (SELECT COUNT(*) FROM solicitudes WHERE estado = 'completada' AND voluntario_id = ?) as completadas
    FROM solicitudes WHERE estado = 'pendiente'";

$stmt = mysqli_prepare($con, $query_stats);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error preparing stats query', 'details' => mysqli_error($con)]);
    exit;
}

mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['usuario_id'], $_SESSION['usuario_id']);
mysqli_stmt_execute($stmt);
$result_stats = mysqli_stmt_get_result($stmt);
$stats = mysqli_fetch_assoc($result_stats);

header('Content-Type: application/json');
echo json_encode([
    'solicitudes' => $solicitudes,
    'estadisticas' => [
        'total' => (int)$stats['total_pendientes'],
        'urgentes' => (int)$stats['total_urgentes'],
        'asignadas' => (int)$stats['mis_asignadas'],
        'completadas' => (int)$stats['completadas']
    ]
]);
?>