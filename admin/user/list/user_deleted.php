<?php
include("../../../db_connection/db_connection.php");

if (!$connection) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Ejecuta una consulta SQL para actualizar el estado del usuario
    $query = "UPDATE usuarios SET estado = 0 WHERE id = $user_id";

    if (mysqli_query($connection, $query)) {
        // Éxito en la actualización, redirige a la página de lista de usuarios
        header("Location: user_list.php");
        exit();
    } else {
        echo "Error al cambiar el estado del usuario: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>