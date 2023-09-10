<?php
$host = "127.0.0.1"; // Cambia a la dirección IP o nombre de host si es un servidor remoto
$usuario = "root"; // Cambia al nombre de usuario de tu base de datos
$contrasena = ""; // Cambia a la contraseña de tu base de datos si la tienes configurada
$base_de_datos = "proyecto1"; // Cambia al nombre de tu base de datos

$connection = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

if (!$connection) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>