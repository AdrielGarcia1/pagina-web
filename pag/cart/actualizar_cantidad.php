<?php

// Incluye el archivo de conexión a la base de datos
include('../../db_connection/db_connection.php');
// Verifica si se han recibido los datos necesarios
if (isset($_POST['usuario_id']) && isset($_POST['producto_id']) && isset($_POST['cantidad_actual'])) {
    // Obtén los valores del formulario
    $usuarioId = $_POST['usuario_id'];
    $id = $_POST['producto_id'];
    $cantidadActual = $_POST['cantidad_actual'];

    // Consulta SQL para verificar si el producto ya está en el carrito
    $sql = "SELECT id, cantidad FROM carrito_compras WHERE usuario_id = ? AND producto_id = ?";
    $stmt = $connection->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $usuarioId, $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // El producto ya está en el carrito, actualiza la cantidad
                $row = $result->fetch_assoc();
                $carritoId = $row['id'];
                $cantidadExistente = $row['cantidad'];
                $nuevaCantidad = $cantidadExistente + $cantidadActual;

                $sql = "UPDATE carrito_compras SET cantidad = ? WHERE id = ?";
                $stmt = $connection->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("ii", $nuevaCantidad, $carritoId);
                    if ($stmt->execute()) {
                        $response['success'] = true;
                        $response['message'] = "Cantidad actualizada con éxito";
                    } else {
                        $response['success'] = false;
                        $response['message'] = "Error al actualizar la cantidad en la base de datos: " . $stmt->error;
                    }
                    // ¡No cierres la sentencia preparada aquí!
                } else {
                    $response['success'] = false;
                    $response['message'] = "Error en la preparación de la consulta SQL para actualizar: " . $connection->error;
                }
            } else {
                // El producto no está en el carrito, inserta un nuevo registro
                $sql = "INSERT INTO carrito_compras (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)";
                $stmt = $connection->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("iii", $usuarioId, $id, $cantidadActual);
                    if ($stmt->execute()) {
                        $response['success'] = true;
                        $response['message'] = "Producto agregado al carrito con éxito";
                    } else {
                        $response['success'] = false;
                        $response['message'] = "Error al agregar el producto al carrito: " . $stmt->error;
                    }
                    // ¡No cierres la sentencia preparada aquí!
                } else {
                    $response['success'] = false;
                    $response['message'] = "Error en la preparación de la consulta SQL para insertar: " . $connection->error;
                }
            }
            // Cierra la sentencia preparada aquí después de usarla
            $stmt->close();
        } else {
            $response['success'] = false;
            $response['message'] = "Error al ejecutar la consulta SQL: " . $stmt->error;
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Error en la preparación de la consulta SQL: " . $connection->error;
    }
} else {
    $response['success'] = false;
    $response['message'] = "Datos incompletos recibidos.";
}
// Después de procesar con éxito la actualización o inserción
$response['success'] = true;
$response['message'] = "Producto agregado al carrito con éxito";

// Redirigir automáticamente a detail.php después de mostrar el mensaje de éxito
echo '<script>window.location.href = "../cart.php";</script>';

// Devuelve la respuesta en formato JSON
echo json_encode($response);
?>