<?php
session_start();

// Verificar que el usuario esté logueado y sea voluntario
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'voluntario') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Acceso no autorizado']);
    exit;
}

require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$solicitud_id = isset($_POST['solicitud_id']) ? (int)$_POST['solicitud_id'] : 0;

if ($solicitud_id <= 0) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'ID de solicitud inválido']);
    exit;
}

// Verificar que la solicitud existe y está pendiente
$query_check = "SELECT id, tipo_servicio, descripcion FROM solicitudes WHERE id = ? AND estado = 'pendiente'";
$stmt_check = mysqli_prepare($con, $query_check);
mysqli_stmt_bind_param($stmt_check, 'i', $solicitud_id);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($result_check) === 0) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Solicitud no encontrada o ya asignada']);
    exit;
}

$solicitud = mysqli_fetch_assoc($result_check);

// Asignar la solicitud al voluntario
$query_update = "UPDATE solicitudes SET estado = 'asignada', voluntario_id = ?, fecha_asignacion = NOW() WHERE id = ?";
$stmt_update = mysqli_prepare($con, $query_update);
mysqli_stmt_bind_param($stmt_update, 'ii', $_SESSION['usuario_id'], $solicitud_id);

if (mysqli_stmt_execute($stmt_update)) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Solicitud aceptada exitosamente',
        'solicitud' => $solicitud
    ]);
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error al asignar la solicitud']);
}
?></content>
<parameter name="filePath">c:\Users\Adrian Salazar R\OneDrive\Documentos\Universidad\I Cuatrimestre 2026\Ambiente Web Cliente Servidor\Repository\AmbienteWebCliente-Servidor\Proyecto Final\aceptar_solicitud.php