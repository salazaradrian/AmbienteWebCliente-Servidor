<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "db ambienteweb";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}
?>