<?php
// Incluye el archivo de conexión a la base de datos
include("../../../db_connection/db_connection.php");
session_start();

// Verifica si se ha enviado un ID de producto válido a través de la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Verifica si la conexión a la base de datos se estableció correctamente
    if (!$connection) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Verifica si se ha enviado el formulario de edición
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtiene los datos del formulario
        $nombre = mysqli_real_escape_string($connection, $_POST['nombre']);
        $precio = floatval($_POST['precio']);
        $stock = intval($_POST['stock']);
        $categoria_id = intval($_POST['categoria']); 
        $talle_id = intval($_POST['talle']); // Verifica el nombre del elemento de formulario
        $color_id = intval($_POST['color']);

        // Actualiza los datos del producto en la base de datos
        $query = "UPDATE productos 
                  SET nombre='$nombre', precio=$precio, stock=$stock, categoria_id=$categoria_id, talle_id=$talle_id, color_id=$color_id
                  WHERE id=$producto_id";

        $result = mysqli_query($connection, $query);

        // Verifica si la consulta se ejecutó correctamente
        if ($result) {
            // Redirige a la página de lista de productos o a donde desees
            header("Location: product_list.php");
            exit();
        } else {
            echo "Error al actualizar el producto: " . mysqli_error($connection);
        }
    }

    // Consulta la información actual del producto
    $query = "SELECT p.id, p.nombre, p.precio, p.stock, p.categoria_id, p.talle_id, p.color_id, c.nombre_categoria, t.nombre_talle, co.nombre_color
              FROM productos p
              LEFT JOIN categorias c ON p.categoria_id = c.id
              LEFT JOIN talles t ON p.talle_id = t.id
              LEFT JOIN colores co ON p.color_id = co.id
              WHERE p.id = $producto_id";

    $result = mysqli_query($connection, $query);

    // Verifica si la consulta se ejecutó correctamente
    if (!$result) {
        echo "Error en la consulta: " . mysqli_error($connection);
        exit();
    }

    // Obtiene los datos del producto
    $producto = mysqli_fetch_assoc($result);

    // Consulta las opciones disponibles para Categoría, Talle y Color
    $queryCategorias = "SELECT id, nombre_categoria FROM categorias";
    $queryTalles = "SELECT id, nombre_talle FROM talles";
    $queryColores = "SELECT id, nombre_color FROM colores";

    $categoriasResult = mysqli_query($connection, $queryCategorias);
    $tallesResult = mysqli_query($connection, $queryTalles);
    $coloresResult = mysqli_query($connection, $queryColores);

    // Verifica si las consultas se ejecutaron correctamente
    if (!$categoriasResult || !$tallesResult || !$coloresResult) {
        echo "Error en la consulta: " . mysqli_error($connection);
        exit();
    }

    // Obtiene las opciones para Categoría, Talle y Color
    $categorias = mysqli_fetch_all($categoriasResult, MYSQLI_ASSOC);
    $talles = mysqli_fetch_all($tallesResult, MYSQLI_ASSOC);
    $colores = mysqli_fetch_all($coloresResult, MYSQLI_ASSOC);

    // Cerrar la conexión a la base de datos
    mysqli_close($connection);
} else {
    // Si no se proporcionó un ID de producto válido, redirige a la página de lista de productos
    header("Location: product_list.php");
    exit();
}
?>