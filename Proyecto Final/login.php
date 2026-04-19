<?php
session_start();
require 'conexion.php';

$usuario = trim($_POST['usuario']);
$password = $_POST['password'];

if (empty($usuario) || empty($password)) {
    die("Debes completar todos los campos.");
}

$sql = "SELECT * FROM usuarios WHERE LOWER(email) = LOWER(?) OR LOWER(nombre) = LOWER(?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('ss', $usuario, $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['tipo_usuario'] = $user['tipo_usuario'];

        if ($user['tipo_usuario'] === 'admin') {
            header("Location: dashboard_admin.html");
            exit;
        } elseif ($user['tipo_usuario'] === 'voluntario') {
            header("Location: dashboard_voluntario.php");
            exit;
        } else {
            header("Location: dashboard_abuelo.php");
            exit;
        }
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no existe.";
}
?>