<?php
/**
 * Setup Database for Círculo de Apoyo
 * Este script crea automáticamente la base de datos y la tabla de usuarios
 */

// Configuración
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "db_ambienteweb";

// Conectar a MySQL (sin especificar BD)
$con = new mysqli($servername, $username, $password);

// Verificar conexión
if ($con->connect_error) {
    die("<div class='alert alert-danger'>❌ Error de conexión: " . $con->connect_error . "</div>");
}

echo "<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    padding: 20px;
}
.container {
    background: white;
    border: 3px solid #000;
    border-radius: 12px;
    box-shadow: 8px 8px 0 #000;
    padding: 2rem;
    max-width: 600px;
    width: 100%;
}
.alert {
    border: 3px solid #000;
    border-radius: 8px;
    padding: 1rem;
    margin: 1rem 0;
    font-weight: 600;
}
.alert-success {
    background: #d4edda;
    color: #155724;
}
.alert-danger {
    background: #f8d7da;
    color: #721c24;
}
.alert-info {
    background: #d1ecf1;
    color: #0c5460;
}
h1 {
    color: #667eea;
    text-align: center;
    font-weight: 900;
}
.btn {
    background: #667eea;
    color: white;
    border: 2px solid #000;
    padding: 0.7rem 1.5rem;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 700;
    box-shadow: 4px 4px 0 #000;
    transition: transform .08s ease;
    font-size: 1rem;
    display: block;
    width: 100%;
    text-align: center;
    text-decoration: none;
    margin-top: 1rem;
}
.btn:hover {
    filter: brightness(0.9);
}
.btn:active {
    transform: translate(4px, 4px);
    box-shadow: 0 0 0 #000;
}
.step {
    margin: 1rem 0;
}
</style>";

echo "<div class='container'>";
echo "<h1>⚙️ Configuración de Base de Datos</h1>";

// PASO 1: Crear base de datos
echo "<div class='step'>";
echo "<h3>Paso 1: Crear Base de Datos</h3>";

$sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

if ($con->query($sql) === TRUE) {
    echo "<div class='alert alert-success'>✅ Base de datos '$dbname' creada o ya existe.</div>";
} else {
    echo "<div class='alert alert-danger'>❌ Error al crear BD: " . $con->error . "</div>";
    die();
}
echo "</div>";

// Seleccionar la BD
$con->select_db($dbname);

// PASO 2: Crear tabla usuarios
echo "<div class='step'>";
echo "<h3>Paso 2: Crear Tabla de Usuarios</h3>";

$sql_tabla = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    tipo_usuario ENUM('admin', 'voluntario', 'usuario') DEFAULT 'usuario',
    password VARCHAR(255) NOT NULL,
    direccion VARCHAR(200) DEFAULT 'Sin dirección',
    fecha_nacimiento DATE DEFAULT '2000-01-01',
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_registro DATE,
    INDEX idx_email (email),
    INDEX idx_tipo (tipo_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($con->query($sql_tabla) === TRUE) {
    echo "<div class='alert alert-success'>✅ Tabla 'usuarios' creada o ya existe.</div>";
} else {
    echo "<div class='alert alert-danger'>❌ Error al crear tabla: " . $con->error . "</div>";
    die();
}
echo "</div>";

// PASO 3: Insertar usuario admin de prueba
echo "<div class='step'>";
echo "<h3>Paso 3: Insertar Usuario Admin de Prueba</h3>";

$admin_password = password_hash("admin123", PASSWORD_DEFAULT);
$fecha = date("Y-m-d");

$sql_admin = "INSERT IGNORE INTO usuarios 
(nombre, email, telefono, tipo_usuario, password, direccion, fecha_nacimiento, estado, fecha_registro)
VALUES 
('Administrador', 'admin@admin.com', '0000000000', 'admin', '$admin_password', 'Sistema', '2000-01-01', 'activo', '$fecha')";

if ($con->query($sql_admin) === TRUE) {
    echo "<div class='alert alert-success'>✅ Usuario admin insertado (email: admin@admin.com / contraseña: admin123)</div>";
} else {
    echo "<div class='alert alert-danger'>❌ Error al insertar admin: " . $con->error . "</div>";
}
echo "</div>";

// PASO 4: Insertar usuario voluntario de prueba
echo "<div class='step'>";
echo "<h3>Paso 4: Insertar Usuario Voluntario de Prueba</h3>";

$vol_password = password_hash("vol123", PASSWORD_DEFAULT);

$sql_vol = "INSERT IGNORE INTO usuarios 
(nombre, email, telefono, tipo_usuario, password, direccion, fecha_nacimiento, estado, fecha_registro)
VALUES 
('Carlos Rodríguez', 'carlos@email.com', '8765432100', 'voluntario', '$vol_password', 'San José', '1990-05-15', 'activo', '$fecha')";

if ($con->query($sql_vol) === TRUE) {
    echo "<div class='alert alert-success'>✅ Usuario voluntario insertado (email: carlos@email.com / contraseña: vol123)</div>";
} else {
    echo "<div class='alert alert-danger'>❌ Error al insertar voluntario: " . $con->error . "</div>";
}
echo "</div>";

// PASO 5: Insertar usuario abuelo de prueba
echo "<div class='step'>";
echo "<h3>Paso 5: Insertar Usuario Abuelo de Prueba</h3>";

$abuelo_password = password_hash("abuelo123", PASSWORD_DEFAULT);

$sql_abuelo = "INSERT IGNORE INTO usuarios 
(nombre, email, telefono, tipo_usuario, password, direccion, fecha_nacimiento, estado, fecha_registro)
VALUES 
('Don Juan Pérez', 'juan@email.com', '9876543210', 'usuario', '$abuelo_password', 'Barrio el Roble', '1950-03-20', 'activo', '$fecha')";

if ($con->query($sql_abuelo) === TRUE) {
    echo "<div class='alert alert-success'>✅ Usuario abuelo insertado (email: juan@email.com / contraseña: abuelo123)</div>";
} else {
    echo "<div class='alert alert-danger'>❌ Error al insertar abuelo: " . $con->error . "</div>";
}
echo "</div>";

// Resumen final
echo "<div class='step'>";
echo "<h2 style='color: #28a745; text-align: center;'>✅ ¡Configuración Completada!</h2>";
echo "<div class='alert alert-info'>";
echo "<strong>Datos de acceso para pruebas:</strong><br>";
echo "🔑 <strong>Admin:</strong> admin@admin.com / admin123<br>";
echo "🔑 <strong>Voluntario:</strong> carlos@email.com / vol123<br>";
echo "🔑 <strong>Abuelo:</strong> juan@email.com / abuelo123<br>";
echo "</div>";

// Verificar tabla
$result = $con->query("SELECT COUNT(*) as total FROM usuarios");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<div class='alert alert-success'>";
    echo "Total de usuarios en la BD: <strong>" . $row['total'] . "</strong>";
    echo "</div>";
}

echo "</div>";

// Botón para ir al login
echo "<a href='Login.html' class='btn'>🚀 Ir al Login</a>";
echo "<a href='pagina inicio.html' class='btn' style='background: #764ba2; margin-top: 0.5rem;'>🏠 Ir al Inicio</a>";

echo "</div>";

$con->close();
?>
