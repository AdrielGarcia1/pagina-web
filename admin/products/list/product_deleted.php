<?php
include("../../../db_connection/db_connection.php");

if (!$connection) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Ejecuta una consulta SQL para actualizar el estado del producto a "0" por su ID
    $query = "UPDATE productos SET estado = 0 WHERE id = $producto_id";

    if (mysqli_query($connection, $query)) {
        // Éxito en la actualización, redirige a la página de lista de productos
        header("Location: product_list.php");
        exit();
    } else {
        echo "Error al cambiar el estado del producto: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>