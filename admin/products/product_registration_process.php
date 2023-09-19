<?php
// Include the database connection
include_once('../../db_connection/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $categoria_id = $_POST["categoria"];
    $talle_id = $_POST["talle"];
    $color_id = $_POST["color"];
    $descripcion_corta = $_POST["descripcion_corta"];
    $descripcion_larga = $_POST["descripcion_larga"];

    // Archivo de imagen
   $nombreArchivo = $_FILES["imagen"]["name"];
   $rutaDestino = '../img/' . $nombreArchivo; // Ruta absoluta
   
    // Insertar datos del producto en la tabla de productos
    $sql = "INSERT INTO productos (nombre, precio, stock, categoria_id, talle_id, color_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sdiiss", $nombre, $precio, $stock, $categoria_id, $talle_id, $color_id);

    if ($stmt->execute()) {
        // Éxito al insertar el producto, ahora inserta las descripciones
        $producto_id = $stmt->insert_id; // ID del producto recién insertado

        // Insertar descripción corta
        $sql = "INSERT INTO descripciones (producto_id, tipo, texto) VALUES (?, 'descripcion_corta', ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("is", $producto_id, $descripcion_corta);
        $stmt->execute();

        // Insertar descripción larga
        $sql = "INSERT INTO descripciones (producto_id, tipo, texto) VALUES (?, 'descripcion_larga', ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("is", $producto_id, $descripcion_larga);
        $stmt->execute();

        $sql = "INSERT INTO imagenes_productos (producto_id, url_imagen) VALUES (?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("is", $producto_id, $rutaDestino);        

        if ($stmt->execute()) {
            // Éxito al guardar la dirección de la imagen
            $mensaje = "Producto agregado exitosamente.";
        } else {
            // Error al insertar la dirección de la imagen
            $mensaje = "Error al guardar la dirección de la imagen.";
        }
    } else {
        // Error al insertar el producto
        $mensaje = "Error al agregar el producto. Inténtalo de nuevo.";
    }
} else {
    // Acceso incorrecto a esta página
    header("Location: add_product.php");
    exit();
}
header("Location: add_product.php");
// Close the database connection
$connection->close();
?>

