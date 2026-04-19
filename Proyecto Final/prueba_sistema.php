<?php
/**
 * Script de prueba para el sistema de solicitudes
 */

require 'conexion.php';

echo "<h2>🧪 PRUEBA DEL SISTEMA DE SOLICITUDES</h2>";

// 1. Verificar conexión
echo "<h3>1. Conexión a BD:</h3>";
if ($con->connect_error) {
    echo "❌ Error: " . $con->connect_error;
} else {
    echo "✅ Conexión exitosa";
}

// 2. Verificar tabla usuarios
echo "<h3>2. Tabla usuarios:</h3>";
$result = $con->query("SELECT COUNT(*) as total FROM usuarios");
if ($result) {
    $row = $result->fetch_assoc();
    echo "✅ {$row['total']} usuarios registrados";
} else {
    echo "❌ Error consultando usuarios: " . $con->error;
}

// 3. Verificar tabla solicitudes
echo "<h3>3. Tabla solicitudes:</h3>";
$result = $con->query("DESCRIBE solicitudes");
if ($result) {
    echo "✅ Tabla 'solicitudes' existe con " . $result->num_rows . " columnas";
} else {
    echo "❌ Error: " . $con->error;
}

// 4. Crear solicitud de prueba
echo "<h3>4. Creando solicitud de prueba:</h3>";
$sql = "INSERT INTO solicitudes (usuario_id, tipo_servicio, descripcion, urgencia, prioridad, estado)
        VALUES (3, 'mandados', 'Prueba: Compra de víveres', 'normal', 'media', 'pendiente')";

if ($con->query($sql) === TRUE) {
    $solicitud_id = $con->insert_id;
    echo "✅ Solicitud de prueba creada con ID: $solicitud_id";
} else {
    echo "❌ Error creando solicitud: " . $con->error;
}

// 5. Verificar solicitudes pendientes
echo "<h3>5. Solicitudes pendientes:</h3>";
$result = $con->query("SELECT COUNT(*) as total FROM solicitudes WHERE estado = 'pendiente'");
if ($result) {
    $row = $result->fetch_assoc();
    echo "✅ {$row['total']} solicitudes pendientes";
} else {
    echo "❌ Error: " . $con->error;
}

$con->close();

echo "<h3>🎉 Prueba completada</h3>";
echo "<p>Ahora puedes:</p>";
echo "<ul>";
echo "<li>Ir a <a href='dashboard_voluntario.html' target='_blank'>Dashboard Voluntario</a> (inicia sesión como voluntario)</li>";
echo "<li>Ir a <a href='dashboard_abuelo.html' target='_blank'>Dashboard Abuelo</a> (inicia sesión como usuario)</li>";
echo "</ul>";
?>