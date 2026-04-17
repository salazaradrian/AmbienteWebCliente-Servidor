<?php
require 'conexion.php';

$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$telefono = trim($_POST['telefono']);
$password = $_POST['password'];

if (empty($nombre) || empty($email) || empty($password)) {
    die("Faltan datos obligatorios.");
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, email, telefono, tipo_usuario, password, estado, fecha_registro)
        VALUES ('$nombre', '$email', '$telefono', 'usuario', '$passwordHash', 'activo', NOW())";

if ($con->query($sql) === TRUE) {
    echo "Usuario creado correctamente.<br><a href='Login.html'>Ir al login</a>";
} else {
    echo "Error: " . $con->error;
}
?>