<?php
// Incluye el archivo de conexión a la base de datos
require_once('../../../db_connection/db_connection.php');

// Verificar si se recibieron datos del formulario de actualización
if (isset($_POST['nombre']) && isset($_POST['nombre_real']) && isset($_POST['apellido']) && isset($_POST['numero_telefono']) && isset($_POST['correo']) && isset($_POST['DNI']) && isset($_POST['usuario_id'])) {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $nombre_real = $_POST['nombre_real'];
    $apellido = $_POST['apellido'];
    $numero_telefono = $_POST['numero_telefono'];
    $correo = $_POST['correo'];
    $DNI = $_POST['DNI'];
    
    // Obtener el usuarioId del formulario
    $id = $_POST['usuario_id'];

    // Preparar la consulta SQL para actualizar la información del usuario
    $sql = "UPDATE usuarios SET nombre = ?, nombre_real = ?, apellido = ?, numero_telefono = ?, correo = ?, DNI = ? WHERE id = ?";

    // Crear una nueva conexión a la base de datos
    $conn = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

    // Verificar si la conexión tuvo éxito
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Preparar la consulta
    $stmt = mysqli_prepare($conn, $sql);

    // Verificar si la preparación de la consulta tuvo éxito
    if ($stmt) {
        // Asociar los parámetros a la consulta
        mysqli_stmt_bind_param($stmt, "ssssssi", $nombre, $nombre_real, $apellido, $numero_telefono, $correo, $DNI, $id);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // La actualización fue exitosa

            // Cerrar la consulta
            mysqli_stmt_close($stmt);

            // Cerrar la conexión a la base de datos
            mysqli_close($conn);

            // Redirigir a user_edit.php y usar el usuarioId del formulario
            header("Location: user_edit.php?id=" . $id);
            exit(); // Asegura que el script se detenga después de la redirección
        } else {
            // Error en la ejecución de la consulta
            echo "Error al actualizar la información: " . mysqli_error($conn);
        }
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($conn);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
} else {
    echo "Por favor, complete el formulario de actualización.";
}
?>