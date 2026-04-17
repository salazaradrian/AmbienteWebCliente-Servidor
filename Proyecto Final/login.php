<?php
session_start();
require 'conexion.php';

$usuario = trim($_POST['usuario']);
$password = $_POST['password'];

if (empty($usuario) || empty($password)) {
    die("Debes completar todos los campos.");
}

$sql = "SELECT * FROM usuarios WHERE email='$usuario' OR nombre='$usuario'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['id_usuario'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['tipo_usuario'] = $user['tipo_usuario'];

        if ($user['tipo_usuario'] === 'admin') {
            header("Location: dashboard_admin.html");
            exit;
        } elseif ($user['tipo_usuario'] === 'voluntario') {
            header("Location: dashboard_voluntario.html");
            exit;
        } else {
            header("Location: dashboard_abuelo.html");
            exit;
        }
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no existe.";
}
?>