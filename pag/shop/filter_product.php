<?php
// Establecer la conexión a la base de datos
require_once "../../db_connection/db_connection.php";

// Inicializar un array para almacenar las categorías
$categorias = array();

// Consulta SQL para obtener todas las categorías
$query = "SELECT id, nombre_categoria FROM categorias";
$result = $connection->query($query);

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Almacenar cada categoría en el array de categorías
        $categorias[] = $row;
    }
}

// Verificar si se ha enviado el formulario y se ha seleccionado una categoría
if (isset($_GET['categoria_filtro']) && !empty($_GET['categoria_filtro'])) {
    // Obtener la categoría seleccionada
    $categoria_filtro = mysqli_real_escape_string($connection, $_GET['categoria_filtro']);
    
    // Consulta SQL para obtener los productos filtrados por categoría
    $query = "SELECT p.id, p.nombre, p.precio, i.url_imagen 
              FROM productos p
              INNER JOIN imagenes_productos i ON p.id = i.producto_id
              WHERE p.estado = 1
              AND p.categoria_id = '$categoria_filtro'"; // Agrega el filtro de categoría
    
    // Ejecutar la consulta
    $result = $connection->query($query);
    
    // Inicializar un array para almacenar los productos filtrados
    $filteredProducts = array();
    
    // Verificar si se obtuvieron resultados
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Almacenar cada producto en el array de productos filtrados
            $filteredProducts[] = $row;
        }
    }
}

// Devuelve los productos filtrados y las categorías en formato JSON (o en el formato que prefieras)
$response = array(
    'filteredProducts' => $filteredProducts,
    'categorias' => $categorias
);

json_encode($response);
?>