<?php
include("../../../db_connection/db_connection.php");

if (!$connection) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Ejecuta una consulta SQL para eliminar el producto por su ID
    $query = "DELETE FROM productos WHERE id = $producto_id";

    if (mysqli_query($connection, $query)) {
        // Éxito en la eliminación, redirige a la página de lista de productos
        header("Location: product_list.php");
        exit();
    } else {
        echo "Error al eliminar el producto: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>