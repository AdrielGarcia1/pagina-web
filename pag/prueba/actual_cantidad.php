<?php
// Incluir el archivo de conexión a la base de datos
include('../../db_connection/db_connection.php');

// Verificar si se ha recibido una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener la nueva cantidad de la solicitud AJAX
    $nuevaCantidad = $_POST['nuevaCantidad'];

    // Supongamos que tienes un identificador de producto y usuario
    $producto_id = 3; // Reemplaza con el ID del producto que deseas actualizar
    $usuario_id = 8; // Reemplaza con el ID del usuario correspondiente

    // Consulta SQL para actualizar la cantidad en la base de datos
    $sql = "UPDATE carrito_compras SET cantidad = '$nuevaCantidad' WHERE producto_id = $producto_id AND usuario_id = $usuario_id";

    // Ejecuta la consulta
    $resultado = mysqli_query($connection, $sql);

    if ($resultado) {
        // La actualización se realizó correctamente
        echo "Cantidad actualizada correctamente";
    } else {
        // Manejo de errores si la actualización falla
        echo "Error al actualizar la cantidad: " . mysqli_error($connection);
    }
} else {
    // Manejar el caso en el que no se haya recibido una solicitud POST
    echo "Acceso no autorizado";
}

// Cierra la conexión a la base de datos
mysqli_close($connection);
?>
