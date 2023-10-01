<?php
require_once "../db_connection/db_connection.php";

// Consulta SQL para obtener los productos con sus imágenes y categorías
$query = "SELECT p.id, p.nombre, p.precio, i.url_imagen, c.nombre_categoria 
          FROM productos p
          INNER JOIN imagenes_productos i ON p.id = i.producto_id
          INNER JOIN categorias c ON p.categoria_id = c.id";

$result = $connection->query($query);

$products = array(); // Un array para almacenar los productos

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Almacenar cada producto en el array
        $products[] = $row;
    }
}

// Devolver el array de productos
return $products;
?>