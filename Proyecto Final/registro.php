<?php
require 'conexion.php';

$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$telefono = trim($_POST['telefono']);
$password = $_POST['password'];
$tipo_usuario_raw = isset($_POST['tipo_usuario']) ? $_POST['tipo_usuario'] : 'usuario';

// Solo se permiten estos dos tipos
$tipos_validos = ['usuario', 'voluntario'];
$tipo_usuario = in_array($tipo_usuario_raw, $tipos_validos) ? $tipo_usuario_raw : 'usuario';

if (empty($nombre) || empty($email) || empty($password)) {
    die("Faltan datos obligatorios.");
}

// Verificar si el email ya existe
$check = $con->prepare("SELECT id FROM usuarios WHERE LOWER(email) = LOWER(?)");
$check->bind_param('s', $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    $check->close();
    die("El correo ya está registrado. <a href='Login.html'>Iniciar sesión</a>");
}
$check->close();

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$direccion = "Sin dirección";
$fecha_nacimiento = "2000-01-01";
$estado = "activo";
$fecha_registro = date("Y-m-d");

$stmt = $con->prepare("INSERT INTO usuarios (nombre, email, telefono, tipo_usuario, password, direccion, fecha_nacimiento, estado, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('sssssssss', $nombre, $email, $telefono, $tipo_usuario, $passwordHash, $direccion, $fecha_nacimiento, $estado, $fecha_registro);

if ($stmt->execute()) {
    echo "Cuenta creada correctamente.<br><a href='Login.html'>Ir al login</a>";
} else {
    echo "Error al registrar: " . $stmt->error;
}
$stmt->close();
?>