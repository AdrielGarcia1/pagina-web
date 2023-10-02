<?php
// Incluye el archivo de conexión a la base de datos
// Inicia sesión (si aún no se ha iniciado)
session_start();
require_once('../db_connection/db_connection.php');
// Verificar si existe la variable de sesión del nombre de usuario
if (isset($_SESSION['username'])) {
    // El usuario ha iniciado sesión
    $username = $_SESSION['username']; // Obtener el nombre de usuario de la sesión

    // Verificar si se recibieron datos del formulario de actualización
    if (isset($_POST['nombre']) && isset($_POST['nombre_real']) && isset($_POST['apellido']) && isset($_POST['numero_telefono']) && isset($_POST['correo']) && isset($_POST['DNI'])) {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $nombre_real = $_POST['nombre_real'];
        $apellido = $_POST['apellido'];
        $numero_telefono = $_POST['numero_telefono'];
        $correo = $_POST['correo'];
        $DNI = $_POST['DNI'];

        // Preparar la consulta SQL para actualizar la información del usuario
        $sql = "UPDATE usuarios SET nombre = ?, nombre_real = ?, apellido = ?, numero_telefono = ?, correo = ?, DNI = ? WHERE nombre = ?";
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
            mysqli_stmt_bind_param($stmt, "sssssss", $nombre, $nombre_real, $apellido, $numero_telefono, $correo, $DNI, $username);

             // Ejecutar la consulta
            if (mysqli_stmt_execute($stmt)) {
                // La actualización fue exitosa

                // Actualizar el nombre de usuario en la sesión actual
                $_SESSION['username'] = $nombre; // Establece el nuevo nombre de usuario

                // Cerrar la consulta
                mysqli_stmt_close($stmt);

                // Cerrar la conexión a la base de datos
                mysqli_close($conn);

                // Redirigir a info_personal.php
                header("Location: personal_info.php");
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
} else {
    // El usuario no ha iniciado sesión
    echo "Debes iniciar sesión para actualizar tu información.";
}
?>