<?php
session_start();
// Incluir archivo de conexión a la base de datos
include('../../db_connection/db_connection.php');

// Verificar si se recibió el parámetro 'productoId' en la solicitud POST
if (isset($_POST['productoId'])) {
    // Obtener el ID del producto a eliminar
    $productoId = $_POST['productoId'];

    // Ejecutar la consulta SQL para eliminar el producto por su ID
    $sql = "DELETE FROM carrito_compras WHERE producto_id = ?";

    // Preparar la sentencia SQL
    $stmt = $connection->prepare($sql);

    if ($stmt === false) {
        die("Error al preparar la consulta: " . $connection->error);
    }

    // Enlazar el parámetro
    $stmt->bind_param("i", $productoId);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // La eliminación se realizó con éxito
        echo "Producto eliminado con éxito.";
    } else {
        // Error al eliminar el producto
        echo "Error al eliminar el producto: " . $stmt->error;
    }

    // Cerrar la sentencia
    $stmt->close();
} else {
    // No se proporcionó un ID de producto válido
    echo "No se proporcionó un ID de producto válido.";
}
?>