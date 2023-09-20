<?php
// cart_query.php

// Incluye el archivo de conexión a la base de datos
include_once("../db_connection/db_connection.php");

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_POST['user_id'];
    $quantity = $_POST['quantity'];

    // Realiza la inserción en la tabla del carrito
    $sql = "INSERT INTO carrito_compras (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    
    if ($stmt->execute()) {
        // Éxito al agregar el producto al carrito, puedes redirigir al usuario a la página de carrito o hacer otra acción.
        header('Location: cart.php');
        exit;
    } else {
        // Manejo del error en caso de que la inserción falle.
        echo "Error al agregar el producto al carrito.";
    }
}
?>