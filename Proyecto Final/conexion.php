<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "db_ambienteweb";

$con = new mysqli($servername, $username, $password, $dbname);
$conexion = $con;

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}
?>