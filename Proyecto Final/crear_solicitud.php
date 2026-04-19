<?php
session_start();
require 'conexion.php';

// Verificar que el usuario esté logueado y sea un abuelo (usuario)
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'usuario') {
    header("Location: Login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo_servicio'])) {
    $tipo_servicio = $_POST['tipo_servicio'];
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $urgencia = isset($_POST['urgencia']) ? $_POST['urgencia'] : 'normal';
    $hora_solicitud = isset($_POST['hora_solicitud']) ? $_POST['hora_solicitud'] : null;
    $detalles_adicionales = isset($_POST['detalles_adicionales']) ? trim($_POST['detalles_adicionales']) : '';

    // Determinar prioridad basada en el tipo y urgencia
    $prioridad = 'media';
    if ($urgencia === 'urgente') {
        $prioridad = 'alta';
    } elseif (in_array($tipo_servicio, ['farmacia', 'medico'])) {
        $prioridad = 'alta';
    } elseif ($tipo_servicio === 'compania') {
        $prioridad = 'baja';
    }

    // Insertar solicitud
    $sql = "INSERT INTO solicitudes (usuario_id, tipo_servicio, descripcion, urgencia, hora_solicitud, detalles_adicionales, prioridad, estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'pendiente')";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("issssss", $_SESSION['usuario_id'], $tipo_servicio, $descripcion, $urgencia, $hora_solicitud, $detalles_adicionales, $prioridad);

    if ($stmt->execute()) {
        // Redirigir de vuelta al dashboard con mensaje de éxito
        header("Location: dashboard_abuelo.php?success=1&tipo=" . urlencode($tipo_servicio));
        exit;
    } else {
        // Redirigir con error
        header("Location: dashboard_abuelo.php?error=1");
        exit;
    }

    $stmt->close();
}

$conexion->close();
?>