<?php
require 'conexion.php';

$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$telefono = trim($_POST['telefono']);
$password = $_POST['password'];

if (empty($nombre)  empty($email) 
 empty($password)) {
    die("Faltan datos obligatorios.");
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$direccion = "Sin dirección";
$fecha_nacimiento = "2000-01-01";
$tipo_usuario = "usuario";
$estado = "activo";
$fecha_registro = date("Y-m-d");

$sql = "INSERT INTO usuarios 
(nombre, email, telefono, tipo_usuario, password, direccion, fecha_nacimiento, estado, fecha_registro)
VALUES 
('$nombre', '$email', '$telefono', '$tipo_usuario', '$passwordHash', '$direccion', '$fecha_nacimiento', '$estado', '$fecha_registro')";

if ($con->query($sql) === TRUE) {
    echo "Usuario creado correctamente.<br><a href='Login.html'>Ir al login</a>";
} else {
    echo "Error: " . $con->error;
}
?>