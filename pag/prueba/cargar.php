<?php
// Incluir el archivo de conexión a la base de datos
include('../../db_connection/db_connection.php');

// Supongamos que tienes un identificador de producto y usuario
$producto_id = 3; // Reemplaza con el ID del producto que deseas consultar
$usuario_id = 8; // Reemplaza con el ID del usuario correspondiente

// Consulta SQL para obtener la cantidad actual
$sql = "SELECT cantidad FROM carrito_compras WHERE producto_id = $producto_id AND usuario_id = $usuario_id";

// Ejecuta la consulta
$resultado = mysqli_query($connection, $sql);

if ($resultado) {
    // Obtiene el valor de la cantidad desde el resultado de la consulta
    $fila = mysqli_fetch_assoc($resultado);
    $cantidadActual = $fila['cantidad'];

    // Cierra el resultado
    mysqli_free_result($resultado);

    // Cierra la conexión a la base de datos
    mysqli_close($connection);
} else {
    // Manejo de errores si la consulta no se ejecuta correctamente
    echo "Error al consultar la base de datos: " . mysqli_error($connection);
}

?>