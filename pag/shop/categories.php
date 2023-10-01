<?php
require_once "../db_connection/db_connection.php";

// Consulta SQL para obtener todas las categorías
$query = "SELECT id, nombre_categoria FROM categorias";
$result = $connection->query($query);

$categorias = array(); // Un array para almacenar las categorías

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Almacenar cada categoría en el array
        $categorias[] = $row;
    }
}

// Cerrar la conexión a la base de datos
$connection->close();

// Devolver las categorías en formato JSON
return$categorias; // Agrega "echo" para imprimir el JSON
?>