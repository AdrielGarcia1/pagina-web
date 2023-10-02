<?php
session_start();

// Incluir el archivo de conexión a la base de datos y otras configuraciones necesarias
include('../../db_connection/db_connection.php');

// Obtener el ID del producto de la URL
$id = isset($_GET['id']) ? $_GET['id'] : 'ID no definido';
$cantidadActual = 1; // Establece la cantidad actual en 1 por defecto

// Verificar si existe la variable de sesión 'username'
if (isset($_SESSION['username'])) {
    // El usuario ha iniciado sesión, obtener el nombre de usuario
    $username = $_SESSION['username'];

    // Realizar una consulta a la base de datos para obtener el usuario_id basado en el nombre de usuario
    $sql = "SELECT id FROM usuarios WHERE nombre = ?";

    // Preparar la sentencia SQL
    $stmt = $connection->prepare($sql);
    
    if ($stmt) {
        // Asociar el valor del nombre de usuario al parámetro de la sentencia SQL
        $stmt->bind_param("s", $username);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Si se encontró un resultado, obtener el usuario_id
            $row = $result->fetch_assoc();
            $usuarioId = $row['id'];
        } else {
            // Manejar el caso en que no se encontró el usuario
            echo "No se encontró el usuario en la base de datos.";
        }

        // Cerrar la sentencia preparada y liberar los resultados
        $stmt->close();
        $result->close();
    } else {
        // Manejar el caso en que hubo un error en la preparación de la consulta
        echo "Error en la preparación de la consulta SQL.";
    }
} else {
    // La variable de sesión 'username' no está definida, manejar este caso apropiadamente
    echo "La sesión del usuario no está iniciada.";
}

// Crear un arreglo asociativo con los datos a enviar a actualizar_cantidad.php
$data = [
    'usuario_id' => $usuarioId,
    'producto_id' => $id,
    'cantidad_actual' => $cantidadActual
];

// Configurar la solicitud POST a actualizar_cantidad.php
$url = 'http://localhost/proyecto/pag/cart/actualizar_cantidad.php'; // Reemplaza con la ruta correcta
$options = [
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => http_build_query($data)
    ]
];

// Realizar la solicitud POST
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// Verificar la respuesta (puede ser JSON, según lo que devuelva actualizar_cantidad.php)
if ($result !== false) {
    $response = json_decode($result, true);
    if (isset($response['success']) && $response['success'] === true) {
        // La actualización fue exitosa, puedes redirigir o mostrar un mensaje de éxito aquí
    } else {
        // Hubo un error en la actualización, maneja el error adecuadamente
    }
} else {
    // Error al realizar la solicitud POST, maneja el error adecuadamente
}
echo '<script>window.location.href = "../cart.php";</script>';
?>