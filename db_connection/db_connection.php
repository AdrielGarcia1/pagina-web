<?php
$host = "127.0.0.1";
$usuario = "root";
$contrasena = "";
$base_de_datos = "proyecto1";

$connection = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

if (!$connection) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>