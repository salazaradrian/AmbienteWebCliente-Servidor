<?php
/**
 * Crear tabla de solicitudes para el sistema de Círculo de Apoyo
 */

require 'conexion.php';

$sql = "CREATE TABLE IF NOT EXISTS solicitudes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    tipo_servicio ENUM('mandados', 'farmacia', 'compania', 'transporte', 'medico') NOT NULL,
    descripcion TEXT NOT NULL,
    urgencia ENUM('normal', 'urgente') DEFAULT 'normal',
    estado ENUM('pendiente', 'asignada', 'en_progreso', 'completada', 'cancelada') DEFAULT 'pendiente',
    voluntario_id INT NULL,
    fecha_solicitud DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_asignacion DATETIME NULL,
    fecha_completada DATETIME NULL,
    hora_solicitud TIME NULL,
    detalles_adicionales TEXT,
    prioridad ENUM('baja', 'media', 'alta') DEFAULT 'media',
    notas_voluntario TEXT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (voluntario_id) REFERENCES usuarios(id),
    INDEX idx_estado (estado),
    INDEX idx_tipo (tipo_servicio),
    INDEX idx_voluntario (voluntario_id),
    INDEX idx_fecha (fecha_solicitud)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($con->query($sql) === TRUE) {
    echo "<div style='color: green; font-weight: bold;'>✅ Tabla 'solicitudes' creada exitosamente</div>";
} else {
    echo "<div style='color: red; font-weight: bold;'>❌ Error creando tabla: " . $con->error . "</div>";
}

$con->close();
?>