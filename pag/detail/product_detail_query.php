<?php
require_once "../db_connection/db_connection.php"; // Asegúrate de incluir tu archivo de conexión aquí

// Obtén el ID del producto de la URL
$id = isset($_GET['id']) ? $_GET['id'] : 'ID no definido';

// Consulta SQL para obtener los detalles del producto específico
 $query = "SELECT p.id, p.precio, t.nombre_talle, c.nombre_color, d.texto AS descripcion_corta,
                 (SELECT texto FROM descripciones WHERE producto_id = $id AND tipo = 'descripcion_larga') AS descripcion_larga,
                 i.url_imagen, p.nombre
          FROM productos p
          LEFT JOIN talles t ON p.talle_id = t.id
          LEFT JOIN colores c ON p.color_id = c.id
          LEFT JOIN descripciones d ON p.id = d.producto_id AND d.tipo = 'descripcion_corta'
          LEFT JOIN imagenes_productos i ON p.id = i.producto_id
          WHERE p.id = " . $id;

$result = $connection->query($query);

if ($result->num_rows > 0) {
    $product_data = $result->fetch_assoc(); // Obtén los detalles del producto específico

    // Convertir la ruta relativa en ruta absoluta para la imagen
    $product_data['url_imagen'] = '../img/' . $product_data['url_imagen']; // Reemplaza "../img/" con la URL base de tu sitio
} else {
    // Manejar el caso en que no se encuentra el producto
    echo "Producto no encontrado.";
}

// Cierra la conexión a la base de datos
$connection->close();

?>