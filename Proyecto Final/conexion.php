<?php
$servername = "localhost:3307";
$username = "root";
$password = "root"; // si ese es el que tienes
$dbname = "db ambiente web";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}
?>